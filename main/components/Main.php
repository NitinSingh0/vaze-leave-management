 <?php

    include '../../config/connect.php';  // Database connection file
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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

 </div>



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
     //  function validateDates() {
     //      const dateInputs = document.querySelectorAll(".date-of-duty");
     //      const offDutyInputs = document.querySelectorAll(".off-duty-date");

     //      // Collect values for both date inputs
     //      const dateValues = [...dateInputs].map(input => input.value);
     //      const offDutyValues = [...offDutyInputs].map(input => input.value);

     //      // Check for duplicates in Date of Duty
     //      if (hasDuplicates(dateValues)) {
     //          alert("Each 'Date of Duty' must be unique.");
     //          return false;
     //      }

     //      // Check for duplicates in Off Duty Date
     //      if (hasDuplicates(offDutyValues)) {
     //          alert("Each 'Off Duty Date' must be unique.");
     //          return false;
     //      }

     //      // If no duplicates, proceed with form submission
     //      return true;
     //  }

     //  // Helper function to check for duplicates in an array
     //  function hasDuplicates(array) {
     //      return new Set(array).size !== array.length;
     //  }


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
     //  function setMinToDate() {
     //      const fromDate = document.getElementById("from_date").value;
     //      document.getElementById("to_date").min = fromDate;
     //      calculateDays();
     //  }

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
         var type1 = document.getElementById("LType").value;
         var year1 = document.getElementById("year").value;
         if (type1 === "") {
             alert("Select The Type Of Leave To be Applied !!");
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