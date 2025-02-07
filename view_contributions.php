<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>View Contribution</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body p {
            font-size: 0.9rem; /* Smaller text size */
        }

        .container {
            max-width: 200px; /* Restrict width */
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Contribution Details for <?= htmlspecialchars($contribution['Name']) ?></h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <!-- Employee Share -->
                            <div class="col-12 mb-3">
                                <h6 class="text-primary fw-bold">Employee Share</h6>
                                <p><strong>SSS:</strong> ₱<?= htmlspecialchars(number_format($contribution['sss_ee'], 2)) ?></p>
                                <p><strong>Pag-ibig:</strong> ₱<?= htmlspecialchars(number_format($contribution['pag_ibig_ee'], 2)) ?></p>
                                <p><strong>PhilHealth:</strong> ₱<?= htmlspecialchars(number_format($contribution['philhealth_ee'], 2)) ?></p>
                            </div>

                            <!-- Employer Share -->
                            <div class="col-12">
                                <h6 class="text-success fw-bold">Employer Share</h6>
                                <p><strong>SSS:</strong> ₱<?= htmlspecialchars(number_format($contribution['sss_er'], 2)) ?></p>
                                <p><strong>Pag-ibig:</strong> ₱<?= htmlspecialchars(number_format($contribution['pag_ibig_er'], 2)) ?></p>
                                <p><strong>PhilHealth:</strong> ₱<?= htmlspecialchars(number_format($contribution['philhealth_er'], 2)) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="manage_contributions.php" class="btn btn-secondary">Back to Contributions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
