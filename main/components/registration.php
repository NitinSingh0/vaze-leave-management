<?php include("../../config/connect.php"); ?>

<div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
    <h2 class="text-2xl font-medium mb-4 text-center dark:text-black text-black">Staff Registration</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="dark:text-black text-black w-3/4">

        <!--Name-->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter The Name"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>

        <!--Department-->
        <div class="mb-4">
            <label for="department" class="block text-gray-700 font-medium mb-2">Department</label>
            <select id="department" name="department"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="" selected disabled>Select a Department</option>
                <?php
                $query = "SELECT D_id, Name FROM department";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['D_id'] . '">' . $row['Name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!--Designation-->
        <div class="mb-4">
            <label for="designation" class="block text-gray-700 font-medium mb-2">Designation</label>
            <input type="text" id="designation" name="designation" placeholder="Enter Designation"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>

        <!--Date Of Joining-->
        <div class="mb-4">
            <label for="date_of_joining" class="block text-gray-700 font-medium mb-2">Date Of Joining</label>
            <input type="date" id="date_of_joining" name="date_of_joining"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>

        <!--Gender-->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Gender</label>
            <div class="flex flex-wrap -mx-2">
                <div class="px-2 w-1/2 text-lg">
                    <label class="block text-gray-700 font-medium mb-2">
                        <input type="radio" name="gender" value="M" class="mr-2 text-lg size-4">Male
                    </label>
                </div>
                <div class="px-2 w-1/2 text-lg">
                    <label for="color-blue" class="block text-gray-700 font-medium mb-2">
                        <input type="radio" name="gender" value="F" class="mr-2 text-lg size-4">Female
                    </label>
                </div>
            </div>
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter a Username"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required onchange="change(this)">
            <p id="usernameWarning" class="text-red-500 text-sm mt-1 hidden">Username already exists.</p>
        </div>

        <!-- Type-->
        <div class="mb-4">
            <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
            <select id="type" name="type"
                class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="" selected disabled>Select a Type</option>
                <option value="TD">Degree Teacher</option>
                <option value="TJ">Junior Teacher</option>
                <option value="NL">Non-Teaching Laboratory</option>
                <option value="NO">Non-Teaching Office</option>
                <option value="OO">Office Operator</option>
            </select>
        </div>

        <!-- Centered Submit Button -->
        <div class="w-full flex justify-center mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full ">Submit</button>
        </div>

    </form>
</div>

<?php
//error_reporting(0);
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
            echo "<script>alert('Duplicate Entry:User already Exist!');</script>";
        } else {
            // No duplicate, proceed with insertion
            $sql = "INSERT INTO staff ( Name, Designation, DOJ, Staff_type, Username, Gender, Job_role, D_id, status, Password) 
                VALUES ('$name', '$desig ', '$date', '$staff_type', '$username', '$gender', '$type','$department','A', 'NEW')";

            if ($res = $conn->query($sql)) {
                echo "<script>alert('New Staff Added Successfully!');</script>";
                //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=registration.php">';
            } else {
                $error_dates .= "$extra_duty, ";
            }
        }
    }
}
?>