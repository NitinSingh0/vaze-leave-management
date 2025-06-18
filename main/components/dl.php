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
        <div class=" text-center align-middle text-2xl font-semibold m-5 dark:text-black text-black">Duty/Special Leave Form</div>
        <form id="yourFormID">

            <div class="-mx-3 flex">
                <!--Academic year -->
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label class="mb-3 block text-base font-medium text-[#07074D]">
                            Academic Year <span class=" font-semibold text-red-600 text-2xl">*</span>
                        </label>
                        <select name="year" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                            <option value="" disabled>Select Year</option>
                            <?php
                            // $currentMonth = date('n'); // Get the current month (1-12)
                            // $currentYear = date('Y');  // Get the current year

                            // // Determine academic year based on the month
                            // if ($currentMonth >= 6) { // From June onwards, current academic year starts with this year
                            //     $startYear = $currentYear;
                            // } else { // Before June, current academic year starts with last year
                            //     $startYear = $currentYear - 1;
                            // }

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


            <div class="-mx-3 flex ">
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

            <div class="-mx-3 flex">

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




            <div class="-mx-3 flex ">
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
                            onchange="calculateDays()"/>
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




            <div class="bg-slate-600 rounded-lg">
                <input type="submit" value="Apply" name="submit" onclick="d1()"
                    class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800" />
            </div>

        </form>
    </div>
</div>



<script>
   
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