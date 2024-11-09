<?php
session_start();

// Database connection
include('../../config/connect.php');

// Check if Staff_id is set in the session
if (!isset($_SESSION['Staff_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['Staff_id'];

// Fetch the department (D_id) of the logged-in staff
$department_query = "SELECT D_id FROM staff WHERE Staff_id = $staff_id";
$department_result = $conn->query($department_query);
if (!$department_result) {
    die("Department Query failed: " . $conn->error);
}

$department = $department_result->fetch_assoc();
$D_id = $department['D_id'];

// Fetch the department (D_id) of the logged-in staff
$college_query = "SELECT College FROM department WHERE D_id = $D_id";
$college_result = $conn->query($college_query);
if (!$college_result) {
    die("College Query failed: " . $conn->error);
}

$college = $college_result->fetch_assoc();
$College = $college['College'];

// Initialize the leave query based on the department
if ($College == 'J') {
    // Junior Staff - Fetch from Junior leave tables
    $leave_tables = [
        'j_cl_leave' => 'Casual Leave',
        'j_dl_leave' => 'Duty Leave',
        'j_ehm_leave' => 'Medical Leave'
    ];
} elseif ($College == 'D') {
    // Degree Staff - Check if the department is "office_lab"
    $office_query = "SELECT Name FROM department WHERE D_id = $D_id";
    $office_result = $conn->query($office_query);
    if (!$office_result) {
        die("Office Query failed: " . $conn->error);
    }

    $office = $office_result->fetch_assoc();
    if ($office['Name'] == 'office_lab') {
        // Non-Teaching Leave tables
        $leave_tables = [
            'n_cl_leave' => 'Casual Leave',
            'n_dl_leave' => 'Duty Leave',
            'n_emhm_leave' => 'Medical Leave',
            'n_off_pay_leave' => 'Off Pay Leave'
        ];
    } else {
        // Degree Staff - Normal Department
        $leave_tables = [
            'd_cl_leave' => 'Casual Leave',
            'd_dl_leave' => 'Duty Leave',
            'd_mhm_leave' => 'Medical Leave'
        ];
    }
} else {
    die("Invalid department or user not found.");
}

// Initialize result arrays
$leave_records = [];

foreach ($leave_tables as $table => $type) {
    // Query for each leave type (Casual Leave, Duty Leave, etc.)
    if ($table == 'd_dl_leave' || $table == 'j_dl_leave' || $table == 'n_dl_leave') {
        // For Duty Leave, replace 'Reason' with 'Nature'
        $query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                         Nature AS reason, Date_of_application AS Date_of_application, 
                         leave_approval_status, A_year 
                  FROM $table 
                  WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";
    } elseif ($table == 'n_off_pay_leave') {
        // For Off Pay Leave, update columns to match the new structure
        $query = "SELECT Date_of_application AS Date_of_application, Extra_duty_date, Nature_of_work, Off_leave_date,
                         leave_approval_status 
                  FROM $table 
                  WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";
    } else {
        // For all other leave types, no change
        $query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                         Reason AS reason, Date_of_application AS Date_of_application, 
                         leave_approval_status, A_year 
                  FROM $table 
                  WHERE leave_approval_status = 'PA' AND Staff_id = $staff_id";
    }

    $result = $conn->query($query);
    if (!$result) {
        die("$table Query failed: " . $conn->error);
    }

    // Store records by leave type
    $leave_records[$table] = [
        'type' => $type,
        'data' => $result->fetch_all(MYSQLI_ASSOC)
    ];
}

$conn->close();
?>

<div class="container mx-auto text-black">
    <!-- Loop through each leave type and display data -->
    <?php foreach ($leave_records as $table => $leave_data): ?>
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4"><?= $leave_data['type'] ?> Records</h2>
            <div class="overflow-y-scroll max-h-64 bg-white shadow rounded-lg p-4">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200">
                            <?php if ($table == 'n_off_pay_leave'): ?>
                                <!-- For Off Pay Leave, customize the table headings -->
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Date of Application</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Extra Duty Date</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Nature of Work</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Off Leave Date</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Approval Status</th>
                            <?php else: ?>
                                <!-- For other leave types, use the default headings -->
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">From Date</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">To Date</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">No. of Days</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Reason</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Application Date</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">Approval Status</th>
                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-600 uppercase">A Year</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($leave_data['data']) > 0): ?>
                            <?php foreach ($leave_data['data'] as $row): ?>
                                <tr>
                                    <?php if ($table == 'n_off_pay_leave'): ?>
                                        <!-- Display data for Off Pay Leave -->
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['Extra_duty_date']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['Nature_of_work']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['Off_leave_date']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                                    <?php else: ?>
                                        <!-- Display data for other leave types -->
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['from_date']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['to_date']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['no_of_days']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['reason']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['leave_approval_status']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['A_year']) ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-2 px-4 text-center">No <?= $leave_data['type'] ?> Records Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>