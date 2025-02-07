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
    <title>Manage Contributions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
</body>

</html>

<?php
$conn->close();
?>