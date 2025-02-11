<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gfi_exel');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-1000">

    <?php include 'aside.php'; ?>

    <main class="flex-1 p-6">
        <div class="container mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee List</h2>
                <a href="manage_employees_add.php">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 mb-4">
                        Add Employee
                    </button>
                </a>
            </div>

            <!-- Centered Search Bar Section -->
            <div class="flex justify-left mb-4">
                <input type="text" id="searchInput" class="py-2 px-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search employee..." onkeyup="searchEmployee()">
                <button class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 ml-2" onclick="searchEmployee()">Search</button>
            </div>

            <div id="employeeList" class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table id="employeeTable" class="w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Employee ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Employee Type</th>
                            <th class="px-4 py-2">Classification</th>
                            <th class="px-4 py-2">Basic Salary</th>
                            <th class="px-4 py-2">F&S Development</th>
                            <th class="px-4 py-2">Incentives</th>
                            <th class="px-4 py-2">Overload Rate</th>
                            <th class="px-4 py-2">Watch Reward</th>
                            <th class="px-4 py-2">Absent / Late Rate</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_fetch = "SELECT * FROM employees";
                        $result = $conn->query($sql_fetch);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='border-b hover:bg-gray-50'>
                                  <td class='px-4 py-2'>" . $row['employee_id'] . "</td>
                                  <td class='px-4 py-2'>" . $row['last_name'] . " " . $row['first_name'] . " " . $row['suffix_title'] . "</td>
                                  <td class='px-4 py-2'>" . ucfirst($row['employee_type']) . "</td>
                                  <td class='px-4 py-2'>" . $row['classification'] . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['basic_salary'], 2) . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['honorarium'], 2) . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['incentives'], 2) . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['overload_rate'], 2) . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['watch_reward'], 2) . "</td>
                                  <td class='px-4 py-2'>" . number_format($row['absent_lateRate'], 2) . "</td>
                                  <td class='px-4 py-2'>
                                      <a href='manage_employees_edit.php?id=" . $row['employee_id'] . "' class='bg-green-500 text-white py-1 px-2 rounded-md shadow hover:bg-green-600'>Edit</a>
                                  </td>
                              </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11' class='px-4 py-2 text-center text-gray-500'>No employees found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script>
                function searchEmployee() {
                    const searchInput = document.getElementById('searchInput').value.toLowerCase();
                    const employeeTable = document.getElementById('employeeTable');
                    const rows = employeeTable.getElementsByTagName('tr');

                    for (let i = 0; i < rows.length; i++) {
                        const cells = rows[i].getElementsByTagName('td');
                        let matchFound = false;

                        for (let j = 0; j < cells.length; j++) {
                            if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                                matchFound = true;
                                break;
                            }
                        }

                        if (matchFound) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }
            </script>
        </div>
    </main>

</body>

</html>
