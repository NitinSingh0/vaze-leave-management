<?php
// Database connection
include('../../config/connect.php');

header('Content-Type: application/json'); // Set JSON response

$response = [
    'success' => false,
    'data' => '',
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $college = isset($_POST['college']) ? $_POST['college'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $staffId = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';

    if ($conn->connect_error) {
        $response['error'] = "Database connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    if (!empty($college) && (!empty($department) || !empty($staffId))) {
        $tables = [];

        if ($college === 'D') {
            $tables = ($department === 'office_lab')
                ? ['n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'n_off_pay_leave']
                : ['d_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
        } elseif ($college === 'J') {
            $tables = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave'];
        }

        $staffIds = [];

        // Step 1: Fetch Staff IDs if department is provided
        if (!empty($department) && empty($staffId)) {
            $staffQuery = "SELECT Staff_id FROM staff WHERE D_id = ?";
            $staffStmt = $conn->prepare($staffQuery);

            if (!$staffStmt) {
                $response['error'] = "Error preparing staff query: " . $conn->error;
                echo json_encode($response);
                exit;
            }

            $staffStmt->bind_param("s", $department);

            if ($staffStmt->execute()) {
                $staffResult = $staffStmt->get_result();
                while ($row = $staffResult->fetch_assoc()) {
                    $staffIds[] = $row['Staff_id'];
                }
            } else {
                $response['error'] = "Error executing staff query: " . $staffStmt->error;
                echo json_encode($response);
                exit;
            }

            $staffStmt->close();

            if (empty($staffIds)) {
                $response['data'] = "<option value='' disabled>No Staff Found for Department</option>";
                echo json_encode($response);
                exit;
            }
        }

        // If staffId is directly provided, use it
        if (!empty($staffId)) {
            $staffIds[] = $staffId;
        }

        // Step 2: Fetch Academic Years for the relevant Staff IDs
        $years = [];
        foreach ($tables as $table) {
            $query = "SELECT DISTINCT A_year FROM $table WHERE Staff_id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                $response['error'] = "Error preparing query for table $table: " . $conn->error;
                echo json_encode($response);
                exit;
            }

            foreach ($staffIds as $id) {
                $stmt->bind_param("s", $id);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $years[] = $row['A_year'];
                    }
                } else {
                    $response['error'] = "Error executing query for table $table: " . $stmt->error;
                    echo json_encode($response);
                    exit;
                }
            }

            $stmt->close();
        }

        if (!empty($years)) {
            $years = array_unique($years);
            sort($years, SORT_NUMERIC);

            $options = "";
            foreach ($years as $year) {
                $displayYear = $year . '-' . ($year + 1);
                $options .= "<option value='$year'>$displayYear</option>";
            }

            $response['success'] = true;
            $response['data'] = $options;
        } else {
            $response['data'] = "<option value='' disabled>No Academic Years Available</option>";
        }
    } else {
        $response['error'] = "Invalid Request: Missing required inputs.";
    }

    $conn->close();
} else {
    $response['error'] = "Invalid Request: This script only supports POST requests.";
}

echo json_encode($response);
