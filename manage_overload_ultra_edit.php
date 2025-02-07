<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gfi_exel"; // Change this to your actual database name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Database connection failed."]));
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(["success" => false, "error" => "Invalid request method."]));
}

// Check if overload_id exists
if (!isset($_POST['overload_id']) || empty($_POST['overload_id'])) {
    die(json_encode(["success" => false, "error" => "Invalid Row ID."]));
}

// Prepare and execute the SQL update query
foreach ($_POST['overload_id'] as $index => $id) {
    // Validate the ID
    if (!is_numeric($id) || $id <= 0) {
        die(json_encode(["success" => false, "error" => "Invalid Row ID: " . htmlspecialchars($id)]));
    }

    // Sanitize input values
    $wednesday_days = isset($_POST['wednesday_days'][$index]) ? intval($_POST['wednesday_days'][$index]) : 0;
    $thursday_days = isset($_POST['thursday_days'][$index]) ? intval($_POST['thursday_days'][$index]) : 0;
    $friday_days = isset($_POST['friday_days'][$index]) ? intval($_POST['friday_days'][$index]) : 0;
    $mtth_days = isset($_POST['mtth_days'][$index]) ? intval($_POST['mtth_days'][$index]) : 0;
    $mtwf_days = isset($_POST['mtwf_days'][$index]) ? intval($_POST['mtwf_days'][$index]) : 0;
    $twthf_days = isset($_POST['twthf_days'][$index]) ? intval($_POST['twthf_days'][$index]) : 0;
    $mw_days = isset($_POST['mw_days'][$index]) ? intval($_POST['mw_days'][$index]) : 0;

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE overload SET 
        wednesday_days = ?, 
        thursday_days = ?, 
        friday_days = ?, 
        mtth_days = ?, 
        mtwf_days = ?, 
        twthf_days = ?, 
        mw_days = ?
        WHERE overload_id = ?");
    
    if (!$stmt) {
        die(json_encode(["success" => false, "error" => "SQL prepare failed: " . $conn->error]));
    }

    // Bind parameters
    $stmt->bind_param("iiiiiiii", $wednesday_days, $thursday_days, $friday_days, $mtth_days, $mtwf_days, $twthf_days, $mw_days, $id);

    // Execute query
    if (!$stmt->execute()) {
        die(json_encode(["success" => false, "error" => "SQL execution failed: " . $stmt->error]));
    }

    $stmt->close();
}

$conn->close();

echo "<script>alert('Days updated successfully!'); window.location.href='manage_overload_update.php';</script>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Overload Data</title>
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="bg-gray-100 p-10">

    <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Edit Overload Data</h2>

    <div class="overflow-x-auto">
        <form method="POST" action="manage_overload_update.php">                
            <table class="w-full bg-white shadow-md rounded-lg border border-gray-200">
                <thead class="bg-blue-600 text-white text-center">
                    <tr>
                        <th rowspan="2" class="p-3 border border-gray-300 sticky left-0 bg-blue-700 z-10">Employee Name</th>
                        <th colspan="3" class="p-3 border border-gray-300">Wednesday</th>
                        <th colspan="3" class="p-3 border border-gray-300">Thursday</th>
                        <th colspan="3" class="p-3 border border-gray-300">Friday</th>
                        <th colspan="3" class="p-3 border border-gray-300">MTTH</th>
                        <th colspan="3" class="p-3 border border-gray-300">MTWF</th>
                        <th colspan="3" class="p-3 border border-gray-300">TWTHF</th>
                        <th colspan="3" class="p-3 border border-gray-300">MW</th>
                        <th rowspan="2" class="p-3 border border-gray-300">Less</th>
                        <th rowspan="2" class="p-3 border border-gray-300">Add</th>
                        <th rowspan="2" class="p-3 border border-gray-300">Adjustments</th>
                        <th rowspan="2" class="p-3 border border-gray-300">Grand Total</th>
                    </tr>
                    <tr class="bg-blue-500">
                        <?php for ($i = 0; $i < 7; $i++) : ?>
                            <th class="p-2 border border-gray-300">DAYS</th>
                            <th class="p-2 border border-gray-300">HRS</th>
                            <th class="p-2 border border-gray-300">TOTAL</th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="border-b hover:bg-gray-100">
                            <input type="hidden" name="overload_id[]" value="<?= $row['overload_id'] ?>">

                            <!-- Sticky Employee ID -->
                            <td class="p-3 font-semibold sticky left-0 bg-white border-r border-gray-300 z-10">
                                <?= htmlspecialchars($row['employee_id']) ?>
                            </td>

                            <!-- Editable "Days" inputs -->
                            <td class="p-3"><input type="number" name="wednesday_days[]" value="<?= $row['wednesday_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-wednesday-hrs><?= htmlspecialchars($row['wednesday_hrs']) ?></td>
                            <td class="p-3 text-center" data-wednesday-total><?= htmlspecialchars($row['wednesday_total']) ?></td>

                            <td class="p-3"><input type="number" name="thursday_days[]" value="<?= $row['thursday_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-thursday-hrs><?= htmlspecialchars($row['thursday_hrs']) ?></td>
                            <td class="p-3 text-center" data-thursday-total><?= htmlspecialchars($row['thursday_total']) ?></td>

                            <td class="p-3"><input type="number" name="friday_days[]" value="<?= $row['friday_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-friday-hrs><?= htmlspecialchars($row['friday_hrs']) ?></td>
                            <td class="p-3 text-center" data-friday-total><?= htmlspecialchars($row['friday_total']) ?></td>

                            <td class="p-3"><input type="number" name="mtth_days[]" value="<?= $row['mtth_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-mtth-hrs><?= htmlspecialchars($row['mtth_hrs']) ?></td>
                            <td class="p-3 text-center" data-mtth-total><?= htmlspecialchars($row['mtth_total']) ?></td>

                            <td class="p-3"><input type="number" name="mtwf_days[]" value="<?= $row['mtwf_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-mtwf-hrs><?= htmlspecialchars($row['mtwf_hrs']) ?></td>
                            <td class="p-3 text-center" data-mtwf-total><?= htmlspecialchars($row['mtwf_total']) ?></td>

                            <td class="p-3"><input type="number" name="twthf_days[]" value="<?= $row['twthf_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-twthf-hrs><?= htmlspecialchars($row['twthf_hrs']) ?></td>
                            <td class="p-3 text-center" data-twthf-total><?= htmlspecialchars($row['twthf_total']) ?></td>

                            <td class="p-3"><input type="number" name="mw_days[]" value="<?= $row['mw_days'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center" data-mw-hrs><?= htmlspecialchars($row['mw_hrs']) ?></td>
                            <td class="p-3 text-center" data-mw-total><?= htmlspecialchars($row['mw_total']) ?></td>

                            <!-- Less, Additional, Adjustments, Grand Total -->
                            <td class="p-3"><input type="number" name="less_lateOL[]" value="<?= $row['less_lateOL'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3"><input type="number" name="additional[]" value="<?= $row['additional'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3"><input type="number" name="adjustment_less[]" value="<?= $row['adjustment_less'] ?>" class="w-16 border rounded px-2 py-1 text-center"></td>
                            <td class="p-3 text-center font-bold text-blue-600" data-grand-total><?= htmlspecialchars($row['grand_total']) ?></td>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="text-right mt-4">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-600">
                    Save Changes
                </button>
            </div>
        </form>


    </div>
    <script>
        function calculateRowTotals(row) {
            let grandTotal = 0;

            // Define the corresponding column names for "DAYS", "HRS", and "TOTAL"
            const dayColumns = ["wednesday", "thursday", "friday", "mtth", "mtwf", "twthf", "mw"];

            dayColumns.forEach(day => {
                const days = parseFloat(row.querySelector(`input[name="${day}_days[]"]`).value) || 0;
                const hours = parseFloat(row.querySelector(`td[data-${day}-hrs]`).textContent) || 0; // Fetch static HRS from table cell
                const totalCell = row.querySelector(`td[data-${day}-total]`); // TOTAL is a non-editable cell

                const total = days * hours;
                totalCell.textContent = total.toFixed(2); // Update the TOTAL column
                grandTotal += total;
            });

            // Handle "Less", "Add", and "Adjustments" calculations
            const less = parseFloat(row.querySelector(`input[name="less_lateOL[]"]`).value) || 0;
            const add = parseFloat(row.querySelector(`input[name="additional[]"]`).value) || 0;
            const adjustments = parseFloat(row.querySelector(`input[name="adjustment_less[]"]`).value) || 0;

            // Calculate Grand Total
            grandTotal = grandTotal - less + add - adjustments;

            // Update the Grand Total cell
            const grandTotalCell = row.querySelector(`td[data-grand-total]`);
            grandTotalCell.textContent = grandTotal.toFixed(2);
        }

        function syncDaysAcrossEmployees(column, value) {
            document.querySelectorAll(`input[name="${column}_days[]"]`).forEach(input => {
                input.value = value;
                calculateRowTotals(input.closest("tr"));
            });
        }

        function addCalculationListeners(row) {
            const inputs = row.querySelectorAll("input[name$='_days[]'], input[name='less_lateOL[]'], input[name='additional[]'], input[name='adjustment_less[]']");

            inputs.forEach(input => {
                input.addEventListener("input", function() {
                    const column = this.name.replace("_days[]", ""); // Extract the column name
                    syncDaysAcrossEmployees(column, this.value);
                });
            });
        }

        // Run script on page load
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("tr.border-b").forEach(row => {
                addCalculationListeners(row);
                calculateRowTotals(row); // Initial calculation in case values are prefilled
            });
        });
    </script>


</body>

</html>