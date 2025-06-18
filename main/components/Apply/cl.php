
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
            $checkSql = "SELECT * FROM d_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                // echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Casual Leave has already been applied for these dates!']);
           
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO d_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    //echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                    echo json_encode(['status' => 'success', 'message' => 'Casual Leave Applied Successfully!']);
               
                } else {
                    //echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
       
                }
            }
        } elseif ($type == 'TJ') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM j_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                //echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Casual Leave has already been applied for these dates!']);
        
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO j_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    // echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    // echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                    echo json_encode(['status' => 'success', 'message' => 'Casual Leave Applied Successfully!']);
                
                } else {
                    //echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
       
                }
            }
        } elseif ($type == 'NL' || $type == 'NO' || $type == 'OO') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                //echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Casual Leave has already been applied for these dates!']);
        
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    // echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    // echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                    echo json_encode(['status' => 'success', 'message' => 'Casual Leave Applied Successfully!']);
               
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                    echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
       
                }
            }
        }
    }
}
?>

