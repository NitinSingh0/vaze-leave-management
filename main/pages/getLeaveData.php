 <?php
    session_start();
    include '../../config/connect.php';  // Database connection file

    // Retrieve Staff_id from session
    $staff_id = $_SESSION['Staff_id'];
    
    $currentYear = date("Y");
    $currentMonth = date("n");
    $a_year = ($currentMonth > 6) ? $currentYear : $currentYear - 1;

    // Step 1: Find D_id for the staff member
    $query = $conn->prepare("SELECT D_id FROM staff WHERE Staff_id = ?");
    $query->bind_param("i", $staff_id);
    $query->execute();
    $result = $query->get_result();
    $staffInfo = $result->fetch_assoc();
    $D_id = $staffInfo['D_id'];

    // Step 2: Check department and college details
    $query = $conn->prepare("SELECT College, Name FROM department WHERE D_id = ?");
    $query->bind_param("i", $D_id);
    $query->execute();
    $result = $query->get_result();
    $departmentInfo = $result->fetch_assoc();
    $college = $departmentInfo['College'];
    $departmentName = $departmentInfo['Name'];

    // Initialize leave totals and used values
    $totalCasualLeave = $usedCasualLeave = 0;
    $totalDutyLeave = $usedDutyLeave = 0;
    $totalOtherLeave = $usedOtherLeave = 0;

    // Step 3: Retrieve leave data based on College and Department
    if ($college == 'J') {
        // Junior College leave data
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'j_cl_leave', $staff_id, $a_year);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'j_dl_leave', $staff_id, $a_year);

        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave($conn, $staff_id, 'Other', $a_year);
        $usedOtherLeave = fetchUsedLeave($conn, 'j_ehm_leave', $staff_id, $a_year);
    } elseif ($college == 'D' && $departmentName == 'Office_lab') {
        // Degree College Office_lab staff
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'n_cl_leave', $staff_id, $currentYear);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'n_dl_leave', $staff_id, $currentYear);

        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave(
            $conn,
            $staff_id,
            'Other',
            $a_year
        );

        $usedOtherLeave = fetchUsedLeave($conn, 'n_emhm_leave', $staff_id, $currentYear);
    } else {
        // General Degree College
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'd_cl_leave', $staff_id, $a_year);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'd_dl_leave', $staff_id, $a_year);
        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave($conn, $staff_id, 'Other', $a_year);
        $usedOtherLeave = fetchUsedLeave($conn, 'd_mhm_leave', $staff_id, $a_year);
    }

    // Step 4: Return data as JSON
    echo json_encode([
        'casual' => ['total' => $totalCasualLeave, 'used' => $usedCasualLeave],
        'duty' => ['total' => $totalDutyLeave, 'used' => $usedDutyLeave],
        'other' => ['total' => $totalOtherLeave, 'used' => $usedOtherLeave]
    ]);

    // Helper functions
    function fetchTotalLeave($conn, $staff_id, $type, $a_year)
    {
        // If the leave type is 'Other', we need to sum all leave types excluding 'CL' and 'DL'
        if ($type == 'Other') {
            $query = $conn->prepare("SELECT SUM(No_of_leaves) AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type NOT IN ('CL', 'DL') AND A_year = ?");
            // Bind parameters and execute
            $query->bind_param("ii", $staff_id, $a_year);
        } else {
            // For specific leave types like CL and DL, the original query applies
            $query = $conn->prepare("SELECT No_of_leaves AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type = ? AND A_year = ?");
            // Bind parameters and execute
            $query->bind_param("isi", $staff_id, $type, $a_year);
        }

        // Execute the query
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        // Return the result (sum for 'Other' and No_of_leaves for specific types)
        return $result['TotalLeave'] ?? 0;
    }




    function fetchUsedLeave($conn, $table, $staff_id, $a_year)
    {
        // Verify the table name is one of the expected values
        $allowedTables = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave', 'n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'd_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Invalid table name: $table");
        }

        // Prepare the query dynamically
        $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND A_year = ?");

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
            echo "No used leave record for: $staff_id, $table, $a_year<br>"; // Debugging line
        }

        return 0; // Return 0 if no results
    }



    ?>