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
    if (isset($_POST['year']) && !empty($_POST['application_date']) && !empty($_POST['department']) && !empty($_POST['from_date']) && !empty($_POST['to_date']) && !empty($_POST['reason'])) {
        $year = $_POST["year"];
        $application_date = $_POST["application_date"];
        $department = $_POST["department"];
        $from_date = $_POST["from_date"];
        $to_date = $_POST["to_date"];
        $reason = $_POST["reason"];
        $ref_no = isset($_POST["reference_no"]) ? $_POST["reference_no"] : null;
        $date_of_letter = isset($_POST["date_of_letter"]) ? $_POST["date_of_letter"] : null;
        $leave_type = $_POST["type"];


        $start = new DateTime($from_date);
        $end = new DateTime($to_date);

        // Calculate the difference
        $interval = $start->diff($end);

        // Get the number of days
        $days = ($interval->days) + 1;

        // echo "Number of days: " . $days;


        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";
        $staff_id = $Staff_id;
        $type = $jobRole;

        if ($type == 'TD') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM d_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                //echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Duty Leave has already been applied for these dates!']);
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO d_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
                    echo json_encode(['status' => 'success', 'message' => 'Duty Leave Applied Successfully!']);
                } else {
                    //echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
                }
            }
        } elseif ($type == 'TJ') {

            // Check for duplicate entry
            $checkSql = "SELECT * FROM j_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                // echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Duty Leave has already been applied for these dates!']);
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO j_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
                    echo json_encode(['status' => 'success', 'message' => 'Duty Leave Applied Successfully!']);
                } else {
                    //echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
                }
            }
        } elseif ($type == 'NL' || $type == 'NO' || $type == 'OO') {

            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                // echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Duty Leave has already been applied for these dates!']);
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';

                    echo json_encode(['status' => 'success', 'message' => 'Duty Leave Applied Successfully!']);
                } else {
                    // echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
                }
            }
        }
    }
}
