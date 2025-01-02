<?php
// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true); // Decode JSON into PHP array

// Access the data
$type = $data['type'] ?? null;


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

if ($jobRole == 'NO' && $jobRole == 'NL' && $jobRole == 'OO') {
    $currentYear = date("Y");
    $currentMonth = date("n");
    $a_year = ($currentMonth > 6) ? $currentYear : $currentYear - 1;
} else {
    $a_year = date("Y");
}

// Initialize leave totals and used values
$totalDutyLeave = $usedDutyLeave = 0;


if ($jobRole == 'TD') {

    $totalDutyLeave = fetchTotalLeave($conn, $Staff_id, $type, $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'd_mhm_leave', $Staff_id, $a_year,$type);
} elseif ($jobRole == 'TJ') {

    $totalDutyLeave = fetchTotalLeave($conn, $Staff_id, $type, $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'j_ehm_leave', $Staff_id, $a_year,$type);
} else {

    $totalDutyLeave = fetchTotalLeave($conn, $Staff_id, $type, $a_year);
    $usedDutyLeave = fetchUsedLeave($conn, 'n_emhm_leave', $Staff_id, $a_year,$type);
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

function fetchUsedLeave($conn, $table, $staff_id, $a_year,$type)
{

    // Prepare the query dynamically
    $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND A_year = ? AND Type= ? ");

    if (!$query) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $query->bind_param("iis", $staff_id, $a_year, $type);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['UsedLeaves'] ?? 0; // Return the value or 0 if no data
    } else {
        return 0;
    }
}

/*

Javascript

 const requestData = {
            userId: "12345", // Replace with dynamic data as needed
            otherKey: "value" // Add additional keys as necessary
        };

        // Sending a POST request with JSON data
        const response = await fetch('../components/Pending/cl.php', {
            method: 'POST', // Specify the HTTP method
            headers: {
                'Content-Type': 'application/json', // Indicate JSON payload
            },
            body: JSON.stringify(requestData), // Convert the data to a JSON string
        });

        // Handle the response
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();



PHP Code
// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true); // Decode JSON into PHP array

// Access the data
$userId = $data['userId'] ?? null;
$otherKey = $data['otherKey'] ?? null;

// Your logic here
$response = [
    'duty' => [
        'used' => 2,  // Replace with dynamic data
        'total' => 10 // Replace with dynamic data
    ]
];

// Send a JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
*/
?>