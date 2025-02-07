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
    <title>Overload Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Overload Data</h1>
        <p class="mb-4">
            This table provides an overview of employee overload data. It includes details such as employee names, hours worked (highlighted in secondary color), and total amounts for specific days of the week, including custom columns for adjustments and grand totals. You can view and edit individual employee overloads below.
        </p>
        <div class="col-md-2 text-end">
            <a href="manage_overload_add.php" class="btn btn-md btn-success mt-2 mb-2">ADD OVERLOAD</a>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="table-success">Employee Name</th>
                        <th colspan="3">Wednesday</th>
                        <th colspan="3">Thursday</th>
                        <th colspan="3">Friday</th>
                        <th colspan="3">MTTH</th>
                        <th colspan="3">MTWF</th>
                        <th colspan="3">TWTHF</th>
                        <th colspan="3">MW</th>
                        <th rowspan="2">Less</th>
                        <th rowspan="2" class="table-warning">Add</th>
                        <th rowspan="2" class="table-danger">Adjustments</th>
                        <th rowspan="2" class="table-success">Grand Total</th>
                        <th rowspan="2">ACTION</th>
                    </tr>
                    <tr>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                        <th>DAYS</th>
                        <th class="table-danger">HRS</th>
                        <th>TOTAL</th>
                    </tr>

                </thead>
                <tbody>
                    <?php if (!empty($overloadData)) : ?>
                        <?php foreach ($overloadData as $row) : ?>
                            <tr data-id="<?= htmlspecialchars($row['overload_id']) ?>">
                                <td><?= htmlspecialchars($row['employee_name']) ?></td>
                                <td><?= htmlspecialchars(number_format($row['wednesday_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['wednesday_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['wednesday_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['thursday_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['thursday_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['thursday_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['friday_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['friday_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['friday_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['mtth_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['mtth_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['mtth_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['mtwf_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['mtwf_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['mtwf_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['twthf_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['twthf_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['twthf_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['mw_days'], 2)) ?></td>
                                <td class="table-danger"><?= htmlspecialchars(number_format($row['mw_hrs'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['mw_total'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['less_lateOL'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['additional'], 2)) ?></td>
                                <td><?= htmlspecialchars(number_format($row['adjustment_less'], 2)) ?></td>
                                <td><?= htmlspecialchars('₱' . number_format($row['grand_total'], 2)) ?></td>
                                <td>
                                    <a href="manage_overload_edit.php?row_id=<?= htmlspecialchars($row['overload_id']) ?>" class="btn btn-sm btn-secondary">Edit</a>

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
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        </div>

</body>

</html>