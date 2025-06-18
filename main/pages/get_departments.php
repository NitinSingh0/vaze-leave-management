<?php
$college = $_POST['college'];


include('../../config/connect.php');


$query = "SELECT D_id, Name FROM department WHERE College = '$college'";
$result = $conn->query($query);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['D_id']}'>{$row['Name']}</option>";
}

echo $options;
$conn->close();
?>