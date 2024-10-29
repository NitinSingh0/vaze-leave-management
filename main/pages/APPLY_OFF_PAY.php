<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Off Pay Leave Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include("../../config/connect.php"); ?>
    <div class="flex items-center justify-center p-12">
        <!--Casual Leave Form-->

        <div class="mx-auto w-full max-w-[550px] bg-white">
            <div class=" text-center align-middle text-2xl font-semibold m-5">Off Pay Leave Form</div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <!--Acedamic year-->
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                        Academic Year
                    </label>
                    <select name="year" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="" disabled>Select Year</option>
                        <?php
                        $currentMonth = date('n'); // Get the current month (1-12)
                        $currentYear = date('Y');  // Get the current year

                        // Determine academic year based on the month
                        if ($currentMonth >= 6) { // From June onwards, current academic year starts with this year
                            $startYear = $currentYear;
                        } else { // Before June, current academic year starts with last year
                            $startYear = $currentYear - 1;
                        }

                        // Display the options
                        echo '<option selected value="' . $startYear . '">' . $startYear . ' - ' . ($startYear + 1) . '</option>';
                        echo '<option value="' . ($startYear + 1) . '">' . ($startYear + 1) . ' - ' . ($startYear + 2) . '</option>';

                        // echo '<option selected value="' . (date('Y')) . '">' . date('Y') . ' - ' . (date('Y') + 1) . '</option>';
                        // echo '<option  value="' . (date('Y') + 1) . '">' . date('Y') + 1 . ' - ' . (date('Y') + 2) . '</option>';

                        ?>
                    </select>

                </div>


                <div class="-mx-3 flex flex-wrap">
                    <!--Application date-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Application Date
                            </label>
                            <input
                                name="application_date"
                                type="date"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                value="<?php echo date('Y-m-d'); ?>"
                                readonly />
                        </div>

                    </div>

                    <!--Department-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Department
                            </label>
                            <select name="department" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <?php
                                $query = "SELECT D_id,Name FROM department where D_id=(select D_id from staff where Staff_id=1)";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    if ($row = $result->fetch_assoc()) {
                                        echo '<option selected readonly value="' . $row['D_id'] . '">' . $row['Name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                </div>



                <!-- No Of Days -->
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                        No. Of Days
                    </label>
                    <input type="number" name="no_of_days" id="no_of_days" required
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        onchange="generateDutyTable()"
                        placeholder="Select No. Of Days" />
                </div>

                <!-- Dynamic Duty Table -->
                <div id="dutyTableContainer" class="mb-5" style="display: none;">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">Duty Details</label>
                    <table id="dutyTable" class="w-full border border-[#e0e0e0]">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Date of Duty</th>
                                <th class="border px-4 py-2">Nature of Work</th>
                                <th class="border px-4 py-2">Off Pay Date</th> <!-- New column for Off Duty Date -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>





                <!-- <div id="from_to_date">

                </div> -->
                <div id="submit123">

                </div>
            </form>
        </div>
    </div>
    <script>
        function generateDutyTable() {
            const noOfDays = document.getElementById("no_of_days").value;
            const dutyTableContainer = document.getElementById("dutyTableContainer");
            const dutyTableBody = document.getElementById("dutyTable").querySelector("tbody");

            // Clear existing rows
            dutyTableBody.innerHTML = "";

            if (noOfDays > 0) {
                // Show the table container
                dutyTableContainer.style.display = "block";

                for (let i = 0; i < noOfDays; i++) {
                    // Create a new row
                    const row = document.createElement("tr");

                    // Date of Duty input cell
                    const dateCell = document.createElement("td");
                    const dateInput = document.createElement("input");
                    dateInput.type = "date";
                    dateInput.name = `date_of_duty_${i + 1}`;
                    dateInput.required = true;
                    dateInput.className = "w-full border border-[#e0e0e0] py-2 px-3";
                    dateCell.appendChild(dateInput);
                    row.appendChild(dateCell);

                    // Nature of Work input cell
                    const workCell = document.createElement("td");
                    const workInput = document.createElement("input");
                    workInput.type = "text";
                    workInput.name = `nature_of_work_${i + 1}`;
                    workInput.required = true;
                    workInput.className = "w-full border border-[#e0e0e0] py-2 px-3";
                    workCell.appendChild(workInput);
                    row.appendChild(workCell);

                    // Off Duty Date input cell
                    const offDutyCell = document.createElement("td");
                    const offDutyInput = document.createElement("input");
                    offDutyInput.type = "date";
                    offDutyInput.name = `off_pay_date_${i + 1}`;
                    offDutyInput.required = true;
                    offDutyInput.className = "w-full border border-[#e0e0e0] py-2 px-3";
                    // // Get today's date
                    // const today = new Date();

                    // // Add one day to the current date
                    // const tomorrow = new Date(today);
                    // tomorrow.setDate(today.getDate() + 1);

                    // // Format the date as 'YYYY-MM-DD'
                    // const minDate = tomorrow.toISOString().split('T')[0];

                    // // Set the min attribute for your date input
                    // offDutyInput.min = minDate;

                    const today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
                    offDutyInput.min = today;
                    offDutyCell.appendChild(offDutyInput);
                    row.appendChild(offDutyCell);

                    // Append the row to the table body
                    dutyTableBody.appendChild(row);
                }

                document.getElementById("submit123").innerHTML = `
    <input type="submit" value="Apply" name="submit"
           class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800" />
`;
            } else {
                // Hide the table if no days are specified
                dutyTableContainer.style.display = "none";
            }
        }
    </script>
</body>

</html>
<?php
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['year']) && !empty($_POST['application_date']) && !empty($_POST['department']) && !empty($_POST['no_of_days'])) {
        $year = $_POST["year"];
        $application_date = $_POST["application_date"];
        $department = $_POST["department"];

        $staff_id = 1;
        $type = "NO";


        // Assuming 'no_of_days' is the input for number of days, we retrieve it
        $no_of_days = $_POST['no_of_days'];

        // Initialize an array to store date and work data
        $duty_data = [];

        for ($i = 1; $i <= $no_of_days; $i++) {
            // Access each date and work input based on the naming pattern
            $date_key = "date_of_duty_$i";
            $work_key = "nature_of_work_$i";
            $off_key = "off_pay_date_$i";

            // Check if both inputs are set before accessing them
            if (isset($_POST[$date_key]) && isset($_POST[$work_key]) && isset($_POST[$off_key])) {
                $duty_data[] = [
                    'date_of_duty' => $_POST[$date_key],
                    'nature_of_work' => $_POST[$work_key],
                    'off_pay_date' => $_POST[$off_key]
                ];
            }
        }

        // Process or display duty_data as needed
        // foreach ($duty_data as $duty) {
        //     //     echo "Date of Duty: " . $duty['date_of_duty'] . "<br>";
        //     //     echo "Date of Duty: " . $duty['off_pay_date'] . "<br>";
        //     //     echo "Nature of Work: " . $duty['nature_of_work'] . "<br><br>";
        // }


        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";

        //flag
        $success_export_duty = "";
        $success_off_date="";
        $error_dates = "";

        foreach ($duty_data as $duty) {
            $extra_duty = $duty['date_of_duty'];
            $off_date = $duty['off_pay_date'];
            $nature = $duty['nature_of_work'];

            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_off_pay_leave WHERE Staff_id = '$staff_id' AND Extra_Duty_date = '$extra_duty'";
            $checkResult = $conn->query($checkSql);


            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry:Off Pay Leave has already been applied for $extra_duty!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_off_pay_leave (Staff_id, Date_of_application, Extra_duty_date, Nature_of_work, Off_leave_date, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$application_date ', '$extra_duty', '$nature', '$off_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    $success_export_duty .= "$extra_duty, ";
                    $success_off_date .= "$off_date, ";
                    // echo "<script>alert('Off Pay Leave Applied Successfully!');</script>";
                    // echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_OFF_PAY.php">';
                } else {
                    $error_dates .= "$extra_duty, ";
                }
            }

           
        }

        // Trim trailing commas and spaces from dates
        $success_export_duty = rtrim($success_export_duty, ', ');
        $success_off_date = rtrim($success_off_date, ', ');
        $error_dates = rtrim($error_dates, ', ');

        // Display the combined alert message
       
        if (!empty($error_dates)) {
            $message .= "\nFailed to apply Off Pay Leave for dates: $error_dates.";
            echo "<script>alert('$message');</script>";
            
        }elseif(!empty($success_off_date)){

            $message = "Off Pay Leave applied successfully for dates: $success_off_date.";
            echo "<script>alert('$message');</script>";
       
        }

      


    }
}
?>

