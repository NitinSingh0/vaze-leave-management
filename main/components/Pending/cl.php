<?php
include("../../../config/connect.php");
header('Content-Type: application/json'); // Return JSON response
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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

if($jobRole=='NO' || $jobRole=='NL' || $jobRole=='OO' ){
    $currentYear = date("Y");
    $currentMonth = date("n");
    $a_year = ($currentMonth > 6) ? $currentYear : $currentYear - 1;
}else{
     $a_year= date("Y");
}

    // Initialize leave totals and used values
    $totalDutyLeave = $usedDutyLeave = 0;


  if ($jobRole == 'TD') {

    $totalDutyLeave = fetchTotalLeave($conn, $Staff_id, 'CL', $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'd_cl_leave',$Staff_id, $a_year);

} elseif ($jobRole == 'TJ') {

    $totalDutyLeave = fetchTotalLeave($conn, $Staff_id, 'CL', $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'j_cl_leave', $Staff_id, $a_year);
    
} else {

    $totalDutyLeave = fetchTotalLeave($conn,$Staff_id, 'CL', $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'n_cl_leave',$Staff_id, $a_year);
}

 //  Return data as JSON
    echo json_encode([
        'duty' => ['total' => $totalDutyLeave, 'used' => $usedDutyLeave]
    ]);

    // Helper functions
    function fetchTotalLeave($conn, $staff_id, $type, $a_year)
    {
       
        // Total DL Assigned Calculation 
        $query = $conn->prepare("SELECT SUM(No_of_leaves) AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type = ? AND A_year = ?");
        // Bind parameters and execute
        $query->bind_param("isi", $staff_id, $type, $a_year);
        
        // Execute the query
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        // Return the result (sum for 'Other' and No_of_leaves for specific types)
        return $result['TotalLeave'] ?? 0;
    }

    function fetchUsedLeave($conn, $table, $staff_id, $a_year)
    {
        
        // Prepare the query dynamically
        $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND A_year = ?");

        if (!$query) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $query->bind_param("ii", $staff_id, $a_year);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['UsedLeaves'] ?? 0; // Return the value or 0 if no data
        } else {
            return 0;
        }

    }


?>