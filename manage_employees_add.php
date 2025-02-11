<?php
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize response array
    $response = ['success' => false, 'message' => ''];

    try {
        // Loop through the form data (assuming you're adding multiple employees)
        foreach ($_POST['first_name'] as $i => $first_name) {
            // Sanitize and escape the form inputs
            $first_name = $conn->real_escape_string($first_name);
            $last_name = $conn->real_escape_string($_POST['last_name'][$i]);
            $suffix_title = $conn->real_escape_string($_POST['suffix_title'][$i]);
            $employee_type = $conn->real_escape_string($_POST['employee_type'][$i]);
            $classification = $conn->real_escape_string($_POST['classification'][$i]);
            $basic_salary = $conn->real_escape_string($_POST['basic_salary'][$i]);
            $honorarium = $conn->real_escape_string($_POST['honorarium'][$i]);
            $incentives = $conn->real_escape_string($_POST['incentives'][$i]);
            $overload_rate = $conn->real_escape_string($_POST['overload_rate'][$i]);
            $watch_reward = $conn->real_escape_string($_POST['watch_reward'][$i]);
            $absent_lateRate = $basic_salary / 13 / 8;

            // Insert the data into the database
            $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, suffix_title, employee_type, classification, basic_salary, honorarium, incentives, overload_rate, watch_reward, absent_lateRate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssdddddd", $first_name, $last_name, $suffix_title, $employee_type, $classification, $basic_salary, $honorarium, $incentives, $overload_rate, $watch_reward, $absent_lateRate);
            $stmt->execute();
        }

        // Success response
        $response['success'] = true;
        $response['message'] = 'Employee added successfully!';
    } catch (Exception $e) {
        // Error response
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    // Return response as JSON
    echo json_encode($response);
    exit(); // End the script
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">
    <?php include 'aside.php'; ?>
    <main class="flex-1 p-6 bg-gray-900">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg max-w-3xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Fill EMPLOYEE</h1>

            <!-- Back Button -->
            <div class="text-left mb-4">
                <a href="sidebarManageemployee.php" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back</a>
            </div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="space-y-6">
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="first_name" class="form-label text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group flex-1">
                        <label for="last_name" class="form-label text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="suffix_title" class="form-label text-sm font-medium text-gray-700">Suffix / Title</label>
                        <input type="text" placeholder="e.g. Sr, LPT" name="suffix_title[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="form-group flex-1">
                        <label for="employee_type" class="form-label text-sm font-medium text-gray-700">Employee Type</label>
                        <select name="employee_type[]" class="form-select block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="full-time">Full-Time</option>
                            <option value="part-time">Part-Time</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="classification" class="form-label text-sm font-medium text-gray-700">Classification</label>
                        <input type="text" name="classification[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group flex-1">
                        <label for="basic_salary" class="form-label text-sm font-medium text-gray-700">Basic Salary</label>
                        <input type="number" name="basic_salary[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required oninput="calculateAbsentLateRate(this)">
                    </div>
                </div>
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="honorarium" class="form-label text-sm font-medium text-gray-700">F&S Development</label>
                        <input type="number" name="honorarium[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="form-group flex-1">
                        <label for="incentives" class="form-label text-sm font-medium text-gray-700">Incentives</label>
                        <input type="number" name="incentives[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="overload_rate" class="form-label text-sm font-medium text-gray-700">Overload Rate</label>
                        <input type="number" name="overload_rate[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="form-group flex-1">
                        <label for="watch_reward" class="form-label text-sm font-medium text-gray-700">Watch Reward</label>
                        <input type="number" name="watch_reward[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                <div class="flex justify-between gap-6">
                    <div class="form-group flex-1">
                        <label for="absentLateRate" class="form-label text-sm font-medium text-gray-700 mt-2">Absent/Late Rate</label>
                        <input type="number" name="absent_lateRate[]" class="form-control block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
                    </div>
                </div>
                <button type="submit" name="add" class="bg-indigo-500 text-white py-2 px-4 rounded-md shadow-lg hover:bg-indigo-700">Submit</button>
            </form>
        </div>
    </main>

    <script>
        
        // Function to calculate the absent/late rate
        function calculateAbsentLateRate(input) {
            const basicSalary = parseFloat(input.value);
            if (!isNaN(basicSalary) && basicSalary > 0) {
                const rate = (basicSalary / 13) / 8;
                // Find the corresponding absentLateRate field
                const absentLateField = input.closest('form').querySelector('[name="absent_lateRate[]"]');
                absentLateField.value = rate.toFixed(2); // Update absentLateRate with calculated value
            }
        }

        // Function to handle the form submission via AJAX
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(this); // Create FormData object from the form
            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Expect a JSON response
                .then(data => {
                    console.log(data); // Debugging line to inspect the response in the console
                    if (data.success) {
                        alert('Employee added successfully!');
                        // Redirect to sidebarManageemployee.php after success
                        window.location.href = "sidebarManageemployee.php"; // Redirect after successful submission
                    } else {
                        alert('Error: ' + data.message); // Show error message if something went wrong
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred, please try again.');
                });
        });
    </script>

</body>

</html>