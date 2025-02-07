<?php include 'database_connection.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table_styles.css">
</head>

<body>
<?php include 'sidebars.php'; ?>
    <div class="content">
        <h1>GFI File 301 Payroll (September 1-15, 2024)</h1>
        <button id="addRowBtn">Add Row</button>
        <button id="saveTableBtn">Save Table</button>
        <div class="table-wrapper">
            <table id="crudTable">
                <thead>
                    <tr>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Employment Classification</th>
                        <th rowspan="2">Job Title</th>
                        <th colspan="1">Rate</th>
                        <th colspan="1"></th>
                        <th colspan="1"></th>
                        <th colspan="2">Other Benifits</th>
                        <th colspan="2">Additional Pay</th>
                        <th rowspan="2">Gross Salary</th>
                        <th colspan="4">Loans</th>
                        <th colspan="3">Contributions</th>
                        <th rowspan="2">Medical Savings</th>
                        <th rowspan="2">Canteen</th>
                        <th rowspan="2">Absent/Late</th>
                        <th rowspan="2">Other Deductions</th>
                        <th rowspan="2">Net Pay</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr>
                        <th>OL/OT</th>
                        <th>OL</th>
                        <th>Basic Salary</th>
                        <th>F&S 15th</th>
                        <th>WATCH</th>
                        <th>OT</th>
                        <th>OVERLOAD</th>
                        <th>HDMF</th>
                        <th>MP2</th>
                        <th>SSS</th>
                        <th>RTRMNT</th>
                        <th>SSS</th>
                        <th>PAG-IBIG</th>
                        <th>PHIC</th>
                    </tr>
                </thead>
                <tbody>
                </body>               