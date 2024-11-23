<?php
// Include the database connection file
include('../../../config/connect.php');

if (isset($_POST['type']) && !empty($_POST['type'])) {
    $type = $_POST['type'];

    if ($type === 'TD') {
        $query = "SELECT D_id,Name FROM department where College='D' AND Name != 'Office_Labratory'";
    } elseif ($type === 'TJ') {
        $query = "SELECT D_id,Name FROM department where College='J'";
    } else {
        $query = "SELECT D_id,Name FROM department where Name = 'Office_Labratory'";
    }
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            echo '<option  value="' . $row['D_id'] . '" selected>' . $row['Name'] . '</option>';
        } else {
            echo '<option  value="" selected disabled > Select a Department</option>';

            while ($row = $result->fetch_assoc()) {
                echo '<option  value="' . $row['D_id'] . '">' . $row['Name'] . '</option>';
            }
        }
    } else {
        echo '<option  value="" selected disabled >No Department Available</option>';
    }
}
