<?php
session_start();
//error_reporting(0);

$Staff_id = $_SESSION['Staff_id'];

//echo $_SESSION['Staff_id'];

    if (isset($_POST['Pass'])) {
      $pass = $_POST['Pass'];
      //echo $pass;
      $hash=password_hash($pass,PASSWORD_DEFAULT);
      $s = "UPDATE Staff set Password='$hash' WHERE Staff_id='$Staff_id'";
      $q = $conn->query($s);
      echo "Password Updated Successfully";
     if ($conn->query($s) === TRUE) {
       echo "Password Updated Successfully";
    } else {
       echo "Error updating password: " . $conn->error;
    }
    }
    ?>