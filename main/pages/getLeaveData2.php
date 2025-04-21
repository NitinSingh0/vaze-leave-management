 <?php
    session_start();
    include '../../config/connect.php';  // Database connection file

    // Retrieve Staff_id from session
    $staff_id = $_SESSION['Staff_id'];


    $sql = "SELECT * FROM staff WHERE Staff_id = '$staff_id'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $jobRole = $row['Job_role'];
    }

    $startMonth = date('n'); // Get the current month (1-12)
    $a_year = date('Y');  // Get the current year

    //If Non Teaching Then No year Change Else the 1 june - 31may Condition

    if ($jobRole != "OO" && $jobRole != "NL" && $jobRole != "NO") {
        // Determine academic year based on the month
        if ($startMonth >= 6) { // From June onwards, current academic year starts with this year
            $a_year = $a_year;
        } else { // Before June, current academic year starts with last year
            $a_year = $a_year - 1;
        }
    }



    // $currentYear = date("Y");
    // $currentMonth = date("n");
    // $a_year = ($currentMonth > 6) ? $currentYear : $currentYear - 1;

    // Step 1: Find D_id for the staff member
    // $query = $conn->prepare("SELECT D_id FROM staff WHERE Staff_id = ?");
    // $query->bind_param("i", $staff_id);
    // $query->execute();
    // $result = $query->get_result();
    // $staffInfo = $result->fetch_assoc();
    // $D_id = $staffInfo['D_id'];

    // // Step 2: Check department and college details
    // $query = $conn->prepare("SELECT College, Name FROM department WHERE D_id = ?");
    // $query->bind_param("i", $D_id);
    // $query->execute();
    // $result = $query->get_result();
    // $departmentInfo = $result->fetch_assoc();
    // $college = $departmentInfo['College'];
    // $departmentName = $departmentInfo['Name'];

    // Initialize leave totals and used values
    $totalCasualLeave = $usedCasualLeave = 0;
    $totalMedicalLeave = $usedMedicalLeave = 0;
    $totalEarnedLeave = $usedEarnedLeave = 0;
    $totalHalfPayLeave = $usedHalfpayLeave = 0;
    $totalMaternityLeave = $usedMaternityLeave = 0;
    // $totalOtherLeave = $usedOtherLeave = 0;

    $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
    $totalHalfPayLeave = fetchTotalLeave($conn, $staff_id, 'HP', $a_year);
    $totalMaternityLeave = fetchTotalLeave($conn, $staff_id, 'MA', $a_year);

    // Step 3: Retrieve leave data based on College and Department
    if ($jobRole == 'TD') {
        // Junior College leave data
        // $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'd_cl_leave','other', $staff_id, $a_year);

        $totalMedicalLeave = fetchTotalLeave($conn, $staff_id, 'ML', $a_year);
        $usedMedicalLeave = fetchUsedLeave($conn, 'd_mhm_leave','ML', $staff_id, $a_year);

        $usedHalfpayLeave = fetchUsedLeave($conn, 'd_mhm_leave','HP', $staff_id, $a_year);
        $usedMaternityLeave = fetchUsedLeave($conn, 'd_mhm_leave','MA', $staff_id, $a_year);


    } elseif ($jobRole == 'TJ') {
        
        $usedCasualLeave = fetchUsedLeave($conn, 'j_cl_leave', 'other', $staff_id, $a_year);

        $totalEarnedLeave= fetchTotalLeave($conn, $staff_id, 'EL', $a_year);
        $usedEarnedLeave = fetchUsedLeave($conn, 'j_ehm_leave', 'EL', $staff_id, $a_year);

        $usedHalfpayLeave = fetchUsedLeave($conn, 'j_ehm_leave', 'HP', $staff_id, $a_year);
        $usedMaternityLeave = fetchUsedLeave($conn, 'j_ehm_leave', 'MA', $staff_id, $a_year);

    } elseif($jobRole == 'NL'){

        $usedCasualLeave = fetchUsedLeave($conn, 'n_cl_leave', 'other', $staff_id, $a_year);

        $totalMedicalLeave = fetchTotalLeave($conn, $staff_id, 'ML', $a_year);
        $usedMedicalLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'ML', $staff_id, $a_year);

        $usedHalfpayLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'HP', $staff_id, $a_year);
        $usedMaternityLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'MA', $staff_id, $a_year);

    } elseif ($jobRole == 'NO' || $jobRole == 'OO') {

        $usedCasualLeave = fetchUsedLeave($conn, 'n_cl_leave', 'other', $staff_id, $a_year);

        $totalMedicalLeave = fetchTotalLeave($conn, $staff_id, 'ML', $a_year);
        $usedMedicalLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'ML', $staff_id, $a_year);

        $totalEarnedLeave= fetchTotalLeave($conn, $staff_id, 'EL', $a_year);
        $usedEarnedLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'EL', $staff_id, $a_year);

        $usedHalfpayLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'HP', $staff_id, $a_year);
        $usedMaternityLeave = fetchUsedLeave($conn, 'n_emhm_leave', 'MA', $staff_id, $a_year);
    }

    // Step 4: Return data as JSON
    echo json_encode([
        'casual' => ['total' => $totalCasualLeave, 'used' => $usedCasualLeave],
        'medical'=> ['total'=> $totalMedicalLeave, 'used'=> $usedMedicalLeave],
        'earned' => ['total' => $totalEarnedLeave, 'used' => $usedEarnedLeave],
        'halfpay' => ['total' => $totalHalfPayLeave, 'used' => $usedHalfpayLeave],
        'maternity' => ['total' => $totalMaternityLeave, 'used' => $usedMaternityLeave]
    ]);

    // Helper functions
    function fetchTotalLeave($conn, $staff_id, $type, $a_year)
    {
       
            $query = $conn->prepare("SELECT SUM(No_of_leaves) AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type = ? AND A_year = ?");
            // Bind parameters and execute
            $query->bind_param("isi", $staff_id, $type, $a_year);

        // $query = $conn->prepare("SELECT SUM(No_of_leaves) AS TotalLeave FROM staff_leaves_trial 
        //                          WHERE Staff_id = ? AND Leave_type NOT IN ('CL', 'DL') AND A_year = ?");

        // Execute the query
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        // Return the result (sum for 'Other' and No_of_leaves for specific types)
        return $result['TotalLeave'] ?? 0;
    }


    function fetchUsedLeave($conn, $table,$leaveType, $staff_id, $a_year)
    {
        // Verify the table name is one of the expected values
        $allowedTables = ['j_cl_leave', 'j_ehm_leave', 'n_cl_leave','n_emhm_leave', 'd_cl_leave', 'd_mhm_leave'];
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Invalid table name: $table");
        }


        if($leaveType=='other'){
            $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND A_year = ?");
            $query->bind_param("ii", $staff_id, $a_year);
        }else{
            $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND Type = ? AND A_year = ?");
            $query->bind_param("isi", $staff_id,$leaveType, $a_year);
        }


        // Prepare the query dynamically
        // $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND A_year = ?");

        // if (!$query) {
        //     die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        // }

        // $query->bind_param("ii", $staff_id, $a_year);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['UsedLeaves'] ?? 0; // Return the value or 0 if no data
        } else {
            echo "No used leave record for: $staff_id, $table, $a_year<br>"; // Debugging line
        }

        return 0; // Return 0 if no results
    }

    function fetchpendingLeave($conn, $table, $leaveType, $staff_id, $a_year)
    {
        // Verify the table name is one of the expected values
        $allowedTables = ['j_cl_leave', 'j_ehm_leave', 'n_cl_leave', 'n_emhm_leave', 'd_cl_leave', 'd_mhm_leave'];
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Invalid table name: $table");
        }


        if ($leaveType == 'other') {
            $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status != 'PA' AND A_year = ?");
            $query->bind_param("ii", $staff_id, $a_year);
        } else {
            $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status != 'PA' AND Type = ? AND A_year = ?");
            $query->bind_param("isi", $staff_id, $leaveType, $a_year);
        }


        // Prepare the query dynamically
        // $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND A_year = ?");

        // if (!$query) {
        //     die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        // }

        // $query->bind_param("ii", $staff_id, $a_year);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['UsedLeaves'] ?? 0; // Return the value or 0 if no data
        } else {
            echo "No used leave record for: $staff_id, $table, $a_year<br>"; // Debugging line
        }

        return 0; // Return 0 if no results
    }



    ?>