 <?php
    error_reporting(0);

    ?>
 <!-- Main Container -->
 <div class="mt-11 flex h-screen">
     <!-- Sidebar -->
     <?php include('../layouts/sidebar.php') ?>

     <!-- Main Content Area with margin for sidebar -->
     <main id="mainContent" class="flex-1 p-8 ml-[20%] overflow-auto">
         <!-- Placeholder for dynamic content (Charts or other data will load here) -->
         <div id="dynamicContent">
             <!-- Responsive Grid for Leave Statistics -->
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                 <!-- Casual Leave Chart -->
                 <div class="bg-white p-6 rounded-lg shadow-lg">
                     <h2 class="text-xl font-semibold text-gray-700 mb-4">Casual Leave</h2>
                     <canvas id="casualLeaveChart"></canvas>
                     <div class="mt-4">
                         <p class="text-gray-600">Total Leaves: <span id="casualTotalLeaves"></span></p>
                         <p class="text-gray-600">Used Leaves: <span id="casualUsedLeaves"></span></p>
                         <p class="text-gray-600">Remaining Leaves: <span id="casualRemainingLeaves"></span></p>
                     </div>
                 </div>

                 <!-- Duty Leave Chart -->
                 <div class="bg-white p-6 rounded-lg shadow-lg">
                     <h2 class="text-xl font-semibold text-gray-700 mb-4">Duty Leave</h2>
                     <canvas id="dutyLeaveChart"></canvas>
                     <div class="mt-4">
                         <p class="text-gray-600">Total Leaves: <span id="dutyTotalLeaves"></span></p>
                         <p class="text-gray-600">Used Leaves: <span id="dutyUsedLeaves"></span></p>
                         <p class="text-gray-600">Remaining Leaves: <span id="dutyRemainingLeaves"></span></p>
                     </div>
                 </div>

                 <!-- Medical/Half-Pay Leave Chart -->
                 <div class="bg-white p-6 rounded-lg shadow-lg">
                     <h2 class="text-xl font-semibold text-gray-700 mb-4">Medical/Half-Pay Leave</h2>
                     <canvas id="medicalLeaveChart"></canvas>
                     <div class="mt-4">
                         <p class="text-gray-600">Total Leaves: <span id="medicalTotalLeaves"></span></p>
                         <p class="text-gray-600">Used Leaves: <span id="medicalUsedLeaves"></span></p>
                         <p class="text-gray-600">Remaining Leaves: <span id="medicalRemainingLeaves"></span></p>
                     </div>
                 </div>
             </div>
         </div>
     </main>
 </div>

 <!-- PHP Leave Data -->
 <?php
    // Sample job role for demonstration purposes
    $jobRole = $_SESSION['job_role']; // Assume job_role is stored in session

    $casualLeavesTotal = 12;
    $casualLeavesUsed = 5;
    $casualLeavesRemaining = $casualLeavesTotal - $casualLeavesUsed;

    $dutyLeavesTotal = 10;
    $dutyLeavesUsed = 3;
    $dutyLeavesRemaining = $dutyLeavesTotal - $dutyLeavesUsed;

    $medicalLeavesTotal = 8;
    $medicalLeavesUsed = 2;
    $medicalLeavesRemaining = $medicalLeavesTotal - $medicalLeavesUsed;

    echo "<script>
    const casualLeaves = { total: $casualLeavesTotal, used: $casualLeavesUsed, remaining: $casualLeavesRemaining };
    const dutyLeaves = { total: $dutyLeavesTotal, used: $dutyLeavesUsed, remaining: $dutyLeavesRemaining };
    const medicalLeaves = { total: $medicalLeavesTotal, used: $medicalLeavesUsed, remaining: $medicalLeavesRemaining };
</script>";
    ?>

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