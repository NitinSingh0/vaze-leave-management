<?php
session_start();
include('../../config/connect.php');

// Check for AJAX request to fetch staff details
if (isset($_POST['fetch_staff_details']) && isset($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];
    $details_query = "SELECT Staff_id, Name, Email, Job_role FROM staff WHERE Staff_id = ? AND Staff_type = 'N'";
    $stmt = $conn->prepare($details_query);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $staff_details = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Log response for debugging
    if ($staff_details) {
        echo json_encode($staff_details);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
    exit();
}

// Check for AJAX request to update the job role
if (isset($_POST['update_job_role']) && isset($_POST['staff_id']) && isset($_POST['job_role'])) {
    $staff_id = $_POST['staff_id'];
    $new_role = $_POST['job_role'];

    $update_query = "UPDATE staff SET Job_role = ? WHERE Staff_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_role, $staff_id);
    $success = $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => $success]);
    exit();
}

// Fetch all non-teaching staff for the dropdown
$staff_query = "SELECT Staff_id, Name FROM staff WHERE Staff_type = 'N'";
$staff_result = $conn->query($staff_query);
$conn->close();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    alert("JavaScript is running!");
    console.log("Testing inline jQuery...");
</script>

<body class="bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
    <div class="container  mt-10 text-gray-900 bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
        <h1 class="text-2xl font-bold mb-5">Update Staff Job Role</h1>

        <!-- Staff Selection Dropdown -->
        <label for="staff_select" class="block text-lg mb-2">Select or Search Staff by Name:</label>
        <select name="staff_id" id="staff_select" class="border p-2 w-full text-gray-900">
            <option value="">Select a Staff Member...</option>
            <?php while ($row = $staff_result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['Staff_id']) ?>"><?= htmlspecialchars($row['Name']) ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Staff Details and Job Role Update -->
        <div id="staff_details" class="mt-5 hidden">
            <h2 class="text-xl font-semibold mb-4">Staff Details</h2>
            <form id="update_role_form">
                <input type="hidden" name="staff_id" id="staff_id">

                <!-- Display staff details here -->
                <div class="mb-4">
                    <label class="block text-lg font-medium">Name:</label>
                    <p class="text-gray-700" id="staff_name"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-lg font-medium">Email:</label>
                    <p class="text-gray-700" id="staff_email"></p>
                </div>

                <div class="mb-4">
                    <label for="job_role" class="block text-lg font-medium">Job Role:</label>
                    <select name="job_role" id="job_role" class="border p-2 w-full">
                        <option value="NO">NO</option>
                        <option value="NL">NL</option>
                        <option value="OO">OO</option>
                    </select>
                </div>

                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Update Job Role</button>
            </form>
        </div>

        <!-- No Record Found Message -->
        <p id="no_record" class="mt-5 text-red-500 hidden">No details found for the selected staff member.</p>
    </div>

    <script>
        // Check if jQuery is loaded
        if (typeof jQuery !== 'undefined') {
            console.log("jQuery loaded successfully.");
        } else {
            console.error("jQuery failed to load.");
        }

        $(document).ready(function() {
            alert("Hello! Script is working.");

            // Fetch staff details when a staff member is selected
            $('#staff_select').on('change', function() {
                const staff_id = $(this).val();
                console.log("Selected staff_id:", staff_id);

                if (staff_id) {
                    $.ajax({
                        url: location.href,
                        type: 'POST',
                        data: {
                            fetch_staff_details: true,
                            staff_id: staff_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response && !response.error) {
                                $('#staff_id').val(response.Staff_id);
                                $('#staff_name').text(response.Name);
                                $('#staff_email').text(response.Email);
                                $('#job_role').val(response.Job_role);
                                $('#staff_details').removeClass('hidden');
                                $('#no_record').addClass('hidden');
                                console.log("Staff details:", response);
                            } else {
                                $('#staff_details').addClass('hidden');
                                $('#no_record').removeClass('hidden');
                                console.log("No record found for selected staff.");
                            }
                        },
                        error: function() {
                            console.error('Error fetching staff details.');
                        }
                    });
                } else {
                    $('#staff_details').addClass('hidden');
                    $('#no_record').addClass('hidden');
                }
            });

            // Handle job role update
            $('#update_role_form').on('submit', function(e) {
                e.preventDefault();
                const staff_id = $('#staff_id').val();
                const job_role = $('#job_role').val();

                $.ajax({
                    url: location.href,
                    type: 'POST',
                    data: {
                        update_job_role: true,
                        staff_id: staff_id,
                        job_role: job_role
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Job role updated successfully!');
                        } else {
                            alert('Error updating job role.');
                        }
                    },
                    error: function() {
                        console.error('Error updating job role.');
                    }
                });
            });
        });
    </script>
</body>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        alert("jQuery is working in a minimal setup");
    });
</script> -->