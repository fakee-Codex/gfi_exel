<?php
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $conn->real_escape_string($_POST['employee_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $employee_type = $conn->real_escape_string($_POST['employee_type']);
    $classification = $conn->real_escape_string($_POST['classification']);
    $basic_salary = $conn->real_escape_string($_POST['basic_salary']);
    $honorarium = $conn->real_escape_string($_POST['honorarium']);

    $sql = "UPDATE employees SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            employee_type = '$employee_type', 
            classification = '$classification', 
            basic_salary = '$basic_salary', 
            honorarium = '$honorarium' 
            WHERE employee_id = '$employee_id'";
    $conn->query($sql);

    header("Location: manage_employees.php?success=1");
    exit();
}
?>
