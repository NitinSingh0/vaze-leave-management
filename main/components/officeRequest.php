<?php
session_start();
include('../../config/connect.php');

$message = ""; // Message to display for success or error

// Check if the logged-in user is in the office role (e.g., "Office Staff")
// Assuming office staff ID and role check are stored in session
$staff_id = $_SESSION['staff_id'];
$staff_id=120;
$office_query = "SELECT * FROM staff WHERE Staff_id = $staff_id AND Job_role = 'OO'";
$office_result = $conn->query($office_query);

if ($office_result && $office_result->num_rows > 0) {
    // Fetch leave requests approved by the Principal (leave_approval_status = 'PA')
    $leave_queries = [
        "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Application_date, l.HOD_remark, l.leave_approval_status, l.Principal_remark, s.Name, d.Name AS Department
                           FROM d_cl_leave AS l
                           JOIN staff AS s ON l.Staff_id = s.Staff_id
                           JOIN department AS d ON s.D_id = d.D_id
                           WHERE l.leave_approval_status = 'PA'",
        "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Application_date, l.HOD_remark, l.leave_approval_status, l.Principal_remark, s.Name, d.Name AS Department
                         FROM d_dl_leave AS l
                         JOIN staff AS s ON l.Staff_id = s.Staff_id
                         JOIN department AS d ON s.D_id = d.D_id
                         WHERE l.leave_approval_status = 'PA'",
        "Medical Half Pay Maternity Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application AS Application_date, l.HOD_remark, l.leave_approval_status, l.Principal_remark, s.Name, d.Name AS Department
                                               FROM d_mhm_leave AS l
                                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                                               JOIN department AS d ON s.D_id = d.D_id
                                               WHERE l.leave_approval_status = 'PA'"
    ];

    $leave_results = [];
    foreach ($leave_queries as $leave_type => $query) {
        $result = $conn->query($query);
        if (!$result) {
            die("Error in $leave_type Query: " . $conn->error);
        }
        $leave_results[$leave_type] = $result;
    }
} else {
    die("Access Denied: Only Office Staff can access this page.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_id = $_POST['leave_id'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $office_remark = $_POST['office_remark'];
    $leave_table = $_POST['leave_table']; // Dynamic table name for update query

    // Update leave record with Office remark
    $update_query = "UPDATE $leave_table SET Office_remark = '$office_remark' 
                     WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
    if ($conn->query($update_query)) {
        $message = "Office remark updated successfully.";
        $messageType = "success";
    } else {
        $message = "Error updating record: " . $conn->error;
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Leave Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center" onload="hideAlert()">
    <div class="container max-w-5xl bg-white rounded-lg shadow-lg p-6">
        <?php if (!empty($message)): ?>
            <div id="alert-box" class="p-4 mb-4 text-sm rounded-lg <?= $messageType == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>" role="alert">
                <span class="font-medium"><?= $messageType == 'success' ? 'Success!' : 'Error!' ?></span>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-700">Office Review of Approved Leave Requests</h2>

        <?php foreach ($leave_results as $leave_type => $leave_result): ?>
            <h3 class="text-xl font-semibold mb-4 text-gray-600"><?= $leave_type ?></h3>
            <?php if ($leave_result->num_rows > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg mb-6">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="py-3 px-4 border-b">Staff Name</th>
                                <th class="py-3 px-4 border-b">Department</th>
                                <th class="py-3 px-4 border-b">From Date</th>
                                <th class="py-3 px-4 border-b">To Date</th>
                                <th class="py-3 px-4 border-b">No. of Days</th>
                                <th class="py-3 px-4 border-b">Reason</th>
                                <th class="py-3 px-4 border-b">Application Date</th>
                                <th class="py-3 px-4 border-b">HOD Remark</th>
                                <th class="py-3 px-4 border-b">Principal Remark</th>
                                <th class="py-3 px-4 border-b">Office Remark</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600">
                            <?php while ($row = $leave_result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Name']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Department']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['From_date']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['To_date']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['No_of_days']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Reason']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Application_date']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['HOD_remark']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Principal_remark']) ?></td>
                                    <td class="py-3 px-4 border-b">
                                        <form method="post" class="flex flex-col space-y-2">
                                            <input type="hidden" name="leave_id" value="<?= $row['Staff_id'] ?>">
                                            <input type="hidden" name="from_date" value="<?= $row['From_date'] ?>">
                                            <input type="hidden" name="to_date" value="<?= $row['To_date'] ?>">
                                            <input type="hidden" name="leave_table" value="<?= strtolower(str_replace(' ', '_', $leave_type)) ?>">
                                            <textarea name="office_remark" class="border border-gray-300 rounded-md p-2" placeholder="Office Remark"></textarea>
                                            <button type="submit" class="bg-blue-500 text-white rounded-md px-4 py-2">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-600">No pending requests for <?= $leave_type ?>.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script>
        function hideAlert() {
            setTimeout(function() {
                const alertBox = document.getElementById("alert-box");
                if (alertBox) alertBox.style.display = "none";
            }, 3000);
        }
    </script>
</body>

</html>