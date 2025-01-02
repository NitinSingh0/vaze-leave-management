<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Leave Management Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vaze Leave Management</title>
    <link rel="stylesheet" href="./output.css">
    <?php include('../../library/library.php'); ?>
    <!-- <link rel="stylesheet" href="" /> -->


</head>

<body class="bg-white dark:bg-gray-100 text-white">
    <?php include('../layouts/header.php'); ?>

    <?php include('../components/Main.php'); ?>
    <?php include('../layouts/footer.php'); ?>


    <!--Activate Deactivate-->
    <script>
        function click2() {
            //alert("d");
            const teachingTab = document.getElementById('teaching-tab');
            const nonTeachingTab = document.getElementById('nonteaching-tab');
            const teachingSection = document.getElementById('teaching-section');
            const nonTeachingSection = document.getElementById('nonteaching-section');
            nonTeachingSection.classList.remove('hidden');
            teachingSection.classList.add('hidden');
            nonTeachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            teachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');
            teachingTab.classList.add('text-gray-500');


        }

        function click1() {
            //alert("d");
            // Toggle Tabs

            const teachingTab = document.getElementById('teaching-tab');
            const nonTeachingTab = document.getElementById('nonteaching-tab');
            const teachingSection = document.getElementById('teaching-section');
            const nonTeachingSection = document.getElementById('nonteaching-section');
            teachingSection.classList.remove('hidden');
            nonTeachingSection.classList.add('hidden');
            teachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            nonTeachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');

        }



        function change1(a) {
            const t_type = a.value;
            document.getElementById('teaching-table').classList.add('hidden');
            //var t_dept = document.getElementById('teaching_department').value;


            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            //alert("Type: " + t_type);
            // document.getElementById(`teaching-table`).classList.add("hidden");
            // Get the values of the selected department and type
            $.ajax({
                url: "../components/active/dept_filter.php",
                type: "POST",
                cache: false,
                data: {
                    type: t_type
                },
                success: function(data) {
                    $("#teaching_department").html(data);
                }
            });

        }

        function table1() {
            var t_dept = document.getElementById('teaching_department').value;
            var t_type = document.getElementById('teaching_type').value;

            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            if (t_dept === "" || t_type === "") {
                alert("Please Select the Values");

            } else {
                // Get the values 
                $.ajax({
                    url: "../components/active/table.php",
                    type: "POST",
                    cache: false,
                    data: {

                        dept: t_dept
                    },
                    success: function(data) {
                        $("#teaching-staff-list").html(data);
                    }
                });
                document.getElementById(`teaching-table`).classList.remove("hidden");
            }


        }


        // Using event delegation for dynamically added elements
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('toggle-status')) {
                e.preventDefault(); // Prevents anchor default navigation

                // Get the staff ID from data attribute
                const staffId = e.target.getAttribute('data-staff-id');
                const newStatus = e.target.getAttribute('data-new-status');


                // alert("staff_id: " + staffId);
                //  alert("newstatus: " + newStatus);


                // Send AJAX request to update the status

                $.ajax({
                    url: "../components/active/update_status.php", // URL for status update
                    type: "POST",
                    data: {
                        staff_id: staffId,
                        status: newStatus
                        // other data as required
                    },
                    success: function(response) {
                        // Update the UI or handle the response
                        alert("Status updated!");
                        $('#submit').trigger('click');
                    },
                    error: function() {
                        alert("Error updating status.");
                    }
                });

            }
        });


        function table2() {
            var n_type = document.getElementById('nonteaching-type').value;

            // Alert to check if values are captured correctly
            // alert("Department: " + n_dept);
            if (n_type === "") {
                alert("Please Select the Values");

            } else {
                // Get the values 
                $.ajax({
                    url: "../components/active/table.php",
                    type: "POST",
                    cache: false,
                    data: {

                        ntype: n_type
                    },
                    success: function(data) {
                        $("#nonteaching-staff-list").html(data);
                    }
                });
                document.getElementById(`nonteaching-table`).classList.remove("hidden");
            }


        }


        // Using event delegation for dynamically added elements
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('toggle-status2')) {
                e.preventDefault(); // Prevents anchor default navigation

                // Get the staff ID from data attribute
                const staffId = e.target.getAttribute('data-staff-id');
                const newStatus = e.target.getAttribute('data-new-status');


                // alert("staff_id: " + staffId);
                //  alert("newstatus: " + newStatus);


                // Send AJAX request to update the status

                $.ajax({
                    url: "../components/active/update_status.php", // URL for status update
                    type: "POST",
                    data: {
                        staff_id: staffId,
                        status: newStatus
                        // other data as required
                    },
                    success: function(response) {
                        // Update the UI or handle the response
                        alert("Status updated!");
                        $('#submit2').trigger('click');
                    },
                    error: function() {
                        alert("Error updating status.");
                    }
                });

            }
        });
    </script>



    <!-- New Registration ajax for username -->
    <script>
        function change(a) {
            //alert(a.value);
            const username = a.value;
            const warning = document.getElementById("usernameWarning");
            const submitBtn = document.getElementById('submitbtn');


            if (username.length > 0) {

                $.ajax({
                    url: "../components/registration/check_username.php", // PHP file to check username
                    method: "POST",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response === "exists") {
                            warning.classList.remove("hidden");
                            submitBtn.disabled = true; // Disable submit button
                            // Show warning if username exists
                        } else {
                            warning.classList.add("hidden"); // Hide warning if username is available
                            submitBtn.disabled = false; // Enable submit button
                        }
                    }
                });
            } else {
                warning.classList.add("hidden"); // Hide warning if input is empty
                submitBtn.disabled = false; // Enable submit button
            }
        }


        //DL Submit function prevenydefault to send data only pnce using ajax

        function d1() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);

                    // Log form data to console
                    console.log("Form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    // Send AJAX request
                    $.ajax({
                        url: "../components/Apply/dl.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                loadContent('dl');
                            } else {
                                alert(response.message); // Show error message if any
                                // loadContent('dl');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

            // Manually trigger form submission for demonstration purposes if needed
            form.submit();
        }


        //CL Submit function prevenydefault to send data only pnce using ajax

        function c1() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID2");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);
                    // Log form data to console
                    console.log("Form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }

                    // Send AJAX request
                    $.ajax({
                        url: "../components/Apply/Cl.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                loadContent('cl');
                            } else {
                                alert(response.message); // Show error message if any
                                //loadContent('cl');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

            // Manually trigger form submission for demonstration purposes if needed
            form.submit();
        }


        //OFF PAY Submit function prevenydefault to send data only pnce using ajax

        function off1() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID3");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);

                    // Send AJAX request
                    $.ajax({
                        url: "../components/Apply/offPay.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                loadContent('APPLY_OFF_PAY');
                            } else {
                                alert(response.message); // Show error message if any
                                loadContent('APPLY_OFF_PAY');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

            // Manually trigger form submission for demonstration purposes if needed
            form.submit();
        }

        //EMHM Submit function prevenydefault to send data only pnce using ajax
        function emhm() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID4");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);

                    // Send AJAX request
                    $.ajax({
                        url: "../components/Apply/emhm.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                loadContent('medical');
                            } else {
                                alert(response.message); // Show error message if any
                                //loadContent('medical');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

            // Manually trigger form submission for demonstration purposes if needed
            form.submit();
        }


        //NEW STAFF REGISTRATION Submit function prevenydefault to send data only pnce using ajax
        function reg1() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID5");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);
                    console.log(formData);

                    // Send AJAX request
                    $.ajax({
                        url: "../components/registration/register.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                loadContent('registration');
                            } else {
                                alert(response.message); // Show error message if any
                                //loadContent('registration');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

            // Manually trigger form submission for demonstration purposes if needed
            //form.submit();
        }





        /*function d1() {
            console.log("outer");
            document.getElementById("yourFormID").addEventListener("submit", function(event) {
                console.log("inner");
                event.preventDefault(); // Prevent the default form submission
                let form1 = document.getElementById("yourFormID")
                let formData = new FormData(form1);
                //alert(form1);
                // Send AJAX request
                $.ajax({
                    url: "Apply/dl.php", // Update with your correct path to dl.php
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Let browser set the correct content type
                    dataType: 'json', // Expect a JSON response
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message); // Show success message
                        } else {
                            alert(response.message); // Show error message if any
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX Error: " + status + " " + error);
                    }
                });
            });
        }*/
    </script>

    <!--New Registration Type Based Department Population-->

    <script>
        function newreg(a) {
            // alert("h");
            var reg_type = a.value;
            $.ajax({
                url: "../components/registration/get_dept.php",
                type: "POST",
                cache: false,
                data: {
                    type: reg_type
                },
                success: function(data) {
                    $("#reg_department").html(data);
                }
            });
        }


        //DL From_Date To_Date Calculation based on total duty and used duty

        function setMinToDate() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date");
            toDate.min = fromDate;

            // fetchLeaveData();

            // // Enable date field if From_Date is provided, otherwise disable it
            // toDate.disabled = fromDate === '';

            // // Make the date field required if From_Date is provided
            // toDate.required = fromDate !== '';

            // async function fetchLeaveData() {
            //     try {
            //         const response = await fetch('../components/Pending/dl.php');
            //         const data = await response.json();

            //         console.log(data); // Log the data to verify
            //         const dutyUsed = Number(data.duty.used);
            //         const dutyRemaining = Number(data.duty.total) - dutyUsed;
            //         console.log(dutyRemaining);

            //         if (dutyRemaining > 0) {
            //             const fromDateObj = new Date(fromDate);
            //             const maxDateObj = new Date(fromDateObj);
            //             maxDateObj.setDate(fromDateObj.getDate() + dutyRemaining - 1);

            //             // Format the date as yyyy-mm-dd
            //             const maxDate = maxDateObj.toISOString().split("T")[0];

            //             // Set the max value for to_date
            //             document.getElementById("to_date").max = maxDate;
            //             console.log(`Max Date: ${maxDate}`);
            //         } else {
            //             // Show alert if no duty leave is left
            //             alert("No duty leave left!");

            //             // Ensure to_date is not disabled
            //             toDate.disabled = true;

            //             // Remove any restrictions on max date
            //             document.getElementById("to_date").max = "";
            //         }

            //     } catch (error) {
            //         console.error("Error fetching leave data:", error);
            //     }
            // }

            calculateDays();
        }

        //CL From_Date To_Date Calculation based on total duty and used duty


        function setMinToDate2() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date");
            toDate.min = fromDate;

            fetchLeaveData();

            // Enable date field if From_Date is provided, otherwise disable it
            toDate.disabled = fromDate === '';

            // Make the date field required if From_Date is provided
            toDate.required = fromDate !== '';

            async function fetchLeaveData() {
                try {
                    const response = await fetch('../components/Pending/cl.php');
                    const data = await response.json();

                    console.log(data); // Log the data to verify
                    const dutyUsed = Number(data.duty.used);
                    const dutyRemaining = Number(data.duty.total) - dutyUsed;
                    console.log(dutyRemaining);

                    if (dutyRemaining > 0) {
                        const fromDateObj = new Date(fromDate);
                        const maxDateObj = new Date(fromDateObj);

                        // Set the max date to either the remaining leave days or 3 days, whichever is smaller
                        const maxDays = Math.min(dutyRemaining, 3);
                        maxDateObj.setDate(fromDateObj.getDate() + maxDays - 1);
                        
                        // maxDateObj.setDate(fromDateObj.getDate() + dutyRemaining - 1);

                        // Format the date as yyyy-mm-dd
                        const maxDate = maxDateObj.toISOString().split("T")[0];

                        // Set the max value for to_date
                        document.getElementById("to_date").max = maxDate;
                        console.log(`Max Date: ${maxDate}`);
                    } else {
                        // Show alert if no duty leave is left
                        alert("No duty leave left!");

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
    </script>


    <!--Deactivae/ activate-->

    <!-- Update details -->
    <script>
        function fetchDetails(selectElement) {
            alert("okk");
            const staffId = selectElement.value;
            const staffDetails = document.getElementById("staff_details");
            const noRecordMessage = document.getElementById("no_record");
            const staffIdInput = document.getElementById("staff_id");
            const staffName = document.getElementById("staff_name");
            const staffEmail = document.getElementById("staff_email");
            const jobRoleSelect = document.getElementById("job_role");


            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            if (staffId) {

                // Get the values 
                $.ajax({
                    url: "staff_ajax.php",
                    type: "POST",
                    cache: false,
                    data: {

                        Staff: staffId
                    },
                    success: function(data) {
                        $("#staff_details").html(data);
                    }
                });
                staffDetails.classList.remove("hidden");
            }


        }

        function updateDetail() {
            // Prevent form submission behavior and handle AJAX submission manually
            const staffId = $("#staff_id").val();
            const jobRole = $("#job_role").val();

            $.ajax({
                url: "staff_ajax.php",
                type: "POST",
                data: {
                    staff_id: staffId,
                    job_role: jobRole
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert('Job role updated successfully');
                        $("#staff_details").html(''); // Clear the form contents
                        $("#staff_select").val("");
                    } else {
                        alert('Failed to update job role');
                    }
                },
                error: function() {
                    alert('An error occurred while updating the job role.');
                }
            });
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
<?php include('../../library/AOS.php'); ?>

</html>