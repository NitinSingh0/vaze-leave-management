<?php
// get_academic_years.php

include('../../config/connect.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $college = isset($_POST['college']) ? $_POST['college'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $staffId = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';

    $response = "";
    $errorMessage = "";

    if ($conn->connect_error) {
        $errorMessage = "Database connection failed: " . $conn->connect_error;
    }
   
    if (!empty($college) && !empty($department) && empty($staffId)) {
        // Define the tables to check based on college and department
        $tables = [];
     
        if ($college === 'D') { // Degree College
            if ($department === 'office_lab') {
                $tables = ['n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'n_off_pay_leave'];
            } else {
                $tables = ['d_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
            }
        } elseif ($college === 'J') { // Junior College
            $tables = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave'];
        }

        // Fetch distinct academic years from the relevant tables
        $years = [];
        foreach ($tables as $table) {
            $query = "SELECT DISTINCT A_year FROM $table WHERE Department = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $errorMessage = "Error preparing query for table $table: " . $conn->error;
                break;
            }
            $stmt->bind_param("s", $department);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $years[] = $row['A_year'];
                }
            } else {
                $errorMessage = "Error executing query for table $table: " . $stmt->error;
            }
            $stmt->close();
        }

        if (empty($errorMessage)) {
            // Remove duplicates and sort years
            $years = array_unique($years);
            sort($years, SORT_NUMERIC);

            // Build response options
            if (!empty($years)) {
                foreach ($years as $year) {
                    $displayYear = $year . '-' . ($year + 1);
                    $response .= "<option value='$year'>$displayYear</option>";
                }
            } else {
                $response = "<option value='' disabled>No Academic Years Available</option>";
            }
        }
    } elseif (!empty($staffId)) {
        // Define the tables to check based on college and department
        $tables = [];
        echo "<script>alert('$errorMessage. hello');</script>";
        if ($college === 'D') { // Degree College
            if ($department === 'office_lab') {
                $tables = ['n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'n_off_pay_leave'];
            } else {
                $tables = ['d_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
            }
        } elseif ($college === 'J') { // Junior College
            $tables = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave'];
        }

        // Fetch distinct academic years from the relevant tables
        $years = [];
        foreach ($tables as $table) {
            $query = "SELECT DISTINCT A_year FROM $table WHERE Department = ? AND Staff_id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $errorMessage = "Error preparing query for table $table: " . $conn->error;
                break;
            }
            $stmt->bind_param("ss", $department, $staffId);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $years[] = $row['A_year'];
                }
            } else {
                $errorMessage = "Error executing query for table $table: " . $stmt->error;
            }
            $stmt->close();
        }

        if (empty($errorMessage)) {
            // Remove duplicates and sort years
            $years = array_unique($years);
            sort($years, SORT_NUMERIC);

            // Build response options
            if (!empty($years)) {
                foreach ($years as $year) {
                    $displayYear = $year . '-' . ($year + 1);
                    $response .= "<option value='$year'>$displayYear</option>";
                }
            } else {
                $response = "<option value='' disabled>No Academic Years Available</option>";
            }
        }
    } else {
        $errorMessage = "Invalid Request: Missing required inputs.";
    }

    $conn->close();

    // Send response or error message
    if (!empty($errorMessage)) {
        echo "<script>alert('$errorMessage');</script>";
    } else {
      
        echo $response;
    }
} else {
    echo "<script>alert('Invalid Request: This script only supports POST requests.');</script>";
}
