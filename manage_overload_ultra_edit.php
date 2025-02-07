<?php
include('database_connection.php'); // Assuming you have a database connection setup


// Execute the query to fetch overload data
$query = "SELECT * FROM overload";  // Customize the query if needed
$result = mysqli_query($conn, $query);  // Execute the query

if (!$result) {
    die("Query failed: " . mysqli_error($conn));  // Handle query failure
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through each employee's overload data
    foreach ($_POST['overload_id'] as $index => $overload_id) {
        // Extract the form data
        $employee_id = $_POST['employee_id'][$index];
        $wednesday_days = $_POST['wednesday_days'][$index];
        $wednesday_hrs = $_POST['wednesday_hrs'][$index];
        $wednesday_total = $_POST['wednesday_total'][$index];

        $thursday_days = $_POST['thursday_days'][$index];
        $thursday_hrs = $_POST['thursday_hrs'][$index];
        $thursday_total = $_POST['thursday_total'][$index];

        $friday_days = $_POST['friday_days'][$index];
        $friday_hrs = $_POST['friday_hrs'][$index];
        $friday_total = $_POST['friday_total'][$index];

        $mtth_days = $_POST['mtth_days'][$index];
        $mtth_hrs = $_POST['mtth_hrs'][$index];
        $mtth_total = $_POST['mtth_total'][$index];

        $mtwf_days = $_POST['mtwf_days'][$index];
        $mtwf_hrs = $_POST['mtwf_hrs'][$index];
        $mtwf_total = $_POST['mtwf_total'][$index];

        $twthf_days = $_POST['twthf_days'][$index];
        $twthf_hrs = $_POST['twthf_hrs'][$index];
        $twthf_total = $_POST['twthf_total'][$index];

        $mw_days = $_POST['mw_days'][$index];
        $mw_hrs = $_POST['mw_hrs'][$index];
        $mw_total = $_POST['mw_total'][$index];

        $less_lateOL = $_POST['less_lateOL'][$index];
        $additional = $_POST['additional'][$index];
        $adjustment_less = $_POST['adjustment_less'][$index];

        // Calculate Grand Total
        $grand_total = ($wednesday_total + $thursday_total + $friday_total + $mtth_total + $mtwf_total + $twthf_total + $mw_total) - $less_lateOL + $additional - $adjustment_less;

        // Update the database with the new values
        $query = "UPDATE overload SET 
                    employee_id = '$employee_id', 
                    wednesday_days = '$wednesday_days', wednesday_hrs = '$wednesday_hrs', wednesday_total = '$wednesday_total', 
                    thursday_days = '$thursday_days', thursday_hrs = '$thursday_hrs', thursday_total = '$thursday_total', 
                    friday_days = '$friday_days', friday_hrs = '$friday_hrs', friday_total = '$friday_total', 
                    mtth_days = '$mtth_days', mtth_hrs = '$mtth_hrs', mtth_total = '$mtth_total', 
                    mtwf_days = '$mtwf_days', mtwf_hrs = '$mtwf_hrs', mtwf_total = '$mtwf_total', 
                    twthf_days = '$twthf_days', twthf_hrs = '$twthf_hrs', twthf_total = '$twthf_total', 
                    mw_days = '$mw_days', mw_hrs = '$mw_hrs', mw_total = '$mw_total', 
                    less_lateOL = '$less_lateOL', additional = '$additional', adjustment_less = '$adjustment_less',
                    grand_total = '$grand_total'
                    WHERE overload_id = '$overload_id'";

        if ($conn->query($query) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

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