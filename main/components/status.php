<?php
session_start();
$_SESSION['staff_id'] = 123; // Example staff_id; replace with actual session data

// Database connection
include('../../config/connect.php');

// Fetch all leave applications initially
$staff_id = $_SESSION['staff_id'];
$status_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                        Reason AS reason, Application_date AS application_date, 
                        leave_approval_status, A_year 
                 FROM d_cl_leave, d_dl_leave 
                 WHERE Staff_id = $staff_id";

$status_result = $conn->query($status_query);
$leave_applications = [];
if ($status_result) {
    while ($row = $status_result->fetch_assoc()) {
        $leave_applications[] = $row;
    }
}

$conn->close();
?>

<div class="container mx-auto text-black">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Leave Application Status</h2>

    <!-- Filter Form -->
    <form id="filter-form" class="mb-4">
        <label for="leave_status" class="mr-2">Filter by Status:</label>
        <select name="leave_status" id="leave_status" class="border border-gray-300 rounded p-2">
            <option value="">All Applications</option>
            <option value="P">Pending</option>
            <option value="HD">HOD Declined</option>
            <option value="HA">HOD Approved</option>
            <option value="PA">Principal Approved</option>
            <option value="PD">Principal Declined</option>
        </select>
        <button type="submit" class="ml-2 bg-blue-500 text-white rounded px-4 py-2">Filter</button>
    </form>

    <!-- Leave Applications Table -->
    <div class="overflow-y-scroll bg-white shadow rounded-lg p-4">
        <table class="min-w-full bg-white" id="leave-table">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">From Date</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">To Date</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">No. of Days</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Reason</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Application Date</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Approval Status</th>
                    <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">A Year</th>
                </tr>
            </thead>
            <tbody id="leave-table-body">
                <?php foreach ($leave_applications as $row): ?>
                    <tr>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['application_date']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way

        const leaveStatus = document.getElementById('leave_status').value;

        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'filter_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the leave status filter
        xhr.send('leave_status=' + leaveStatus);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const leaveApplications = JSON.parse(xhr.responseText);
                const tableBody = document.getElementById('leave-table-body');
                tableBody.innerHTML = ''; // Clear existing table body

                // Populate the table with new data
                leaveApplications.forEach(function(row) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td class="py-2 px-4">${row.from_date}</td>
                    <td class="py-2 px-4">${row.to_date}</td>
                    <td class="py-2 px-4">${row.no_of_days}</td>
                    <td class="py-2 px-4">${row.reason}</td>
                    <td class="py-2 px-4">${row.application_date}</td>
                    <td class="py-2 px-4">${row.leave_approval_status}</td>
                    <td class="py-2 px-4">${row.A_year}</td>
                `;
                    tableBody.appendChild(tr);
                });
            } else {
                console.error('Error fetching data: ' + xhr.statusText);
            }
        };
    });
</script>