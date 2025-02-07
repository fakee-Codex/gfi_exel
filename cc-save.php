<?php
// cc-save.php
require 'database_connection.php';

// Decode the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Process each row of data
    foreach ($data as $row) {
        // Extract data
        $employee_id = $row['employee_id'];
        $full_name = $row['full_name'];
        $basic_salary = $row['basic_salary'];
        $honorarium = $row['honorarium'];
        $overload_hr = $row['overload_hr'];
        $overload_rate = $row['overload_rate'];
        $overload_total = $row['overload_total'];
        $wr_hr = $row['wr_hr'];
        $wr_rate = $row['wr_rate'];
        $wr_total = $row['wr_total'];
        $adjust_hr = $row['adjust_hr'];
        $adjust_rate = $row['adjust_rate'];
        $adjust_total = $row['adjust_total'];
        $watch_hr = $row['watch_hr'];
        $watch_rate = $row['watch_rate'];
        $watch_total = $row['watch_total'];
        $gross_pay = $row['gross_pay'];
        $absent_late_hr = $row['absent_late_hr'];
        $absent_late_rate = $row['absent_late_rate'];
        $absent_late_total = $row['absent_late_total'];
        $pagibig = $row['pagibig'];
        $mp2 = $row['mp2'];
        $canteen = $row['canteen'];
        $others = $row['others'];
        $total_deduction = $row['total_deduction'];
        $net_pay = $row['net_pay'];

        // Log extracted data
        $log_data = "Employee ID: $employee_id, Full Name: $full_name, Basic Salary: $basic_salary, Honorarium: $honorarium, Overload HR: $overload_hr, Overload Rate: $overload_rate, Overload Total: $overload_total, WR HR: $wr_hr, WR Rate: $wr_rate, WR Total: $wr_total, Adjust HR: $adjust_hr, Adjust Rate: $adjust_rate, Adjust Total: $adjust_total, Watch HR: $watch_hr, Watch Rate: $watch_rate, Watch Total: $watch_total, Gross Pay: $gross_pay, Absent Late HR: $absent_late_hr, Absent Late Rate: $absent_late_rate, Absent Late Total: $absent_late_total, Pagibig: $pagibig, MP2: $mp2, Canteen: $canteen, Others: $others, Total Deduction: $total_deduction, Net Pay: $net_pay\n";

        // Write the log data to a log file
        file_put_contents('data_log.txt', $log_data, FILE_APPEND);

        // Check if the employee_id already exists in the database
        $check_sql = "SELECT employee_id FROM computation WHERE employee_id = '$employee_id'";
        $check_result = $conn->query($check_sql);

        if ($check_result && $check_result->num_rows > 0) {
            // If the employee_id exists, update the data
            $update_sql = "UPDATE computation SET
                overload_rate = '$overload_rate', overload_total = '$overload_total', 
                wr_hr = '$wr_hr', wr_rate = '$wr_rate', wr_total = '$wr_total', 
                adjust_hr = '$adjust_hr', adjust_rate = '$adjust_rate', adjust_total = '$adjust_total', 
                watch_hr = '$watch_hr', watch_rate = '$watch_rate', watch_total = '$watch_total', 
                gross_pay = '$gross_pay', absent_late_hr = '$absent_late_hr', absent_late_rate = '$absent_late_rate', 
                absent_late_total = '$absent_late_total', pagibig = '$pagibig', mp2 = '$mp2', 
                canteen = '$canteen', others = '$others', total_deduction = '$total_deduction', net_pay = '$net_pay' 
                WHERE employee_id = '$employee_id'";

            // Execute the update query
            if (!mysqli_query($conn, $update_sql)) {
                // Handle error
                echo json_encode(["success" => false, "message" => "Error updating data for employee ID: $employee_id"]);
                exit; // Stop further processing if there's an error
            }
        } else {
            // If employee_id does not exist, insert new data
            $insert_sql = "INSERT INTO computation (
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

            // Execute the insert query
            if (!mysqli_query($conn, $insert_sql)) {
                // Handle error
                echo json_encode(["success" => false, "message" => "Error inserting data for employee ID: $employee_id"]);
                exit; // Stop further processing if there's an error
            }
        }
    }

    // Send a success response
    echo json_encode(["success" => true, "message" => "Data saved successfully"]);
} else {
    // Send an error response if no data received
    echo json_encode(["success" => false, "message" => "No data received"]);
}
?>
