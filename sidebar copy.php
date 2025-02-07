<?php
// Database connection
require 'database_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the contributions table
$sql = "SELECT 
            c.contributions_id,
            e.employee_id,
            CONCAT(e.last_name, ', ', e.first_name) AS Name,
            e.employee_type AS Type,
            e.basic_salary AS Basic,
            c.sss_ee, c.pag_ibig_ee, c.philhealth_ee,
            c.sss_er, c.pag_ibig_er, c.philhealth_er,
            c.medical_savings, c.retirement
        FROM contributions c
        JOIN employees e ON c.employee_id = e.employee_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       
    </style>
</head>

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->
<style>

</style>
    <main>
    <div class="container mt-5 mb-3 text-center">
        <h1>CONTRIBUTIONS</h1>
    </div>

    <p><strong>Legend:</strong> Total contributions include both Employee (EE) and Employer (ER) shares.</p>
    <a href="manage_contributions_add.php" class="btn btn-primary mb-3">Add Contribution</a>

    <!-- Table Section -->
    <div id="contributions-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee Type</th>
                    <th>Basic Salary</th>
                    <th>SSS Total</th>
                    <th>Pag-ibig Total</th>
                    <th>PhilHealth Total</th>
                    <th>Total EE</th>
                    <th>Total ER</th>
                    <th>Medical Savings</th>
                    <th>Retirement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sss_total = $row['sss_ee'] + $row['sss_er'];
                        $pagibig_total = $row['pag_ibig_ee'] + $row['pag_ibig_er'];
                        $philhealth_total = $row['philhealth_ee'] + $row['philhealth_er'];
                        $total_ee = $row['sss_ee'] + $row['pag_ibig_ee'] + $row['philhealth_ee'];
                        $total_er = $row['sss_er'] + $row['pag_ibig_er'] + $row['philhealth_er'];
                        $medical_savings = $row['medical_savings'];
                        $retirement = $row['retirement'];

                        echo "<tr>
                    <td>{$row['Name']}</td>
                    <td>{$row['Type']}</td>
                    <td>₱" . number_format($row['Basic'], 2) . "</td>
                    <td>₱" . number_format($sss_total, 2) . "</td>
                    <td>₱" . number_format($pagibig_total, 2) . "</td>
                    <td>₱" . number_format($philhealth_total, 2) . "</td>
                    <td>₱" . number_format($total_ee, 2) . "</td>
                    <td>₱" . number_format($total_er, 2) . "</td>
                    <td>₱" . number_format($medical_savings, 2) . "</td>
                    <td>₱" . number_format($retirement, 2) . "</td>
                    <td>
                        <a href='manage_contributions_edit.php?id={$row['contributions_id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#viewModal' 
                            onclick='loadModal({$row['contributions_id']})'>View</button>
                    </td>
                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="viewModalLabel">Contribution Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-content">
                        <!-- Content will be loaded here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadModal(id) {
            fetch(`get_contribution_data.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modal-content').innerHTML = data;
                })
                .catch(error => console.error('Error fetching modal data:', error));
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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