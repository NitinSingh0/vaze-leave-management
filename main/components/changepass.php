<?php
//session_start();
error_reporting(0);

$Staff_id = $_SESSION['Staff_id'];
$email = $_SESSION['email']; // Check if email is set in session

if (!$Staff_id && !$email) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}

// Database connection
include('../../config/connect.php');

if ($Staff_id) {
    // Fetch the existing password for the staff (when Staff_id is set)
    $sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $current_password_hash = $row['Password'];
    }
}
?>

<div class="bg-gray-100 min-h-screen pt-4">
    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="bg-white mx-auto max-w-3xl rounded-md py-10">

            <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">Change Password</h1>

            <form method="POST" action="changepass.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">

                <?php if (!$email): ?>
                    <!-- Old Password Field (Only if email is not set) -->
                    <div>
                        <h1 class="text-xl font-medium mb-3">Enter Old Password</h1>
                        <input type="password" id="OldPass" name="OldPass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Old Password" required />
                    </div>
                <?php endif; ?>

                <!-- New Password Field -->
                <div>
                    <h1 class="text-xl font-medium mb-3">Enter New Password</h1>
                    <input type="password" id="Npass" name="Npass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="New Password" required />
                </div>

                <!-- Confirm New Password Field -->
                <div>
                    <h1 class="text-xl font-medium mb-3">Confirm New Password</h1>
                    <input type="password" id="Cpass" name="Cpass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Confirm Password" required />
                </div>

                <button type="submit" id="submit" class="block w-full rounded-lg bg-black px-5 py-3 text-sm font-medium text-white bg-slate-500 hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
                    Change Password
                </button>
            </form>

            <!-- Alert Box -->
            <div id="alertBox" class="hidden fixed top-5 right-5 p-4 rounded-md shadow-lg transition-opacity duration-500 ease-in-out">edewdewdewd</div>
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
                e.preventDefault();
                showAlert('New Password and Confirm Password do not match!', 'red');
            }
        });
    });

    function showAlert(message, color) {
        $('#alertBox').removeClass('hidden').addClass(`bg-${color}-500 text-white`).text(message).fadeIn();

        setTimeout(function() {
            $('#alertBox').fadeOut('slow', function() {
                $(this).addClass('hidden').removeClass(`bg-${color}-500 text-white`).text('');
            });
        }, 3000); // Adjust the duration as needed
    }
</script>

<?php
// Handling password update on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['OldPass'] ?? null;
    $new_password = $_POST['Npass'];
    $confirm_password = $_POST['Cpass'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        if ($email) {
            // Update directly using email (if email is set in session)
            $sql = "UPDATE staff SET Password = '$hashed_password' WHERE Username = '$email'";
        } else {
            // Verify old password and update using Staff_id
            if (password_verify($old_password, $current_password_hash)) {
                $sql = "UPDATE staff SET Password = '$hashed_password' WHERE Staff_id = '$Staff_id'";
            } else {
                echo "<script>showAlert('Incorrect Old Password.', 'red');</script>";
                exit;
            }
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    showAlert('Password Updated Successfully', 'green');
                    setTimeout(function() {
                        window.location.href = '../pages/index.php';
                    }, 2000);
                  </script>";
        } else {
            echo "<script>showAlert('Error updating password: " . $conn->error . "', 'red');</script>";
        }
    } else {
        echo "<script>showAlert('New Password and Confirm Password do not match.', 'red');</script>";
    }
}
?>