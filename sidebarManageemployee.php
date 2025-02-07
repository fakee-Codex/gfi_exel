<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing employee data
$sql_fetch = "SELECT * FROM employees";
$result = $conn->query($sql_fetch);

// Fetch employee data for editing if the edit_id is provided
$employee = null;
if (isset($_GET['edit_id'])) {
    $employee_id = $_GET['edit_id'];
    $sql_fetch_edit = "SELECT * FROM employees WHERE employee_id = $employee_id";
    $result_edit = $conn->query($sql_fetch_edit);
    $employee = $result_edit->fetch_assoc();
}

// Check if the form is submitted for adding or updating employees
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['add'])) {

        // Loop through each employee entry
        for ($i = 0; $i < count($_POST['first_name']); $i++) {
            $first_name = $conn->real_escape_string($_POST['first_name'][$i]);
            $last_name = $conn->real_escape_string($_POST['last_name'][$i]);
            $employee_type = $conn->real_escape_string($_POST['employee_type'][$i]);
            $classification = $conn->real_escape_string($_POST['classification'][$i]);
            $basic_salary = $conn->real_escape_string($_POST['basic_salary'][$i]);
            $honorarium = $conn->real_escape_string($_POST['honorarium'][$i]);



            $overload_rate = $conn->real_escape_string($_POST['overload_rate'][$i]);
            $watch_reward = $conn->real_escape_string($_POST['watch_reward'][$i]);


            $absent_lateRate = $conn->real_escape_string($_POST['absent_lateRate'][$i]);

            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, employee_type = ?, classification = ?, basic_salary = ?, honorarium = ?, overload_rate = ?, watch_reward = ?, absent_lateRate = ? WHERE employee_id = ?");
            $stmt->bind_param("ssssddddii", $first_name, $last_name, $employee_type, $classification, $basic_salary, $honorarium, $overload_rate, $watch_reward, $absent_lateRate, $employee_id);
            $stmt->execute();



            $stmt->execute();
        }
    } else if (isset($_POST['update'])) {
        // Update employee data
        $employee_id = $conn->real_escape_string($_POST['employee_id']);
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $employee_type = $conn->real_escape_string($_POST['employee_type']);
        $classification = $conn->real_escape_string($_POST['classification']);
        $basic_salary = $conn->real_escape_string($_POST['basic_salary']);
        $honorarium = $conn->real_escape_string($_POST['honorarium']);
        $overload_rate = $conn->real_escape_string($_POST['overload_rate']);
        $watch_reward = $conn->real_escape_string($_POST['watch_reward']);
        $absent_lateRate = $conn->real_escape_string($_POST['absent_lateRate']);

        // Prepare the SQL statement based on updating employee data
        $stmt = $conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, employee_type = ?, classification = ?, basic_salary = ?, honorarium = ?, overload_rate = ?, watch_reward = ?, absent_lateRate = ? WHERE employee_id = ?");
        $stmt->bind_param("ssssdddddi", $first_name, $last_name, $employee_type, $classification, $basic_salary, $honorarium, $overload_rate, $watch_reward, $absent_lateRate, $employee_id);
        $stmt->execute();
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to toggle between views (Employee List, Add Employee, Edit Employee)
        function toggleView(view) {
            if (view === 'employeeList') {
                document.getElementById('employeeList').style.display = 'block';
                document.getElementById('addEmployeeForm').style.display = 'none';
                document.getElementById('editEmployeeForm').style.display = 'none';
            } else if (view === 'addEmployee') {
                document.getElementById('employeeList').style.display = 'none';
                document.getElementById('editEmployeeForm').style.display = 'none';
                document.getElementById('addEmployeeForm').style.display = 'block';
            } else if (view === 'editEmployee') {
                document.getElementById('employeeList').style.display = 'none';
                document.getElementById('addEmployeeForm').style.display = 'none';
                document.getElementById('editEmployeeForm').style.display = 'block';
            }
        }

        // Check if we are on an edit page and show the edit form
        window.onload = function() {
            if (window.location.search.indexOf('edit_id') > -1) {
                toggleView('editEmployee');
            } else {
                toggleView('employeeList');
            }
        };
    </script>
</head>

<body class="bg-gray-100">

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->

    <main class="flex-1 p-6">
        <div class="container mx-auto">

            <!-- Employee List Section -->
            <div id="employeeList" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee List</h2>
                <button class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 mb-4" onclick="toggleView('addEmployee')">ADD EMPLOYEE</button>

                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-2">Employee ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Employee Type</th>
                                <th class="px-4 py-2">Classification</th>
                                <th class="px-4 py-2">Basic Salary</th>
                                <th class="px-4 py-2">Honorarium</th>


                                <th class="px-4 py-2">Overload Rate</th>
                                <th class="px-4 py-2">Watch Reward</th>
                                <th class="px-4 py-2">Absent / Late Rate</th>



                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b hover:bg-gray-50'>
                                            <td class='px-4 py-2'>" . $row['employee_id'] . "</td>
                                            <td class='px-4 py-2'>" . $row['first_name'] . " " . $row['last_name'] . "</td>
                                            <td class='px-4 py-2'>" . ucfirst($row['employee_type']) . "</td>
                                            <td class='px-4 py-2'>" . $row['classification'] . "</td>
                                            <td class='px-4 py-2'>₱" . number_format($row['basic_salary'], 2) . "</td>
                                            <td class='px-4 py-2'>₱" . number_format($row['honorarium'], 2) . "</td>
                                            <td class='px-4 py-2'>₱" . number_format($row['overload_rate'], 2) . "</td>
                                            <td class='px-4 py-2'>₱" . number_format($row['watch_reward'], 2) . "</td>
                                            <td class='px-4 py-2'>₱" . number_format($row['absent_lateRate'], 2) . "</td>
                                            <td class='px-4 py-2'>
                                                <button class='bg-green-500 text-white py-1 px-3 rounded-md shadow hover:bg-green-600' onclick='window.location.href=\"?edit_id=" . $row['employee_id'] . "\"'>EDIT</button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='px-4 py-2 text-center text-gray-500'>No employees found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Employee Form Section -->
            <div id="addEmployeeForm" style="display: none;">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Employee</h2>
                <button class="bg-gray-500 text-white py-2 px-4 rounded-md shadow hover:bg-gray-600 mb-4" onclick="toggleView('employeeList')">Back to Employee List</button>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="space-y-6">
                    <div class="form-group">
                        <label for="first_name" class="form-label text-sm font-medium text-white">First Name</label>
                        <input type="text" name="first_name[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label text-sm font-medium text-white">Last Name</label>
                        <input type="text" name="last_name[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group">
                        <label for="employee_type" class="form-label text-sm font-medium text-white">Employee Type</label>
                        <select name="employee_type[]" class="form-select block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="full-time">Full-Time</option>
                            <option value="part-time">Part-Time</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classification" class="form-label text-sm font-medium text-white">Classification</label>
                        <input type="text" name="classification[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group">
                        <label for="basic_salary" class="form-label text-sm font-medium text-white">Basic Salary</label>
                        <!-- <input type="number" id="basicSalary" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required"> -->



                        <input type="number" id="basic_salary" name="basic_salary[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required oninput="calculateRate()">
                    </div>
                    <div class="form-group">
                        <label for="honorarium" class="form-label text-sm font-medium text-white">Honorarium</label>
                        <input type="number" name="honorarium[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>


                    <div class="form-group">
                        <label for="basic_salary" class="form-label text-sm font-medium text-white">Overload Rate</label>
                        <input type="number" name="overload_rate[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>


                    <div class="form-group">
                        <label for="basic_salary" class="form-label text-sm font-medium text-white">Watch Reward</label>
                        <input type="number" name="watch_reward[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>


                    <div class="form-group">

                        <label for="absentLateRate" class="form-label text-sm font-medium text-white mt-2">Absent/late Rate</label>
                        <input type="number" id="absentLateRate" name="absent_lateRate[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>

                    </div>

                    <script>
                        function calculateRate() {
                            let basicSalary = parseFloat(document.getElementById('basic_salary').value);
                            if (!isNaN(basicSalary) && basicSalary > 0) {
                                let absentLateRate = (basicSalary / 13) / 8;
                                document.getElementById('absentLateRate').value = absentLateRate.toFixed(2);
                                document.getElementById('resultText').innerText = "Absent/Late Rate: " + absentLateRate.toFixed(2);
                            } else {
                                document.getElementById('absentLateRate').value = "";
                                document.getElementById('resultText').innerText = "";
                            }
                        }
                    </script>

                    <button type="submit" name="add" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 w-full">Add Employee</button>
                </form>
            </div>



            <!-- Edit Employee Form Section -->
            <div id="editEmployeeForm" style="display: none;">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Employee</h2>
                <button class="bg-gray-500 text-white py-2 px-4 rounded-md shadow hover:bg-gray-600 mb-4" onclick="toggleView('employeeList')">Back to Employee List</button>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="space-y-6">
                    <input type="hidden" name="employee_id" id="edit_id" value="<?php echo isset($employee['employee_id']) ? $employee['employee_id'] : ''; ?>">

                    <div>
                        <label for="edit_first_name" class="text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="edit_first_name" value="<?php echo isset($employee['first_name']) ? $employee['first_name'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_last_name" class="text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="edit_last_name" value="<?php echo isset($employee['last_name']) ? $employee['last_name'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_employee_type" class="text-sm font-medium text-gray-700">Employee Type</label>
                        <select name="employee_type" id="edit_employee_type" class="form-select block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="full-time" <?php echo (isset($employee['employee_type']) && $employee['employee_type'] == 'full-time') ? 'selected' : ''; ?>>Full-Time</option>
                            <option value="part-time" <?php echo (isset($employee['employee_type']) && $employee['employee_type'] == 'part-time') ? 'selected' : ''; ?>>Part-Time</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit_classification" class="text-sm font-medium text-gray-700">Classification</label>
                        <input type="text" name="classification" id="edit_classification" value="<?php echo isset($employee['classification']) ? $employee['classification'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_basic_salary" class="text-sm font-medium text-gray-700">Basic Salary</label>
                        <input type="number" name="basic_salary" id="edit_basic_salary" value="<?php echo isset($employee['basic_salary']) ? $employee['basic_salary'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" oninput="calculateRate()">
                    </div>

                    <div>
                        <label for="edit_honorarium" class="text-sm font-medium text-gray-700">Honorarium</label>
                        <input type="number" name="honorarium" id="edit_honorarium" value="<?php echo isset($employee['honorarium']) ? $employee['honorarium'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_overload_rate" class="text-sm font-medium text-gray-700">Overload Rate</label>
                        <input type="number" name="overload_rate" id="edit_overload_rate" value="<?php echo isset($employee['overload_rate']) ? $employee['overload_rate'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_watch_reward" class="text-sm font-medium text-gray-700">Watch Reward</label>
                        <input type="number" name="watch_reward" id="edit_watch_reward" value="<?php echo isset($employee['watch_reward']) ? $employee['watch_reward'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_absent_lateRate" class="text-sm font-medium text-gray-700">Absent/late Rate</label>
                        <input type="number" name="absent_lateRate" id="edit_absent_lateRate" value="<?php echo isset($employee['absent_lateRate']) ? $employee['absent_lateRate'] : ''; ?>" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly step="0.01">
                    </div>

                    <button type="submit" name="update" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 w-full">Save Changes</button>
                </form>
            </div>

            <script>
                function calculateRate() {
                    let basicSalary = parseFloat(document.getElementById('edit_basic_salary').value);
                    if (!isNaN(basicSalary) && basicSalary > 0) {
                        let absentLateRate = (basicSalary / 13) / 8;
                        document.getElementById('edit_absent_lateRate').value = absentLateRate.toFixed(2); // Automatically fill the Absent/Late Rate
                    } else {
                        document.getElementById('edit_absent_lateRate').value = ""; // Clear if Basic Salary is invalid
                    }
                }
            </script>


        </div>
    </main>

</body>

</html>