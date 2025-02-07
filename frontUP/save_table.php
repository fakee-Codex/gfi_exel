<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !is_array($data)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data format.']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "gfi_exel");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$conn->begin_transaction();

try {   
    $conn->query("DELETE FROM computation");

    foreach ($data as $row) {
        $stmt = $conn->prepare("INSERT INTO computation (employee_name, basic_salary, honorarium, gross_pay, net_pay) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sddds",
            $row['employee_name'],
            $row['basic_salary'],
            $row['honorarium'],
            $row['gross_pay'],
            $row['net_pay']
        );

        if (!$stmt->execute()) {
            throw new Exception('Insert failed: ' . $stmt->error);
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
