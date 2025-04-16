<?php
// session_start(); // Uncomment if not already started above
if (isset($_POST['submit'])) {
  $u_name = $_POST['u_name'];
  $pass = $_POST['pass'];
  $sql = "SELECT * FROM staff";
  $result = mysqli_query($conn, $sql);
  $val = 0;

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['Username'] == $u_name) {
        $hashedpass = $row['Password'];

        if ($pass === 'NEW') {
          if (password_verify($pass, $hashedpass)) {
            $_SESSION['Staff_id'] = $row['Staff_id'];
            echo '<script>
              alert("Welcome! Please update your password.");
              window.location.href = "../pages/changepass.php";
            </script>';
            $val = 3;
            break;
          }
        } else {
          if (password_verify($pass, $hashedpass)) {
            $val = 1;
            break;
          } else {
            $val = 2;
            break;
          }
        }
      }
    }

    if ($val == 1) {
      $_SESSION['Staff_id'] = $row['Staff_id'];
      $login_msg = "Login successful! Redirecting...";
      echo '<script>
      //     alert("Login successful! Redirecting...");
           window.location.href = "index.php";
         </script>';
    } elseif ($val == 2) {
      $login_msg = "Incorrect password. Please try again!";
    } elseif ($val == 0) {
      $login_msg = "User does not exist. Please check your email or register.";
    }
  }
}
?>



<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
  <div class="w-full max-w-md px-8 py-10 bg-white shadow-xl rounded-xl border border-blue-200">
    <h1 class="text-3xl font-bold text-center text-blue-900">Vaze Leave Management</h1>
    <p class="text-center text-gray-600 mb-6">Login to your account</p>

    <form method="POST" action="login.php" class="space-y-6">
      <div>
        <label for="u_name" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input type="email" id="u_name" name="u_name" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          placeholder="your@email.com" />
      </div>

      <div>
        <label for="pass" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" id="pass" name="pass" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          placeholder="Enter your password" />
      </div>

      <button type="submit" name="submit"
        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300">
        Login
      </button>

      <p class="text-center text-sm text-gray-500">
        Forgot your password?
        <a href="forgot.php" class="text-blue-700 hover:underline">Reset here</a>
      </p>
    </form>
    <?php if (isset($login_msg)) : ?>
      <div id="alertBox" class="mx-auto max-w-md my-4 rounded-lg border-l-4 border-blue-600 bg-blue-100 px-4 py-3 text-blue-800 shadow-md transition duration-300">
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium"><?= $login_msg ?></span>
          <button onclick="document.getElementById('alertBox').style.display='none'" class="text-blue-800 hover:text-red-600 transition duration-300">
            &times;
          </button>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
<div id="toast" class="fixed top-5 right-5 z-50 hidden max-w-sm rounded-lg px-4 py-3 shadow-lg text-white transition duration-300"></div>