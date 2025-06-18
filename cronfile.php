<?php
include("config/connect.php");

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
session_start();


$startMonth = date('n'); // Get the current month (1-12)
$startYear = date('Y')-1;  // Get the current year and subtracting 1 year for carry forwarding the previous year ML leave


//Selecting all staff members except those with Job_role 'TJ' and status 'A'
$sql= "SELECT * FROM staff WHERE Job_role!= 'TJ' AND status='A'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $staff_id = $row['Staff_id'];
        $jobRole = $row['Job_role'];

        // Check if the staff member is a teacher or non-teacher BASED ON WHICH THE YEAR IS DECIDED
        if ($jobRole != "OO" && $jobRole != "NL" && $jobRole != "NO") {
            // Determine academic year based on the month
            if ($startMonth >= 6) { // From June onwards, current academic year starts with this year
                $startYear = $startYear;
            } else { // Before June, current academic year starts with last year
                $startYear = $startYear - 1;
            }
        }

        // CHECK THE TOTAL ML LEAVE OF THE staff member for the current academic year
        $sql2 = "SELECT Staff_id,sum(No_of_leaves) AS TotalML FROM staff_leaves_trial WHERE Staff_id = '$staff_id' AND A_year = '$startYear' AND Leave_type = 'ML'";
        $result2 = $conn->query($sql2);
        if( $result2->num_rows > 0) {
            if ($row2 = $result2->fetch_assoc()) {
                $totalML = $row2['TotalML'];
            }
        } else {
            $totalML = 0; // Default value if no records found
        }

        // CHECK THE JOB_ROLE OF THE STAFF MEMBER AND FETCH THE USED ML LEAVE
        if($jobRole=="TD"){

            // CHECK THE TOTAL USED ML LEAVE OF THE staff member for the current academic year
            $sql3 = "SELECT Staff_id,sum(No_of_days) AS TotalMLUSED FROM d_mhm_leave WHERE Staff_id = '$staff_id' AND A_year = '$startYear' AND leave_approval_status = 'PA' AND Type = 'ML' ";
            $result3= $conn->query($sql3);
            if ($result3->num_rows > 0) {
                if ($row3 = $result3->fetch_assoc()) {
                    $totalMLUSED = $row3['TotalMLUSED'];
                }
            } else {
                $totalMLUSED = 0; // Default value if no records found
            }
        }else{

            // CHECK THE TOTAL USED ML LEAVE OF THE staff member for the current academic year
            $sql3 = "SELECT Staff_id,sum(No_of_days) AS TotalMLUSED FROM n_emhm_leave WHERE Staff_id = '$staff_id' AND A_year = '$startYear' AND leave_approval_status = 'PA' AND Type = 'ML' ";
            $result3 = $conn->query($sql3);
            if ($result3->num_rows > 0) {
                if ($row3 = $result3->fetch_assoc()) {
                    $totalMLUSED = $row3['TotalMLUSED'];
                }
            } else {
                $totalMLUSED = 0; // Default value if no records found
            }
        }

        // Calculate the remaining Medical Leave (ML) for the staff member
        $REMAININGML= $totalML- $totalMLUSED;

        if($REMAININGML>0){

            //INCREMENTING THE ACEDEMIC YEAR
            $nextyear=$startYear+1;

            //INSERTING THE REMAINING ML LEAVE FOR THAT STAFF MEMBER FOR THE NEXT YEAR
            $sql4 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) 
            VALUES ('$staff_id', 'ML', '$REMAININGML', '$nextyear')";

            if ($res = $conn->query($sql4)) {
                echo "<script>alert('Medical Leave Carry forward Successfully!');</script>";
                //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
                // echo json_encode(['status' => 'success', 'message' => 'ML Leave Applied Successfully!']);
            } else {
                echo "<script>alert('ERROR!!');</script>";
                // echo json_encode(['status' => 'error', 'message' => 'ERROR!!']);
            }
        }else{
            echo "<script>alert('No Medical Leave to carry forward for Staff ID: $staff_id');</script>";
            // echo json_encode(['status' => 'info', 'message' => 'No Medical Leave to carry forward for Staff ID: ' . $staff_id]);
        }
      
    }
}else{
    echo "<script>alert('No active staff members found.');</script>";
    exit;
}


?>