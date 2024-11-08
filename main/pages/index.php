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
            var n_dept = document.getElementById('nonteaching-type').value;

            // Alert to check if values are captured correctly
            // alert("Department: " + n_dept);
            if (n_dept === "") {
                alert("Please Select the Values");

            } else {
                // Get the values 
                $.ajax({
                    url: "../components/active/table.php",
                    type: "POST",
                    cache: false,
                    data: {

                        ndept: n_dept
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

            if (username.length > 0) {

                $.ajax({
                    url: "../pages/check_username.php", // PHP file to check username
                    method: "POST",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response === "exists") {
                            warning.classList.remove("hidden"); // Show warning if username exists
                        } else {
                            warning.classList.add("hidden"); // Hide warning if username is available
                        }
                    }
                });
            } else {
                warning.classList.add("hidden"); // Hide warning if input is empty
            }
        }
    </script>


    <!--Deactivae/ activate-->

</body>
<?php include('../../library/AOS.php'); ?>

</html>