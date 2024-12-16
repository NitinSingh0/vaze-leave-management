<?php
// Include the database connection file
include('../../../config/connect.php');
//print_r($_POST);

//INDIVIDUAL
if (
    isset($_POST['teacherId']) &&
    !empty($_POST['year']) &&
    !empty($_POST['indiv_ml']) &&
    !empty($_POST['indiv_cl']) &&
    !empty($_POST['indiv_hl']) &&
    !empty($_POST['indiv_ma']) &&
    !empty($_POST['indiv_el'])
) {
    $el = $_POST['indiv_el'];
    $staff_id = $_POST['teacherId'];
    $cl = $_POST['indiv_cl'];
    $ma = $_POST['indiv_ma'];
    $hl = $_POST['indiv_hl'];
    $ml = $_POST['indiv_ml'];
    $year = $_POST['year'];
    $message = "";

    $checkSql = "SELECT * FROM staff_leaves_trial WHERE Staff_id = '$staff_id' AND A_year = '$year' AND (Leave_type = 'CL' OR Leave_type = 'MA' OR Leave_type = 'HP' OR Leave_type = 'EL' OR Leave_type = 'ML' )";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Duplicate found
        echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Leaves for the Year Already Assigned!']);
    } else {
        // No duplicate, proceed with insertion
        $sql1 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'CL', '$cl', '$year')";
        $sql2 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'MA', '$ma', '$year')";
        $sql3 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'HP', '$hl', '$year')";
        $sql4 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'ML', '$ml', '$year')";
      
       if ($el != "ok123") {
            $sql5 = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'EL', '$el', '$year')";
            if ($conn->query($sql5)) {
                $message .= "Earned Leave Applied \n";
            } else {
                $message .= "Failed to Apply Earned Leave \n";
            }
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
            $message .= "Medical Leave Applied \n";
        } else {
            $message .= "Failed to Apply Medical Leave \n";
        }

        echo json_encode(['status' => 'success', 'message' => $message]);
    }
}
//ALL
elseif (
    !empty($_POST['year']) &&
    !empty($_POST['all_ml']) &&
    !empty($_POST['all_cl']) &&
    !empty($_POST['all_hl']) &&
    !empty($_POST['all_ma']) &&
    !empty($_POST['all_el']) &&
    !empty($_POST['type'])
) {
    $el = $_POST['all_el'];
    $type = $_POST['type'];
    $cl = $_POST['all_cl'];
    $ma = $_POST['all_ma'];
    $hl = $_POST['all_hl'];
    $ml = $_POST['all_ml'];
    $year = $_POST['year'];
    $message = "";

    if($type=='NO'){
        $query = "SELECT * FROM staff WHERE Job_role IN ('NO','OO') AND status='A' ";
    }
    else{
        // Query to fetch all staff members in the specified department
        $query = "SELECT * FROM staff WHERE Job_role='$type' AND status='A' ";
    }
  
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
                    "CL" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'CL', '$cl', '$year')",
                    "MA" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'MA', '$ma', '$year')",
                    "HP" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'HP', '$hl', '$year')",
                    "DL" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'DL', 10, '$year')",
                    "ML" => "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'ML', '$ml', '$year')",
                            ];

                if ($el != "ok123") {
                    $insertSql["EL"] = "INSERT INTO staff_leaves_trial (Staff_id, Leave_type, No_of_leaves, A_year) VALUES ('$staff_id', 'EL', '$el', '$year')";
                }

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
