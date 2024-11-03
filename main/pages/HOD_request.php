<?php
session_start();
include('../../config/connect.php');

$message = ""; // Message to display for success or error

// Check if the logged-in user is an HOD
$staff_id = $_SESSION['staff_id'];
$hod_query = "SELECT D_id FROM staff WHERE Staff_id = $staff_id AND Designation = 'HOD'";
$hod_result = $conn->query($hod_query);

if ($hod_result && $hod_result->num_rows > 0) {
    $D_id = $hod_result->fetch_assoc()['D_id'];

    // Fetch pending leave requests for the department
    $leave_query_cl = "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Application_date, l.leave_approval_status, s.Name 
                    FROM d_cl_leave AS l
                    JOIN staff AS s ON l.Staff_id = s.Staff_id
                    WHERE s.D_id = $D_id AND l.leave_approval_status = 'P'";
    $leave_result_cl = $conn->query($leave_query_cl);

    $leave_query_dl = "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Application_date, l.leave_approval_status, s.Name 
                    FROM d_dl_leave AS l
                    JOIN staff AS s ON l.Staff_id = s.Staff_id
                    WHERE s.D_id = $D_id AND l.leave_approval_status = 'P'";
    $leave_result_dl = $conn->query($leave_query_dl);

    $leave_query_mhm = "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application AS Application_date, l.leave_approval_status, s.Name 
                    FROM d_mhm_leave AS l
                    JOIN staff AS s ON l.Staff_id = s.Staff_id
                    WHERE s.D_id = $D_id AND l.leave_approval_status = 'P'";
    $leave_result_mhm = $conn->query($leave_query_mhm);
} else {
    die("Access Denied: Only HODs can access this page.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['leave_table'])) {
        $leave_id = $_POST['leave_id'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $hod_remark = $_POST['hod_remark'];
        $status = $_POST['status']; // 'accept' for approve, 'decline' for decline
        $leave_table = $_POST['leave_table'];

        // Construct the update query based on the leave table
        $update_query = "";
        if ($leave_table === 'd_cl_leave') {
            $update_query = "UPDATE d_cl_leave SET HOD_remark = '$hod_remark', leave_approval_status = '$status' 
                             WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
        } elseif ($leave_table === 'd_dl_leave') {
            $update_query = "UPDATE d_dl_leave SET HOD_remark = '$hod_remark', leave_approval_status = '$status' 
                             WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
        } elseif ($leave_table === 'd_mhm_leave') {
            $update_query = "UPDATE d_mhm_leave SET HOD_remark = '$hod_remark', leave_approval_status = '$status' 
                             WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
        }

        // Execute the update query only if it is not empty
        if (!empty($update_query) && $conn->query($update_query)) {
            $message = "Leave request updated successfully.";
            $messageType = "success";
        } else {
            $message = "Error updating record: " . $conn->error;
            $messageType = "error";
        }
    } else {
        $message = "Leave table information is missing.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Leave Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Hide alert after a few seconds
        function hideAlert() {
            setTimeout(() => {
                const alertBox = document.getElementById('alert-box');
                if (alertBox) alertBox.style.display = 'none';
            }, 4000);
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center" onload="hideAlert()">
    <div class="container max-w-4xl bg-white rounded-lg shadow-lg p-6">

        <!-- Alert Box -->
        <?php if (!empty($message)): ?>
            <div id="alert-box" class="p-4 mb-4 text-sm rounded-lg 
                <?= $messageType == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>"
                role="alert">
                <span class="font-medium"><?= $messageType == 'success' ? 'Success!' : 'Error!' ?></span>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-700">Pending Leave Requests</h2>

        <?php
        $leave_types = [
            'Casual Leave' => ['result' => $leave_result_cl, 'table' => 'd_cl_leave'],
            'Duty Leave' => ['result' => $leave_result_dl, 'table' => 'd_dl_leave'],
            'Medical Half Pay Maternity Leave' => ['result' => $leave_result_mhm, 'table' => 'd_mhm_leave']
        ];

        foreach ($leave_types as $leave_type => $data): ?>
            <h3 class="text-xl font-semibold mb-4 text-gray-600"><?= $leave_type ?></h3>

            <?php if ($data['result']->num_rows > 0): ?>
                <div class="overflow-x-auto"> <!-- Make the table responsive -->
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg mb-6">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="py-3 px-4 border-b">Staff Name</th>
                                <th class="py-3 px-4 border-b">From Date</th>
                                <th class="py-3 px-4 border-b">To Date</th>
                                <th class="py-3 px-4 border-b">No. of Days</th>
                                <th class="py-3 px-4 border-b w-40">Reason</th>
                                <th class="py-3 px-4 border-b">Application Date</th>
                                <th class="py-3 px-4 border-b">HOD Remark</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600">
                            <?php while ($row = $data['result']->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Name']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['From_date']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['To_date']) ?></td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['No_of_days']) ?></td>
                                    <td class="py-3 px-4 border-b w-40 truncate">
                                        <div class="overflow-y-auto h-12"><?= htmlspecialchars($row['Reason']) ?></div>
                                    </td>
                                    <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['Application_date']) ?></td>
                                    <td class="py-3 px-4 border-b">
                                        <form method="POST" action="">
                                            <input type="hidden" name="leave_id" value="<?= $row['Staff_id'] ?>">
                                            <input type="hidden" name="from_date" value="<?= $row['From_date'] ?>">
                                            <input type="hidden" name="to_date" value="<?= $row['To_date'] ?>">
                                            <input type="hidden" name="leave_table" value="<?= $data['table'] ?>">

                                            <textarea name="hod_remark" class="border border-gray-300 rounded-md p-2 w-full mb-2" rows="2" placeholder="Enter remark..."></textarea>

                                            <!-- Accept and Decline buttons -->
                                            <div class="flex justify-between">
                                                <button type="submit" name="status" value="HA" class="bg-green-500 text-white rounded-md px-4 py-1">Accept</button>
                                                <button type="submit" name="status" value="HD" class="bg-red-500 text-white rounded-md px-4 py-1">Decline</button>
                                            </div>
                                        </form>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-500">No pending requests for <?= $leave_type ?>.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>

</html>