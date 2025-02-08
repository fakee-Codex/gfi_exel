<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <?php include 'aside.php'; ?> <!-- This will import the sidebar -->

    <main>



        <!-- Main Content -->
        <div class="flex-grow-1 bg-light p-4">
            <h1 class="mb-4">Run Payroll</h1>

            <!-- Employee Table -->
            <div class="card p-4">
                <h2 class="mb-3">Employee hours and wages</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Worker</th>
                            <th>Hours</th>
                            <th>Wages</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-4oEE1D5KIFmVraXTngEy88BuVZ3w5d.png" width="40" class="rounded-circle"> Elena Dennis
                            </td>
                            <td>
                                <input type="number" value="30" class="form-control d-inline w-25"> Regular
                                <br>
                                <input type="number" value="0" class="form-control d-inline w-25"> OT
                            </td>
                            <td>$2610.00</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-4oEE1D5KIFmVraXTngEy88BuVZ3w5d.png" width="40" class="rounded-circle"> Bethany Kaufman
                            </td>
                            <td>
                                <input type="number" value="40" class="form-control d-inline w-25"> Regular
                                <br>
                                <input type="number" value="2" class="form-control d-inline w-25"> OT
                            </td>
                            <td>$1075.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>





</body>

</html>