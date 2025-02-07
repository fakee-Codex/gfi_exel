<?php
// Get the data from the URL
$basic_salary = isset($_GET['basic_salary']) ? $_GET['basic_salary'] : 'Not provided';
$full_name = isset($_GET['full_name']) ? $_GET['full_name'] : 'Not provided';
$honorarium = isset($_GET['honorarium']) ? $_GET['honorarium'] : 'Not provided';
$gross_pay = isset($_GET['gross_pay']) ? $_GET['gross_pay'] : 'Not provided';
$sss_total = isset($_GET['sss_total']) ? $_GET['sss_total'] : 'Not provided';
$philhealth_total = isset($_GET['philhealth_total']) ? $_GET['philhealth_total'] : 'Not provided';
$pag_ibig_total = isset($_GET['pag_ibig_total']) ? $_GET['pag_ibig_total'] : 'Not provided';
$net_pay = isset($_GET['net_pay']) ? $_GET['net_pay'] : 'Not provided';
$medical_savings = isset($_GET['medical_savings']) ? $_GET['medical_savings'] : 'Not provided';
$retirement = isset($_GET['retirement']) ? $_GET['retirement'] : 'Not provided';
$total_deduction = isset($_GET['total_deduction']) ? $_GET['total_deduction'] : 'Not provided';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Payslips</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="print.css">
</head>

<body>
    <div class="container">
        <!-- Payslip 1 -->
        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>

            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?php echo htmlspecialchars($full_name); ?></td>
                    <td>Ctrl no:</td>
                    <td class="text-red-500">309</td>
                </tr>
                <tr>
                    <td>Period:</td>
                    <td colspan="3">SEPTEMBER 1-15, 2024</td>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($basic_salary); ?></td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($honorarium); ?></td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong><?php echo htmlspecialchars($gross_pay); ?></strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($total_deduction); ?></td>

                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($retirement); ?></td>

                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($medical_savings); ?></td>

                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($sss_total); ?></td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($philhealth_total); ?></td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?php echo htmlspecialchars($pag_ibig_total); ?></td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong><?php echo htmlspecialchars($net_pay); ?></strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>




    </div>
</body>

</html>