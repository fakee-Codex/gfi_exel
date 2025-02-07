<?php
// Database connection details
$host = 'localhost';
$dbname = 'gfi_exel';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch full-time employees
    $employeeQuery = "
    SELECT employee_id, CONCAT(first_name, ' ', last_name) AS name 
    FROM employees 
    WHERE employee_type = 'full-time' 
    AND employee_id NOT IN (SELECT DISTINCT employee_id FROM overload)";
    $employeeStmt = $pdo->prepare($employeeQuery);
    $employeeStmt->execute();
    $employees = $employeeStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Hours Table</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-bordered {
            border-width: 1px;
            border-color: #000;
        }

        .table-bordered th,
        .table-bordered td {
            border-width: 1px;
            border-color: #000;
        }

        /* Set the width of editable cells */
        .table td input.form-control {
            width: 70px;
            /* Adjust this value as needed */
            margin: 0 auto;
            /* Center the input in the cell */
        }

        /* Optional: Adjust dropdown width for the Employee Name cell */
        .table td select.form-select {
            width: 200px;
            /* Slightly smaller than the column width */
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-3">ADD OVERLOAD</h1>
        <div class="col-md-2 mb-2 text-end">
            <a href="manage_overload.php" class="btn btn-md btn-success me-2">Back</a>
            <button class="btn btn-md btn-success" onclick="addRow()">Add Row</button>
        </div>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th rowspan="2" class="table-success">Employee Name</th>
                    <th colspan="3">Wednesday</th>
                    <th colspan="3">Thursday</th>
                    <th colspan="3">Friday</th>
                    <th colspan="3">MTTH</th>
                    <th colspan="3">MTWF</th>
                    <th colspan="3">TWTHF</th>
                    <th colspan="3">MW</th>
                    <th colspan="1">LESS</th>
                    <th colspan="1" class="table-warning">ADD</th>
                    <th colspan="1" class="table-danger">ADJUSTMENTS</th>
                    <th rowspan="2" class="table-success">Grand Total</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>DAYS</th>
                    <th class="table-secondary">HRS</th>
                    <th>TOTAL</th>
                    <th>Late OL</th>
                    <th>Subject</th>
                    <th>Less</th>
                </tr>
            </thead>
            <tbody>
                <!-- No rows initially -->
            </tbody>
        </table>
        <button class="btn btn-sm btn-primary mt-3" onclick="saveTable()">Save Table</button>
    </div>

    <script>
        // Dynamically fetch employees from PHP
        const employees = <?= json_encode($employees) ?>;

        function addRow() {
            const tableBody = document.querySelector("table tbody");
            if (!tableBody) {
                console.error("Table body not found");
                return;
            }

            const newRow = document.createElement("tr");

            // Add dropdown for Employee Name
            const employeeCell = document.createElement("td");
            const select = document.createElement("select");
            select.className = "form-select";
            select.name = "employee_name[]";

            // Get the list of existing employee IDs in the table
            const existingEmployeeIds = Array.from(document.querySelectorAll("select[name='employee_name[]']"))
                .map(existingSelect => existingSelect.value);

            // Populate dropdown with employee options, excluding already selected ones
            employees.forEach(employee => {
                if (!existingEmployeeIds.includes(employee.employee_id.toString())) { // Exclude already selected employee IDs
                    const option = document.createElement("option");
                    option.value = employee.employee_id;
                    option.textContent = employee.name;
                    select.appendChild(option);
                }
            });

            employeeCell.appendChild(select);
            newRow.appendChild(employeeCell);


            // Add editable cells for the rest of the columns
            for (let i = 1; i <= 25; i++) {
                const editableCell = document.createElement("td");
                const input = document.createElement("input");
                input.type = "number";
                input.className = "form-control";
                input.name = `column_${i}[]`;

                // Restrict input to decimal values only
                input.addEventListener("input", (e) => {
                    const value = e.target.value;
                    if (!/^(\d+(\.\d{0,2})?)?$/.test(value)) { // Allow only decimals with up to 2 decimal places
                        e.target.value = value.slice(0, -1);
                    }
                });

                editableCell.appendChild(input);
                newRow.appendChild(editableCell);
            }

            // Add action buttons (Delete Row)
            const actionCell = document.createElement("td");
            const deleteButton = document.createElement("button");
            deleteButton.className = "btn btn-sm btn-danger";
            deleteButton.textContent = "Remove";
            deleteButton.onclick = () => {
                newRow.remove();
            };
            actionCell.appendChild(deleteButton);
            newRow.appendChild(actionCell);

            // Append the new row to the table
            tableBody.appendChild(newRow);

            // Add calculation listeners to the new row
            addCalculationListeners(newRow);
        }

        function calculateRowTotals(row) {
            let grandTotal = 0;

            // Iterate through "DAYS" and "HRS" columns for each day
            for (let i = 1; i <= 21; i += 3) { // Steps of 3: DAYS, HRS, TOTAL
                const days = parseFloat(row.querySelector(`input[name="column_${i}[]"]`).value) || 0;
                const hours = parseFloat(row.querySelector(`input[name="column_${i + 1}[]"]`).value) || 0;
                const totalCell = row.querySelector(`input[name="column_${i + 2}[]"]`);
                const total = days * hours;

                // Update the TOTAL cell
                totalCell.value = total.toFixed(2);
                grandTotal += total;
            }

            // Handle "Less", "Add", and "Adjustments" columns
            const less = parseFloat(row.querySelector(`input[name="column_22[]"]`).value) || 0;
            const add = parseFloat(row.querySelector(`input[name="column_23[]"]`).value) || 0;
            const adjustments = parseFloat(row.querySelector(`input[name="column_24[]"]`).value) || 0;

            // Calculate Grand Total
            grandTotal = grandTotal - less + add - adjustments;

            // Update the Grand Total cell
            const grandTotalCell = row.querySelector(`input[name="column_25[]"]`);
            grandTotalCell.value = grandTotal.toFixed(2);
        }

        // Add an event listener to each input for recalculating totals dynamically
        function addCalculationListeners(row) {
            const inputs = row.querySelectorAll("input");
            inputs.forEach(input => {
                input.addEventListener("input", () => calculateRowTotals(row));
            });
        }

        // Modified `addRow` function to include calculation listeners
        function addRow() {
            const tableBody = document.querySelector("table tbody");

            const newRow = document.createElement("tr");

            // Add dropdown for Employee Name
            const employeeCell = document.createElement("td");
            const select = document.createElement("select");
            select.className = "form-select";
            select.name = "employee_name[]";

            employees.forEach(employee => {
                const option = document.createElement("option");
                option.value = employee.employee_id;
                option.textContent = employee.name;
                select.appendChild(option);
            });

            employeeCell.appendChild(select);
            newRow.appendChild(employeeCell);

            // Add editable cells
            for (let i = 1; i <= 25; i++) {
                const editableCell = document.createElement("td");
                const input = document.createElement("input");
                input.type = "number";
                input.className = "form-control";
                input.name = `column_${i}[]`;
                editableCell.appendChild(input);
                newRow.appendChild(editableCell);
            }

            // Add action buttons
            const actionCell = document.createElement("td");
            const deleteButton = document.createElement("button");
            deleteButton.className = "btn btn-sm btn-danger";
            deleteButton.textContent = "Remove";
            deleteButton.onclick = () => newRow.remove();
            actionCell.appendChild(deleteButton);
            newRow.appendChild(actionCell);

            // Append row and add calculation listeners
            tableBody.appendChild(newRow);
            addCalculationListeners(newRow);
        }

        function editRow(button) {
            const row = button.closest("tr"); // Get the parent row
            const inputs = row.querySelectorAll("td:not(:last-child)"); // Get all cells except the last (Action cell)

            if (button.textContent === "Edit") {
                // Enable editing
                inputs.forEach(cell => {
                    const text = cell.textContent.trim();
                    if (!cell.querySelector("input")) { // If there's no input already
                        cell.innerHTML = `<input type="text" class="form-control" value="${number}">`;
                    }
                });

                button.textContent = "Save";
                button.classList.remove("btn-secondary");
                button.classList.add("btn-success");
            } else {
                // Collect updated data
                const updatedData = {};
                inputs.forEach((cell, index) => {
                    const input = cell.querySelector("input");
                    if (input) {
                        updatedData[`column_${index + 1}`] = input.value; // Map column data
                        cell.textContent = input.value; // Replace input with plain text
                    }
                });

                updatedData['row_id'] = row.getAttribute("data-id"); // Add row ID to data

                // Send updated data to the server
                fetch("manage_overload_update.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(updatedData)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert("Row updated successfully!");
                        } else {
                            alert("Failed to update row: " + result.error);
                        }
                    })
                    .catch(error => {
                        console.error("Error updating row:", error);
                    });

                button.textContent = "Edit";
                button.classList.remove("btn-success");
                button.classList.add("btn-secondary");
            }
        }



        function saveTable() {
            console.log("Save Table button clicked");

            const tableBody = document.querySelector("table tbody");
            const rows = Array.from(tableBody.querySelectorAll("tr")); // Convert NodeList to an array
            const data = [];
            let isTableValid = true;

            rows.forEach(row => {
                const rowData = {};
                const select = row.querySelector("select");
                if (select) {
                    rowData.employee_id = select.value; // Include employee_id
                }

                const inputs = row.querySelectorAll("input");
                inputs.forEach((input, index) => {
                    const value = input.value.trim();

                    // Only validate non-empty cells
                    if (value && (isNaN(value) || parseFloat(value) < 0)) {
                        isTableValid = false;
                        input.classList.add("is-invalid"); // Highlight invalid input
                    } else {
                        input.classList.remove("is-invalid"); // Remove invalid highlight
                    }

                    rowData[`column_${index + 1}`] = value;
                });

                data.push(rowData);
            });

            // Validation: Ensure at least one non-empty input exists
            const hasData = rows.some(row => {
                return Array.from(row.querySelectorAll("input"))
                    .some(input => input.value.trim() !== "");
            });

            if (!hasData) {
                alert("Cannot save the table. At least one input must have a value.");
                return;
            }

            // If invalid data exists, show an alert and prevent saving
            if (!isTableValid) {
                alert("Cannot save the table. Ensure all non-empty cells have valid decimal values.");
                return;
            }

            console.log("Data to send:", data);

            fetch("manage_overload_save.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    console.log("Server Response:", result);
                    if (result.success) {
                        alert("Data saved successfully!");
                    } else {
                        alert("Failed to save data: " + (result.error || "Unknown error"));
                    }
                })
                .catch(error => {
                    console.error("Error saving data:", error);
                    alert("An error occurred while saving data.");
                });
        }
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>