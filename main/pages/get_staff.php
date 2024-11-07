<?php
$departmentId = $_POST['department_id'];
include('../../config/connect.php');
$query = "SELECT Staff_id, Name FROM staff WHERE D_id = '$departmentId'";
$result = $conn->query($query);

$options = "<option>Select Staff</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['Staff_id']}'>{$row['Name']}</option>";
}

echo $options;
$conn->close();
?>