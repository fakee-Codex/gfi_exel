<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through each employee entry
    for ($i = 0; $i < count($_POST['first_name']); $i++) {
        $first_name = $conn->real_escape_string($_POST['first_name'][$i]);
        $last_name = $conn->real_escape_string($_POST['last_name'][$i]);
        $employee_type = $conn->real_escape_string($_POST['employee_type'][$i]);
        $classification = $conn->real_escape_string($_POST['classification'][$i]);
        $basic_salary = $conn->real_escape_string($_POST['basic_salary'][$i]);
        $honorarium = $conn->real_escape_string($_POST['honorarium'][$i]);

        $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, employee_type, classification, basic_salary, honorarium) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdd", $first_name, $last_name, $employee_type, $classification, $basic_salary, $honorarium);
        $stmt->execute();
    }
    header("Location: manage_employees.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'sidebars.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script>
        function addEmployeeForm() {
            var container = document.getElementById('employeeForms');
            var newForm = document.createElement('div');
            newForm.classList.add('employee-entry');
            newForm.innerHTML = `
             <hr>
                <h4>Employee ${container.children.length + 1}</h4>
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="employee_type" class="form-label">Employee Type</label>
                    <select name="employee_type[]" class="form-select" required>
                        <option value="full-time">Full-Time</option>
                        <option value="part-time">Part-Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="classification" class="form-label">Classification</label>
                    <input type="text" name="classification[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="basic_salary" class="form-label">Basic Salary</label>
                    <input type="number" name="basic_salary[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="honorarium" class="form-label">Honorarium</label>
                    <input type="number" name="honorarium[]" class="form-control">
                </div>
            `;
            container.appendChild(newForm);
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Employee</h2>
        <form method="POST" action="">
            <div id="employeeForms">
                <!-- Dynamically added employee forms will appear here -->
            </div>
            <button type="button" class="btn btn-secondary" onclick="addEmployeeForm()">Add More Employees</button>
            <br><br>
            <button type="submit" class="btn btn-primary">Submit All Employees</button>
        </form>
    </div>
</body>
</html>
