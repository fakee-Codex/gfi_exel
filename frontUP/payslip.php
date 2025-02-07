<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Payslips</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        .payslip {
            width: 30%;
            margin-bottom: 2%;
            border: 1px solid #ccc;
            padding: 8px;
            font-family: Arial, sans-serif;
            font-size: 8px;
            /* Reduced font size */
        }

        .payslip .header {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            /* Slightly larger for headers */
        }

        .payslip table {
            width: 100%;
            margin-top: 5px;
            border-spacing: 0;
        }

        .payslip td {
            padding: 2px;
        }

        .payslip .footer {
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
        }

        /* To manage layout properly in two rows and three columns */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .container .payslip {
            width: 30%;
            /* Ensuring 3 payslips fit per row */
            margin-bottom: 2%;
        }
    </style>
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
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>

        <!-- Payslip 2 -->
        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>
            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>

        <!-- Payslip 3 -->
        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>
            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>

        <!-- Payslip 4 -->
        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>
            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>

        <!-- Payslip 5 -->
        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>
            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
                </tr>
            </table>
            <div class="footer">
                <span>Prepared by:</span>
                <span>Approved by:</span>
                <span>Noted by:</span>
            </div>
        </div>

        <div class="payslip">
            <div class="header">
                <h1>GENSANTOS FOUNDATION COLLEGE, INC.</h1>
                <h2>PAY SLIP</h2>
            </div>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>TEACHER 9</td>
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
                    <td class="text-right">19,000.00</td>
                </tr>
                <tr>
                    <td>Faculty and Staff Development</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">1,000.00</td>
                </tr>
                <tr>
                    <td><strong>GROSS</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>20,000.00</strong></td>
                </tr>
                <tr>
                    <td>Deductions:</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Ret. Plan</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Medical Savings</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>SSS Cont'n</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">472.50</td>
                </tr>
                <tr>
                    <td>Phil Health</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">262.50</td>
                </tr>
                <tr>
                    <td>PAG-IBIG</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">200.00</td>
                </tr>
                <tr>
                    <td><strong>NET</strong></td>
                    <td>P</td>
                    <td></td>
                    <td class="text-right"><strong>19,065.00</strong></td>
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
