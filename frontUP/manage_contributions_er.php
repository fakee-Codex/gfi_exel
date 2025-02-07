<?php
// Database connection
require 'database_connection.php';

// Query to fetch Employer Share data
$sql = "SELECT CONCAT(last_name, ', ', first_name) AS Name, basic_salary 
        FROM employees";
$result = $conn->query($sql);

?>

<h3>Employer Share</h3>
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
                $basic_salary = $row['basic_salary'];
                $sss_er = $basic_salary * 0.095;
                $pagibig_er = 200; // Default value
                $philhealth_er = $basic_salary * 0.025;
                $total_er = $sss_er + $pagibig_er + $philhealth_er;

                echo "<tr>
                        <td>{$row['Name']}</td>
                        <td>" . number_format($basic_salary, 2) . "</td>
                        <td>" . number_format($sss_er, 2) . "</td>
                        <td>{$pagibig_er}</td>
                        <td>" . number_format($philhealth_er, 2) . "</td>
                        <td>" . number_format($total_er, 2) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$conn->close();
?>
