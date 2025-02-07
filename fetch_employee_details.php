<?php
require 'database_connection.php';

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Fetch employee details
    $query = "SELECT basic_salary, employee_type FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        echo json_encode($employee);
    } else {
        echo json_encode(['basic_salary' => '', 'employee_type' => '']);
    }
    $stmt->close();
}

$conn->close();
?>
