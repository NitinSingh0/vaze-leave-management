<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-gray-100">
    <?php include("../../../config/connect.php"); ?>

    <div class=" bg-white border rounded-lg px-8 py-6 mx-auto my-8 max-w-4xl">
        <h1 class="text-2xl font-bold text-center mb-6 dark:text-black">Deactivate Staff</h1>
        <!-- Tabs -->
        <div class="flex border-b">
            <button id="teaching-tab" class="px-4 py-2 text-blue-500 font-semibold focus:outline-none border-b-2 border-blue-500">Teaching</button>
            <button id="nonteaching-tab" class="px-4 py-2 text-gray-500 font-semibold focus:outline-none border-b-2 border-transparent hover:text-blue-500">Non-Teaching</button>
        </div>

        <!-- Teaching Section -->
        <div id="teaching-section" class="mt-6">
            <div class="flex space-x-4 mb-4">
                <!-- Type Selection -->
                <div class="dark:text-black">
                    <label for="teaching-type" class="block text-gray-700 p-2">Type</label>
                    <select id="teaching_type" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="" selected disabled>Select Type</option>
                        <option value="D">Degree</option>
                        <option value="J">Junior</option>
                    </select>
                </div>
                <!-- Department Selection -->
                <div class="dark:text-black">
                    <label for="teaching-department" class="block text-gray-700 p-2">Department</label>
                    <select id="teaching_department" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="" selected disabled>Select a Department</option>

                    </select>
                </div>
            </div>
            <div>
                <button type="button" id="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 hover:translate-y-[200px]">Show</button>
            </div>
            <br>
            <!-- Table -->
            <div id="teaching-table" class="hidden overflow-x-auto">
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
            </div>



        </div>

        <!-- Non-Teaching Section -->
        <div id="nonteaching-section" class="mt-6 hidden">
            <div class="flex space-x-4 mb-4">
                <!-- Type Selection -->
                <div>
                    <label for="nonteaching-type" class="block text-gray-700 p-2">Type</label>
                    <select id="nonteaching-type" class=" w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="" selected disabled>Select Type</option>
                        <?php
                        $query = "SELECT * FROM `department` WHERE College IN ('L','O')";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['D_id'] . '"> ' . ($row["College"] === 'L' ? 'Labratory' : 'Office') . '</option>';
                            }
                        } else {
                            echo '<option value="" selected disabled>No Type</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Department Selection -->
                <div>
                    <label for="nonteaching-department" class="block text-gray-700 p-2">Department</label>
                    <select id="nonteaching-department" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="" selected disabled>Office Labratory</option>

                    </select>
                </div>
            </div>
            <div>
                <button type="button" id="submit2" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 hover:translate-y-[200px]">Show</button>
            </div>
            <br>
            <!-- Table -->
            <div id="nonteaching-table" class="hidden overflow-x-auto">
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
            </div>
        </div>
    </div>

    <script>
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


        // Reason Textarea onchange Professor ajax
        $("#teaching_type").on("change", function() {
            //var t_dept = document.getElementById('teaching_department').value;
            var t_type = this.value;

            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            // alert("Type: " + t_type);
            document.getElementById(`teaching-table`).classList.add("hidden");
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

        $("#submit").on("click", function() {
            var t_dept = document.getElementById('teaching_department').value;
            var t_type = document.getElementById('teaching_type').value;

            // Alert to check if values are captured correctly
            // alert("Department: " + t_dept);
            if (t_dept === "" || t_type === "") {
                alert("Please Select the Values");

            } else {
                // Get the values 
                $.ajax({
                    url: "table.php",
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

        });


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
                    url: "update_status.php", // URL for status update
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


        $("#submit2").on("click", function() {
            var n_dept = document.getElementById('nonteaching-type').value;

            // Alert to check if values are captured correctly
            // alert("Department: " + n_dept);
            if (n_dept === "") {
                alert("Please Select the Values");

            } else {
                // Get the values 
                $.ajax({
                    url: "table.php",
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

        });




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
                    url: "update_status.php", // URL for status update
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
</body>

</html>