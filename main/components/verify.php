<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $enterotp = $_POST['otp'];

    if (isset($_SESSION['OTP'])) {
        $otpp = $_SESSION['OTP'];

        if ($otpp == $enterotp) {
            unset($_SESSION['OTP']);
            //session_destroy();

            echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=changepass.php">';
        } else {
            echo '<script>alert("WRONG OTP !! Please enter Correct OTP");</script>';
        }
    }
}
?>


<div class="bg-gray-100 min-h-screen pt-4">
    <div class=" mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
        <div class=" bg-white mx-auto max-w-3xl rounded-md py-10">
            <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">OTP</h1>
            <form method="POST" action="verify.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">
                <div>
                    <div>
                        <label for="otp" class="text-xl font-medium mb-3">Enter OTP</label>
                    </div>

                    <div class="relative">

                        <input type="text" id="otp" name="otp" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Enter OTP Here" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" required />

                    </div>

                </div>

                <button type="submit" name="submit" id="submit" class="block w-full font-medium rounded-lg bg-black px-5 py-3 text-sm text-white hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
                    Verify OTP
                </button>
            </form>
        </div>
    </div>
</div>