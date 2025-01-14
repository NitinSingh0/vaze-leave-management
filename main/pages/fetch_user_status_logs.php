<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../../config/connect.php');

// Check database connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$filter_username = isset($_GET['username']) ? trim($_GET['username']) : '';

// Construct query
$query = "SELECT usl.id, u.Name AS staff_name, a.Name AS action_by, usl.action, usl.timestamp 
          FROM user_status_logs usl 
          JOIN staff u ON usl.staff_id = u.Staff_id 
          JOIN staff a ON usl.action_performed_by = a.Staff_id";

if ($filter_username !== '') {
    $query .= " WHERE u.Name LIKE ?";
}

$query .= " ORDER BY usl.timestamp DESC";

// Debugging (optional: uncomment for debugging only)
// var_dump($query);

$stmt = $conn->prepare($query);

if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}

// Bind parameters if a filter is provided
if ($filter_username !== '') {
    $search_username = '%' . $filter_username . '%';
    $stmt->bind_param('s', $search_username);
}

// Execute statement
if (!$stmt->execute()) {
    die('Execute failed: ' . $stmt->error);
}

// Fetch results
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($data);

$stmt->close();
$conn->close();
