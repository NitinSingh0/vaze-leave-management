<?php
session_start();

// Database connection
include('../../config/connect.php');

// Fetch CL, DL, and Medical leave records for the logged-in staff
if (!isset($_SESSION['Staff_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['Staff_id'];

// Query for Casual Leave (CL) records
$cl_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                    Reason AS reason, Date_of_application AS Date_of_application, 
                    leave_approval_status, A_year 
             FROM d_cl_leave 
             WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";
$cl_result = $conn->query($cl_query);
if (!$cl_result) {
    die("CL Query failed: " . $conn->error);
}

// Query for Duty Leave (DL) records
$dl_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                    Nature AS reason, Date_of_application AS Date_of_application, 
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
                         Reason AS reason, Date_of_application AS Date_of_application, 
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
                    <?php if ($cl_result->num_rows > 0): ?>
                        <?php while ($row = $cl_result->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-2 px-4 text-center">No Casual Leave Records Found</td>
                        </tr>
                    <?php endif; ?>
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
                    <?php if ($dl_result->num_rows > 0): ?>
                        <?php while ($row = $dl_result->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['reference_no']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['date_of_letter']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="py-2 px-4 text-center">No Duty Leave Records Found</td>
                        </tr>
                    <?php endif; ?>
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
                    <?php if ($medical_result->num_rows > 0): ?>
                        <?php while ($row = $medical_result->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-2 px-4 text-center">No Medical Leave Records Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>