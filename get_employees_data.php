<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID is passed via GET
if (isset($_GET['id'])) {
    $employee_id = $conn->real_escape_string($_GET['id']);

    // Query to fetch the employee data
    $result = $conn->query("SELECT * FROM employees WHERE employee_id = '$employee_id'");

    if ($result->num_rows > 0) {
        // Fetch the employee data as an associative array
        $employee = $result->fetch_assoc();

        // Return the data as a JSON response
        echo json_encode([
            "status" => "success",
            "data" => $employee
        ]);
    } else {
        // Employee not found
        echo json_encode([
            "status" => "error",
            "message" => "Employee not found."
        ]);
    }
} else {
    // No ID passed
    echo json_encode([
        "status" => "error",
        "message" => "No employee ID provided."
    ]);
}
?>
