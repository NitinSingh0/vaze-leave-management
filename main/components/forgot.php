<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$msg = "";
$color = "";

if (isset($_POST['submit'])) {
  $email = $_POST['u_name'];

  $sql = "SELECT * FROM staff WHERE Username='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $otp = rand(1000, 9999);
    $_SESSION['OTP'] = $otp;
    $_SESSION['email'] = $email;

    require('Exception.php');
    require('PHPMailer.php');
    require('SMTP.php');

    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'odhadam0@gmail.com';
      $mail->Password   = 'oyzcgfwumrbyuhct';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port       = 465;

      $mail->setFrom('odhadam0@gmail.com', 'Omkar Dhadam');
      $mail->addAddress($email, 'Mail For Forgot Password');

      $mail->isHTML(true);
      $mail->Subject = 'Mail for Forget Password';
      $mail->Body = '
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
      color: #4d4d4d;
    }
    .email-container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      border: 1px solid #ddd;
    }
    .email-header {
      background-color: #0056b3;
      color: #ffffff;
      padding: 20px;
      text-align: center;
    }
    .email-header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }
    .email-body {
      padding: 20px;
      font-size: 16px;
      line-height: 1.6;
      color: #333333;
    }
    .email-body p {
      margin: 10px 0;
      color: #5a5a5a;
    }
    .otp-box {
      margin: 20px 0;
      padding: 15px;
      background-color: #e3f2fd;
      color: #007bff;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-radius: 5px;
      letter-spacing: 1.2px;
    }
    .email-footer {
      background-color: #f1f3f5;
      padding: 15px;
      text-align: center;
      font-size: 14px;
      color: #6c757d;
      border-top: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <h1>Vaze Leave Management System</h1>
    </div>
    <div class="email-body">
      <p>Dear User,</p>
      <p>You have requested to reset your password on the <strong style="color: #0056b3;">Vaze Leave Management System</strong>. Please use the OTP below to complete the process:</p>
      <div class="otp-box">' . $otp . '</div>
      <p style="color: #6c757d;">If you did not make this request, please ignore this email. Your account remains secure.</p>
      <p>Best Regards,<br><strong style="color: #0056b3;">The Vaze College Leave Management Team</strong></p>
    </div>
    <div class="email-footer">
      <p>&copy; ' . date("Y") . ' V.G. Vaze College | All Rights Reserved.</p>
    </div>
  </div>
</body>
</html>
';



      $mail->send();

      $msg = "OTP sent successfully to your email!";
      $color = "green";
      echo "<script>setTimeout(() => window.location.href='verify.php', 1500);</script>";
    } catch (Exception $e) {
      $msg = "Failed to send email. Please try again.";
      $color = "red";
    }
  } else {
    $msg = "No account found with that email address.";
    $color = "red";
  }
}
?>

<!-- 🎨 Toast Message Section -->
<?php if (!empty($msg)): ?>
  <div id="toast-msg" class="fixed top-5 right-5 z-50 bg-<?= $color ?>-100 text-<?= $color ?>-800 px-6 py-4 rounded-lg shadow-lg border-l-4 border-<?= $color ?>-500 animate-fadeIn">
    <?= $msg ?>
  </div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-msg');
      if (toast) toast.remove();
    }, 3000);
  </script>
<?php endif; ?>


<!-- 🌌 Forgot Password Page -->
<div class="bg-gradient-to-br from-purple-100 via-blue-50 to-white min-h-screen pt-4">
  <div class="max-w-screen-sm mx-auto px-4 py-16">
    <div class="bg-white rounded-xl shadow-lg p-10">
      <h1 class="text-4xl font-bold text-center text-black mb-4">Forgot Password</h1>
      <p class="text-center text-gray-500 mb-8">Enter your registered email to receive an OTP.</p>

      <form method="POST" action="forgot.php" class="space-y-6">
        <div>
          <label for="u_name" class="block text-lg font-semibold mb-2">Email</label>
          <div class="relative">
            <input type="email" id="u_name" name="u_name" required
              class="w-full border border-gray-300 rounded-md px-4 py-3 pr-12 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200"
              placeholder="you@example.com" />
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </span>
          </div>
        </div>

        <button type="submit" name="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition duration-200">
          Send OTP
        </button>
      </form>
    </div>
  </div>
</div>

<!--  Fade In Animation for Toast -->
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
  }
</style>