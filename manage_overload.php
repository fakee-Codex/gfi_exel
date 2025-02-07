<?php
// Database connection
$host = 'localhost';
$dbname = 'gfi_exel';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch overload data along with employee names
    $query = "
        SELECT 
            o.*, 
            CONCAT(e.first_name, ' ', e.last_name) AS employee_name
        FROM overload o
        JOIN employees e ON o.employee_id = e.employee_id
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $overloadData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <script src="https://cdn.tailwindcss.com"></script>


    <style>
        /* Custom Tailwind style for table and button */
        .table-wrapper {
            max-width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.5rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        td input {
            width: 100%;
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            text-align: center;
        }

        td input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .save-btn {
            padding: 0.5rem 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-btn:hover {
            background-color: #45a049;
        }

        .editable-cell {
            text-align: center;
            width: 80px;
        }

        /* Styling for error input fields */
        .error-input {
            border-color: #ff0000;
        }

        .content {
            padding: 2rem;
            background-color: #f9fafb;
        }

        h1 {
            font-size: 1.75rem;
            color: #333;
        }
    </style>
</head>

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->
    <style>
        /* Sticky for the first column horizontally */
        #crudTable td:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            /* Optional: Set background color to avoid overlap with other columns */
            z-index: 2;
            /* Ensures the first column is above other content */
        }

        .gg {
            position: sticky;
            left: 0;
            z-index: 2;
            /* Ensures the first column is above other content */

        }
    </style>
    <main>

    <div class="content">
    <h1 class="text-3xl font-semibold text-center mb-4">Overload Data</h1>
    <p class="mb-4 text-center">
        This table provides an overview of employee overload data. It includes details such as employee names, hours worked (highlighted in secondary color), and total amounts for specific days of the week, including custom columns for adjustments and grand totals. You can view and edit individual employee overloads below.
    </p>
    <div class="text-right mb-4">
        <a href="manage_overload_add.php" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-600">ADD OVERLOAD</a>
    </div>

    <div class="table-wrapper">
        <!-- Start Form -->
        <form action="save_overload_data.php" method="POST" id="overloadForm">
            <table id="crudTable" class="table-auto w-full">
                <thead>
                    <tr>
                        <th rowspan="2" class="sticky gg">Employee Name</th>
                        <th colspan="3">Wednesday</th>
                        <th colspan="3">Thursday</th>
                        <th colspan="3">Friday</th>
                        <th colspan="3">MTTH</th>
                        <th colspan="3">MTWF</th>
                        <th colspan="3">TWTHF</th>
                        <th colspan="3">MW</th>
                        <th rowspan="2">Less</th>
                        <th rowspan="2">Add</th>
                        <th rowspan="2">Adjustments</th>
                        <th rowspan="2">Grand Total</th>
                        <th rowspan="2">ACTION</th>
                    </tr>
                    <tr>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>       <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th>HRS</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($overloadData)) : ?>
                        <?php foreach ($overloadData as $row) : ?>
                            <tr data-id="<?= htmlspecialchars($row['overload_id']) ?>">



                            <td><?= htmlspecialchars($row['employee_name']) ?></td>
                            <td>
    <input type="text" name="wednesday_days[]" value="<?= htmlspecialchars(number_format($row['wednesday_days'], 2)) ?>" oninput="updateDayTotal(this, 'wednesday')"/>
</td>

<td id="wednesday_hrs"><?= htmlspecialchars(number_format($row['wednesday_hrs'], 2)) ?></td>
<td id="wednesday_total"><?= htmlspecialchars('₱' . number_format($row['wednesday_total'], 2)) ?></td>

<script>
  function updateDayTotal(inputElement, day) {
    // Get the input value for days (wednesday_days)
    let days = parseFloat(inputElement.value);
    
    // Get the value for hours (wednesday_hrs) - assuming it's in the HTML
    let hours = parseFloat(document.getElementById(day + '_hrs').textContent);
    
    // If the days or hours are not valid numbers, set the total to 0
    if (isNaN(days) || isNaN(hours)) {
      document.getElementById(day + '_total').textContent = '₱0.00';
    } else {
      // Calculate the total (days * hours)
      let total = days * hours;

      // Update the total field (wednesday_total)
      document.getElementById(day + '_total').textContent = '₱' + total.toFixed(2);
    }
  }
</script>

<td>
    <input type="text" name="thursday_days[]" value="<?= htmlspecialchars(number_format($row['thursday_days'], 2)) ?>" oninput="updateDayTotal(this, 'thursday')"/>
</td>
<td><?= htmlspecialchars(number_format($row['thursday_hrs'], 2)) ?></td>
<td><?= htmlspecialchars('₱' . number_format($row['thursday_total'], 2)) ?></td>

<td>
    <input type="text" name="friday_days[]" value="<?= htmlspecialchars(number_format($row['friday_days'], 2)) ?>" oninput="updateDayTotal(this, 'friday')"/>
</td>
<td><?= htmlspecialchars(number_format($row['friday_hrs'], 2)) ?></td>
<td><?= htmlspecialchars('₱' . number_format($row['friday_total'], 2)) ?></td>

<!-- Apply the same for other days as well -->
<td>
    <input type="text" name="mtth_days[]" value="<?= htmlspecialchars(number_format($row['mtth_days'], 2)) ?>" oninput="updateDayTotal(this, 'mtth')"/>
</td>
<td><?= htmlspecialchars(number_format($row['mtth_hrs'], 2)) ?></td>
<td><?= htmlspecialchars('₱' . number_format($row['mtth_total'], 2)) ?></td>

<td>
    <input type="text" name="mtwf_days[]" value="<?= htmlspecialchars(number_format($row['mtwf_days'], 2)) ?>" oninput="updateDayTotal(this, 'mtwf')"/>
</td>
<td><?= htmlspecialchars(number_format($row['mtwf_hrs'], 2)) ?></td>
<td><?= htmlspecialchars('₱' . number_format($row['mtwf_total'], 2)) ?></td>

<td>
    <input type="text" name="twthf_days[]" value="<?= htmlspecialchars(number_format($row['twthf_days'], 2)) ?>" oninput="updateDayTotal(this, 'twthf')"/>
</td>
<td><?= htmlspecialchars(number_format($row['twthf_hrs'], 2)) ?></td>
<td><?= htmlspecialchars('₱' . number_format($row['twthf_total'], 2)) ?></td>

<td>
    <input type="text" name="mw_days[]" value="<?= htmlspecialchars(number_format($row['mw_days'], 2)) ?>" oninput="updateDayTotal(this, 'mw')"/>
</td>


<!-- The other columns can follow the same pattern -->

                                    <td><?= htmlspecialchars(number_format($row['mw_hrs'], 2)) ?></td>
                                    <td><?= htmlspecialchars('₱' . number_format($row['mw_total'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['less_lateOL'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['additional'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['adjustment_less'], 2)) ?></td>
                                    <td><?= htmlspecialchars('₱' . number_format($row['grand_total'], 2)) ?></td>
                                    <td>
                                        <a href="manage_overload_edit.php?row_id=<?= htmlspecialchars($row['overload_id']) ?>"
                                            style="color: white; background-color: blue; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Edit</a>
                                    </td>



                              
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="27">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Submit Button -->
           
        </form> <!-- End Form -->
    </div>
    <div class="text-right mt-4">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-600">
                    Save Changes
                </button>
            </div>
</div>

<script>
  function updateDayTotal(inputElement, day) {
    // Get all input fields for the specified day
    const dayInputs = document.querySelectorAll('[name$="_days[]"]');
    
    // Iterate through each input element and update its value
    dayInputs.forEach(function(field) {
      if (field.name.includes(day)) {
        field.value = inputElement.value; // Set the value of each field
      }
    });
  }
</script>



            <script src="js/bootstrap.bundle.min.js"></script>
        </div>



    </main>



</body>

</html>