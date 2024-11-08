<?php
// Start the session
session_start();
$staff_id = $_SESSION['Staff_id']; // Use session data for the logged-in staff ID

if (!isset($_SESSION['Staff_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Database connection
include('../../config/connect.php');

// Default query to fetch all leave applications
$query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                 Reason AS reason, Application_date AS application_date, 
                 leave_approval_status, A_year, 'CL' AS leave_type
          FROM d_cl_leave 
          WHERE Staff_id = $staff_id
          UNION ALL
          SELECT From_date, To_date, No_of_days, Nature AS reason, Application_date, 
                 leave_approval_status, A_year, 'DL' AS leave_type 
          FROM d_dl_leave 
          WHERE Staff_id = $staff_id";

// Fetch filtered results if POST request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leave_status = $_POST['leave_status'] ?? '';
    $academic_year = $_POST['academic_year'] ?? '';
    $leave_type = $_POST['leave_type'] ?? '';
    $from_date = $_POST['from_date'] ?? '';

    // Build query with filters
    if ($leave_status) {
        $query .= " AND leave_approval_status = '$leave_status'";
    }
    if ($academic_year) {
        $query .= " AND A_year = '$academic_year'";
    }
    if ($leave_type) {
        $query .= " AND leave_type = '$leave_type'";
    }
    if ($from_date) {
        $query .= " AND From_date >= '$from_date'";
    }
}

// Execute the query
$result = $conn->query($query);
$leave_applications = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leave_applications[] = $row;
    }
}

// Close the database connection
$conn->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode($leave_applications);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #error-message {
            display: none;
            color: red;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-6 p-4 bg-white shadow rounded-lg">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Leave Application Status</h2>

        <!-- Error message -->
        <div id="error-message"></div>

        <!-- Filters Section -->
        <div id="filters" class="mb-6 text-gray-800">
            <label for="leave_status" class="mr-4">Status:</label>
            <select id="leave_status" class="border rounded p-2">
                <option value="">All</option>
                <option value="P">Pending</option>
                <option value="HD">HOD Declined</option>
                <option value="HA">HOD Approved</option>
                <option value="PA">Principal Approved</option>
                <option value="PD">Principal Declined</option>
            </select>

            <label for="academic_year" class="ml-4 mr-4">Academic Year:</label>
            <select id="academic_year" class="border rounded p-2">
                <option value="">All</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>

            <label for="leave_type" class="ml-4 mr-4">Leave Type:</label>
            <select id="leave_type" class="border rounded p-2">
                <option value="">All</option>
                <option value="CL">Casual Leave</option>
                <option value="DL">Duty Leave</option>
            </select>

            <label for="from_date" class="ml-4">From Date:</label>
            <input type="date" id="from_date" class="border rounded p-2">
        </div>

        <!-- Table for Leave Applications -->
        <div class="overflow-x-auto text-gray-800">
            <table class="min-w-full table-auto" id="leave-table">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-left">From Date</th>
                        <th class="py-2 px-4 text-left">To Date</th>
                        <th class="py-2 px-4 text-left">No. of Days</th>
                        <th class="py-2 px-4 text-left">Reason</th>
                        <th class="py-2 px-4 text-left">Application Date</th>
                        <th class="py-2 px-4 text-left">Approval Status</th>
                        <th class="py-2 px-4 text-left">A Year</th>
                        <th class="py-2 px-4 text-left">Leave Type</th>
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
                            <td class="py-2 px-4"><?= htmlspecialchars($row['leave_type']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function applyFilters() {
            const leaveStatus = document.getElementById('leave_status').value;
            const academicYear = document.getElementById('academic_year').value;
            const leaveType = document.getElementById('leave_type').value;
            const fromDate = document.getElementById('from_date').value;

            const data = new URLSearchParams();
            data.append('leave_status', leaveStatus);
            data.append('academic_year', academicYear);
            data.append('leave_type', leaveType);
            data.append('from_date', fromDate);

            fetch(window.location.href, {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Filtered data:', data); // Debug: Check if the server returns the filtered data

                    const tableBody = document.getElementById('leave-table-body');
                    tableBody.innerHTML = '';

                    if (data.length === 0) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td colspan="8" class="py-2 px-4 text-center">No records found</td>`;
                        tableBody.appendChild(tr);
                    } else {
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td class="py-2 px-4">${row.from_date}</td>
                            <td class="py-2 px-4">${row.to_date}</td>
                            <td class="py-2 px-4">${row.no_of_days}</td>
                            <td class="py-2 px-4">${row.reason}</td>
                            <td class="py-2 px-4">${row.application_date}</td>
                            <td class="py-2 px-4">${row.leave_approval_status}</td>
                            <td class="py-2 px-4">${row.A_year}</td>
                            <td class="py-2 px-4">${row.leave_type}</td>
                        `;
                            tableBody.appendChild(tr);
                        });
                    }
                })
                .catch(error => {
                    const errorMessage = document.getElementById('error-message');
                    errorMessage.textContent = 'Error fetching data';
                    errorMessage.style.display = 'block';
                });
        }

        // Attach event listeners to filter inputs
        document.getElementById('leave_status').addEventListener('change', applyFilters);
        document.getElementById('academic_year').addEventListener('change', applyFilters);
        document.getElementById('leave_type').addEventListener('change', applyFilters);
        document.getElementById('from_date').addEventListener('change', applyFilters);
    </script>

</body>

</html>