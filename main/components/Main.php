 <?php
    session_start();
    include '../../config/connect.php';  // Database connection file

    // Retrieve Staff_id from session
    $staff_id = $_SESSION['Staff_id'];
    echo "staff" . $staff_id;
    $currentYear = date("Y");
    $currentMonth = date("n");
    $a_year = ($currentMonth > 6) ? $currentYear : $currentYear - 1;

    // Step 1: Find D_id for the staff member
    $query = $conn->prepare("SELECT D_id FROM staff WHERE Staff_id = ?");
    $query->bind_param("i", $staff_id);
    $query->execute();
    $result = $query->get_result();
    $staffInfo = $result->fetch_assoc();
    $D_id = $staffInfo['D_id'];

    // Step 2: Check department and college details
    $query = $conn->prepare("SELECT College, Name FROM department WHERE D_id = ?");
    $query->bind_param("i", $D_id);
    $query->execute();
    $result = $query->get_result();
    $departmentInfo = $result->fetch_assoc();
    $college = $departmentInfo['College'];
    $departmentName = $departmentInfo['Name'];

    // Initialize leave totals and used values
    $totalCasualLeave = $usedCasualLeave = 0;
    $totalDutyLeave = $usedDutyLeave = 0;
    $totalOtherLeave = $usedOtherLeave = 0;

    // Step 3: Retrieve leave data based on College and Department
    if ($college == 'J') {
        // Junior College leave data
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'j_cl_leave', $staff_id, $a_year);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'j_dl_leave', $staff_id, $a_year);

        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave($conn, $staff_id, 'Other', $a_year);
        $usedOtherLeave = fetchUsedLeave($conn, 'j_ehm_leave', $staff_id, $a_year);
    } elseif ($college == 'D' && $departmentName == 'Office_lab') {
        // Degree College Office_lab staff
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'n_cl_leave', $staff_id, $currentYear);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'n_dl_leave', $staff_id, $currentYear);

        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave(
            $conn,
            $staff_id,
            'Other',
            $a_year
        );

        $usedOtherLeave = fetchUsedLeave($conn, 'n_emhm_leave', $staff_id, $currentYear);
    } else {
        // General Degree College
        $totalCasualLeave = fetchTotalLeave($conn, $staff_id, 'CL', $a_year);
        $usedCasualLeave = fetchUsedLeave($conn, 'd_cl_leave', $staff_id, $a_year);

        $totalDutyLeave = fetchTotalLeave($conn, $staff_id, 'DL', $a_year);
        $usedDutyLeave = fetchUsedLeave($conn, 'd_dl_leave', $staff_id, $a_year);
        // For Other Leave (which is neither CL nor DL)
        $totalOtherLeave = fetchTotalLeave($conn, $staff_id, 'Other', $a_year);
        $usedOtherLeave = fetchUsedLeave($conn, 'd_mhm_leave', $staff_id, $a_year);
    }

    // Step 4: Return data as JSON
    echo json_encode([
        'casual' => ['total' => $totalCasualLeave, 'used' => $usedCasualLeave],
        'duty' => ['total' => $totalDutyLeave, 'used' => $usedDutyLeave],
        'other' => ['total' => $totalOtherLeave, 'used' => $usedOtherLeave]
    ]);

    // Helper functions
    function fetchTotalLeave($conn, $staff_id, $type, $a_year)
    {
        // If the leave type is 'Other', we need to sum all leave types excluding 'CL' and 'DL'
        if ($type == 'Other') {
            $query = $conn->prepare("SELECT SUM(No_of_leaves) AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type NOT IN ('CL', 'DL') AND A_year = ?");
            // Bind parameters and execute
            $query->bind_param("ii", $staff_id, $a_year);
        } else {
            // For specific leave types like CL and DL, the original query applies
            $query = $conn->prepare("SELECT No_of_leaves AS TotalLeave FROM staff_leaves_trial 
                                 WHERE Staff_id = ? AND Leave_type = ? AND A_year = ?");
            // Bind parameters and execute
            $query->bind_param("isi", $staff_id, $type, $a_year);
        }

        // Execute the query
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        // Return the result (sum for 'Other' and No_of_leaves for specific types)
        return $result['TotalLeave'] ?? 0;
    }




    function fetchUsedLeave($conn, $table, $staff_id, $a_year)
    {
        // Verify the table name is one of the expected values
        $allowedTables = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave', 'n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'd_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Invalid table name: $table");
        }

        // Prepare the query dynamically
        $query = $conn->prepare("SELECT SUM(No_of_days) AS UsedLeaves FROM $table WHERE Staff_id = ? AND leave_approval_status = 'PA' AND A_year = ?");

        if (!$query) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $query->bind_param("ii", $staff_id, $a_year);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['UsedLeaves'] ?? 0; // Return the value or 0 if no data
        } else {
            echo "No used leave record for: $staff_id, $table, $a_year<br>"; // Debugging line
        }

        return 0; // Return 0 if no results
    }



    ?>


 <!-- Main Container -->
 <div class="mt-11 flex h-screen">
     <!-- Sidebar -->
     <?php include('../layouts/sidebar.php') ?>

     <!-- Main Content Area with margin for sidebar -->
     <main id="mainContent" class="flex-1 p-8 ml-[20%] overflow-auto">
         <div id="dynamicContent">
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
             </div>
         </div>
     </main>
     <script>
         document.addEventListener("DOMContentLoaded", function() {
             fetchLeaveData();

             async function fetchLeaveData() {
                 try {
                     const response = await fetch('getLeaveData.php');
                     const data = await response.json();

                     // Ensure the data is parsed correctly
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
                         maintainAspectRatio: false,
                         plugins: {
                             title: {
                                 display: true,
                                 text: label
                             }
                         }
                     }
                 });
             }
         });
     </script>
 </div>



 <!-- JavaScript for AJAX and Chart.js -->
 <script>
     function loadContent(page) {
         fetch(`../components/${page}.php`)
             .then(response => response.text())
             .then(data => {
                 document.getElementById('dynamicContent').innerHTML = data;
             })
             .catch(error => console.error('Error loading content:', error));
     }

     document.addEventListener('DOMContentLoaded', function() {
         new Chart(document.getElementById('casualLeaveChart').getContext('2d'), {
             type: 'pie',
             data: {
                 labels: ['Used', 'Remaining'],
                 datasets: [{
                     data: [casualLeaves.used, casualLeaves.remaining],
                     backgroundColor: ['#ff6384', '#36a2eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
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

         document.getElementById('casualTotalLeaves').textContent = casualLeaves.total;
         document.getElementById('casualUsedLeaves').textContent = casualLeaves.used;
         document.getElementById('casualRemainingLeaves').textContent = casualLeaves.remaining;

         new Chart(document.getElementById('dutyLeaveChart').getContext('2d'), {
             type: 'pie',
             data: {
                 labels: ['Used', 'Remaining'],
                 datasets: [{
                     data: [dutyLeaves.used, dutyLeaves.remaining],
                     backgroundColor: ['#ffce56', '#36a2eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
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

         document.getElementById('dutyTotalLeaves').textContent = dutyLeaves.total;
         document.getElementById('dutyUsedLeaves').textContent = dutyLeaves.used;
         document.getElementById('dutyRemainingLeaves').textContent = dutyLeaves.remaining;

         new Chart(document.getElementById('medicalLeaveChart').getContext('2d'), {
             type: 'pie',
             data: {
                 labels: ['Used', 'Remaining'],
                 datasets: [{
                     data: [medicalLeaves.used, medicalLeaves.remaining],
                     backgroundColor: ['#4bc0c0', '#36a2eb']
                 }]
             },
             options: {
                 responsive: true,
                 plugins: {
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

         document.getElementById('medicalTotalLeaves').textContent = medicalLeaves.total;
         document.getElementById('medicalUsedLeaves').textContent = medicalLeaves.used;
         document.getElementById('medicalRemainingLeaves').textContent = medicalLeaves.remaining;
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
    <input type="submit" value="Apply" name="submit"  onclick="off1()"
           class="hover:shadow-form w-full rounded-md bg-[#55a0e7] py-3 px-8 text-center text-base font-semibold text-white outline-none hover:bg-blue-800" />
`;
         } else {
             // Hide the table if no days are specified
             dutyTableContainer.style.display = "none";
         }
     }
 </script>



 <!--MEDICAL-->
 <script>
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