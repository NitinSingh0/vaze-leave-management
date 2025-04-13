 <?php

    include '../../config/connect.php';  // Database connection file
    error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    $Staff_id = $_SESSION['Staff_id'];
    if (!$Staff_id) {
        echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
        exit;
    }


    $sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $jobRole = $row['Job_role'];
        $designation = $row['Designation'];
    }
    $currentSubPage = basename($_SERVER['PHP_SELF']);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : '';

    // All Leave Tables
    $leaveTables = [
        'd_cl_leave',
        'd_dl_leave',
        'd_mhm_leave',
        'j_cl_leave',
        'j_dl_leave',
        'j_ehm_leave',
        'n_cl_leave',
        'n_dl_leave',
        'n_emhm_leave',
        'n_off_pay_leave'
    ];

    // 1. DEPARTMENT-WISE LEAVE (Using Degree CL Leave for simplicity)
    $deptLeaveQuery = "
    SELECT department.Name as department_name, SUM(d_cl_leave.No_of_days) as total_days
    FROM d_cl_leave
    INNER JOIN staff ON d_cl_leave.Staff_id = staff.Staff_id
    INNER JOIN department ON staff.D_id = department.D_id
    GROUP BY department.D_id
";
    $deptResult = mysqli_query($conn, $deptLeaveQuery);
    if (!$deptResult) {
        die("Query Failed: " . mysqli_error($conn));
    }
    $departments = [];
    $deptLeaveCounts = [];
    while ($row = mysqli_fetch_assoc($deptResult)) {
        $departments[] = $row['department_name'];
        $deptLeaveCounts[] = $row['total_days'];
    }

    // 2. LEAVE TYPE DISTRIBUTION
    $leaveTables = [
        'd_cl_leave' => 'Degree CL',
        'd_dl_leave' => 'Degree DL',
        'd_mhm_leave' => 'Degree MHM',
        'j_cl_leave' => 'Junior CL',
        'j_dl_leave' => 'Junior DL',
        'j_ehm_leave' => 'Junior EHM',
        'n_cl_leave' => 'Non-Teaching CL',
        'n_dl_leave' => 'Non-Teaching DL',
        'n_emhm_leave' => 'Non-Teaching EMHM',
    ];
    $leaveLabels = [];
    $leaveCounts = [];
    foreach ($leaveTables as $table => $label) {
        $query = "SELECT SUM(No_of_days) as total FROM $table";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query Failed on $table: " . mysqli_error($conn));
        }
        $data = mysqli_fetch_assoc($result);
        $leaveLabels[] = $label;
        $leaveCounts[] = (int)$data['total'];
    }
    // Add n_off_pay_leave separately using COUNT(*)
    $offPayQuery = "SELECT COUNT(*) as total FROM n_off_pay_leave";
    $offPayResult = mysqli_query($conn, $offPayQuery);
    if (!$offPayResult) {
        die("Query Failed on n_off_pay_leave: " . mysqli_error($conn));
    }
    $offPayData = mysqli_fetch_assoc($offPayResult);
    $leaveLabels[] = 'Non-Teaching Off Pay';
    $leaveCounts[] = (int)$offPayData['total'];
    // 3. MONTHLY CL LEAVES across all CL tables
    $monthlyLeaveCounts = array_fill(1, 12, 0);  // Jan to Dec
    $clTables = ['d_cl_leave', 'j_cl_leave', 'n_cl_leave'];
    foreach ($clTables as $table) {
        $query = "SELECT MONTH(from_date) as month, SUM(No_of_days) as total FROM $table GROUP BY MONTH(from_date)";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $month = (int)$row['month'];
            $monthlyLeaveCounts[$month] += (int)$row['total'];
        }
    }
    $months = array_map(function ($m) {
        return date('F', mktime(0, 0, 0, $m, 1));
    }, array_keys($monthlyLeaveCounts));
    $monthlyCounts = array_values($monthlyLeaveCounts);


    ?>


 <!-- Main Container -->
 <div class="mt-11 flex h-screen">
     <style>
         .chart-container {
             width: 80%;
             margin: 30px auto;
         }
     </style>
     <!-- Sidebar -->
     <?php include('../layouts/sidebar.php') ?>


     <!-- Main Content Area with margin for sidebar -->
     <main id="mainContent" class="flex-1 p-4 ml-[20%] overflow-auto">
         <div id="dynamicContent">
             <?php if (strcasecmp(trim($designation), 'Principal') != 0):  ?>
                 <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <div class="bg-white p-6 rounded-lg shadow-lg">
                         <h2 class="text-xl font-semibold text-gray-700 mb-4">Casual Leave</h2>
                         <canvas id="casualLeaveChart"></canvas>
                     </div>
                     <div class="bg-white p-6 rounded-lg shadow-lg">
                         <h2 class="text-xl font-semibold text-gray-700 mb-4">Duty Leave</h2>
                         <canvas id="dutyLeaveChart"></canvas>
                     </div>
                     <div class="bg-white p-6 rounded-lg shadow-lg">
                         <h2 class="text-xl font-semibold text-gray-700 mb-4">Medical/Half-Pay Leave</h2>
                         <canvas id="medicalLeaveChart"></canvas>
                     </div>
                 </div> -->

                 <!-- Newly added start -->


                 <div class="min-h-screen px-2 py-4">
                     <!-- Header -->
                     <header class="mb-8">
                         <h1 class="text-3xl font-bold text-gray-800">Leave Management Dashboard</h1>
                         <p class="text-gray-600">Academic Year 2024-2025</p>
                     </header>

                     <!-- Total Leave Summary -->
                     <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                         <div class="bg-white rounded-lg shadow p-6">
                             <div class="flex items-center gap-4 mb-4">
                                 <div class="p-3 bg-green-100 rounded-full">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                     </svg>
                                 </div>
                                 <h3 class="text-lg font-semibold text-gray-800">Casual Leave</h3>
                             </div>
                             <div class="flex gap-4 justify-center items-center">
                                 <span class="text-3xl font-bold text-green-600">12</span>
                                 <span class="text-sm text-gray-500">Total Days/Year</span>
                             </div>
                             <!-- Progress Bar -->
                             <div class="w-full h-3 mt-5 bg-gray-200 rounded-full overflow-hidden">
                                 <div class="h-full bg-green-500" style="width: 50%; float: left;"></div>
                                 <div class="h-full bg-orange-400" style="width: 16.67%; float: left;"></div>
                                 <div class="h-full bg-gray-300" style="width: 33.33%; float: left;"></div>
                             </div>

                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <div class="flex items-center gap-4 mb-4">
                                 <div class="p-3 bg-blue-100 rounded-full">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                     </svg>
                                 </div>
                                 <h3 class="text-lg font-semibold text-gray-800">Medical Leave</h3>
                             </div>
                             <div class="flex gap-4 justify-center items-center">
                                 <span class="text-3xl font-bold text-blue-600">15</span>
                                 <span class="text-sm text-gray-500">Total Days/Year</span>
                             </div>
                             <!-- Progress Bar -->
                             <div class="w-full h-3 mt-5 bg-gray-200 rounded-full overflow-hidden">
                                 <div class="h-full bg-blue-500" style="width: 33.33%; float: left;"></div>
                                 <div class="h-full bg-orange-400" style="width: 6.67%; float: left;"></div>
                                 <div class="h-full bg-gray-300" style="width: 60%; float: left;"></div>
                             </div>

                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <div class="flex items-center gap-4 mb-4">
                                 <div class="p-3 bg-yellow-100 rounded-full">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                     </svg>
                                 </div>
                                 <h3 class="text-lg font-semibold text-gray-800">Half Pay Leave</h3>
                             </div>
                             <div class="flex gap-4 justify-center items-center">
                                 <span class="text-3xl font-bold text-yellow-600">10</span>
                                 <span class="text-sm text-gray-500">Total Days/Year</span>
                             </div>
                             <!-- Progress Bar -->
                             <div class="w-full h-3 mt-5 bg-gray-200 rounded-full overflow-hidden">
                                 <div class="h-full bg-yellow-500" style="width: 20%; float: left;"></div>
                                 <div class="h-full bg-orange-400" style="width: 10%; float: left;"></div>
                                 <div class="h-full bg-gray-300" style="width: 70%; float: left;"></div>
                             </div>

                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <div class="flex items-center gap-4 mb-4">
                                 <div class="p-3 bg-pink-100 rounded-full">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                     </svg>
                                 </div>
                                 <h3 class="text-lg font-semibold text-gray-800">Maternity Leave</h3>
                             </div>
                             <div class="flex gap-4 justify-center items-center">
                                 <span class="text-3xl font-bold text-pink-600">180</span>
                                 <span class="text-sm text-gray-500">Total Days</span>
                             </div>
                             <!-- Progress Bar -->
                             <div class="w-full h-3 mt-5 bg-gray-200 rounded-full overflow-hidden">
                                 <div class="h-full bg-pink-400" style="width: 55.56%; float: left;"></div>
                                 <div class="h-full bg-orange-400" style="width: 5.56%; float: left;"></div>
                                 <div class="h-full bg-gray-300" style="width: 38.88%; float: left;"></div>
                             </div>
                         </div>
                     </div>
                     <!-- Leave Status Charts -->
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                         <div class="bg-white rounded-lg shadow p-6">
                             <h3 class="text-lg font-semibold text-gray-800 mb-4">Casual Leave Status</h3>
                             <canvas id="casualChart"></canvas>
                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <h3 class="text-lg font-semibold text-gray-800 mb-4">Medical Leave Status</h3>
                             <canvas id="medicalChart"></canvas>
                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <h3 class="text-lg font-semibold text-gray-800 mb-4">Half Pay Leave Status</h3>
                             <canvas id="halfpayChart"></canvas>
                         </div>
                         <div class="bg-white rounded-lg shadow p-6">
                             <h3 class="text-lg font-semibold text-gray-800 mb-4">Maternity Leave Status</h3>
                             <canvas id="maternityChart"></canvas>
                         </div>
                     </div>

                     <!-- Yearly Leave Trend -->
                     <div class="bg-white rounded-lg shadow p-6">
                         <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave Usage</h3>
                         <canvas id="yearlyChart"></canvas>
                     </div>
                 </div>



                 <!-- Newly added end -->

             <?php endif; ?>
             <?php if (strcasecmp(trim($designation), 'Principal') == 0):  ?>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <!-- Department-wise -->
                     <div class="chart-container">
                         <h3>Department-wise CL Leave (Horizontal Bar)</h3>
                         <canvas id="deptChart"></canvas>
                     </div>

                     <!-- Leave Type Distribution -->
                     <div class="chart-container">
                         <h3>Leave Type Distribution (No. of Days)</h3>
                         <canvas id="typeChart"></canvas>
                     </div>

                     <!-- Monthly Leave -->
                     <div class="chart-container">
                         <h3>Monthly CL Leave Requests (All Categories)</h3>
                         <canvas id="monthlyChart"></canvas>
                     </div>
                 </div>
             <?php endif; ?>

         </div>
     </main>

 </div>
 <script>
     // Department-wise Leave (Horizontal Bar)
     new Chart(document.getElementById('deptChart'), {
         type: 'bar',
         data: {
             labels: <?php echo json_encode($departments); ?>,
             datasets: [{
                 label: 'Total CL Leave Days',
                 data: <?php echo json_encode($deptLeaveCounts); ?>,
                 backgroundColor: '#4e73df'
             }]
         },
         options: {
             indexAxis: 'y',
             responsive: true,
             plugins: {
                 legend: {
                     display: false
                 }
             }
         }
     });

     // Leave Type Distribution
     new Chart(document.getElementById('typeChart'), {
         type: 'doughnut',
         data: {
             labels: <?php echo json_encode($leaveLabels); ?>,
             datasets: [{
                 label: 'Leave Days',
                 data: <?php echo json_encode($leaveCounts); ?>,
                 backgroundColor: [
                     '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc',
                     '#a569bd', '#5dade2', '#f39c12', '#7f8c8d',
                     '#58d68d', '#dc7633'
                 ]
             }]
         },
         options: {
             responsive: true
         }
     });

     // Monthly CL Leave Trends (Line Chart)
     new Chart(document.getElementById('monthlyChart'), {
         type: 'line',
         data: {
             labels: <?php echo json_encode($months); ?>,
             datasets: [{
                 label: 'Total CL Leave Days',
                 data: <?php echo json_encode($monthlyCounts); ?>,
                 fill: false,
                 borderColor: '#36b9cc',
                 tension: 0.2
             }]
         },
         options: {
             responsive: true
         }
     });
 </script>

 <!-- JavaScript for AJAX and Chart.js -->
 <script>
     //to load the page if dynamicContentContainer div is not availabe. go to index.php then fetch content from components

     function loadContent(page) {
         // Get the base URL up to the directory containing index.php
         const baseUrl = `${window.location.origin}/vaze-leave-management/main/pages/`;

         // Check if the dynamic content container exists
         const dynamicContentContainer = document.getElementById('dynamicContent');

         if (dynamicContentContainer) {
             // If the dynamic content container exists, load the content dynamically
             fetch(`../components/${page}.php`)
                 .then(response => {
                     if (!response.ok) {
                         throw new Error(`HTTP error! Status: ${response.status}`);
                     }
                     return response.text();
                 })
                 .then(data => {
                     dynamicContentContainer.innerHTML = data;
                     // Optionally update the browser history
                     window.history.pushState({
                         page: page
                     }, '', `index.php?page=${page}`);
                 })
                 .catch(error => console.error('Error loading content:', error));
         } else {
             // If the dynamic content container doesn't exist, redirect to index.php
             const url = new URL(`${baseUrl}index.php`);
             url.searchParams.set('page', page); // Add the 'page' parameter to the URL
             window.location.href = url;
         }
     }

     // Check for `page` parameter in the URL and load the corresponding content
     window.addEventListener('DOMContentLoaded', () => {
         const params = new URLSearchParams(window.location.search);
         const page = params.get('page');

         if (page) {
             const dynamicContentContainer = document.getElementById('dynamicContent');
             if (dynamicContentContainer) {
                 // Dynamically load the page if the container exists
                 fetch(`../components/${page}.php`)
                     .then(response => {
                         if (!response.ok) {
                             throw new Error(`HTTP error! Status: ${response.status}`);
                         }
                         return response.text();
                     })
                     .then(data => {
                         dynamicContentContainer.innerHTML = data;
                     })
                     .catch(error => console.error('Error loading content:', error));
             }
         }
     });


     //JavaScriptfor AJAX and Chart.js

     document.addEventListener("DOMContentLoaded", function() {
         fetchLeaveData();

         async function fetchLeaveData() {
             try {
                 const response = await fetch('getLeaveData.php');
                 const data = await response.json();

                 console.log(data); // Log the data to verify

                 const casualUsed = Number(data.casual.used);
                 const casualRemaining = Number(data.casual.total) - casualUsed;
                 createPieChart('casualLeaveChart', casualUsed, casualRemaining, 'Casual Leave');

                 const dutyUsed = Number(data.duty.used);
                 const dutyRemaining = Number(data.duty.total) - dutyUsed;
                 createPieChart('dutyLeaveChart', dutyUsed, dutyRemaining, 'Duty Leave');

                 const otherUsed = Number(data.other.used);
                 const otherRemaining = Number(data.other.total) - otherUsed;
                 createPieChart('medicalLeaveChart', otherUsed, otherRemaining, 'Other Leave');

             } catch (error) {
                 console.error("Error fetching leave data:", error);
             }
         }


         function createPieChart(elementId, used, remaining, label) {
             const ctx = document.getElementById(elementId).getContext('2d');
             new Chart(ctx, {
                 type: 'pie',
                 data: {
                     labels: ['Used Leaves', 'Remaining Leaves'],
                     datasets: [{
                         data: [used, remaining],
                         backgroundColor: ['#ff6384', '#36a2eb']
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: true,
                     plugins: {
                         title: {
                             display: true,
                             text: label
                         },
                         legend: {
                             position: 'bottom'
                         },
                         tooltip: {
                             callbacks: {
                                 label: context => `${context.label}: ${context.raw} days`
                             }
                         }
                     }
                 }
             });
         }
     });
 </script>



 <!--OFF PAY-->
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
                 dateInput.className = "w-full border border-[#e0e0e0] py-2 px-3 date-of-duty";
                 dateInput.addEventListener("input", validateDates); // Attach validation on input change
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


                 // // Nature of Work input cell
                 // const workCell = document.createElement("td");
                 // const workTextarea = document.createElement("textarea"); // Create a textarea instead of input
                 // workTextarea.name = `nature_of_work_${i + 1}`;
                 // workTextarea.required = true;
                 // workTextarea.className = "w-full border border-[#e0e0e0] py-2 px-3";
                 // workCell.appendChild(workTextarea); // Append the textarea to the cell
                 // row.appendChild(workCell);





                 // Off Duty Date input cell
                 const offDutyCell = document.createElement("td");
                 const offDutyInput = document.createElement("input");
                 offDutyInput.type = "date";
                 offDutyInput.name = `off_pay_date_${i + 1}`;
                 offDutyInput.required = true;
                 offDutyInput.className = "w-full border border-[#e0e0e0] py-2 px-3 off-duty-date";
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
                 offDutyInput.addEventListener("input", validateDates); // Attach validation on input change
                 offDutyCell.appendChild(offDutyInput);
                 row.appendChild(offDutyCell);

                 // Append the row to the table body
                 dutyTableBody.appendChild(row);
             }

             document.getElementById("submit123").innerHTML = `
    <input type="submit" value="Apply" name="submit"  onclick="off1()"
           class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800" />
`;
         } else {
             // Hide the table if no days are specified
             dutyTableContainer.style.display = "none";
         }
     }

     // Function to validate unique dates
     function validateDates(event) {
         const targetClass = event.target.className;
         let isValid = true;

         if (targetClass.includes("date-of-duty")) {
             isValid = validateSpecificDates(".date-of-duty", "'Date of Duty' Already Selected.");
         } else if (targetClass.includes("off-duty-date")) {
             isValid = validateSpecificDates(".off-duty-date", "'Off Duty Date' Already Selected.");
         }

         // Enable or disable the submit button based on validity
         const submitButton = document.querySelector("input[type='submit'][name='submit']");
         const div1 = document.getElementById("submit123");
         if (submitButton) {
             submitButton.disabled = !isValid;
         }

         if (!isValid) {
             div1.classList.remove('hover:bg-blue-800');
             div1.classList.add('opacity-50');
         } else {
             div1.classList.add('hover:bg-blue-800');
             div1.classList.remove('opacity-50');
         }
     }

     // Helper function to validate a specific set of inputs
     function validateSpecificDates(selector, errorMessage) {
         const inputs = document.querySelectorAll(selector);
         const values = [...inputs].map(input => input.value);

         // Check for duplicates
         if (hasDuplicates(values)) {
             alert(errorMessage);
             return false; // Validation failed
         }

         return true; // Validation passed
     }

     // Helper function to check for duplicates in an array
     function hasDuplicates(array) {
         return new Set(array.filter(Boolean)).size !== array.filter(Boolean).length;
     }
 </script>



 <!--MEDICAL-->
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


     //MHME From_Date To_Date Calculation based on total duty and used duty


     function setMinToDate3() {
         const fromDate = document.getElementById("from_date").value;
         const toDate = document.getElementById("to_date");
         const submit = document.getElementById("submit22");
         var type1 = document.getElementById("LType").value;
         var year1 = document.getElementById("year").value;
         if (type1 === "") {
             alert("Select The Type Of Leave To be Applied !!");
             submit.disabled = true;
             toDate.disabled = true;
             return;
         } else {
             fetchLeaveData();
         }
         toDate.min = fromDate;



         // Enable date field if From_Date is provided, otherwise disable it
         toDate.disabled = fromDate === '';

         // Make the date field required if From_Date is provided
         toDate.required = fromDate !== '';

         async function fetchLeaveData() {
             try {

                 // Data to send in the request
                 const requestData = {
                     type: type1,
                     year: year1
                 };

                 // Sending a POST request with JSON data
                 const response = await fetch('../components/Pending/mhme.php', {
                     method: 'POST', // Specify the HTTP method
                     headers: {
                         'Content-Type': 'application/json', // Indicate JSON payload
                     },
                     body: JSON.stringify(requestData), // Convert the data to a JSON string
                 });

                 // Handle the response
                 if (!response.ok) {
                     throw new Error(`HTTP error! Status: ${response.status}`);
                 }

                 const data = await response.json();

                 console.log(data); // Log the data to verify
                 const dutyUsed = Number(data.duty.used);
                 const dutyRemaining = Number(data.duty.total) - dutyUsed;
                 console.log(dutyRemaining);

                 if (dutyRemaining > 0) {
                     const fromDateObj = new Date(fromDate);
                     const maxDateObj = new Date(fromDateObj);

                     maxDateObj.setDate(fromDateObj.getDate() + dutyRemaining - 1);

                     // Format the date as yyyy-mm-dd
                     const maxDate = maxDateObj.toISOString().split("T")[0];

                     // Set the max value for to_date
                     document.getElementById("to_date").max = maxDate;
                     console.log(`Max Date: ${maxDate}`);
                 } else {
                     // Show alert if no duty leave is left
                     alert("No Leave left !!!");

                     // Ensure to_date is not disabled
                     toDate.disabled = true;
                     submit.disabled = true;


                     // Remove any restrictions on max date
                     document.getElementById("to_date").max = "";
                 }

             } catch (error) {
                 console.error("Error fetching leave data:", error);
             }
         }

         calculateDays();
     }


     //DL

     function toggleDateField() {
         const referenceNumber = document.getElementById('reference_number').value;
         const dateOfLetter = document.getElementById('date_of_letter');

         // Enable date field if reference number is provided, otherwise disable it
         dateOfLetter.disabled = referenceNumber === '';

         // Make the date field required if reference number is provided
         dateOfLetter.required = referenceNumber !== '';
     }
 </script>

 <!-- Newly added start -->
 <script>
     $(document).ready(function() {

         // Initialize pie charts
         //   const leaveTypes = [
         //     { name: 'casual', color: '#22c55e', total: 12 },
         //     { name: 'medical', color: '#3b82f6', total: 15 },
         //     { name: 'halfpay', color: '#eab308', total: 10 },
         //     { name: 'maternity', color: '#ec4899', total: 180 }
         //   ];

         //   leaveTypes.forEach(type => {
         //     const ctx = document.getElementById(`${type.name}Chart`);
         //     new Chart(ctx, {
         //       type: 'pie',
         //       data: {
         //         labels: ['Used', 'Pending', 'Available'],
         //         datasets: [{
         //           data: [
         //             Math.floor(Math.random() * type.total), 
         //             Math.floor(Math.random() * 3), 
         //             type.total - Math.floor(Math.random() * type.total)
         //           ],
         //           backgroundColor: [
         //             type.color,
         //             '#9ca3af',
         //             '#e5e7eb'
         //           ]
         //         }]
         //       },
         //       options: {
         //         responsive: true,
         //         plugins: {
         //           legend: {
         //             position: 'bottom',
         //             labels: {
         //               padding: 20
         //             }
         //           }
         //         }
         //       }
         //     });
         //   });


         // Casual Leave Pie Chart
         const casualCtx = document.getElementById('casualChart');
         new Chart(casualCtx, {
             type: 'pie',
             data: {
                 labels: ['Used', 'Pending', 'Available'],
                 datasets: [{
                     data: [6, 2, 4],
                     backgroundColor: ['#22c55e', '#9ca3af', '#e5e7eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
                     legend: {
                         position: 'bottom',
                         labels: {
                             padding: 20
                         }
                     }
                 }
             }
         });

         // Medical Leave Pie Chart
         const medicalCtx = document.getElementById('medicalChart');
         new Chart(medicalCtx, {
             type: 'pie',
             data: {
                 labels: ['Used', 'Pending', 'Available'],
                 datasets: [{
                     data: [5, 1, 9],
                     backgroundColor: ['#3b82f6', '#9ca3af', '#e5e7eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
                     legend: {
                         position: 'bottom',
                         labels: {
                             padding: 20
                         }
                     }
                 }
             }
         });

         // Half-Pay Leave Pie Chart
         const halfpayCtx = document.getElementById('halfpayChart');
         new Chart(halfpayCtx, {
             type: 'pie',
             data: {
                 labels: ['Used', 'Pending', 'Available'],
                 datasets: [{
                     data: [2, 1, 7],
                     backgroundColor: ['#eab308', '#9ca3af', '#e5e7eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
                     legend: {
                         position: 'bottom',
                         labels: {
                             padding: 20
                         }
                     }
                 }
             }
         });

         // Maternity Leave Pie Chart
         const maternityCtx = document.getElementById('maternityChart');
         new Chart(maternityCtx, {
             type: 'pie',
             data: {
                 labels: ['Used', 'Pending', 'Available'],
                 datasets: [{
                     data: [100, 10, 70],
                     backgroundColor: ['#ec4899', '#9ca3af', '#e5e7eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
                     legend: {
                         position: 'bottom',
                         labels: {
                             padding: 20
                         }
                     }
                 }
             }
         });


         // Initialize yearly trend chart
         const yearlyCtx = document.getElementById('yearlyChart');
         const allotted = [12, 10, 15, 6];
         const used = [6, 4, 2, 3];
         const pending = [2, 1, 1, 1];

         new Chart(yearlyCtx, {
             type: 'bar',
             data: {
                 labels: ['Casual Leave', 'Medical Leave', 'Half-Pay Leave', 'Maternity Leave'],
                 datasets: [{
                         label: 'Allotted Leave',
                         data: allotted,
                         backgroundColor: '#3b82f6',
                         borderRadius: 4,
                         stack: 'Allotted'
                     },
                     {
                         label: 'Used Leave',
                         data: used,
                         backgroundColor: '#22c55e',
                         borderRadius: 4,
                         stack: 'Used'
                     },
                     {
                         label: 'Pending Approval',
                         data: pending,
                         backgroundColor: '#f97316',
                         borderRadius: 4,
                         stack: 'Used'
                     }
                 ]
             },
             options: {
                 responsive: true,
                 scales: {
                     x: {
                         stacked: true,
                         title: {
                             display: true,
                             text: 'Type of Leave'
                         }
                     },
                     y: {
                         beginAtZero: true,
                         stacked: true,
                         ticks: {
                             stepSize: 1
                         },
                         title: {
                             display: true,
                             text: 'Number of Leaves'
                         }
                     }
                 },
                 plugins: {
                     legend: {
                         position: 'top'
                     },
                     tooltip: {
                         mode: 'index',
                         intersect: false,
                         callbacks: {
                             afterBody: function(tooltipItems) {
                                 const index = tooltipItems[0].dataIndex;
                                 const available = allotted[index] - (used[index] + pending[index]);
                                 return 'Available: ' + available;
                             }
                         }
                     }
                 }
             }
         });
     });
 </script>


 <!-- Newly added end -->

 </body>

 </html>