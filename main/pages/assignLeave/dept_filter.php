
<?php
// Include the database connection file
include('../../../config/connect.php');

if (isset($_POST['type']) && !empty($_POST['type'])) {
    $type = $_POST['type'];

    $query = "SELECT D_id,Name FROM department where College='$type' AND Name !='office_lab'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '<option  value="" selected disabled > Select a Department</option>';

        while ($row = $result->fetch_assoc()) {
            echo '<option  value="' . $row['D_id'] . '">' . $row['Name'] . '</option>';
        }
    } else {
        echo '<option  value="" selected disabled >No Department Available</option>';
    }
}
