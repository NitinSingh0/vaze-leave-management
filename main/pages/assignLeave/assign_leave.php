<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Leave</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include('../../../library/library.php'); ?>

</head>

<body class="bg-gray-100">

    <?php include("../../../config/connect.php"); ?>
    <?php include('../../layouts/header.php'); ?>

    <div class="mt-11 flex h-screen">
        <!-- Sidebar -->
        <?php include('../../layouts/sidebar.php');
        ?>
         <main class=" bg-gray-100 min-h-screen flex flex-col items-center p-6 ml-[20vw]">
            <div class=" bg-white border rounded-lg px-8 py-6 mx-auto my-8 max-w-4xl ">
                <h1 class="text-2xl font-bold text-center mb-6">Assign Leave</h1>

                <!-- Tabs -->
                <div class="flex border-b">
                    <button id="teaching-tab" class="px-4 py-2 text-blue-500 font-semibold focus:outline-none border-b-2 border-blue-500">Teaching</button>
                    <button id="nonteaching-tab" class="px-4 py-2 text-gray-500 font-semibold focus:outline-none border-b-2 border-transparent hover:text-blue-500">Non-Teaching</button>
                </div>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">


                    <!-- Teaching Section -->
                    <div id="teaching-section" class="mt-6">

                        <div class="mx-auto w-full max-w-[550px] bg-white">
                            <!-- Type Selection -->
                            <div class="mb-5">
                                <label class="mb-3 block text-base text-gray-700 font-semibold">
                                    Academic Year
                                </label>
                                <select name="t_year" id="teaching_year" class="focus:ring-blue-500 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700 outline-none focus:border-[#6A64F1] focus:shadow-md">
                                    <option value="" disabled selected>Select a Year</option>
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
                                    echo '<option value="' . $startYear . '">' . $startYear . ' - ' . ($startYear + 1) . '</option>';
                                    echo '<option value="' . ($startYear + 1) . '">' . ($startYear + 1) . ' - ' . ($startYear + 2) . '</option>';

                                    // echo '<option selected value="' . (date('Y')) . '">' . date('Y') . ' - ' . (date('Y') + 1) . '</option>';
                                    // echo '<option  value="' . (date('Y') + 1) . '">' . date('Y') + 1 . ' - ' . (date('Y') + 2) . '</option>';

                                    ?>
                                </select>

                            </div>
                            <!-- Department Selection -->


                            <div class="-mx-3 flex flex-wrap">
                                <!--Type Selection-->
                                <div class="w-full px-3 sm:w-1/2">
                                    <div class="mb-5">
                                        <label class="mb-3 block text-base text-gray-700 font-semibold">
                                            Type
                                        </label>
                                        <select name="t_type" onchange=" t_change()" id="teaching_type" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="D">Degree</option>
                                            <option value="J">Junior</option>
                                        </select>
                                    </div>

                                </div>

                                <!--Department-->
                                <div class="w-full px-3 sm:w-1/2">
                                    <div class="mb-5">
                                        <label class="mb-3 block text-base text-gray-700 font-semibold">
                                            Department
                                        </label>
                                        <select onchange=" t_change()" name="t_department" id="teaching_department" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
                                            <option value="" selected disabled>Select an Department</option>

                                        </select>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Teaching Sub Tabs -->
                        <div class="mb-4">
                            <button type="button" id="teacherWiseTab" class="px-4 py-2 rounded-l-lg bg-gray-300 text-gray-700  focus:outline-none">Teacher Wise</button>
                            <button type="button" id="departmentWiseTab" class="px-4 py-2 rounded-r-lg bg-gray-300 text-gray-700 focus:outline-none">Department Wise</button>
                        </div>


                        <hr class=" border-2 mb-2 border-blue-700">


                        <!-- Teacher Wise Fields -->
                        <div id="teacherWiseFields" class="mb-4 hidden">
                            <!-- <div class="mb-4">
                        <label for="casualLeaveTeacher" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveTeacher" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="medicalLeaveTeacher" class="block text-gray-700 font-semibold mb-2">Medical Leave</label>
                        <input type="number" id="medicalLeaveTeacher" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div> -->
                        </div>

                        <!-- Department Wise Fields (initially hidden) -->
                        <div id="departmentWiseFields" class="mb-4 hidden">
                            <!-- <div class="mb-4">
                        <label for="casualLeaveDept" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveDept" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="maternityLeaveDept" class="block text-gray-700 font-semibold mb-2">Maternity Leave</label>
                        <input type="number" id="maternityLeaveDept" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div> -->
                        </div>





                        <!-- Table -->
                        <!-- <div id="teaching-table" class="hidden overflow-x-auto">
                    <table class="w-full bg-white rounded-lg shadow-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Date of Joining</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="teaching-staff-list"></tbody>
                    </table>
                </div> -->

                    </div>





                    <!-- Non-Teaching Section -->
                    <div id="nonteaching-section" class="mt-6 hidden">
                        <div class="mx-auto w-full max-w-[550px] bg-white">
                            <!-- Type Selection -->

                            <div class="mb-5">
                                <label class="mb-3 block text-base text-gray-700 font-semibold">
                                    Academic Year
                                </label>
                                <select name="nt_year" id="nt_year" class="focus:ring-blue-500 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700 outline-none focus:border-[#6A64F1] focus:shadow-md">
                                    <option value="" disabled selected>Select a Year</option>
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
                                    echo '<option value="' . $startYear . '">' . $startYear . ' - ' . ($startYear + 1) . '</option>';
                                    echo '<option value="' . ($startYear + 1) . '">' . ($startYear + 1) . ' - ' . ($startYear + 2) . '</option>';

                                    // echo '<option selected value="' . (date('Y')) . '">' . date('Y') . ' - ' . (date('Y') + 1) . '</option>';
                                    // echo '<option  value="' . (date('Y') + 1) . '">' . date('Y') + 1 . ' - ' . (date('Y') + 2) . '</option>';

                                    ?>
                                </select>

                            </div>
                            <!-- Department Selection -->


                            <div class="-mx-3 flex flex-wrap">
                                <!--Type Selection-->
                                <div class="w-full px-3 sm:w-1/2">
                                    <div class="mb-5">
                                        <label class="mb-3 block text-base text-gray-700 font-semibold">
                                            Type
                                        </label>
                                        <select name="nt_type" id="nt_type" onchange="nt_change()" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="NO">Office</option>
                                            <option value="NL">Labratory</option>
                                            <?php
                                            // $query = "SELECT * FROM `department` WHERE College IN ('L','O')";
                                            // $result = $conn->query($query);
                                            // if ($result->num_rows > 0) {
                                            //     while ($row = $result->fetch_assoc()) {
                                            //         echo '<option value="' . $row['D_id'] . '"> ' . ($row["College"] === 'L' ? 'Labratory' : 'Office') . '</option>';
                                            //     }
                                            // } else {
                                            //     echo '<option value="" selected disabled>No Type</option>';
                                            // }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <!--Department-->
                                <div class="w-full px-3 sm:w-1/2">
                                    <div class="mb-5">
                                        <label class="mb-3 block text-base text-gray-700 font-semibold">
                                            Department
                                        </label>
                                        <select name="nt_department" id="nt_department" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
                                            <option value="" selected disabled>Office Laboratory</option>

                                        </select>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Non Teaching Sub Tabs -->
                        <div class="mb-4">
                            <button type="button" id="individualTab" class="px-4 py-2 rounded-l-lg bg-gray-300 text-gray-700 focus:outline-none">Individual</button>
                            <button type="button" id="allTab" class="px-4 py-2 rounded-r-lg bg-gray-300 text-gray-700 focus:outline-none w-24">All</button>
                        </div>

                        <hr class=" border-2 mb-2 border-blue-700">

                        <!-- Individual Fields -->
                        <div id="individualFields" class="mb-4 hidden">
                            <!-- <div class="mb-4">
                        <label for="casualLeaveIndividual" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveIndividual" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="medicalLeaveIndividual" class="block text-gray-700 font-semibold mb-2">Medical Leave</label>
                        <input type="number" id="medicalLeaveIndividual" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div> -->
                        </div>

                        <!-- All Fields (initially hidden) -->
                        <div id="allFields" class="mb-4 hidden">
                            <!-- <div class="mb-4">
                        <label for="casualLeaveAll" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveAll" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="maternityLeaveAll" class="block text-gray-700 font-semibold mb-2">Maternity Leave</label>
                        <input type="number" id="maternityLeaveAll" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div> -->
                        </div>




                        <!-- <div class=" mb-4  w-full flex justify-center">
                    <button type="button" id="nt_submit" class="hidden bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 hover:translate-y-[200px] w-full  ">Show</button>
                </div>
                <br> -->

                        <!-- Table -->
                        <!-- <div id="nonteaching-table" class="hidden overflow-x-auto">
                    <table class="w-full bg-white rounded-lg shadow-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Date of Joining</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="nonteaching-staff-list"></tbody>
                    </table>
                </div> -->

                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Teaching sub-tab switching
        const teacherWiseTab = document.getElementById('teacherWiseTab');
        const departmentWiseTab = document.getElementById('departmentWiseTab');
        const teacherWiseFields = document.getElementById('teacherWiseFields');
        const departmentWiseFields = document.getElementById('departmentWiseFields');
        // const teachingsubmit = document.getElementById('t_submit');

        teacherWiseTab.addEventListener('click', () => {
            //sub_table(1);
            // Call sub_table() and only proceed if it returns true
            if (!sub_table(1)) {
                return;
            }

            teacherWiseTab.classList.add('subtab-active');
            departmentWiseTab.classList.remove('subtab-active');
            teacherWiseFields.classList.remove('hidden');
            departmentWiseFields.classList.add('hidden');
            departmentWiseTab.classList.remove('bg-blue-500', 'text-white');
            teacherWiseTab.classList.remove('text-gray-700', 'bg-gray-300');
            teacherWiseTab.classList.add('bg-blue-500', 'text-white');
            //teachingsubmit.classList.remove('hidden');


        });

        departmentWiseTab.addEventListener('click', () => {

            if (!sub_table(2)) {
                return;
            }
            departmentWiseTab.classList.add('subtab-active');
            teacherWiseTab.classList.remove('subtab-active');
            departmentWiseFields.classList.remove('hidden');
            teacherWiseFields.classList.add('hidden');
            departmentWiseTab.classList.remove('text-gray-700');
            departmentWiseTab.classList.add('bg-blue-500', 'text-white');
            teacherWiseTab.classList.remove('bg-blue-500', 'text-white');
            teacherWiseTab.classList.add('text-gray-700', 'bg-gray-300');
            //teachingsubmit.classList.remove('hidden');
            //sub_table(2);
        });



        // Non-Teaching sub-tab switching
        const individualTab = document.getElementById('individualTab');
        const allTab = document.getElementById('allTab');
        const individualFields = document.getElementById('individualFields');
        const allFields = document.getElementById('allFields');
        //const nteachingsubmit = document.getElementById('nt_submit');

        individualTab.addEventListener('click', () => {
            if (!sub_table2(1)) {
                return;
            }

            individualTab.classList.add('subtab-active');
            allTab.classList.remove('subtab-active');
            individualFields.classList.remove('hidden');
            allFields.classList.add('hidden');
            allTab.classList.remove('bg-blue-500', 'text-white');
            individualTab.classList.remove('text-gray-700', 'bg-gray-300');
            individualTab.classList.add('bg-blue-500', 'text-white');
            //nteachingsubmit.classList.remove('hidden');
            //sub_table2(1);

        });

        allTab.addEventListener('click', () => {
            if (!sub_table2(2)) {
                return;
            }
            allTab.classList.add('subtab-active');
            individualTab.classList.remove('subtab-active');
            allFields.classList.remove('hidden');
            individualFields.classList.add('hidden');
            allTab.classList.remove('text-gray-700');
            allTab.classList.add('bg-blue-500', 'text-white');
            individualTab.classList.remove('bg-blue-500', 'text-white');
            individualTab.classList.add('text-gray-700', 'bg-gray-300');
            //nteachingsubmit.classList.remove('hidden');
            //sub_table2(2);
        });








        // Toggle Tabs
        const teachingTab = document.getElementById('teaching-tab');
        const nonTeachingTab = document.getElementById('nonteaching-tab');
        const teachingSection = document.getElementById('teaching-section');
        const nonTeachingSection = document.getElementById('nonteaching-section');

        teachingTab.addEventListener('click', () => {
            teachingSection.classList.remove('hidden');
            nonTeachingSection.classList.add('hidden');
            teachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            nonTeachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');

        });

        nonTeachingTab.addEventListener('click', () => {
            nonTeachingSection.classList.remove('hidden');
            teachingSection.classList.add('hidden');
            nonTeachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            teachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');
        });


        //Teaching staff form
        function sub_table(a) {
            var t_dept = document.getElementById('teaching_department').value;
            var t_year = document.getElementById('teaching_year').value;
            var t_type = document.getElementById('teaching_type').value;
            if (t_dept === "" || t_year === "" || t_type === "") {
                alert("Please Select the Values");
                return false; // Return false if values are missing

            } else {
                // Get the values 
                $.ajax({
                    url: "teaching_wise.php",
                    type: "POST",
                    cache: false,
                    data: {
                        dept: t_dept,
                        year: t_year,
                        type: t_type,
                        sub_table: a
                    },
                    success: function(data) {
                        if (a == 1) {
                            $("#teacherWiseFields").html(data);
                        } else {
                            $("#departmentWiseFields").html(data);
                        }
                    }
                });
                return true;

            }

        }

        //Non-Teaching staff form
        function sub_table2(a) {
            //var nt_dept = document.getElementById('nt_department').value;
            var nt_year = document.getElementById('nt_year').value;
            var nt_type = document.getElementById('nt_type').value;

            if (nt_type === "" || nt_year === "") {
                alert("Please Select the Values");
                return false; // Return false if values are missing
            } else {
                // Get the values 
                $.ajax({
                    url: "teaching_wise.php",
                    type: "POST",
                    cache: false,
                    data: {
                        ntype: nt_type,
                        nyear: nt_year,
                        sub_table2: a
                    },
                    success: function(data) {
                        if (a == 1) {
                            $("#individualFields").html(data);
                        } else {
                            $("#allFields").html(data);
                        }
                    }
                });
                return true;
            }

        }

        // To erase the Non teching form On change
        function nt_change() {
            individualFields.classList.add('hidden');
            allFields.classList.add('hidden');

        }
        // To erase the Teaching form On change
        function t_change() {
            teacherWiseFields.classList.add('hidden');
            departmentWiseFields.classList.add('hidden');

        }


        // function teachingSubmit() {
        //     alert("teching_wiseyy");
        //     var t_type = document.getElementById('teaching_type').value;
        //     var teaching_wise_t = document.getElementById('teacher_wise_teacher').value;
        //     var teaching_wise_cl = document.getElementById('teacher_wise_cl').value;
        //     var teaching_wise_ma = document.getElementById('teacher_wise_ma').value;
        //     var teaching_wise_hl = document.getElementById('teacher_wise_hl').value;
        //     var teaching_wise_ml_el = document.getElementById('teacher_wise_ml_el').value;
        //     var a_type = document.getElementById('teaching_year').value;
        //     console.log({
        //         year: a_type,
        //         teaching_t: teaching_wise_t,
        //         teaching_cl: teaching_wise_cl,
        //         teaching_ma: teaching_wise_ma,
        //         teaching_hl: teaching_wise_hl,
        //         teaching_el: teaching_wise_ml_el // if applicable
        //     });

        //     if (teaching_wise_t === "" || teaching_wise_cl === "" || teaching_wise_ma === "" || teaching_wise_hl === "" || teaching_wise_ml_el === "") {
        //         alert("Please Assign All the Leaves !!");

        //     } else {
        //         // console.log({
        //         //     year: a_type,
        //         //     teaching_t: teaching_wise_t,
        //         //     teaching_cl: teaching_wise_cl,
        //         //     teaching_ma: teaching_wise_ma,
        //         //     teaching_hl: teaching_wise_hl,
        //         //     teaching_el: teaching_wise_ml_el // if applicable
        //         // });


        //         $.ajax({
        //             url: "action.php",
        //             type: "POST",
        //             dataType: 'json', // Expect a JSON response
        //             data: {
        //                 type: t_type,
        //                 year: a_type,
        //                 teaching_t: teaching_wise_t,
        //                 teaching_cl: teaching_wise_cl,
        //                 teaching_ma: teaching_wise_ma,
        //                 teaching_hl: teaching_wise_hl,
        //                 teaching_ml_el: teaching_wise_ml_el
        //             },
        //             success: function(response) {
        //                 if (response.status === 'success') {
        //                     alert(response.message); // Show success message
        //                     //loadContent('dl');
        //                 } else {
        //                     alert(response.message); // Show error message if any
        //                     // loadContent('dl');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 //console.error("AJAX Error: ", status, error);
        //                 //console.log("Response Text:", xhr.responseText);
        //                 alert("AJAX Error: " + status + " " + error + "\nResponse Text: " + xhr.responseText);
        //             }

        //         });

        //     }



        // }







        // Reason Textarea onchange Professor ajax
        $("#teaching_type").on("change", function() {

            //var t_dept = document.getElementById('teaching_department').value;
            var t_type = this.value;

            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            // alert("Type: " + t_type);
            //document.getElementById(`teaching-table`).classList.add("hidden");
            // Get the values of the selected department and type
            $.ajax({
                url: "dept_filter.php",
                type: "POST",
                cache: false,
                data: {
                    type: t_type
                },
                success: function(data) {
                    $("#teaching_department").html(data);
                }
            });
        });
    </script>
</body>

</html>