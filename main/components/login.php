
<?php
include('../../config/connect.php');
if(isset($_POST['submit'])){

    $u_name=$_POST['u_name'];
    $pass=$_POST['pass'];

    $sql="select * from staff";
    $result=mysqli_query($conn,$sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            if($row['Username']==$u_name){
                if ($row['Password']==$pass) {
                    session_start();
                    $_SESSION['Staff_id'] = $row['Staff_id'];
                    echo '<script>alert("LOGIN SUCCESSFULL.....");</script>';
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=Main.php">';
                }else{
                    echo '<script>alert("WRONG PASSWORd !!");</script>';
                  } 
                }else{
                    echo '<script>alert("USER DO NOT EXIST !!!! to Login.. !!!");</script/>';
                  }
            }
        }
    }




  ?>







<div class="bg-blue-200 h-screen pt-10">
<script src="https://cdn.tailwindcss.com"></script>
<div class=" mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
  <div class=" bg-white mx-auto max-w-3xl rounded-md py-10">
    <h1 class="text-center text-4xl font-bold text-black sm:text-4xl">Login</h1>


    <form method="POST" action="login.php" class="mb-0 mt-6 space-y-5 rounded-lg p-4 sm:p-6 lg:p-8">

    <div>
        <div>
            <h1 class="text-xl font-medium mb-3">Email</h1>
        </div>
        
        <div class="relative">
       
          <input type="email" id="u_name" name="u_name" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Enter email" />

          <span class="absolute inset-y-0 end-0 grid place-content-center px-4">

            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
            </svg>
          </span>
        </div>
        </div>

      <div>
        
        <div>
            <h1 class="text-xl font-medium mb-3">Password</h1>
        </div>

        <div class="relative">
        
          <input type="password" id="pass" name="pass" class="w-full border-2 border-black rounded-lg p-4 pe-12 text-sm shadow-sm" placeholder="Enter password"/>

          <span class="absolute inset-y-0 end-0 grid place-content-center px-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="size-4 text-gray-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
              />
            </svg>
          </span>
        </div>
      </div>

      <button type="submit" name="submit" id="submit" class="block w-full font-medium rounded-lg bg-black px-5 py-3 text-sm font-medium text-white hover:bg-white hover:text-black hover:font-medium hover:duration-300 hover:border-2 hover:border-black">
        Login
      </button>

      <p class="text-center text-sm text-gray-500">
        Don't Remember Password ?
        <a class="underline" href="forgot.php">Forgot Password</a>
      </p>
    </form>
  </div>
</div>
</div>