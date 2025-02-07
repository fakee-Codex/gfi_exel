<?php
// Database connection details
$host = 'localhost';
$dbname = 'gfi_exel';
$username = 'root';
$password = '';

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the posted data
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || empty($data)) {
        http_response_code(400);
        echo json_encode(["error" => "No data received."]);
        exit;
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO overload (
        employee_id, wednesday_days, wednesday_hrs, wednesday_total,
        thursday_days, thursday_hrs, thursday_total,
        friday_days, friday_hrs, friday_total,
        mtth_days, mtth_hrs, mtth_total,
        mtwf_days, mtwf_hrs, mtwf_total,
        twthf_days, twthf_hrs, twthf_total,
        mw_days, mw_hrs, mw_total,
        less_lateOL, additional, adjustment_less, grand_total
    ) VALUES (
        :employee_id, :wednesday_days, :wednesday_hrs, :wednesday_total,
        :thursday_days, :thursday_hrs, :thursday_total,
        :friday_days, :friday_hrs, :friday_total,
        :mtth_days, :mtth_hrs, :mtth_total,
        :mtwf_days, :mtwf_hrs, :mtwf_total,
        :twthf_days, :twthf_hrs, :twthf_total,
        :mw_days, :mw_hrs, :mw_total,
        :less_lateOL, :additional, :adjustment_less, :grand_total
    )";
    

    $stmt = $pdo->prepare($sql);

    // Iterate through the data and insert each row
    foreach ($data as $row) {
        $stmt->execute([
            ':employee_id' => $row['employee_id'],
            ':wednesday_days' => $row['column_1'] ?? 0,
            ':wednesday_hrs' => $row['column_2'] ?? 0,
            ':wednesday_total' => $row['column_3'] ?? 0,
            ':thursday_days' => $row['column_4'] ?? 0,
            ':thursday_hrs' => $row['column_5'] ?? 0,
            ':thursday_total' => $row['column_6'] ?? 0,
            ':friday_days' => $row['column_7'] ?? 0,
            ':friday_hrs' => $row['column_8'] ?? 0,
            ':friday_total' => $row['column_9'] ?? 0,
            ':mtth_days' => $row['column_10'] ?? 0,
            ':mtth_hrs' => $row['column_11'] ?? 0,
            ':mtth_total' => $row['column_12'] ?? 0,
            ':mtwf_days' => $row['column_13'] ?? 0,
            ':mtwf_hrs' => $row['column_14'] ?? 0,
            ':mtwf_total' => $row['column_15'] ?? 0,
            ':twthf_days' => $row['column_16'] ?? 0,
            ':twthf_hrs' => $row['column_17'] ?? 0,
            ':twthf_total' => $row['column_18'] ?? 0,
            ':mw_days' => $row['column_19'] ?? 0,
            ':mw_hrs' => $row['column_20'] ?? 0,
            ':mw_total' => $row['column_21'] ?? 0,
            ':less_lateOL' => $row['column_22'] ?? 0,
            ':additional' => $row['column_23'] ?? 0,
            ':adjustment_less' => $row['column_24'] ?? 0,
            ':grand_total' => $row['column_25'] ?? 0
        ]);
    }

    // Return success response
    echo json_encode(["success" => true, "message" => "Data saved successfully."]);
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
