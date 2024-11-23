<div class="bg-gray-100 min-h-screen pt-4">
  <div class=" mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
    <div class=" bg-white mx-auto max-w-3xl rounded-md py-10">
      <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">Forgot Password</h1>
      <form method="POST" action="forgot.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">

        <div>
          <div>
            <h1 class="text-xl font-medium mb-3">Email</h1>
          </div>

          <div class="relative">

            <input type="email" id="u_name" name="u_name" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Enter email" />

            <span class="absolute inset-y-0 end-0 grid place-content-center px-4">

              <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </span>
          </div>
        </div>

        <button type="submit" name="submit" id="submit" class="block w-full font-medium rounded-lg bg-black px-5 py-3 text-sm text-white hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
          Send OTP
        </button>

      </form>
    </div>
  </div>
</div>


<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



if (isset($_POST['submit'])) {

  $email = $_POST['u_name'];

  $sql = "select * from staff";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['Username'] == $email) {

        $otp = rand(1000, 9999);

        session_start();
        $_SESSION['OTP'] = $otp;

        require('Exception.php');
        require('PHPMailer.php');
        require('SMTP.php');


        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
          //Server settings
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = 'odhadam0@gmail.com';                     //SMTP username
          $mail->Password   = 'oyzcgfwumrbyuhct';                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

          //Recipients
          $mail->setFrom('odhadam0@gmail.com', 'OmkarDhadam');
          $mail->addAddress($email, 'Mail For Forget Password');     //Add a recipient


          //Attachments
          // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Mail for Forget Password';
          $mail->Body    = "To reset password Your OTP :- $otp";


          $mail->send();

          echo '<script>alert("Mail Sent Successfully.....");</script>';
          echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=verify.php">';
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        echo '<script>alert("Email not EXISTS !!!");</script>';
      }
    }
  }
}














?>