<?php
// Database connection
require 'database_connection.php';

// Query to fetch Employee Share data, including existing contribution values
$sql = "SELECT 
            e.employee_id, 
            CONCAT(e.last_name, ', ', e.first_name) AS Name, 
            e.basic_salary,
            c.sss_ee, 
            c.pag_ibig_ee, 
            c.philhealth_ee
        FROM employees e
        LEFT JOIN contributions c ON e.employee_id = c.employee_id";
$result = $conn->query($sql);

// Handle Save functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['sss_ee'] as $employee_id => $sss_ee_value) {
        $pagibig_ee_value = $_POST['pag_ibig_ee'][$employee_id];
        $philhealth_ee_value = $_POST['philhealth_ee'][$employee_id];

        // Update the values in the database
        $update_sql = "UPDATE contributions 
                       SET sss_ee = ?, pag_ibig_ee = ?, philhealth_ee = ? 
                       WHERE employee_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("dddi", $sss_ee_value, $pagibig_ee_value, $philhealth_ee_value, $employee_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Data saved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}

?>

<h3>Employee Share</h3>
<form method="POST">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Basic Salary</th>
                <th>SSS</th>
                <th>Pag-ibig</th>
                <th>PhilHealth</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Get existing values or set defaults if null
                    $basic_salary = $row['basic_salary'];
                    $sss_ee = $row['sss_ee'] ?? ($basic_salary * 0.045);
                    $pagibig_ee = $row['pag_ibig_ee'] ?? 200;
                    $philhealth_ee = $row['philhealth_ee'] ?? ($basic_salary * 0.025);
                    $total_ee = $sss_ee + $pagibig_ee + $philhealth_ee;

                    echo "<tr>
                            <td>{$row['Name']}</td>
                            <td>" . number_format($basic_salary, 2) . "</td>
                            <td><input type='number' name='sss_ee[{$row['employee_id']}]' value='" . number_format($sss_ee, 2) . "' class='form-control' /></td>
                            <td><input type='number' name='pag_ibig_ee[{$row['employee_id']}]' value='" . number_format($pagibig_ee, 2) . "' class='form-control' /></td>
                            <td><input type='number' name='philhealth_ee[{$row['employee_id']}]' value='" . number_format($philhealth_ee, 2) . "' class='form-control' /></td>
                            <td>" . number_format($total_ee, 2) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Single Save Button for the whole form -->
    <button type="submit" class="btn btn-success">Save All Changes</button>
</form>

<?php
$conn->close();
?>
