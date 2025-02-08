<?php

include('database_connection.php'); // Assuming you have a database connection setup

// Execute the query to fetch overload data
$query = "
    SELECT 
        o.overload_id,  -- Ensure overload_id is selected here
        o.*, 
        CONCAT(e.first_name, ' ', e.last_name) AS employee_name
    FROM overload o
    JOIN employees e ON o.employee_id = e.employee_id
";  // Customize the query if needed
$result = mysqli_query($conn, $query);  // Execute the query

if (!$result) {
    die("Query failed: " . mysqli_error($conn));  // Handle query failure
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['overload_id']) && is_array($_POST['overload_id'])) {
//         foreach ($_POST['overload_id'] as $index => $overload_id) {
//             // Use isset to avoid undefined index warnings
//             $employee_id = isset($_POST['employee_id'][$index]) ? $_POST['employee_id'][$index] : '';
//             $wednesday_days = isset($_POST['wednesday_days'][$index]) ? $_POST['wednesday_days'][$index] : 0;
//             $wednesday_hrs = isset($_POST['wednesday_hrs'][$index]) ? $_POST['wednesday_hrs'][$index] : 0;
//             $wednesday_total = isset($_POST['wednesday_total'][$index]) ? $_POST['wednesday_total'][$index] : 0;

//             $thursday_days = isset($_POST['thursday_days'][$index]) ? $_POST['thursday_days'][$index] : 0;
//             $thursday_hrs = isset($_POST['thursday_hrs'][$index]) ? $_POST['thursday_hrs'][$index] : 0;
//             $thursday_total = isset($_POST['thursday_total'][$index]) ? $_POST['thursday_total'][$index] : 0;

//             $friday_days = isset($_POST['friday_days'][$index]) ? $_POST['friday_days'][$index] : 0;
//             $friday_hrs = isset($_POST['friday_hrs'][$index]) ? $_POST['friday_hrs'][$index] : 0;
//             $friday_total = isset($_POST['friday_total'][$index]) ? $_POST['friday_total'][$index] : 0;

//             $mtth_days = isset($_POST['mtth_days'][$index]) ? $_POST['mtth_days'][$index] : 0;
//             $mtth_hrs = isset($_POST['mtth_hrs'][$index]) ? $_POST['mtth_hrs'][$index] : 0;
//             $mtth_total = isset($_POST['mtth_total'][$index]) ? $_POST['mtth_total'][$index] : 0;

//             $mtwf_days = isset($_POST['mtwf_days'][$index]) ? $_POST['mtwf_days'][$index] : 0;
//             $mtwf_hrs = isset($_POST['mtwf_hrs'][$index]) ? $_POST['mtwf_hrs'][$index] : 0;
//             $mtwf_total = isset($_POST['mtwf_total'][$index]) ? $_POST['mtwf_total'][$index] : 0;

//             $twthf_days = isset($_POST['twthf_days'][$index]) ? $_POST['twthf_days'][$index] : 0;
//             $twthf_hrs = isset($_POST['twthf_hrs'][$index]) ? $_POST['twthf_hrs'][$index] : 0;
//             $twthf_total = isset($_POST['twthf_total'][$index]) ? $_POST['twthf_total'][$index] : 0;

//             $mw_days = isset($_POST['mw_days'][$index]) ? $_POST['mw_days'][$index] : 0;
//             $mw_hrs = isset($_POST['mw_hrs'][$index]) ? $_POST['mw_hrs'][$index] : 0;
//             $mw_total = isset($_POST['mw_total'][$index]) ? $_POST['mw_total'][$index] : 0;

//             $less_lateOL = isset($_POST['less_lateOL'][$index]) ? $_POST['less_lateOL'][$index] : 0;
//             $additional = isset($_POST['additional'][$index]) ? $_POST['additional'][$index] : 0;
//             $adjustment_less = isset($_POST['adjustment_less'][$index]) ? $_POST['adjustment_less'][$index] : 0;

//             // Calculate Grand Total
//             $grand_total = ($wednesday_total + $thursday_total + $friday_total + $mtth_total + $mtwf_total + $twthf_total + $mw_total) - $less_lateOL + $additional - $adjustment_less;

//             // Update the database with the new values
//             $query = "UPDATE overload SET 
//                         employee_id = '$employee_id', 
//                         wednesday_days = '$wednesday_days', wednesday_hrs = '$wednesday_hrs', wednesday_total = '$wednesday_total', 
//                         thursday_days = '$thursday_days', thursday_hrs = '$thursday_hrs', thursday_total = '$thursday_total', 
//                         friday_days = '$friday_days', friday_hrs = '$friday_hrs', friday_total = '$friday_total', 
//                         mtth_days = '$mtth_days', mtth_hrs = '$mtth_hrs', mtth_total = '$mtth_total', 
//                         mtwf_days = '$mtwf_days', mtwf_hrs = '$mtwf_hrs', mtwf_total = '$mtwf_total', 
//                         twthf_days = '$twthf_days', twthf_hrs = '$twthf_hrs', twthf_total = '$twthf_total', 
//                         mw_days = '$mw_days', mw_hrs = '$mw_hrs', mw_total = '$mw_total', 
//                         less_lateOL = '$less_lateOL', additional = '$additional', adjustment_less = '$adjustment_less',
//                         grand_total = '$grand_total'
//                         WHERE overload_id = '$overload_id'";

//             if ($conn->query($query) === TRUE) {
//                 // On success, return success message for AJAX
//                 echo "success";
//             } else {
//                 // On failure, return error message for AJAX
//                 echo "Error updating record: " . $conn->error;
//             }
//         }
//     } else {
//         // If overload_id is missing, return an error message
//         echo "No overload data received or 'overload_id' is missing.";
//     }
//     exit();  // Terminate the script after responding to AJAX
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>


</head>

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->

    <main>


        <div class="bg-gray-200 p-2 rounded-lg shadow-md">

            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Edit Overload Data</h2>
            <form method="POST" action="">


                <div class="text-right mb-4">
                    <button id="updateButton" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-600">
                        Save Changes
                    </button>
                </div>

                <div class="overflow-x-auto">

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


                                <tr class="border-b hover:bg-gray-100"
                                    data-overload-id="<?= $row['overload_id'] ?>"
                                    data-employee-id="<?= $row['employee_id'] ?>">




                                    <!-- Employee Name -->
                                    <td class="p-3 font-semibold sticky left-0 bg-white border-r border-gray-300 z-10">
                                        <?= htmlspecialchars($row['employee_name']) ?>
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
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>



                </div>

            </form>
            <script>
                document.getElementById("updateButton").addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent default form submission

                    let rows = document.querySelectorAll("tbody tr");
                    let data = [];

                    rows.forEach(row => {
                        let rowData = {
                            overload_id: row.getAttribute("data-overload-id"),
                            employee_id: row.getAttribute("data-employee-id"),

                            // Inputs
                            wednesday_days: row.querySelector("input[name='wednesday_days[]']").value,
                            thursday_days: row.querySelector("input[name='thursday_days[]']").value,
                            friday_days: row.querySelector("input[name='friday_days[]']").value,
                            mtth_days: row.querySelector("input[name='mtth_days[]']").value,
                            mtwf_days: row.querySelector("input[name='mtwf_days[]']").value,
                            twthf_days: row.querySelector("input[name='twthf_days[]']").value,
                            mw_days: row.querySelector("input[name='mw_days[]']").value,
                            less_lateOL: row.querySelector("input[name='less_lateOL[]']").value,
                            additional: row.querySelector("input[name='additional[]']").value,
                            adjustment_less: row.querySelector("input[name='adjustment_less[]']").value,

                            // Text values from table cells
                            wednesday_hrs: row.querySelector("[data-wednesday-hrs]").textContent.trim(),
                            wednesday_total: row.querySelector("[data-wednesday-total]").textContent.trim(),
                            thursday_hrs: row.querySelector("[data-thursday-hrs]").textContent.trim(),
                            thursday_total: row.querySelector("[data-thursday-total]").textContent.trim(),
                            friday_hrs: row.querySelector("[data-friday-hrs]").textContent.trim(),
                            friday_total: row.querySelector("[data-friday-total]").textContent.trim(),
                            mtth_hrs: row.querySelector("[data-mtth-hrs]").textContent.trim(),
                            mtth_total: row.querySelector("[data-mtth-total]").textContent.trim(),
                            mtwf_hrs: row.querySelector("[data-mtwf-hrs]").textContent.trim(),
                            mtwf_total: row.querySelector("[data-mtwf-total]").textContent.trim(),
                            twthf_hrs: row.querySelector("[data-twthf-hrs]").textContent.trim(),
                            twthf_total: row.querySelector("[data-twthf-total]").textContent.trim(),
                            mw_hrs: row.querySelector("[data-mw-hrs]").textContent.trim(),
                            mw_total: row.querySelector("[data-mw-total]").textContent.trim(),
                            grand_total: row.querySelector("[data-grand-total]").textContent.trim(),
                        };

                        data.push(rowData);
                    });

                    // Send data to the server using fetch
                    fetch('manage_overload_ultra_edit_update.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            console.log('Success:', result);
                            window.location.reload();

                            // Handle success response here
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle error here
                        });
                });
            </script>


        </div>
        <script>

        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll("tr.border-b").forEach(row => {
                    addCalculationListeners(row);
                    calculateRowTotals(row);
                });
            });

            function addCalculationListeners(row) {
                const inputs = row.querySelectorAll("input[name$='_days[]'], input[name='less_lateOL[]'], input[name='additional[]'], input[name='adjustment_less[]']");

                inputs.forEach(input => {
                    input.addEventListener("input", function() {
                        const dayMatch = input.name.match(/(wednesday|thursday|friday|mtth|mtwf|twthf|mw)_days\[\]/);
                        if (dayMatch) {
                            const dayColumn = dayMatch[1] + "_days[]";
                            syncColumnInputs(dayColumn); // Sync all inputs in the same column
                        }
                        calculateRowTotals(row);
                    });
                });
            }

            function calculateRowTotals(row) {
                let grandTotal = 0;
                const dayColumns = ["wednesday", "thursday", "friday", "mtth", "mtwf", "twthf", "mw"];

                dayColumns.forEach(day => {
                    const daysInput = row.querySelector(`input[name="${day}_days[]"]`);
                    const hoursCell = row.querySelector(`td[data-${day}-hrs]`);
                    const totalCell = row.querySelector(`td[data-${day}-total]`);

                    if (daysInput && hoursCell && totalCell) {
                        const days = parseFloat(daysInput.value) || 0;
                        const hours = parseFloat(hoursCell.textContent) || 0;
                        const total = days * hours;

                        totalCell.textContent = total.toFixed(2);
                        grandTotal += total;
                    }
                });

                // Handle Less, Additional, and Adjustments
                const less = parseFloat(row.querySelector(`input[name="less_lateOL[]"]`).value) || 0;
                const add = parseFloat(row.querySelector(`input[name="additional[]"]`).value) || 0;
                const adjustments = parseFloat(row.querySelector(`input[name="adjustment_less[]"]`).value) || 0;

                // Final Grand Total Calculation
                grandTotal = grandTotal - less + add - adjustments;

                // Update Grand Total cell
                const grandTotalCell = row.querySelector(`td[data-grand-total]`);
                if (grandTotalCell) {
                    grandTotalCell.textContent = grandTotal.toFixed(2);
                }
            }

            // ✅ Sync all rows' inputs for the given column (e.g., "wednesday_days[]")
            function syncColumnInputs(inputName) {
                const referenceInput = document.querySelector(`input[name="${inputName}"]`);
                if (!referenceInput) return;

                const value = referenceInput.value; // Get the typed value

                document.querySelectorAll(`input[name="${inputName}"]`).forEach(input => {
                    input.value = value;
                    calculateRowTotals(input.closest("tr")); // Recalculate row totals after updating values
                });
            }
        </script>


    </main>



</body>

</html>