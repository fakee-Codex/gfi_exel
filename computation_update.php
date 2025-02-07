<?php
require 'database_connection.php';

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['employee_id'])) {
    $employee_id = $data['employee_id'];
    $updates = [];
    $values = [];

    // Dynamically build the update query
    foreach ($data as $column => $value) {
        if ($column !== "employee_id") {
            $updates[] = "$column = ?";
            $values[] = $value;
        }
    }

    if (!empty($updates)) {
        $values[] = $employee_id; // Add employee_id for WHERE clause
        $sql = "UPDATE computation SET " . implode(", ", $updates) . " WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(str_repeat("s", count($values)), ...$values);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Data updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating data: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to prepare statement."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No valid fields to update."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request data."]);
}
?>
