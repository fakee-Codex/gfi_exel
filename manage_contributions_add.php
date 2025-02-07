<?php
// Database connection
require 'database_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $sss_ee = $_POST['sss_ee'];
    $pagibig_ee = $_POST['pagibig_ee'];
    $philhealth_ee = $_POST['philhealth_ee'];
    $sss_er = $_POST['sss_er'];
    $pagibig_er = $_POST['pagibig_er'];
    $philhealth_er = $_POST['philhealth_er'];
    $medical_savings = $_POST['medical_savings'];
    $retirement = $_POST['retirement'];

    // Insert query
    $insert_sql = "INSERT INTO contributions (employee_id, sss_ee, pag_ibig_ee, philhealth_ee, sss_er, pag_ibig_er, philhealth_er, medical_savings, retirement)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("idddddddd", $employee_id, $sss_ee, $pagibig_ee, $philhealth_ee, $sss_er, $pagibig_er, $philhealth_er, $medical_savings, $retirement);


    if ($stmt->execute()) {
        echo "<div class='alert alert-success' id='success-alert'>Contribution added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

// Fetch employees for dropdown
$employees_sql = "SELECT employee_id, CONCAT(last_name, ', ', first_name) AS Name FROM employees";
$employees_result = $conn->query($employees_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contribution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container mt-5 p-4 bg-white shadow-lg rounded">
        <h3 class="text-center mb-4 text-primary fw-bold">Add Contribution</h3>

        <!-- Success Alert Script -->
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $("#success-alert").fadeOut("slow", function() {
                        $(this).remove();
                    });
                }, 2000); // 2 seconds
            });
        </script>

        <form method="POST" class="p-3">
            <div class="row g-4">
                <!-- Employee Selection -->
                <div class="col-md-6">
                    <label for="employee_id" class="form-label fw-semibold">Employee Name</label>
                    <select name="employee_id" id="employee_id" class="form-select border-primary" required>
                        <option value="">Select Employee</option>
                        <?php
                        if ($employees_result->num_rows > 0) {
                            while ($row = $employees_result->fetch_assoc()) {
                                echo "<option value='{$row['employee_id']}'>{$row['Name']}</option>";
                            }
                        } else {
                            echo "<option value=''>No employees found</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Initialize Select2 -->
                <script>
                    $(document).ready(function() {
                        $('#employee_id').select2({
                            placeholder: "Search Employee",
                            allowClear: true,
                            width: '100%'
                        });
                    });
                </script>

                <!-- Basic Salary -->
                <div class="col-md-3">
                    <label for="basic_salary" class="form-label fw-semibold">Basic Salary</label>
                    <input type="text" id="basic_salary" class="form-control-sm border-primary form-control" readonly>
                </div>

                <!-- Employee Type -->
                <div class="col-md-3">
                    <label for="employee_type" class="form-label fw-semibold">Employee Type</label>
                    <input type="text" id="employee_type" class="form-control-sm border-primary form-control" readonly>
                </div>

                <!-- Employer Share Column -->
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded shadow">
                        <h5 class="text-center text-success fw-bold">Employer Share</h5>

                        <!-- SSS Employer Share -->
                        <div class="mb-3">
                            <label for="sss_er" class="form-label fw-semibold">SSS (Employer Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="sss_er" id="sss_er" class="form-control form-control-sm border-primary" placeholder="Enter SSS contribution" required>
                            </div>
                        </div>

                        <!-- Pag-ibig Employer Share -->
                        <div class="mb-3">
                            <label for="pagibig_er" class="form-label fw-semibold">Pag-ibig (Employer Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="pagibig_er" id="pagibig_er" class="form-control form-control-sm border-primary" value="200" required>
                            </div>
                        </div>

                        <!-- PhilHealth Employer Share -->
                        <div class="mb-3">
                            <label for="philhealth_er" class="form-label fw-semibold">PhilHealth (Employer Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="philhealth_er" id="philhealth_er" class="form-control form-control-sm border-primary" placeholder="Enter PhilHealth contribution" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Share Column -->
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded shadow">
                        <h5 class="text-center text-primary fw-bold">Employee Share</h5>

                        <!-- SSS Employee Share -->
                        <div class="mb-3">
                            <label for="sss_ee" class="form-label fw-semibold">SSS (Employee Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="sss_ee" id="sss_ee" class="form-control form-control-sm border-primary" placeholder="Enter SSS contribution" required>
                            </div>
                        </div>

                        <!-- Pag-ibig Employee Share -->
                        <div class="mb-3">
                            <label for="pagibig_ee" class="form-label fw-semibold">Pag-ibig (Employee Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="pagibig_ee" id="pagibig_ee" class="form-control form-control-sm border-primary" value="200" required>
                            </div>
                        </div>

                        <!-- PhilHealth Employee Share -->
                        <div class="mb-3">
                            <label for="philhealth_ee" class="form-label fw-semibold">PhilHealth (Employee Share)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="philhealth_ee" id="philhealth_ee" class="form-control form-control-sm border-primary" placeholder="Enter PhilHealth contribution" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Savings Section -->
                <div class="mb-4">
                    <h4 class="text-center mb-4 text-primary fw-bold">Savings</h4>

                    <div class="d-flex justify-content-center gap-3">
                        <!-- Medical Savings Contribution -->
                        <div>
                            <label for="medical_savings" class="form-label fw-semibold">Medical</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="medical_savings" id="medical_savings"
                                    class="form-control form-control-sm border-primary text-center"
                                    placeholder="Medical" style="max-width: 150px;" required>
                            </div>
                        </div>

                        <!-- Retirement Contribution -->
                        <div>
                            <label for="retirement" class="form-label fw-semibold">Retirement</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="retirement" id="retirement"
                                    class="form-control form-control-sm border-primary text-center"
                                    placeholder="Retirement" style="max-width: 150px;" required>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Add Contribution</button>
                    <a href="manage_contributions.php" class="btn btn-secondary px-4 py-2 fw-bold">Back</a>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {
            $('#employee_id').change(function() {
                const employeeId = $(this).val();

                if (employeeId) {
                    // Fetch employee details using AJAX
                    $.ajax({
                        url: 'fetch_employee_details.php', // File to fetch data
                        type: 'POST',
                        data: {
                            employee_id: employeeId
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            const basicSalary = parseFloat(data.basic_salary);

                            // Populate Basic Salary and Employee Type
                            $('#basic_salary').val(basicSalary.toFixed(2));
                            $('#employee_type').val(data.employee_type);

                            // Calculate and populate percentages
                            if (!isNaN(basicSalary)) {
                                const sssEr = basicSalary * 0.095;
                                $('#sss_er').val(sssEr.toFixed(2));
                                const sssEe = basicSalary * 0.045;
                                $('#sss_ee').val(sssEe.toFixed(2));
                                const philhealth = basicSalary * 0.025;
                                $('#philhealth_er').val(philhealth.toFixed(2));
                                $('#philhealth_ee').val(philhealth.toFixed(2));
                            }
                        },
                        error: function() {
                            alert('Unable to fetch employee details.');
                        }
                    });
                } else {
                    // Clear fields if no employee selected
                    $('#basic_salary').val('');
                    $('#employee_type').val('');
                    $('#sss_er').val('');
                    $('#sss_ee').val('');
                    $('#philhealth_er').val('');
                    $('#philhealth_ee').val('');
                }
            });
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>