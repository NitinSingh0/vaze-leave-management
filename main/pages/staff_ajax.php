<?php
session_start();
include('../../config/connect.php');

if (isset($_POST['Staff'])) {
    // Fetch Staff Details
    $staff_id = $_POST['Staff'];
    $details_query = "SELECT Staff_id, Name, Username Email, Job_role FROM staff WHERE Staff_id = ? AND Staff_type = 'N'";
    $stmt = $conn->prepare($details_query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $staff_details = $result->fetch_assoc()) {
        echo '
            <h2 class="text-xl font-semibold mb-4">Staff Details</h2>
            <form id="update_role_form">
                <input type="hidden" name="staff_id" id="staff_id" value="' . htmlspecialchars($staff_details['Staff_id']) . '">

                <div class="mb-4">
                    <label class="block text-lg font-medium">Name:</label>
                    <p class="text-gray-700" id="staff_name">' . htmlspecialchars($staff_details['Name']) . '</p>
                </div>

                <div class="mb-4">
                    <label class="block text-lg font-medium">Email:</label>
                    <p class="text-gray-700" id="staff_email">' . htmlspecialchars($staff_details['Email']) . '</p>
                </div>

                <div class="mb-4">
                    <label for="job_role" class="block text-lg font-medium">Job Role:</label>
                    <select name="job_role" id="job_role" class="border p-2 w-full">
                        <option value="NO" ' . ($staff_details['Job_role'] == 'NO' ? 'selected' : '') . '>Non Taeching Office</option>
                        <option value="NL" ' . ($staff_details['Job_role'] == 'NL' ? 'selected' : '') . '>Non Teaching Lab</option>
                        <option value="OO" ' . ($staff_details['Job_role'] == 'OO' ? 'selected' : '') . '>Office Operator</option>
                    </select>
                </div>

                <button  class="bg-green-500 text-white py-2 px-4 rounded" onclick="updateDetail()">Update Job Role</button>
            </form>
        ';
    } else {
        echo '<tr class="text-center"><td colspan="4">No Data found</td></tr>';
    }
}

if (isset($_POST['staff_id']) && isset($_POST['job_role'])) {
    // Update Job Role
    $staff_id = $_POST['staff_id'];
    $new_role = $_POST['job_role'];

    $update_query = "UPDATE staff SET Job_role = ? WHERE Staff_id = ?";
    $stmt = $conn->prepare($update_query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("si", $new_role, $staff_id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        echo json_encode(['success' => true, 'new_role' => $new_role]);
    } else {
        echo json_encode(['error' => 'Failed to update job role']);
    }
    exit();
}

$conn->close();
?>