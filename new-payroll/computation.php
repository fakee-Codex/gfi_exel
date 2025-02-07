<?php
require 'database_connection.php';

// SQL query to fetch all necessary data for computation
$sql = "
    SELECT 
        e.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS full_name,
        e.basic_salary, 
        e.honorarium,
        comp.overload_rate,
        comp.overload_total,
        comp.wr_hr,
        comp.wr_rate,
        comp.wr_total,
        comp.adjust_hr,
        comp.adjust_rate,
        comp.adjust_total,
        comp.watch_hr,
        comp.watch_rate,
        comp.watch_total,
        comp.gross_pay,
        comp.absent_late_hr,
        comp.absent_late_rate,
        comp.absent_late_total,
        comp.pagibig AS loan_pagibig,
        comp.mp2 AS loan_mp2,
        COALESCE(SUM(o.grand_total), 0) AS overload_hr,
        COALESCE(c.medical_savings, 0) AS medical_savings,
        COALESCE(c.retirement, 0) AS retirement,
        COALESCE((c.sss_ee + c.sss_er), 0) AS sss_total,
        COALESCE((c.pag_ibig_ee + c.pag_ibig_er), 0) AS pag_ibig_total,
        COALESCE((c.philhealth_ee + c.philhealth_er), 0) AS philhealth_total,
        comp.canteen,
        comp.others,
        comp.total_deduction,
        comp.net_pay
    FROM employees e
    LEFT JOIN overload o ON e.employee_id = o.employee_id
    LEFT JOIN contributions c ON e.employee_id = c.employee_id
    LEFT JOIN computation comp ON e.employee_id = comp.employee_id
    GROUP BY e.employee_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table_styles.css">
    <title>Computation Data</title>
</head>

<body>
    <?php include 'sidebars.php'; ?>
    <div class="content">
        <h1>Computation Data Overview</h1>
        <div class="table-wrapper">
            <table>
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
                        <th>Basic Salary</th>
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
                        <th>Medical Savings</th>
                        <th>SSS</th>
                        <th>Retirement</th>
                        <th>Pag-ibig</th>
                        <th>Philhealth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-employee-id='{$row['employee_id']}'>";
                            echo "<td>{$row['full_name']}</td>";
                            echo "<td>{$row['basic_salary']}</td>"; // Non-editable
                            echo "<td>{$row['honorarium']}</td>"; // Non-editable
                            echo "<td>{$row['overload_hr']}</td>"; // Non-editable
                            echo "<td contenteditable='true' data-column='overload_rate'>{$row['overload_rate']}</td>";
                            echo "<td contenteditable='true' data-column='overload_total'>{$row['overload_total']}</td>";
                            echo "<td contenteditable='true' data-column='wr_hr'>{$row['wr_hr']}</td>";
                            echo "<td contenteditable='true' data-column='wr_rate'>{$row['wr_rate']}</td>";
                            echo "<td contenteditable='true' data-column='wr_total'>{$row['wr_total']}</td>";
                            echo "<td contenteditable='true' data-column='adjust_hr'>{$row['adjust_hr']}</td>";
                            echo "<td contenteditable='true' data-column='adjust_rate'>{$row['adjust_rate']}</td>";
                            echo "<td contenteditable='true' data-column='adjust_total'>{$row['adjust_total']}</td>";
                            echo "<td contenteditable='true' data-column='watch_hr'>{$row['watch_hr']}</td>";
                            echo "<td contenteditable='true' data-column='watch_rate'>{$row['watch_rate']}</td>";
                            echo "<td contenteditable='true' data-column='watch_total'>{$row['watch_total']}</td>";
                            echo "<td>{$row['gross_pay']}</td>"; // Non-editable, calculated
                            echo "<td contenteditable='true' data-column='absent_late_hr'>{$row['absent_late_hr']}</td>";
                            echo "<td contenteditable='true' data-column='absent_late_rate'>{$row['absent_late_rate']}</td>";
                            echo "<td contenteditable='true' data-column='absent_late_total'>{$row['absent_late_total']}</td>";
                            echo "<td contenteditable='true' data-column='loan_pagibig'>{$row['loan_pagibig']}</td>";
                            echo "<td contenteditable='true' data-column='loan_mp2'>{$row['loan_mp2']}</td>";
                            echo "<td>{$row['medical_savings']}</td>"; // Non-editable
                            echo "<td>{$row['retirement']}</td>"; // Non-editable
                            echo "<td>{$row['sss_total']}</td>"; // Non-editable
                            echo "<td>{$row['pag_ibig_total']}</td>"; // Non-editable
                            echo "<td>{$row['philhealth_total']}</td>"; // Non-editable
                            echo "<td contenteditable='true' data-column='canteen'>{$row['canteen']}</td>";
                            echo "<td contenteditable='true' data-column='others'>{$row['others']}</td>";
                            echo "<td>{$row['total_deduction']}</td>"; // Non-editable, calculated
                            echo "<td>{$row['net_pay']}</td>"; // Non-editable, calculated
                            echo "<td><button class='edit-btn'>Edit</button> <button class='save-btn' disabled>Save</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='30'>No data found</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle Edit Buttons
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");

                // Enable editing for specific cells
                row.querySelectorAll("td[contenteditable='true']").forEach(cell => {
                    cell.style.backgroundColor = "#f9f9f9"; // Highlight editable cells
                    cell.setAttribute("contenteditable", "true");
                });

                // Enable Save button for the row
                row.querySelector(".save-btn").removeAttribute("disabled");
            });
        });

        // Handle Save Buttons
        document.querySelectorAll(".save-btn").forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                const employeeId = row.getAttribute("data-employee-id");
                const updatedData = {};

                // Collect updated values
                row.querySelectorAll("td[contenteditable='true']").forEach(cell => {
                    const column = cell.getAttribute("data-column");
                    updatedData[column] = cell.textContent.trim();
                });

                // Disable Save button until the next edit
                button.setAttribute("disabled", "true");

                // Send data to the server
                fetch("update_computation.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            employee_id: employeeId,
                            ...updatedData
                        }),
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === "success") {
                            alert("Row updated successfully.");
                            row.querySelectorAll("td[contenteditable='true']").forEach(cell => {
                                cell.setAttribute("contenteditable", "false");
                                cell.style.backgroundColor = ""; // Reset styling
                            });
                        } else {
                            alert("Failed to update row: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while updating the row.");
                    });
            });
        });
    });
</script>

</html>