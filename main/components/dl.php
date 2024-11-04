<?php
session_start();
$Staff_id = $_SESSION['Staff_id'];

if (!$Staff_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duty/Special Leave Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include("../../config/connect.php"); ?>
    <div class="flex items-center justify-center p-12">
        <!--Casual Leave Form-->

        <div class="mx-auto w-full max-w-[550px] bg-white">
            <div class=" text-center align-middle text-2xl font-semibold m-5 dark:text-black text-black">Duty/Special Leave Form</div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="dark:text-black">

                <div class="-mx-3 flex flex-wrap">
                    <!--Academic year -->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Academic Year <span class=" font-semibold text-red-600 text-2xl">*</span>
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
                    </div>

                    <!--Type-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Type:<span class=" font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <select required name="type" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option selected disabled value="">Select Type Of Leave</option>
                                <option value="SL"> Specia Leave</option>
                                <option value="DL"> Duty Leave</option>

                            </select>


                        </div>
                    </div>
                </div>


                <div class="-mx-3 flex flex-wrap">
                    <!--Application date-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Application Date <span class=" font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <input
                                required
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
                                Department <span class=" font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <select required name="department" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <?php
                                $query = "SELECT D_id,Name FROM department where D_id=(select D_id from staff where Staff_id=$Staff_id)";
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

                <div class="-mx-3 flex flex-wrap">

                    <!-- Reference No.-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Reference No.
                            </label>
                            <input name="reference_no" type="number" oninput="toggleDateField()" id="reference_number"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>

                    <!--Date of Letter-->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Date Of Letter
                            </label>
                            <input name="date_of_letter" type="date" id="date_of_letter" disabled
                                class=" disabled:opacity-40 disabled:border-gray-400 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                </div>




                <div class="-mx-3 flex flex-wrap">
                    <!-- From DATE -->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                From-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <input name="from_date" id="from_date" required type="date"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                onchange="setMinToDate()" min="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>

                    <!-- To DATE -->
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                To-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <input name="to_date" id="to_date" required type="date"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                onchange="calculateDays()" />
                        </div>
                    </div>
                </div>

                <!-- No Of Days -->
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                        No. Of Days
                    </label>
                    <input type="text" id="no_of_days" disabled
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>

                <!--On Account Of-->
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                        Nature Of Duty Assigned: <span class=" font-semibold text-red-600 text-2xl">*</span>
                    </label>
                    <textarea name="reason" required placeholder="Nature Of Duty"
                        class="w-full  rounded-md border border-[#e0e0e0] bg-white py-6 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                </div>




                <div>
                    <Input type="submit" value="Apply" name="submit"
                        class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800"
                        Apply />
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDateField() {
            const referenceNumber = document.getElementById('reference_number').value;
            const dateOfLetter = document.getElementById('date_of_letter');

            // Enable date field if reference number is provided, otherwise disable it
            dateOfLetter.disabled = referenceNumber === '';

            // Make the date field required if reference number is provided
            dateOfLetter.required = referenceNumber !== '';
        }

        function setMinToDate() {
            const fromDate = document.getElementById("from_date").value;
            document.getElementById("to_date").min = fromDate;
            calculateDays();
        }

        function calculateDays() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date").value;

            if (fromDate && toDate) {
                const from = new Date(fromDate);
                const to = new Date(toDate);
                const timeDiff = to - from;
                const daysDiff = timeDiff / (1000 * 60 * 60 * 24) + 1; // Adding 1 to include the start date

                document.getElementById("no_of_days").value = daysDiff > 0 ? daysDiff : 0;
            } else {
                document.getElementById("no_of_days").value = "";
            }
        }
    </script>
</body>

</html>
<?php
//error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['year']) && !empty($_POST['application_date']) && !empty($_POST['department']) && !empty($_POST['from_date']) && !empty($_POST['to_date']) && !empty($_POST['reason'])) {
        $year = $_POST["year"];
        $application_date = $_POST["application_date"];
        $department = $_POST["department"];
        $from_date = $_POST["from_date"];
        $to_date = $_POST["to_date"];
        $reason = $_POST["reason"];
        $ref_no = isset($_POST["reference_no"]) ? $_POST["reference_no"] : null;
        $date_of_letter = isset($_POST["date_of_letter"]) ? $_POST["date_of_letter"] : null;
        $leave_type = $_POST["type"];


        $start = new DateTime($from_date);
        $end = new DateTime($to_date);

        // Calculate the difference
        $interval = $start->diff($end);

        // Get the number of days
        $days = ($interval->days) + 1;

        // echo "Number of days: " . $days;


        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";
        $staff_id = $Staff_id;
        $type = "TD";

        if ($type == 'TD') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM d_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO d_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=dl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        } elseif ($type == 'TJ') {

            // Check for duplicate entry
            $checkSql = "SELECT * FROM j_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO j_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=dl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        } elseif ($type == 'NL' || $type == 'NO' || $type == 'OO') {

            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_dl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_dl_leave (Staff_id, From_date, To_date, No_of_days, Nature, Reference_no, Date_of_letter, Date_of_application, leave_approval_status, A_year, Type) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$ref_no' , '$date_of_letter' , '$application_date', 'P', $year, '$leave_type')";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=dl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        }
    }
}


?>