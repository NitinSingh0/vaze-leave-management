<?php include("../../config/connect.php"); ?>
<?php
session_start();
$Staff_id = $_SESSION['Staff_id'];

if (!$Staff_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}

$sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $jobRole = $row['Job_role'];
}
?>


<?php include("../../library/library.php"); ?>

<div class="flex items-center justify-center p-12">
    <!--Casual Leave Form-->

    <div class="mx-auto w-full max-w-[550px] bg-white">
        <div class=" text-center align-middle text-2xl font-semibold m-5 text-black">Casual Leave Form</div>
        <form id="yourFormID2">

            <!--Acedamic year-->
            <div class="mb-5">
                <label class="mb-3 block text-base font-medium text-[#07074D]">
                    Academic Year
                </label>
                <select name="year" id="year3" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option value="" disabled>Select Year</option>
                    <?php
                    $startMonth = date('n'); // Get the current month (1-12)
                    $startYear= date('Y');  // Get the current year

//If Non Teaching Then No year Change Else the 1 june - 31may Condition

                 if ($jobRole != "OO" && $jobRole != "NL" && $jobRole != "NO") {
                        // Determine academic year based on the month
                        if ($startMonth >= 6) { // From June onwards, current academic year starts with this year
                            $startYear = $startYear;
                        } else { // Before June, current academic year starts with last year
                            $startYear = $startYear - 1;
                          
                        }

                     }
                   

                    // Display the options
                    echo '<option selected value="' . $startYear . $ok. '">' . $startYear . ' - ' . ($startYear + 1) . '</option>';
                    echo '<option value="' . ($startYear + 1) . '">' . ($startYear + 1) . ' - ' . ($startYear + 2) . '</option>';

                    // echo '<option selected value="' . (date('Y')) . '">' . date('Y') . ' - ' . (date('Y') + 1) . '</option>';
                    // echo '<option  value="' . (date('Y') + 1) . '">' . date('Y') + 1 . ' - ' . (date('Y') + 2) . '</option>';

                    ?>
                </select>

            </div>


            <div class="-mx-3 flex ">
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

            <div class="-mx-3 flex ">
                <!-- From DATE -->
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label class="mb-3 block text-base font-medium text-[#07074D]">
                            From-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                        </label>
                        <input name="from_date" id="from_date" required type="date"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            onchange="setMinToDate2()" min="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>

                <!-- To DATE -->
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label class="mb-3 block text-base font-medium text-[#07074D]">
                            To-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                        </label>
                        <input disabled name="to_date" id="to_date" required type="date"
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
                    On Account Of:<span class=" font-semibold text-red-600 text-2xl">*</span>
                </label>
                <textarea name="reason" required placeholder="Reason For Leave"
                    class="w-full  rounded-md border border-[#e0e0e0] bg-white py-6 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
            </div>




            <div class="bg-slate-600 rounded-lg">
                <Input type="submit" value="Apply" name="submit" id="submit2" onclick="c1()"
                    class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800"
                    Apply />
            </div>
        </form>
    </div>
</div>
<script>
    function setMinToDate2() {
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

<?php
/*
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['year']) && !empty($_POST['application_date']) && !empty($_POST['department']) && !empty($_POST['from_date']) && !empty($_POST['to_date']) && !empty($_POST['reason'])) {
        $year = $_POST["year"];
        $application_date = $_POST["application_date"];
        $department = $_POST["department"];
        $from_date = $_POST["from_date"];
        $to_date = $_POST["to_date"];
        $reason = $_POST["reason"];



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
        $type = $jobRole;

        if ($type == 'TD') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM d_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO d_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        } elseif ($type == 'TJ') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM j_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO j_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        } elseif ($type == 'NL' || $type == 'NO' || $type == 'OO') {
            // Check for duplicate entry
            $checkSql = "SELECT * FROM n_cl_leave WHERE Staff_id = '$staff_id' AND From_date = '$from_date' AND To_date = '$to_date'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                echo "<script>alert('Duplicate Entry: Casual Leave has already been applied for these dates!');</script>";
            } else {
                // No duplicate, proceed with insertion
                $sql = "INSERT INTO n_cl_leave (Staff_id, From_date, To_date, No_of_days, Reason, Date_of_application, leave_approval_status, A_year) 
                VALUES ('$staff_id', '$from_date', '$to_date', '$days', '$reason', '$application_date', 'P', $year)";

                if ($res = $conn->query($sql)) {
                    echo "<script>alert('Casual Leave Applied Successfully!');</script>";
                    echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=cl.php">';
                } else {
                    echo "<script>alert('ERROR!!');</script>";
                }
            }
        }
    }
}
    */
?>








































<!--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-select Date Field</title>
    <script src="https://cdn.tailwindcss.com"></scrip>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Select Dates</h2>
        <div id="datePickerContainer" class="mb-4">
            <div id="selectedDates" class="flex flex-wrap gap-2 mb-2"></div>
            <input type="text" id="dateInput" placeholder="Click to select dates" readonly
                class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
        </div>
        <div id="calendar" class="grid grid-cols-7 gap-1"></div>

    </div>
        <input type="submit" value="submit2" >
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('dateInput');
            const calendar = document.getElementById('calendar');
            const selectedDatesContainer = document.getElementById('selectedDates');
            let currentDate = new Date();
            let selectedDates = [];

            function generateCalendar(year, month) {
                calendar.innerHTML = '';
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const firstDay = new Date(year, month, 1).getDay();

                // Add day names
                const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                dayNames.forEach(day => {
                    const dayNameElement = document.createElement('div');
                    dayNameElement.textContent = day;
                    dayNameElement.className = 'text-center font-bold text-gray-500';
                    calendar.appendChild(dayNameElement);
                });

                // Add empty cells for days before the 1st
                for (let i = 0; i < firstDay; i++) {
                    calendar.appendChild(document.createElement('div'));
                }

                // Add date cells
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateCell = document.createElement('div');
                    dateCell.textContent = day;
                    dateCell.className = 'text-center p-2 cursor-pointer hover:bg-blue-100 rounded-full';

                    const cellDate = new Date(year, month, day);
                    if (isDateSelected(cellDate)) {
                        dateCell.classList.add('bg-blue-500', 'text-white');
                    }

                    dateCell.addEventListener('click', () => toggleDateSelection(cellDate));
                    calendar.appendChild(dateCell);
                }
            }

            function toggleDateSelection(date) {
                const index = selectedDates.findIndex(d => d.toDateString() === date.toDateString());
                if (index > -1) {
                    selectedDates.splice(index, 1);
                } else {
                    selectedDates.push(date);
                }
                updateSelectedDatesDisplay();
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            }

            function isDateSelected(date) {
                return selectedDates.some(d => d.toDateString() === date.toDateString());
            }

            function updateSelectedDatesDisplay() {
                selectedDatesContainer.innerHTML = '';
                selectedDates.forEach(date => {
                    const dateTag = document.createElement('span');
                    dateTag.textContent = date.toLocaleDateString();
                    dateTag.className = 'bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded';
                    selectedDatesContainer.appendChild(dateTag);
                });
            }

            dateInput.addEventListener('click', () => {
                calendar.classList.toggle('hidden');
            });

            // Initialize calendar
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });
    </script>
</body>

</html>
-->