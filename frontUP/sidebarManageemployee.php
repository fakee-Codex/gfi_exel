<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing employee data
$sql_fetch = "SELECT * FROM employees";
$result = $conn->query($sql_fetch);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to toggle between views (Employee List and Edit Form)
        function toggleEditForm(employeeId) {
            document.getElementById('employeeList').style.display = 'none';
            document.getElementById('editEmployeeForm').style.display = 'block';

            // Fetch data for the selected employee and populate the edit form
            fetch(`get_employee_data.php?id=${employeeId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id').value = data.employee_id;
                    document.getElementById('edit_first_name').value = data.first_name;
                    document.getElementById('edit_last_name').value = data.last_name;
                    document.getElementById('edit_employee_type').value = data.employee_type;
                    document.getElementById('edit_classification').value = data.classification;
                    document.getElementById('edit_basic_salary').value = data.basic_salary;
                    document.getElementById('edit_honorarium').value = data.honorarium;
                });
        }

        // Function to go back to Employee List
        function toggleView(view) {
            if (view === 'employeeList') {
                document.getElementById('employeeList').style.display = 'block';
                document.getElementById('addEmployeeForm').style.display = 'none'; // Hide Add Employee Form
                document.getElementById('editEmployeeForm').style.display = 'none';
            
        } else if (view === 'addEmployee') {
            document.getElementById('employeeList').style.display = 'none'; // Hide Employee List
            document.getElementById('editEmployeeForm').style.display = 'none'; // Hide Edit Employee Form
            document.getElementById('addEmployeeForm').style.display = 'block'; // Show Add Employee Form
        }
         }
    </script>
</head>
<link rel="stylesheet" href="css/bootstrap.min.css">

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->


    <main>
    <div class="container mt-5">
        <!-- Employee List Section -->
        <div id="employeeList">
            <h2 class="mb-9">Employee List</h2>
            <button class="btn btn-primary mb-3" onclick="toggleView('addEmployee')">ADD EMPLOYEE</button>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Employee Type</th>
                        <th>Classification</th>
                        <th>Basic Salary</th>
                        <th>Honorarium</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['employee_id'] . "</td>
                                    <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
                                    <td>" . ucfirst($row['employee_type']) . "</td>
                                    <td>" . $row['classification'] . "</td>
                                    <td>₱" . number_format($row['basic_salary'], 2) . "</td>
                                    <td>₱" . number_format($row['honorarium'], 2) . "</td>
                                    <td>
                                        <button class='btn btn-danger btn-sm' onclick='toggleEditForm(" . $row['employee_id'] . ")'>EDIT</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No employees found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add Employee Form Section -->
        <div id="addEmployeeForm" style="display: none;">
            <h2>Add Employee</h2>
            <button class="btn btn-secondary mb-3" onclick="toggleView('employeeList')">Back to Employee List</button>
            <form method="POST" action="manage_employees_add.php">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="employee_type" class="form-label">Employee Type</label>
                    <select name="employee_type" class="form-select" required>
                        <option value="full-time">Full-Time</option>
                        <option value="part-time">Part-Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="classification" class="form-label">Classification</label>
                    <input type="text" name="classification" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="basic_salary" class="form-label">Basic Salary</label>
                    <input type="number" name="basic_salary" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="honorarium" class="form-label">Honorarium</label>
                    <input type="number" name="honorarium" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Employee</button>
            </form>
        </div>

        <!-- Edit Employee Form Section -->
        <div id="editEmployeeForm" style="display: none;">
            <h2>Edit Employee</h2>
            <button class="btn btn-secondary mb-3" onclick="toggleView('employeeList')">Back to Employee List</button>
            <form method="POST" action="manage_employees_edit.php">
                <input type="hidden" name="employee_id" id="edit_id">
                <div class="form-group">
                    <label for="edit_first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="edit_first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="edit_last_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_employee_type" class="form-label">Employee Type</label>
                    <select name="employee_type" id="edit_employee_type" class="form-select">
                        <option value="full-time">Full-Time</option>
                        <option value="part-time">Part-Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_classification" class="form-label">Classification</label>
                    <input type="text" name="classification" id="edit_classification" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_basic_salary" class="form-label">Basic Salary</label>
                    <input type="number" name="basic_salary" id="edit_basic_salary" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_honorarium" class="form-label">Honorarium</label>
                    <input type="number" name="honorarium" id="edit_honorarium" class="form-control">
                </div>
                <button type="submit" class="btn btn-success mt-3">Save Changes</button>
            </form>
        </div>
    </div>
    </main>



</body>

</html>