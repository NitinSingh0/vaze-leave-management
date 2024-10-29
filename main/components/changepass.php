<?php
session_start();
//error_reporting(0);

$Staff_id = $_SESSION['Staff_id'];

echo $_SESSION['Staff_id'];
echo "<script>
             alert("
    . $Staff_id . ");
                  </script>
                  ";
$sql = "select * from staff where Staff_id = '$Staff_id'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $pass = $row['Password'];
}
?>

<div class="bg-blue-200 min-h-screen pt-4">
    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="bg-white mx-auto max-w-3xl rounded-md py-10">

            <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">Change Password</h1>

            <form method="POST" action="changepass.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">

                <div>
                    <div>
                        <h1 class="text-xl font-medium mb-3">Enter New Password</h1>
                    </div>

                    <div class="relative">
                        <input type="password" id="Npass" name="Npass" value="<?php echo $pass ?>" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="New Password" required />
                    </div>
                </div>

                <div>
                    <div>
                        <h1 class="text-xl font-medium mb-3">Confirm New Password</h1>
                    </div>

                    <div class="relative">
                        <input type="password" id="Cpass" name="Cpass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Confirm Password" required />
                    </div>
                </div>

                <button type="submit" id="submit" class="block w-full rounded-lg bg-black px-5 py-3 text-sm font-medium text-white bg-slate-500 hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
                    Change Password
                </button>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#submit').click(function(e) {
            var npass = $('#Npass').val();
            var cpass = $('#Cpass').val();

            if (npass !== cpass) {
                e.preventDefault(); // Prevent form submission
                alert('New Password and Confirm Password do not match!');



            } else {
                // Reason Textarea onchange Professor aja
                   
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        cache: false,
                        data: {
                            pId: p_id
                        },
                        success: function(data) {
                            $("#prof_name").html(data);
                        }
                    });
               
            }
        });




    });
</script>