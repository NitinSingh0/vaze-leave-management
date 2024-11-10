
<?php
//error_reporting(0);
include("../../../config/connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && !empty($_POST['department']) && !empty($_POST['designation']) && !empty($_POST['date_of_joining']) && !empty($_POST['gender']) && !empty($_POST['username']) && !empty($_POST['type'])) {
        $name = $_POST["name"];
        $department = $_POST["department"];
        $desig = $_POST["designation"];
        $date = $_POST["date_of_joining"];
        $gender = $_POST["gender"];
        $username = $_POST["username"];
        $type = $_POST["type"];



        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";

        $staff_type = (($type === "TD" || $type === "TJ")) ? "T" : "N";

        // Check for duplicate entry
        $checkSql = "SELECT * FROM staff WHERE  Name = '$name' AND  Designation = '$desig' AND DOJ = '$date' AND Gender='$gender' AND Job_role = '$type' AND D_id = '$department' ";
        $checkResult = $conn->query($checkSql);


        if ($checkResult->num_rows > 0) {
            // Duplicate found
            // echo "<script>alert('Duplicate Entry:User already Exist!');</script>";
            echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry:User already Exist!']);
      
        } else {
            // No duplicate, proceed with insertion
            $sql = "INSERT INTO staff ( Name, Designation, DOJ, Staff_type, Username, Gender, Job_role, D_id, status, Password) 
                VALUES ('$name', '$desig ', '$date', '$staff_type', '$username', '$gender', '$type','$department','A', 'NEW')";

            if ($res = $conn->query($sql)) {
                //echo "<script>alert('New Staff Added Successfully!');</script>";
                //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=registration.php">';
                echo json_encode(['status' => 'success', 'message' => 'New Staff member Added Successfully!']);
   
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add the member !']);
      
            }
        }
    }
}
?>