<?php 
error_reporting(0);
session_start();
$Staff_id = $_SESSION['Staff_id'];
echo $_SESSION['Staff_id'];
$sql = "select * from staff where Staff_id = '$Staff_id'";
$result = $conn->query($sql);
if($result){
$row = $result->fetch_assoc();
$pass = $row['Password'];
}
?>

<div class="bg-blue-200 min-h-screen pt-4">
<div class=" mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
  <div class=" bg-white mx-auto max-w-3xl rounded-md py-10">

    <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">Change Password</h1>

    <form method="POST" action="changepass.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">

    <div>
        <div>
            <h1 class="text-xl font-medium mb-3">Enter New Password</h1>
        </div>
        
        <div class="relative">
          <input type="text" id="Npass" name="Npass" value="<?php echo $pass ?>" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="New Password" />
        </div>

    </div>

    <div>
        <div>
            <h1 class="text-xl font-medium mb-3">Confirm New Password</h1>
        </div>
        
        <div class="relative">
          <input type="text" id="Cpass" name="Cpass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Confirm Password" />
        </div>

    </div>
    <button type="submit" name="submit" id="submit" class="block w-full font-medium rounded-lg bg-black px-5 py-3 text-sm font-medium text-white hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
        Change Password
    </button>

    </form>
  </div>
</div>
</div>




<script>
$(document).ready(function(){
    $('#submit').click(function(){
        var Npass = $('#Npass').val();
        var Cpass = $('#Cpass').val();
        if(Npass==Cpass){
            <?php 
            if(isset($_POST['submit'])){
            $Npass = $_POST['Npass'];

            $hashpass= password_hash($Npass,PASSWORD_DEFAULT);
    
            $sql = "update staff set Password ='$hashpass' where Staff_id='$Staff_id'";
            $result = $conn->query($sql);
            if ($result) {
            echo "<script> alert('Password Updated Successfully'); </script>";
            header("refresh:0.5; url=login.php");
            } else {
            echo "<script> alert('Password NOT Updated !!!!!'); </script>";
            }
        } 
        
        ?>
    
        }else{
            alert('New Password And Confirm Password is Not Same !!!!!');
            header("refresh:0.5; url=changepass.php"); 
        }
        
    });
});

</script>

