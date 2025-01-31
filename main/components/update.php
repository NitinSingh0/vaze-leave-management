<?php
session_start();
include('../../config/connect.php');
$staff_query = "SELECT Staff_id, Name FROM staff WHERE Staff_type = 'N'";
$staff_result = $conn->query($staff_query);
$conn->close();
?>

<body class="bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
    <div class="container mt-10 text-gray-900 bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
        <h1 class="text-2xl font-bold mb-5">Update Staff Job Role</h1>

        <!-- Staff Selection Dropdown -->
        <label for="staff_select" class="block text-lg mb-2">Select or Search Staff by Name:</label>
        <select name="staff_id" id="staff_select" class="border p-2 w-full text-gray-900" onchange="fetchDetails(this)">
            <option value="">Select a Staff Member...</option>
            <?php while ($row = $staff_result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['Staff_id']) ?>"><?= htmlspecialchars($row['Name']) ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Staff Details and Job Role Update -->
        <div id="staff_details" class="mt-5 hidden">
            
        </div>

        <!-- No Record Found Message -->
        <p id="no_record" class="mt-5 text-red-500 hidden">No details found for the selected staff member.</p>
    </div>
</body>