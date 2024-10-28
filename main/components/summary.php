<?php
session_start();
$_SESSION['staff_id'] = 123; // Example staff_id; replace with actual session data

// Database connection
include('../../config/connect.php');

// Fetch CL, DL, and Medical leave records for the logged-in staff
$staff_id = $_SESSION['staff_id'];

// Query for Casual Leave (CL) records
$cl_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                    Reason AS reason, Application_date AS application_date, 
                    leave_approval_status, A_year 
             FROM d_cl_leave 
             WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";
$cl_result = $conn->query($cl_query);

                    // Query for Duty Leave (DL) records
                    $dl_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                    Nature AS reason, Application_date AS application_date, 
                    Reference_no AS reference_no, Date_of_letter AS date_of_letter,
                    leave_approval_status, A_year 
             FROM d_dl_leave 
             WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";

                    $dl_result = $conn->query($dl_query);
                    if (!$dl_result) {
                        die("DL Query failed: " . $conn->error);
                    }

                    // Query for Medical Leave records
                    $medical_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                         Reason AS reason, Date_of_application AS application_date, 
                         leave_approval_status, A_year 
                  FROM d_mhm_leave 
                  WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";

                    $medical_result = $conn->query($medical_query);
                    if (!$medical_result) {
                        die("Medical Query failed: " . $conn->error);
                    }


$conn->close();
?>

<div class="container mx-auto text-black">

    <!-- Casual Leave Table -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Casual Leave Records</h2>
        <div class="overflow-y-scroll max-h-64 bg-white shadow rounded-lg p-4">
            <table class="min-w-full bg-white">
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
                <tbody>
                    <?php while ($row = $cl_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['application_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Duty Leave Table -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Duty Leave Records</h2>
        <div class="overflow-y-scroll max-h-64 bg-white shadow rounded-lg p-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">From Date</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">To Date</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">No. of Days</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Reason</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Application Date</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Reference No.</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Date of Letter</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Approval Status</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">A Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $dl_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['application_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['reference_no']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['date_of_letter']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Medical Leave Table -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Medical Leave Records</h2>
        <div class="overflow-y-scroll max-h-64 bg-white shadow rounded-lg p-4">
            <table class="min-w-full bg-white">
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
                <tbody>
                    <?php while ($row = $medical_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['application_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>