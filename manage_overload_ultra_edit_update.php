<?php
// manage_overload_ultra_edit_update.php
include('database_connection.php'); // Assuming you have a database connection setup

// Get the raw POST data
$data = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($data, true);

// Process the data
foreach ($data as $row) {
    // Access each row's data
    $overload_id = $row['overload_id'];
    $wednesday_days = $row['wednesday_days'];
    $wednesday_hrs = $row['wednesday_hrs'];
    $wednesday_total = $row['wednesday_total'];
    // ... and so on for other fields
    $thursday_days = $row['thursday_days'];
    $thursday_hrs = $row['thursday_hrs'];
    $thursday_total = $row['thursday_total'];
    $friday_days = $row['friday_days'];
    $friday_hrs = $row['friday_hrs'];
    $friday_total = $row['friday_total'];
    $mtth_days = $row['mtth_days'];
    $mtth_hrs = $row['mtth_hrs'];
    $mtth_total = $row['mtth_total'];
    $mtwf_days = $row['mtwf_days'];
    $mtwf_hrs = $row['mtwf_hrs'];
    $mtwf_total = $row['mtwf_total'];
    $twthf_days = $row['twthf_days'];
    $twthf_hrs = $row['twthf_hrs'];
    $twthf_total = $row['twthf_total'];
    $mw_days = $row['mw_days'];
    $mw_hrs = $row['mw_hrs'];
    $mw_total = $row['mw_total'];
    $less_lateOL = $row['less_lateOL'];
    $additional = $row['additional'];
    $adjustment_less = $row['adjustment_less'];
    $grand_total = $row['grand_total'];



    $sql = "UPDATE overload
    SET wednesday_days=?, wednesday_hrs=?, wednesday_total=?,
      thursday_days = ?, thursday_hrs = ?, thursday_total = ?, 
        friday_days = ?, friday_hrs = ?, friday_total = ?,
          mtth_days = ?, mtth_hrs = ?, mtth_total = ?, 
        mtwf_days = ?, mtwf_hrs = ?, mtwf_total = ?,
        twthf_days = ?, twthf_hrs = ?, twthf_total = ?,
  mw_days = ?, mw_hrs = ?, mw_total = ?,
   less_lateOL = ?, additional = ?, adjustment_less = ?, 
        grand_total = ?
    WHERE overload_id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "dddddddddddddddddddddddddi",
            $wednesday_days,
            $wednesday_hrs,
            $wednesday_total,
            $thursday_days,
            $thursday_hrs,
            $thursday_total,
            $friday_days,
            $friday_hrs,
            $friday_total,
            $mtth_days,
            $mtth_hrs,
            $mtth_total,
            $mtwf_days,
            $mtwf_hrs,
            $mtwf_total,
            $twthf_days,
            $twthf_hrs,
            $twthf_total,
            $mw_days,
            $mw_hrs,
            $mw_total,

            $less_lateOL,
            $additional,
            $adjustment_less,
            $grand_total,
            $overload_id
        );
        $stmt->execute();
        $stmt->close();
    }
}

// Return a response (optional)
echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
