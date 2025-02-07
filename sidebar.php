<?php
require 'database_connection.php';

$sql = "
    SELECT 
        e.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS full_name, 
        e.basic_salary, 
        e.honorarium, 
        
                e.overload_rate,
       
                ct.overload_total,

        ct.wr_hr,
        ct.wr_rate,
        ct.wr_total,
        ct.adjust_hr,
        ct.adjust_rate,
        ct.adjust_total,
        ct.watch_hr,
        e.watch_reward,
        ct.watch_total,
        ct.gross_pay,
        ct.absent_late_hr,
         e.absent_lateRate,
        ct.pagibig,
        ct.mp2,
        ct.sss,
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
            background-color: #fff;
            /* Optional: Set background color to avoid overlap with other columns */
            z-index: 2;
            /* Ensures the first column is above other content */
        }

        .gg {
            position: sticky;
            left: 0;
            z-index: 2;
            /* Ensures the first column is above other content */

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
                            <th colspan="3" class="p-2 bg-gray-200">CLOVES</th>
                            <th colspan="3" class="p-2 bg-gray-200">Adjustment</th>
                            <th colspan="3" class="p-2 bg-gray-200">Watch Reward</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Gross Pay</th>
                            <th colspan="3" class="p-2 bg-gray-200">Absences/Late</th>
                            <th colspan="3" class="p-2 bg-gray-200">Loans</th>
                            <th colspan="5" class="p-2 bg-gray-200">Contributions</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Canteen</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Others</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Total Deductions</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Net Pay</th>
                            <th rowspan="2" class="p-2 bg-gray-200">Action</th>

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
                            <th class="p-2 bg-gray-200">HDMF</th>
                            <th class="p-2 bg-gray-200">MP2</th>
                            <th class="p-2 bg-gray-200">SSS</th>
                            <th class="p-2 bg-gray-200">MED.S</th>
                            <th class="p-2 bg-gray-200">SSS</th>
                            <th class="p-2 bg-gray-200">RET.</th>
                            <th class="p-2 bg-gray-200">P-IBIG</th>
                            <th class="p-2 bg-gray-200">PHIC</th>

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
                                echo "<td class='p-2'>{$row['overload_rate']}</td>";
                                echo "<td name='overload_total' class='p-2'>{$row['overload_total']}</td>"; // Overload Total
                                echo "<td><input type='number' name='wr_hr' class='editable-cell' value='{$row['wr_hr']}'></td>"; // WR HR
                                echo "<td><input type='number' name='wr_rate' class='editable-cell' value='{$row['wr_rate']}'></td>"; // WR Rate
                                echo "<td name='wr_total' class='p-2'>{$row['wr_total']}</td>"; // WR Total
                                echo "<td><input type='number' name='adjust_rate' class='editable-cell' value='{$row['adjust_rate']}'></td>"; // Adjust Rate
                                echo "<td><input type='number' name='adjust_hr' class='editable-cell' value='{$row['adjust_hr']}'></td>"; // Adjust HR
                                echo "<td name='adjust_total' class='p-2'>{$row['adjust_total']}</td>"; // Adjust Total
                                echo "<td><input type='number' name='watch_hr' class='editable-cell' value='{$row['watch_hr']}'></td>"; // Watch HR
                                echo "<td><input type='number' name='watch_reward' class='editable-cell' value='{$row['watch_reward']}'></td>";
                                echo "<td name='watch_total' class='p-2'>{$row['watch_total']}</td>"; // Watch Total
                                echo "<td name='gross_pay' class='p-2'>{$row['gross_pay']}</td>"; // Gross Pay
                                echo "<td><input type='number' name='absent_late_hr' class='editable-cell' value='{$row['absent_late_hr']}'></td>"; // Absent Late HR

                                echo "<td class='p-2' name='absent_lateRate'>{$row['absent_lateRate']}</td>";

                                echo "<td name='absent_late_total' class='p-2'>0.00</td>"; // Absent Late Total

                                // echo "<td><input type='number' name='absent_late_rate' class='editable-cell' value='{$row['absent_late_rate']}'></td>"; // Absent Late Rate

                                echo "<td><input type='number' name='pagibig' class='editable-cell' value='{$row['pagibig']}'></td>"; // Pagibig
                                echo "<td><input type='number' name='mp2' class='editable-cell' value='{$row['mp2']}'></td>"; // MP2
                                echo "<td><input type='number' name='sss' class='editable-cell' value='{$row['sss']}'></td>"; // MP2
                                echo "<td class='p-2'>{$row['pag_ibig_total']}</td>"; // Pag-ibig Total
                                echo "<td class='p-2'>{$row['medical_savings']}</td>"; // Medical Savings
                                echo "<td class='p-2'>{$row['sss_total']}</td>"; // SSS Total
                                echo "<td class='p-2'>{$row['retirement']}</td>"; // Retirement
                                echo "<td class='p-2'>{$row['philhealth_total']}</td>"; // Philhealth Total
                                echo "<td><input type='number' name='canteen' class='editable-cell' value='{$row['canteen']}'></td>"; // Canteen
                                echo "<td><input type='number' name='others' class='editable-cell' value='{$row['others']}'></td>"; // Others
                                echo "<td name='total_deduction' class='p-2'>{$row['total_deduction']}</td>"; // Total Deduction
                                echo "<td name='net_pay' class='p-2'>{$row['net_pay']}</td>"; // Net Pay


                                echo "<td>
                                <button onclick=\"printData('{$row['basic_salary']}', '{$row['full_name']}', '{$row['honorarium']}', '{$row['gross_pay']}', '{$row['sss_total']}', '{$row['total_deduction']}', '{$row['retirement']}', '{$row['medical_savings']}', '{$row['philhealth_total']}', '{$row['pag_ibig_total']}', '{$row['net_pay']}')\" 
                                class=\"px-4 py-2 bg-blue-500 text-white rounded flex items-center gap-2 hover:bg-blue-600\">
                                    <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5\" viewBox=\"0 0 512 512\">
                                        <path d=\"M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z\"/>
                                    </svg>
                                    Print
                                </button>
                              </td>";




                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='p-2 text-center'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <script>
                    function printData(basicSalary, fullName, honorarium, grossPay, sssTotal, philhealthTotal, pagIbigTotal, medicalSavings, retirement, totalDeduction, netPay) {
                        // Open the print.php page and pass all the data via URL
                        window.location.href = 'print.php?basic_salary=' + encodeURIComponent(basicSalary) +
                            '&full_name=' + encodeURIComponent(fullName) +
                            '&honorarium=' + encodeURIComponent(honorarium) +
                            '&gross_pay=' + encodeURIComponent(grossPay) +
                            '&sss_total=' + encodeURIComponent(sssTotal) +
                            '&medical_savings=' + encodeURIComponent(medicalSavings) +
                            '&retirement=' + encodeURIComponent(retirement) +
                            '&total_deduction=' + encodeURIComponent(totalDeduction) +
                            '&philhealth_total=' + encodeURIComponent(philhealthTotal) +
                            '&pag_ibig_total=' + encodeURIComponent(pagIbigTotal) +
                            '&net_pay=' + encodeURIComponent(netPay);
                    }
                </script>



            </div>
            <div class="flex justify-end mt-5 gap-x-4">
                <button id="printTableBtn" class="save-btn mb-4 bg-blue-500 text-white px-4 py-2 rounded" onclick="window.location.href='print2.php';">Print Table</button>


                <button id="saveTableBtn" class="save-btn mb-4">Save Table</button>
            </div>


        </div>
        <script>

        </script>


    </main>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const saveButton = document.getElementById("saveTableBtn");

            // Function to calculate values for a row
            function calculateRow(row) {
                const overloadHR = parseFloat(row.querySelector("td:nth-child(4)").textContent) || 0; // Overload HR
                const overloadRate = parseFloat(row.querySelector("td:nth-child(5)").textContent) || 0; // Overload Rate (non-editable)

                // Calculate overload total (HR * Rate)
                const overloadTotal = overloadHR * overloadRate;

                // Update the overload total cell
                row.querySelector("td[name='overload_total']").textContent = overloadTotal.toFixed(2);

                const adjustmentHR = parseFloat(row.querySelector("input[name='adjust_hr']").value) || 0;
                const adjustmentRate = parseFloat(row.querySelector("input[name='adjust_rate']").value) || 0;
                const wrHR = parseFloat(row.querySelector("input[name='wr_hr']").value) || 0;
                const wrRate = parseFloat(row.querySelector("input[name='wr_rate']").value) || 0;
                const watchHR = parseFloat(row.querySelector("input[name='watch_hr']").value) || 0;
                const watchReward = parseFloat(row.querySelector("input[name='watch_reward']").value) || 0;

                const absentLateHR = parseFloat(row.querySelector("input[name='absent_late_hr']").value) || 0;
                const absentLateRate = parseFloat(row.querySelector("td:nth-child(16)").textContent) || 0;

                // Calculate the absent late total
                const absentLateTotal = absentLateHR * absentLateRate;

                // Update the absent late total cell
                row.querySelector("td[name='absent_late_total']").textContent = absentLateTotal.toFixed(2);

                const pagibig = parseFloat(row.querySelector("input[name='pagibig']").value) || 0;
                const mp2 = parseFloat(row.querySelector("input[name='mp2']").value) || 0;
                const sss = parseFloat(row.querySelector("input[name='sss']").value) || 0;
                const canteen = parseFloat(row.querySelector("input[name='canteen']").value) || 0;
                const others = parseFloat(row.querySelector("input[name='others']").value) || 0;
                const pagibigTotal = parseFloat(row.querySelector("td:nth-child(22)").textContent) || 0; // Pag-ibig Total
                const medicalSavings = parseFloat(row.querySelector("td:nth-child(23)").textContent) || 0; // Medical Savings
                const sssTotal = parseFloat(row.querySelector("td:nth-child(24)").textContent) || 0; // SSS Total
                const retirement = parseFloat(row.querySelector("td:nth-child(25)").textContent) || 0; // Retirement
                const philhealthTotal = parseFloat(row.querySelector("td:nth-child(26)").textContent) || 0; // Philhealth Total

                // Calculate totals
                const wrTotal = wrHR * wrRate;
                const adjustmentTotal = adjustmentHR * adjustmentRate;
                const watchRewardTotal = watchHR * watchReward;

                const totalContributions = pagibigTotal + medicalSavings + sssTotal + retirement + philhealthTotal;
                const totalDeduction = absentLateTotal + pagibig + mp2 + sss + totalContributions + canteen + others;

                const basicSalary = parseFloat(row.querySelector("td:nth-child(2)").textContent) || 0; // Basic Salary
                const honorarium = parseFloat(row.querySelector("td:nth-child(3)").textContent) || 0; // Honorarium
                const grossPay = basicSalary + honorarium + overloadTotal + wrTotal + adjustmentTotal + watchRewardTotal;
                const netPay = grossPay - totalDeduction;

                // Update calculated values in the table
                row.querySelector("td[name='overload_total']").textContent = overloadTotal.toFixed(2);
                row.querySelector("td[name='wr_total']").textContent = wrTotal.toFixed(2);
                row.querySelector("td[name='adjust_total']").textContent = adjustmentTotal.toFixed(2);
                row.querySelector("td[name='watch_total']").textContent = watchRewardTotal.toFixed(2);
                row.querySelector("td[name='gross_pay']").textContent = grossPay.toFixed(2);
                row.querySelector("td[name='total_deduction']").textContent = totalDeduction.toFixed(2);
                row.querySelector("td[name='net_pay']").textContent = netPay.toFixed(2);
            }

            // Trigger calculation when the page loads
            function calculateAllRows() {
                const rows = document.querySelectorAll("#crudTable tbody tr");
                rows.forEach(row => {
                    calculateRow(row);
                });
            }

            // Calculate all rows once the page is loaded
            calculateAllRows();

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
                        overload_rate: parseFloat(row.querySelector("td:nth-child(5)").textContent) || 0,
                        overload_total: parseFloat(row.querySelector("td[name='overload_total']").textContent) || 0,
                        wr_hr: parseFloat(row.querySelector("input[name='wr_hr']").value) || 0,
                        wr_rate: parseFloat(row.querySelector("input[name='wr_rate']").value) || 0,
                        wr_total: parseFloat(row.querySelector("td[name='wr_total']").textContent) || 0,
                        adjust_hr: parseFloat(row.querySelector("input[name='adjust_hr']").value) || 0,
                        adjust_rate: parseFloat(row.querySelector("input[name='adjust_rate']").value) || 0,
                        adjust_total: parseFloat(row.querySelector("td[name='adjust_total']").textContent) || 0,
                        watch_hr: parseFloat(row.querySelector("input[name='watch_hr']").value) || 0,
                        watch_reward: parseFloat(row.querySelector("input[name='watch_reward']").value) || 0,
                        watch_total: parseFloat(row.querySelector("td[name='watch_total']").textContent) || 0,
                        gross_pay: parseFloat(row.querySelector("td[name='gross_pay']").textContent) || 0,
                        absent_late_hr: parseFloat(row.querySelector("input[name='absent_late_hr']").value) || 0,
                        absent_lateRate: parseFloat(row.querySelector("input[name='absent_lateRate']").value) || 0,
                        absent_late_total: parseFloat(row.querySelector("td[name='absent_late_total']").textContent) || 0,
                        pagibig: parseFloat(row.querySelector("input[name='pagibig']").value) || 0,
                        mp2: parseFloat(row.querySelector("input[name='mp2']").value) || 0,
                        sss: parseFloat(row.querySelector("input[name='sss']").value) || 0,
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
                            location.reload(); // This refreshes the page
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