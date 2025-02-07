<?php
require 'database_connection.php';

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);
$response = ['status' => 'error', 'message' => 'No data recesived.'];

if ($data) {
    $errors = []; // To track errors for individual rows
    $duplicates = []; // To track duplicate employee IDs
    $successCount = 0;

    foreach ($data as $row) {
        // Extract values
        $employee_id = $row['employee_id'];
        $overload_rate = $row['overload_rate'] ?? 0;
        $overload_total = $row['overload_total'] ?? 0;
        $wr_hr = $row['wr_hr'] ?? 0;
        $wr_rate = $row['wr_rate'] ?? 0;
        $wr_total = $row['wr_total'] ?? 0;
        $adjust_hr = $row['adjust_hr'] ?? 0;
        $adjust_rate = $row['adjust_rate'] ?? 0;
        $adjust_total = $row['adjust_total'] ?? 0;
        $watch_hr = $row['watch_hr'] ?? 0;
        $watch_rate = $row['watch_rate'] ?? 0;
        $watch_total = $row['watch_total'] ?? 0;
        $gross_pay = $row['gross_pay'] ?? 0;
        $absent_late_hr = $row['absent_late_hr'] ?? 0;
        $absent_late_rate = $row['absent_late_rate'] ?? 0;
        $absent_late_total = $row['absent_late_total'] ?? 0;
        $pagibig = $row['pagibig'] ?? 0;
        $mp2 = $row['mp2'] ?? 0;
        $canteen = $row['canteen'] ?? 0;
        $others = $row['others'] ?? 0;
        $total_deduction = $row['total_deduction'] ?? 0;
        $net_pay = $row['net_pay'] ?? 0;

        // Check if employee_id already exists in the table
        $check_sql = "SELECT employee_id FROM computation WHERE employee_id = '$employee_id'";
        $check_result = $conn->query($check_sql);

        if ($check_result && $check_result->num_rows > 0) {
            $duplicates[] = $employee_id; // Add to duplicates list
            continue; // Skip this entry
        }

        // Insert SQL query
        $sql = "INSERT INTO computation (
                    employee_id, overload_rate, overload_total, wr_hr, wr_rate, wr_total, 
                    adjust_hr, adjust_rate, adjust_total, watch_hr, watch_rate, watch_total, 
                    gross_pay, absent_late_hr, absent_late_rate, absent_late_total, pagibig, 
                    mp2, canteen, others, total_deduction, net_pay
                ) VALUES (
                    '$employee_id', '$overload_rate', '$overload_total', '$wr_hr', '$wr_rate', '$wr_total', 
                    '$adjust_hr', '$adjust_rate', '$adjust_total', '$watch_hr', '$watch_rate', '$watch_total', 
                    '$gross_pay', '$absent_late_hr', '$absent_late_rate', '$absent_late_total', '$pagibig', 
                    '$mp2', '$canteen', '$others', '$total_deduction', '$net_pay'
                )";

        if ($conn->query($sql) === TRUE) {
            $successCount++; // Increment success count
        } else {
            $errors[] = "Error for Employee ID: $employee_id - " . $conn->error;
        }
    }

    // Prepare the response
    if ($successCount > 0) {
        $response = [
            'status' => 'success',
            'message' => "$successCount row(s) saved successfully.",
        ];
    }

    if (!empty($duplicates)) {
        $response['duplicates'] = "Duplicate entries detected for Employee ID(s): " . implode(", ", $duplicates);
    }

    if (!empty($errors)) {
        $response['errors'] = $errors;
    }
}

// Send the final response
header('Content-Type: application/json');
echo json_encode($response);


employee_id, overload_rate, overload_total, wr_hr, wr_rate, wr_total, 
adjust_hr, adjust_rate, adjust_total, watch_hr, watch_rate, watch_total, 
gross_pay, absent_late_hr, absent_late_rate, absent_late_total, pagibig, 
mp2, canteen, others, total_deduction, net_pay