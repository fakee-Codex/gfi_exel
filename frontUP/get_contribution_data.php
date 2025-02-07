<?php
require 'database_connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $contribution_id = $_GET['id'];

    $sql = "SELECT 
                c.contributions_id,
                e.employee_id,
                CONCAT(e.last_name, ', ', e.first_name) AS Name,
                e.employee_type AS Type,
                e.basic_salary AS Basic,
                c.sss_ee, c.pag_ibig_ee, c.philhealth_ee,
                c.sss_er, c.pag_ibig_er, c.philhealth_er
            FROM contributions c
            JOIN employees e ON c.employee_id = e.employee_id
            WHERE c.contributions_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contribution_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        echo "<div class='text-center mb-4'>
                <h6 class='fw-bold text-muted'>Employee</h6>
                <p class='fs-5'>{$row['Name']}</p>
                <p class='text-muted'>{$row['Type']}</p>
                <p class='fw-light fs-6'>Basic Salary: ₱" . number_format($row['Basic'], 2) . "</p>
            </div>";

        echo "<div class='text-center'>
                <h6 class='fw-bold text-muted'>Contribution Details</h6>
                <p class='fs-6'>SSS (EE): ₱" . number_format($row['sss_ee'], 2) . " <small class='text-muted'>(9.5%)</small></p>
                <p class='fs-6'>SSS (ER): ₱" . number_format($row['sss_er'], 2) . " <small class='text-muted'>(4.5%)</small></p>
                <p class='fs-6'>Pag-ibig (EE): ₱" . number_format($row['pag_ibig_ee'], 2) . "</p>
                <p class='fs-6'>Pag-ibig (ER): ₱" . number_format($row['pag_ibig_er'], 2) . "</p>
                <p class='fs-6'>PhilHealth (EE): ₱" . number_format($row['philhealth_ee'], 2) . " <small class='text-muted'>(2.5%)</small></p>
                <p class='fs-6'>PhilHealth (ER): ₱" . number_format($row['philhealth_er'], 2) . " <small class='text-muted'>(2.5%)</small></p>
            </div>";
    } else {
        echo "<p>No details found for this contribution.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}

$conn->close();
?>
