<?php
require 'database_connection.php';

$sql = "
    SELECT 
        e.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS full_name, 
        e.basic_salary, 
        e.honorarium, 
        ct.overload_rate,
                ct.overload_total,

        ct.wr_hr,
        ct.wr_rate,
        ct.wr_total,
        ct.adjust_hr,
        ct.adjust_rate,
        ct.adjust_total,
        ct.watch_hr,
        ct.watch_rate,
        ct.watch_total,
        ct.gross_pay,
        ct.absent_late_hr,
        ct.absent_late_rate,
        ct.absent_late_total,
        ct.pagibig,
        ct.mp2,
        ct.canteen,
        ct.others,
        ct.total_deduction,
        ct.net_pay,
        ct.reg_date,

        COALESCE(SUM(o.grand_total), 0) AS overload_hr, 
        COALESCE(c.medical_savings, 0) AS medical_savings, 
        COALESCE(c.retirement, 0) AS retirement, 
        COALESCE((c.sss_ee + c.sss_er), 0) AS sss_total, 
        COALESCE((c.pag_ibig_ee + c.pag_ibig_er), 0) AS pag_ibig_total, 
        COALESCE((c.philhealth_ee + c.philhealth_er), 0) AS philhealth_total
    FROM employees e
    LEFT JOIN overload o ON e.employee_id = o.employee_id
    LEFT JOIN contributions c ON e.employee_id = c.employee_id
    LEFT JOIN computation ct ON e.employee_id = ct.employee_id

    GROUP BY e.employee_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Tailwind style for table and button */
        .table-wrapper {
            max-width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.5rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        td input {
            width: 100%;
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            text-align: center;
        }

        td input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .save-btn {
            padding: 0.5rem 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-btn:hover {
            background-color: #45a049;
        }

        .editable-cell {
            text-align: center;
            width: 80px;
        }

        /* Styling for error input fields */
        .error-input {
            border-color: #ff0000;
        }

        .content {
            padding: 2rem;
            background-color: #f9fafb;
        }

        h1 {
            font-size: 1.75rem;
            color: #333;
        }
    </style>
</head>

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->
<style>
   /* Sticky for the first column horizontally */
#crudTable td:first-child {
    position: sticky;
    left: 0;
    background-color: #fff; /* Optional: Set background color to avoid overlap with other columns */
    z-index: 2; /* Ensures the first column is above other content */
}
.gg{
    position: sticky;
    left: 0;
    z-index: 2; /* Ensures the first column is above other content */
  
}

</style>
    <main>
        <div class="content">
            <h1 class="text-xl font-bold mb-4">GFI File 301 Payroll (September 1-15, 2024)</h1>
            <div class="table-wrapper">
            <table id="crudTable" class="table-auto w-full">
    <thead>
        <tr>
            <th rowspan="2" class="p-2 bg-gray-200 sticky gg">Name</th> <!-- Name with Sticky -->
            <th colspan="2" class="p-2 bg-gray-200">Full-Time</th>
            <th colspan="2" class="p-2 bg-gray-200">Overloads</th>
            <th rowspan="2" class="p-2 bg-gray-200">Total</th>
            <th colspan="3" class="p-2 bg-gray-200">With Review</th>
            <th colspan="3" class="p-2 bg-gray-200">Adjustment</th>
            <th colspan="3" class="p-2 bg-gray-200">Watch Reward</th>
            <th rowspan="2" class="p-2 bg-gray-200">Gross Pay</th>
            <th colspan="3" class="p-2 bg-gray-200">Absences/Late</th>
            <th colspan="2" class="p-2 bg-gray-200">Loans</th>
            <th colspan="5" class="p-2 bg-gray-200">Contributions</th>
            <th rowspan="2" class="p-2 bg-gray-200">Canteen</th>
            <th rowspan="2" class="p-2 bg-gray-200">Others</th>
            <th rowspan="2" class="p-2 bg-gray-200">Total Deductions</th>
            <th rowspan="2" class="p-2 bg-gray-200">Net Pay</th>
        </tr>
        <tr>
            <th class="p-2 bg-gray-200">Basic</th>
            <th class="p-2 bg-gray-200">Honorarium</th>
            <th class="p-2 bg-gray-200">HR</th>
            <th class="p-2 bg-gray-200">Rate</th>
            <th class="p-2 bg-gray-200">HR</th>
            <th class="p-2 bg-gray-200">Rate</th>
            <th class="p-2 bg-gray-200">Total</th>
            <th class="p-2 bg-gray-200">HR</th>
            <th class="p-2 bg-gray-200">Rate</th>
            <th class="p-2 bg-gray-200">Total</th>
            <th class="p-2 bg-gray-200">HR</th>
            <th class="p-2 bg-gray-200">Rate</th>
            <th class="p-2 bg-gray-200">Total</th>
            <th class="p-2 bg-gray-200">HR</th>
            <th class="p-2 bg-gray-200">Rate</th>
            <th class="p-2 bg-gray-200">Total</th>
            <th class="p-2 bg-gray-200">Pag-ibig</th>
            <th class="p-2 bg-gray-200">MP2</th>
            <th class="p-2 bg-gray-200">Medical. S</th>
            <th class="p-2 bg-gray-200">SSS</th>
            <th class="p-2 bg-gray-200">Ret.</th>
            <th class="p-2 bg-gray-200">P-ibig</th>
            <th class="p-2 bg-gray-200">P-Hlth</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-employee='{$row['employee_id']}' class='p-2 sticky'>{$row['full_name']}</td>"; // Sticky Name
                echo "<td class='p-2'>{$row['basic_salary']}</td>"; // Basic Salary
                echo "<td class='p-2'>{$row['honorarium']}</td>"; // Honorarium
                echo "<td class='p-2'>{$row['overload_hr']}</td>"; // Overload HR
                echo "<td><input type='number' name='overload_rate' class='editable-cell' value='{$row['overload_rate']}'></td>";
                echo "<td name='overload_total' class='p-2'>{$row['overload_total']}</td>"; // Overload Total
                echo "<td><input type='number' name='wr_hr' class='editable-cell' value='{$row['wr_hr']}'></td>"; // WR HR
                echo "<td><input type='number' name='wr_rate' class='editable-cell' value='{$row['wr_rate']}'></td>"; // WR Rate
                echo "<td name='wr_total' class='p-2'>{$row['wr_total']}</td>"; // WR Total
                echo "<td><input type='number' name='adjust_rate' class='editable-cell' value='{$row['adjust_rate']}'></td>"; // Adjust Rate
                echo "<td><input type='number' name='adjust_hr' class='editable-cell' value='{$row['adjust_hr']}'></td>"; // Adjust HR
                echo "<td name='adjust_total' class='p-2'>{$row['adjust_total']}</td>"; // Adjust Total
                echo "<td><input type='number' name='watch_hr' class='editable-cell' value='{$row['watch_hr']}'></td>"; // Watch HR
                echo "<td><input type='number' name='watch_rate' class='editable-cell' value='{$row['watch_rate']}'></td>"; // Watch Rate
                echo "<td name='watch_total' class='p-2'>{$row['watch_total']}</td>"; // Watch Total
                echo "<td name='gross_pay' class='p-2'>{$row['gross_pay']}</td>"; // Gross Pay
                echo "<td><input type='number' name='absent_late_hr' class='editable-cell' value='{$row['absent_late_hr']}'></td>"; // Absent Late HR
                echo "<td><input type='number' name='absent_late_rate' class='editable-cell' value='{$row['absent_late_rate']}'></td>"; // Absent Late Rate
                echo "<td name='absent_late_total' class='p-2'>{$row['absent_late_total']}</td>"; // Absent Late Total
                echo "<td><input type='number' name='pagibig' class='editable-cell' value='{$row['pagibig']}'></td>"; // Pagibig
                echo "<td><input type='number' name='mp2' class='editable-cell' value='{$row['mp2']}'></td>"; // MP2
                echo "<td class='p-2'>{$row['pag_ibig_total']}</td>"; // Pag-ibig Total
                echo "<td class='p-2'>{$row['medical_savings']}</td>"; // Medical Savings
                echo "<td class='p-2'>{$row['sss_total']}</td>"; // SSS Total
                echo "<td class='p-2'>{$row['retirement']}</td>"; // Retirement
                echo "<td class='p-2'>{$row['philhealth_total']}</td>"; // Philhealth Total
                echo "<td><input type='number' name='canteen' class='editable-cell' value='{$row['canteen']}'></td>"; // Canteen
                echo "<td><input type='number' name='others' class='editable-cell' value='{$row['others']}'></td>"; // Others
                echo "<td name='total_deduction' class='p-2'>{$row['total_deduction']}</td>"; // Total Deduction
                echo "<td name='net_pay' class='p-2'>{$row['net_pay']}</td>"; // Net Pay
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12' class='p-2 text-center'>No data found</td></tr>";
        }
        ?>
    </tbody>
</table>


            </div>
            <div class="flex justify-end mt-5">
                <button id="saveTableBtn" class="save-btn mb-4">Save Table</button>
            </div>


        </div>
    </main>


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
                row.querySelector("td[name='overload_total']").textContent = overloadTotal.toFixed(2);
                row.querySelector("td[name='wr_total']").textContent = wrTotal.toFixed(2);
                row.querySelector("td[name='adjust_total']").textContent = adjustmentTotal.toFixed(2);
                row.querySelector("td[name='watch_total']").textContent = watchRewardTotal.toFixed(2);
                row.querySelector("td[name='absent_late_total']").textContent = absentLateTotal.toFixed(2);
                row.querySelector("td[name='gross_pay']").textContent = grossPay.toFixed(2);
                row.querySelector("td[name='total_deduction']").textContent = totalDeduction.toFixed(2);
                row.querySelector("td[name='net_pay']").textContent = netPay.toFixed(2);
            }

            // Attach input event listener to editable cells
            document.querySelectorAll(".editable-cell").forEach(cell => {
                cell.addEventListener("input", function() {
                    const row = this.closest("tr");
                    calculateRow(row);
                });
            });

            // Save table data

            saveButton.addEventListener("click", function() {
                const rows = document.querySelectorAll("#crudTable tbody tr");
                const data = [];

                rows.forEach(row => {
                    const rowData = {
                        employee_id: row.querySelector("td[data-employee]").getAttribute("data-employee") || 0, // Default employee_id to 0
                        full_name: row.querySelector("td[data-employee]").textContent || "", // Ensure full_name is set to an empty string if empty
                        basic_salary: parseFloat(row.querySelector("td:nth-child(2)").textContent) || 0,
                        honorarium: parseFloat(row.querySelector("td:nth-child(3)").textContent) || 0,
                        overload_hr: parseFloat(row.querySelector("td:nth-child(4)").textContent) || 0,
                        overload_rate: parseFloat(row.querySelector("input[name='overload_rate']").value) || 0,
                        overload_total: parseFloat(row.querySelector("td[name='overload_total']").textContent) || 0,
                        wr_hr: parseFloat(row.querySelector("input[name='wr_hr']").value) || 0,
                        wr_rate: parseFloat(row.querySelector("input[name='wr_rate']").value) || 0,
                        wr_total: parseFloat(row.querySelector("td[name='wr_total']").textContent) || 0,
                        adjust_hr: parseFloat(row.querySelector("input[name='adjust_hr']").value) || 0,
                        adjust_rate: parseFloat(row.querySelector("input[name='adjust_rate']").value) || 0,
                        adjust_total: parseFloat(row.querySelector("td[name='adjust_total']").textContent) || 0,
                        watch_hr: parseFloat(row.querySelector("input[name='watch_hr']").value) || 0,
                        watch_rate: parseFloat(row.querySelector("input[name='watch_rate']").value) || 0,
                        watch_total: parseFloat(row.querySelector("td[name='watch_total']").textContent) || 0,
                        gross_pay: parseFloat(row.querySelector("td[name='gross_pay']").textContent) || 0,
                        absent_late_hr: parseFloat(row.querySelector("input[name='absent_late_hr']").value) || 0,
                        absent_late_rate: parseFloat(row.querySelector("input[name='absent_late_rate']").value) || 0,
                        absent_late_total: parseFloat(row.querySelector("td[name='absent_late_total']").textContent) || 0,
                        pagibig: parseFloat(row.querySelector("input[name='pagibig']").value) || 0,
                        mp2: parseFloat(row.querySelector("input[name='mp2']").value) || 0,
                        canteen: parseFloat(row.querySelector("input[name='canteen']").value) || 0,
                        others: parseFloat(row.querySelector("input[name='others']").value) || 0,
                        total_deduction: parseFloat(row.querySelector("td[name='total_deduction']").textContent) || 0,
                        net_pay: parseFloat(row.querySelector("td[name='net_pay']").textContent) || 0,
                    };
                    data.push(rowData);
                });

                // Send data to server using AJAX
                fetch("cc-save.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert("Data saved successfully!");
                            location.reload();  // This refreshes the page
                        } else {
                            alert("Failed to save data: " + result.message);
                            console.error("Server Error: ", result.message); // Log server error message in the console
                        }
                    })
                    .catch(error => {
                        console.error("Error occurred while sending request:", error); // Log the error if the network request fails
                        alert("An error occurred while saving data.");
                    });
            });



        });
    </script>

</body>

</html>