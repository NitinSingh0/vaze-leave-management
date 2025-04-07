<?php
// Include the database connection file
include('../../../config/connect.php');
//print_r($_POST);

//Teaching wise
if (
    isset($_POST['teaching_t']) &&
    !empty($_POST['teaching_cl']) &&
    !empty($_POST['teaching_ma']) &&
    !empty($_POST['teaching_hl']) &&
    !empty($_POST['teaching_ml_el']) &&
    !empty($_POST['year']) &&
    !empty($_POST['type'])
) {
    $type= $_POST['type'];
    $teaching_t = $_POST['teaching_t'];
    $teaching_cl = $_POST['teaching_cl'];
    $teaching_ma = $_POST['teaching_ma'];
    $teaching_hl = $_POST['teaching_hl'];
    $teaching_ml_el = $_POST['teaching_ml_el'];
    $year = $_POST['year'];
    $message = "";

    $checkSql = "SELECT * FROM staff_leaves_trial WHERE Staff_id = '$teaching_t' AND A_year = '$year' AND (Leave_type = 'CL' OR Leave_type = 'MA' OR Leave_type = 'HP' OR Leave_type = 'EL' OR Leave_type = 'ML' )";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Duplicate found
        echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Leaves for the Year Already Assigned!']);
    } else {
        // No duplicate, proceed with insertion
        $sql1 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$teaching_t', 'CL', '$teaching_cl', '$year')";
        $sql2 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$teaching_t', 'MA', '$teaching_ma', '$year')";
        $sql3 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$teaching_t', 'HP', '$teaching_hl', '$year')";
        if($type=='J'){
            $sql4 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$teaching_t', 'EL', '$teaching_ml_el', '$year')";
            $leave="Earned";

        }elseif($type == 'D'){
            $sql4 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$teaching_t', 'ML', '$teaching_ml_el', '$year')";
            $leave = "Medical";
        }
      
        if ($conn->query($sql1)) {
            $message .= "Casual Leave Applied \n";
        } else {
            $message .= "Failed to Apply Casual Leave \n";
        }

        if ($conn->query($sql2)) {
            $message .= "Maternity Leave Applied \n";
        } else {
            $message .= "Failed to Apply Maternity Leave \n";
        }

        if ($conn->query($sql3)) {
            $message .= "Half Pay Leave Applied \n";
        } else {
            $message .= "Failed to Apply Half Pay Leave \n";
        }

        if ($conn->query($sql4)) {
            $message .= "$leave Leave Applied \n";
        } else {
            $message .= "Failed to Apply $leave Leave \n";
        }

        echo json_encode(['status' => 'success', 'message' => $message]); 
    }
}
//Teaching wise
elseif (
    !empty($_POST['department_wise_cl']) &&
    !empty($_POST['department_wise_ma']) &&
    !empty($_POST['department_wise_hl']) &&
    !empty($_POST['department_wise_ml_el']) &&
    !empty($_POST['year']) &&
    !empty($_POST['type']) &&
    !empty($_POST['department'])
) {
    $type = $_POST['type'];
    $department_wise_cl = $_POST['department_wise_cl'];
    $department_wise_ma = $_POST['department_wise_ma'];
    $department_wise_hl = $_POST['department_wise_hl'];
    $department_wise_ml_el = $_POST['department_wise_ml_el'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $message = "";

    // Query to fetch all staff members in the specified department
    $query = "SELECT * FROM staff WHERE D_id= '$department' AND status='A' ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Loop through each staff member in the department
        while ($row = $result->fetch_assoc()) {
            $staff_id = $row['Staff_id'];

            // Check for existing leave entries for the specified year
            $checkSql = "SELECT * FROM staff_leaves_trial WHERE Staff_id = '$staff_id' AND A_year = '$year' AND (Leave_type = 'CL' OR Leave_type = 'MA' OR Leave_type = 'HP' OR Leave_type = 'EL' OR Leave_type = 'ML')";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // If duplicate leave records found for the staff member, skip insertion and record a message
                $message .= "Duplicate Entry: Leaves for " . $row['Name'] . " already assigned for this year.\n";
                continue;
            } else {
                // Prepare insertion statements for each leave type
                $insertSql = [
                    "CL" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'CL', '$department_wise_cl', '$year')",
                    "MA" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'MA', '$department_wise_ma', '$year')",
                    "HP" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'HP', '$department_wise_hl', '$year')",
                    // "DL" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'DL', 10, '$year')",
                    ($type == 'J' ? "EL" : "ML") => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', '" . ($type == 'J' ? "EL" : "ML") . "', '$department_wise_ml_el', '$year')"
                ];

                // Execute each insert query and log success or failure messages
                foreach ($insertSql as $leaveType => $sql) {
                    if ($conn->query($sql)) {
                        $message .= ucfirst(strtolower($leaveType)) . " Leave applied for " . $row['Name'] . "\n";
                    } else {
                        $message .= "Failed to apply " . ucfirst(strtolower($leaveType)) . " Leave for " . $row['Name'] . "\n";
                    }
                }
            }
        }

        // Final success message with details of the operation
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        // Error message if no staff members are found in the department
        echo json_encode(['status' => 'error', 'message' => 'No teachers found in the specified department!']);
    }

    
}
else {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
}
