<?php

include("../../../config/connect.php");
session_start();
$Staff_id = $_SESSION['Staff_id'];
//echo "console.log(" . $Staff_id . ")";

if (!$Staff_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}
$sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $jobRole = $row['Job_role'];
}
//error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['year']) && !empty($_POST['application_date']) && !empty($_POST['department']) && !empty($_POST['no_of_days'])) {
        $year = $_POST["year"];
        $application_date = $_POST["application_date"];
        $department = $_POST["department"];

        $staff_id = $Staff_id;
        $type = $jobRole;


        // Assuming 'no_of_days' is the input for number of days, we retrieve it
        $no_of_days = $_POST['no_of_days'];

        // Initialize an array to store date and work data
        $duty_data = [];

        for ($i = 1; $i <= $no_of_days; $i++) {
            // Access each date and work input based on the naming pattern
            $date_key = "date_of_duty_$i";
            $work_key = "nature_of_work_$i";
            $off_key = "off_pay_date_$i";

            // Check if both inputs are set before accessing them
            if (isset($_POST[$date_key]) && isset($_POST[$work_key]) && isset($_POST[$off_key])) {
                $duty_data[] = [
                    'date_of_duty' => $_POST[$date_key],
                    'nature_of_work' => $_POST[$work_key],
                    'off_pay_date' => $_POST[$off_key]
                ];
            }
        }

        // Process or display duty_data as needed
        // foreach ($duty_data as $duty) {
        //     //     echo "Date of Duty: " . $duty['date_of_duty'] . "<br>";
        //     //     echo "Date of Duty: " . $duty['off_pay_date'] . "<br>";
        //     //     echo "Nature of Work: " . $duty['nature_of_work'] . "<br><br>";
        // }


        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";

        //flag
        $success_export_duty = "";
        $success_off_date = "";
        $error_dates = "";

        foreach ($duty_data as $duty) {
            $extra_duty = $duty['date_of_duty'];
            $off_date = $duty['off_pay_date'];
            $nature = $duty['nature_of_work'];

            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_off_pay_leave WHERE Staff_id = '$staff_id' AND Extra_Duty_date = '$extra_duty'";
            $checkResult = $conn->query($checkSql);


            if ($checkResult->num_rows > 0) {
                // Duplicate found
                //echo "<script>alert('Duplicate Entry:Off Pay Leave has already been applied for $extra_duty!');</script>";
                $error_dates .= "$extra_duty,";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_off_pay_leave (Staff_id, Date_of_application, Extra_duty_date, Nature_of_work, Off_leave_date, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$application_date ', '$extra_duty', '$nature', '$off_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    $success_export_duty .= "$extra_duty,";
                    $success_off_date .= "$off_date,";
                    // echo "<script>alert('Off Pay Leave Applied Successfully!');</script>";
                    // echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_OFF_PAY.php">';
                } else {
                    $error_dates .= "$extra_duty,";
                }
            }
        }

        // Trim trailing commas and spaces from dates
        $success_export_duty = rtrim($success_export_duty, ',');
        $success_off_date = rtrim($success_off_date, ',');
        $error_dates = rtrim($error_dates, ',');

        // Display the combined alert message

        if (!empty($error_dates)) {
            $message .= "\nFailed to apply Off Pay Leave for dates: $error_dates.";
            //echo "<script>alert('$message');</script>";
            //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_OFF_PAY.php">';
            echo json_encode(['status' => 'error', 'message' => 'Failed to apply Off Pay Leave for dates: '.$error_dates.'.']);
        
        } elseif (!empty($success_off_date)) {

            $message = "Off Pay Leave applied successfully for dates: $success_off_date.";
            echo json_encode(['status' => 'success', 'message' => 'Off Pay Leave applied successfully for dates: '.$success_off_date.'.']);
               
            //echo "<script>alert('$message');</script>";
            //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_OFF_PAY.php">';
        }
    }
}
