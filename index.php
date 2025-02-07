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
                        <th colspan="2">Full-Time</th>
                        <th colspan="2">Overloads</th>
                        <th rowspan="2">Total</th>
                        <th colspan="3">With Review</th>
                        <th colspan="3">Adjustment</th>
                        <th colspan="3">Watch Reward</th>
                        <th rowspan="2">Gross</th>
                        <th colspan="3">Absences/Late</th>
                        <th colspan="2">Loans</th>
                        <th colspan="5">Contributions</th>
                        <th rowspan="2">Canteen</th>
                        <th rowspan="2">Others</th>
                        <th rowspan="2">Total Deductions</th>
                        <th rowspan="2">Net Pay</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr>
                        <th>Basic</th>
                        <th>Honorarium</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>HR</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Pag-ibig</th>
                        <th>MP2</th>
                        <th>Med. S</th>
                        <th>SSS</th>
                        <th>Ret.</th>
                        <th>P-ibig</th>
                        <th>P-Hlth</th>
                    </tr>
                </thead>
                <tbody>
        
                    <?php
                    $sql = "SELECT * FROM computation";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["employee_name"] . "</td>";
                            echo "<td>" . $row["basic_salary"] . "</td>";
                            echo "<td>" . $row["honorarium"] . "</td>";
                            echo "<td>" . $row["overload_hr"] . "</td>";
                            echo "<td>" . $row["overload_rate"] . "</td>";
                            echo "<td>" . $row["overload_total"] . "</td>";
                            echo "<td>" . $row["wr_hr"] . "</td>";
                            echo "<td>" . $row["wr_rate"] . "</td>";
                            echo "<td>" . $row["wr_total"] . "</td>";
                            echo "<td>" . $row["adjust_hr"] . "</td>";
                            echo "<td>" . $row["adjust_rate"] . "</td>";
                            echo "<td>" . $row["adjust_total"] . "</td>";
                            echo "<td>" . $row["watch_hr"] . "</td>";
                            echo "<td>" . $row["watch_rate"] . "</td>";
                            echo "<td>" . $row["watch_total"] . "</td>";
                            echo "<td>" . $row["gross_pay"] . "</td>";
                            echo "<td>" . $row["absent_late_hr"] . "</td>";
                            echo "<td>" . $row["absent_late_rate"] . "</td>";
                            echo "<td>" . $row["absent_late_total"] . "</td>";
                            echo "<td>" . $row["pagibig"] . "</td>";
                            echo "<td>" . $row["mp2"] . "</td>";
                            echo "<td>" . $row["med_s"] . "</td>";
                            echo "<td>" . $row["sss"] . "</td>";
                            echo "<td>" . $row["retirement"] . "</td>";
                            echo "<td>" . $row["p_ibig"] . "</td>";
                            echo "<td>" . $row["philhealth"] . "</td>";
                            echo "<td>" . $row["canteen"] . "</td>";
                            echo "<td>" . $row["others"] . "</td>";
                            echo "<td>" . $row["total_deduction"] . "</td>";
                            echo "<td>" . $row["net_pay"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='26'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            const table = document.getElementById('crudTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            for (let i = 0; i < 30; i++) {
                const newCell = newRow.insertCell(i);
                newCell.contentEditable = 'true';
                newCell.textContent = '';
            }
            const actionsCell = newRow.insertCell(30);
            actionsCell.innerHTML = '<button>Edit</button>';
        });

        document.getElementById('saveTableBtn').addEventListener('click', function() {
            const table = document.getElementById('crudTable').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');
            const data = [];

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length < 30) {
                    console.error(`Row ${i} does not have enough cells.`);
                    continue;
                }
                const rowData = {
                    employee_name: cells[0].textContent.trim(),
                    basic_salary: cells[1].textContent.trim(),
                    honorarium: cells[2].textContent.trim(),
                    overload_hr: cells[3].textContent.trim(),
                    overload_rate: cells[4].textContent.trim(),
                    overload_total: cells[5].textContent.trim(),
                    wr_hr: cells[6].textContent.trim(),
                    wr_rate: cells[7].textContent.trim(),
                    wr_total: cells[8].textContent.trim(),
                    adjust_hr: cells[9].textContent.trim(),
                    adjust_rate: cells[10].textContent.trim(),
                    adjust_total: cells[11].textContent.trim(),
                    watch_hr: cells[12].textContent.trim(),
                    watch_rate: cells[13].textContent.trim(),
                    watch_total: cells[14].textContent.trim(),
                    gross_pay: cells[15].textContent.trim(),
                    absent_late_hr: cells[16].textContent.trim(),
                    absent_late_rate: cells[17].textContent.trim(),
                    absent_late_total: cells[18].textContent.trim(),
                    pagibig: cells[19].textContent.trim(),
                    mp2: cells[20].textContent.trim(),
                    med_s: cells[21].textContent.trim(),
                    sss: cells[22].textContent.trim(),
                    retirement: cells[23].textContent.trim(),
                    p_ibig: cells[24].textContent.trim(),
                    philhealth: cells[25].textContent.trim(),
                    canteen: cells[26].textContent.trim(),
                    others: cells[27].textContent.trim(),
                    total_deduction: cells[28].textContent.trim(),
                    net_pay: cells[29].textContent.trim()
                };
                data.push(rowData);
            }

            console.log('Data to be sent:', data); // Debugging line

            fetch('save_table.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response from server:', data); // Debugging line
                    if (data.success) {
                        alert('Table saved successfully!');
                    } else {
                        alert('Failed to save table.');
                        console.error('Server response:', data); // Debugging line
                    }
                })
                .catch(error => {
                    alert('An error occurred while saving the table.');
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>