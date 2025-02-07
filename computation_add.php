<?php
require 'database_connection.php';

$sql = "
    SELECT 
        e.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS full_name, 
        e.basic_salary, 
        e.honorarium, 
        COALESCE(SUM(o.grand_total), 0) AS overload_hr, 
        COALESCE(c.medical_savings, 0) AS medical_savings, 
        COALESCE(c.retirement, 0) AS retirement, 
        COALESCE((c.sss_ee + c.sss_er), 0) AS sss_total, 
        COALESCE((c.pag_ibig_ee + c.pag_ibig_er), 0) AS pag_ibig_total, 
        COALESCE((c.philhealth_ee + c.philhealth_er), 0) AS philhealth_total
    FROM employees e
    LEFT JOIN overload o ON e.employee_id = o.employee_id
    LEFT JOIN contributions c ON e.employee_id = c.employee_id
    GROUP BY e.employee_id";

$result = $conn->query($sql);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table_styles.css">
    <style>
        .editable-cell {
            width: 100px;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php include 'sidebars.php'; ?>
    <div class="content">
        <h1>GFI File 301 Payroll (September 1-15, 2024)</h1>
        <div class="table-wrapper">
            <button id="saveTableBtn">Save Table</button>
            <table id="crudTable">
                <thead>
                    <tr>
                        <th rowspan="2">Name</th>
                        <th colspan="2">Full-Time</th>
                        <th colspan="2">Overloads</th>
                        <th rowspan="2">Total</th>
                        <th colspan="3">With Review</th>
                        <th colspan="3">Adjustment</th>
                        <th colspan="3">Watch Reward</th>
                        <th rowspan="2">Gross</th>
                        <th colspan="3">Absences/Late</th>
                        <th colspan="2">Loans</th>
                        <th colspan="5">Contributions</th>
                        <th rowspan="2">Canteen</th>
                        <th rowspan="2">Others</th>
                        <th rowspan="2">Total Deductions</th>
                        <th rowspan="2">Net Pay</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr>
                        <th>Basic</th>
                        <th>Honorarium</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Pag-ibig</th>
                        <th>MP2</th>
                        <th>Medical. S</th>
                        <th>SSS</th>
                        <th>Ret.</th>
                        <th>P-ibig</th>
                        <th>P-Hlth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td data-employee='{$row['employee_id']}'>{$row['full_name']}</td>"; // Name with Employee ID
                            echo "<td>{$row['basic_salary']}</td>"; // Basic Salary
                            echo "<td>{$row['honorarium']}</td>"; // Honorarium
                            echo "<td>{$row['overload_hr']}</td>"; // Overload HR
                            echo "<td><input type='number' name='overload_rate' class='editable-cell'></td>";
                            echo "<td><input type='number' name='overload_total' class='editable-cell'></td>";
                            echo "<td><input type='number' name='wr_hr' class='editable-cell'></td>";
                            echo "<td><input type='number' name='wr_rate' class='editable-cell'></td>";
                            echo "<td><input type='number' name='wr_total' class='editable-cell'></td>";
                            echo "<td><input type='number' name='adjust_rate' class='editable-cell'></td>";
                            echo "<td><input type='number' name='adjust_hr' class='editable-cell'></td>";
                            echo "<td><input type='number' name='adjust_total' class='editable-cell'></td>";
                            echo "<td><input type='number' name='watch_hr' class='editable-cell'></td>";
                            echo "<td><input type='number' name='watch_rate' class='editable-cell'></td>";
                            echo "<td><input type='number' name='watch_total' class='editable-cell'></td>";
                            echo "<td><input type='number' name='gross_pay' class='editable-cell'></td>";
                            echo "<td><input type='number' name='absent_late_hr' class='editable-cell'></td>";
                            echo "<td><input type='number' name='absent_late_rate' class='editable-cell'></td>";
                            echo "<td><input type='number' name='absent_late_total' class='editable-cell'></td>";
                            echo "<td><input type='number' name='pagibig' class='editable-cell'></td>";
                            echo "<td><input type='number' name='mp2' class='editable-cell'></td>";
                            echo "<td>{$row['pag_ibig_total']}</td>"; // Pag-ibig
                            echo "<td>{$row['medical_savings']}</td>"; // Medical Savings
                            echo "<td>{$row['sss_total']}</td>"; // SSS Total
                            echo "<td>{$row['retirement']}</td>"; // Retirement
                            echo "<td>{$row['philhealth_total']}</td>"; // Philhealth Total
                            echo "<td><input type='number' name='canteen' class='editable-cell'></td>";
                            echo "<td><input type='number' name='others' class='editable-cell'></td>";
                            echo "<td><input type='number' name='total_deduction' class='editable-cell'></td>";
                            echo "<td><input type='number' name='net_pay' class='editable-cell'></td>";
                            echo "<td><button class='save-btn'>Edit</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const saveButton = document.getElementById("saveTableBtn");

        // Function to calculate values for a row
        function calculateRow(row) {
            const overloadHR = parseFloat(row.querySelector("td:nth-child(4)").textContent) || 0; // Overload HR
            const overloadRate = parseFloat(row.querySelector("input[name='overload_rate']").value) || 0;
            const adjustmentHR = parseFloat(row.querySelector("input[name='adjust_hr']").value) || 0;
            const adjustmentRate = parseFloat(row.querySelector("input[name='adjust_rate']").value) || 0;
            const wrHR = parseFloat(row.querySelector("input[name='wr_hr']").value) || 0;
            const wrRate = parseFloat(row.querySelector("input[name='wr_rate']").value) || 0;
            const watchHR = parseFloat(row.querySelector("input[name='watch_hr']").value) || 0;
            const watchRate = parseFloat(row.querySelector("input[name='watch_rate']").value) || 0;
            const absentLateHR = parseFloat(row.querySelector("input[name='absent_late_hr']").value) || 0;
            const absentLateRate = parseFloat(row.querySelector("input[name='absent_late_rate']").value) || 0;
            const pagibig = parseFloat(row.querySelector("input[name='pagibig']").value) || 0;
            const mp2 = parseFloat(row.querySelector("input[name='mp2']").value) || 0;
            const canteen = parseFloat(row.querySelector("input[name='canteen']").value) || 0;
            const others = parseFloat(row.querySelector("input[name='others']").value) || 0;
            const pagibigTotal = parseFloat(row.querySelector("td:nth-child(22)").textContent) || 0; // Pag-ibig Total
            const medicalSavings = parseFloat(row.querySelector("td:nth-child(23)").textContent) || 0; // Medical Savings
            const sssTotal = parseFloat(row.querySelector("td:nth-child(24)").textContent) || 0; // SSS Total
            const retirement = parseFloat(row.querySelector("td:nth-child(25)").textContent) || 0; // Retirement
            const philhealthTotal = parseFloat(row.querySelector("td:nth-child(26)").textContent) || 0; // Philhealth Total

            // Calculate totals
            const overloadTotal = overloadHR * overloadRate;
            const wrTotal = wrHR * wrRate;
            const adjustmentTotal = adjustmentHR * adjustmentRate;
            const watchRewardTotal = watchHR * watchRate;
            const absentLateTotal = absentLateHR * absentLateRate;
            const totalContributions = pagibigTotal + medicalSavings + sssTotal + retirement + philhealthTotal;
            const totalDeduction = absentLateTotal + pagibig + mp2 + totalContributions + canteen + others;

            const basicSalary = parseFloat(row.querySelector("td:nth-child(2)").textContent) || 0; // Basic Salary
            const honorarium = parseFloat(row.querySelector("td:nth-child(3)").textContent) || 0; // Honorarium
            const grossPay = basicSalary + honorarium + overloadTotal + wrTotal + adjustmentTotal + watchRewardTotal;
            const netPay = grossPay - totalDeduction;

            // Update calculated values in the table
            row.querySelector("input[name='overload_total']").value = overloadTotal.toFixed(2);
            row.querySelector("input[name='wr_total']").value = wrTotal.toFixed(2);
            row.querySelector("input[name='adjust_total']").value = adjustmentTotal.toFixed(2);
            row.querySelector("input[name='watch_total']").value = watchRewardTotal.toFixed(2);
            row.querySelector("input[name='absent_late_total']").value = absentLateTotal.toFixed(2);
            row.querySelector("input[name='gross_pay']").value = grossPay.toFixed(2);
            row.querySelector("input[name='total_deduction']").value = totalDeduction.toFixed(2);
            row.querySelector("input[name='net_pay']").value = netPay.toFixed(2);
        }

        // Attach input event listener to editable cells
        document.querySelectorAll(".editable-cell").forEach(cell => {
            cell.addEventListener("input", function() {
                const row = this.closest("tr");
                calculateRow(row);
            });
        });

        // Save table data
        if (saveButton) {
            saveButton.addEventListener("click", function() {
                const tableRows = document.querySelectorAll("#crudTable tbody tr");
                const data = [];
                let hasInvalidRows = false;

                tableRows.forEach(row => {
                    const rowData = {};
                    const employeeId = row.querySelector("td").getAttribute("data-employee");

                    // Skip rows without an employee ID
                    if (!employeeId) return;

                    rowData["employee_id"] = employeeId;

                    // Collect and validate inputs
                    row.querySelectorAll("input").forEach(input => {
                        const value = input.value.trim();
                        const fieldName = input.name;

                        // Validate required numeric fields
                        if (
                            ["overload_total", "wr_total", "adjust_total", "watch_total"].includes(fieldName) &&
                            (value === "" || isNaN(value))
                        ) {
                            hasInvalidRows = true;
                            input.style.border = "1px solid red"; // Highlight invalid fields
                        } else {
                            input.style.border = ""; // Reset border for valid fields
                        }

                        // Add values to rowData, defaulting to 0 for invalid fields
                        rowData[fieldName] = value === "" || isNaN(value) ? 0 : parseFloat(value);
                    });

                    // Push valid row data
                    data.push(rowData);
                });

                // Show alert and stop if there are invalid rows
                if (hasInvalidRows) {
                    alert("Please fill in all required numeric fields before saving.");
                    return;
                }

                // If no valid rows, show an alert
                if (data.length === 0) {
                    alert("No valid data to save. Please fill in the table.");
                    return;
                }

                // Send valid data to the server
                fetch("computation_save.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === "success") {
                            alert(result.message);
                            if (result.duplicates) {
                                alert(result.duplicates);
                            }
                            if (result.errors) {
                                console.error("Errors:", result.errors);
                            }
                        } else {
                            alert(result.message || "Failed to save data.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An unexpected error occurred.");
                    });
            });
        } else {
            console.error("Error: Save Table Button (saveTableBtn) not found!");
        }
    });
</script>
</html>