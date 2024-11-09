<?php
include('../../config/connect.php');

$message = ""; // Message for success or error
$messageType = "";

// Check if the logged-in user is authorized (adjust as needed for office access)
session_start();
$staff_id = $_SESSION['Staff_id'];
if (!isset($staff_id)) {
    header("Location: login.php");
    exit();
}

        $office_query = "SELECT * FROM staff WHERE Staff_id = $staff_id AND Job_role = 'OO'";
        $office_result = $conn->query($office_query);


if ($office_result && $office_result->num_rows > 0) {
    // Queries for each leave type in each tab, with conditions for `Office_remark` and `leave_approval_status`
    $leave_queries = [
        "Degree" => [
            "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                               FROM d_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'D' AND d.Name != 'office_lab'",
            "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                             FROM d_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'D' AND d.Name != 'office_lab'",
            "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                                FROM d_mhm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'D' AND d.Name != 'office_lab'"
        ],
        "Junior" => [
            "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                               FROM j_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'J'",
            "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                             FROM j_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'J'",
            "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.Principal_remark, l.leave_approval_status, l.Office_remark, s.Name, d.Name AS Department
                                FROM j_ehm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.College = 'J'"
        ],
        "Non-Teaching" => [
            "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.leave_approval_status, l.Principal_remark, l.Office_remark, s.Name, d.Name AS Department
                               FROM n_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.Name = 'office_lab'",
            "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.leave_approval_status, l.Principal_remark, l.Office_remark, s.Name, d.Name AS Department
                             FROM n_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.Name = 'office_lab'",
            "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.leave_approval_status, l.Principal_remark, l.Office_remark, s.Name, d.Name AS Department
                                FROM n_emhm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.Name = 'office_lab'",
            "Off Pay Leave" =>
            "SELECT s.Name AS Staff_name, d.Name AS Department, l.Date_of_application, l.Extra_duty_date, l.Nature_of_work, l.Off_leave_date, l.A_year, l.Principal_remark, l.Office_remark,l.Staff_id
                                FROM n_off_pay_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.Office_remark = '' AND l.leave_approval_status = 'PA' AND d.Name = 'office_lab'"                   
        ]
    ];

    $leave_results = [];
    foreach ($leave_queries as $tab => $queries) {
        foreach ($queries as $leave_type => $query) {
            $result = $conn->query($query);
            if (!$result) {
                die("Error in $tab - $leave_type Query: " . $conn->error);
            }
            $leave_results[$tab][$leave_type] = $result;
        }
    }
} else {
    die("Access Denied.");
}

// Handle form submission for Office Remark
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_id = $_POST['leave_id'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $office_remark = $_POST['office_remark'];
    $leave_table = $_POST['leave_table']; // Dynamic table name for update query

    switch ($leave_table) {
        case 'd_c_leave':
            $leave_table = 'd_cl_leave';
            break;
        case 'd_d_leave':
            $leave_table = 'd_dl_leave';
            break;
        case 'd_m_leave':
            $leave_table = 'd_mhm_leave';
            break;
        case 'j_c_leave':
            $leave_table = 'j_cl_leave';
            break;
        case 'j_d_leave':
            $leave_table = 'j_dl_leave';
            break;
        case 'j_m_leave':
            $leave_table = 'j_ehm_leave';
            break;
        case 'n_c_leave':
            $leave_table = 'n_cl_leave';
            break;
        case 'n_d_leave':
            $leave_table = 'n_dl_leave';
            break;
        case 'n_m_leave':
            $leave_table = 'n_emhm_leave';
            break;
        case 'n_o_leave':
            $leave_table = 'n_off_pay_leave';
            break;
        default:
            // In case an unexpected leave_table value is encountered
            die("Error: Invalid leave table.");
    }

    // Table mapping adjustment for office request
    $update_query = "UPDATE $leave_table SET Office_remark = '$office_remark' 
                     WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
    if ($conn->query($update_query)) {
        $message = "Office remark added successfully.";
        $messageType = "success";
    } else {
        $message = "Error updating record: " . $conn->error;
        $messageType = "error";
    }
}
?>

<!-- HTML and JavaScript part -->
<main class="bg-gray-100 min-h-screen flex flex-col items-center p-6 ml-[20vw]">
    <div class="w-full max-w-6xl bg-white shadow-lg rounded-lg p-6">
        <?php if (!empty($message)): ?>
            <div id="alert-box" class="p-4 mb-4 rounded <?= $messageType == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
            <script>
                setTimeout(() => document.getElementById("alert-box").style.display = "none", 30000);
            </script>
        <?php endif; ?>

        <ul class="flex justify-center mb-4 space-x-4 text-gray-600">
            <li class="cursor-pointer py-2 px-4 rounded active-tab" onclick="showTab('Degree', this)">Degree</li>
            <li class="cursor-pointer py-2 px-4 rounded" onclick="showTab('Junior', this)">Junior</li>
            <li class="cursor-pointer py-2 px-4 rounded" onclick="showTab('Non-Teaching', this)">Non-Teaching</li>
        </ul>

        <?php foreach ($leave_results as $tab => $leave_types): ?>
            <div class="tab-content hidden" id="<?= $tab ?>">
                <?php foreach ($leave_types as $leave_type => $rows): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2"><?= htmlspecialchars($leave_type) ?></h3>
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700">
                                        <th class="p-2 border">Name</th>
                                        <th class="p-2 border">Department</th>
                                        <th class="p-2 border">From Date</th>
                                        <th class="p-2 border">To Date</th>
                                        <th class="p-2 border">No of Days</th>
                                        <th class="p-2 border">Reason</th>
                                        <th class="p-2 border">Date of Application</th>
                                        <th class="p-2 border">HOD Remark</th>
                                        <th class="p-2 border">Principal Remark</th>
                                        <th class="p-2 border">Office Remark</th>
                                        <th class="p-2 border">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $rows->fetch_assoc()): ?>
                                        <tr class="text-gray-700">
                                            <td class="p-2 border"><?= htmlspecialchars($row['Name']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['Department']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['From_date']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['To_date']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['No_of_days']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['Reason']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['HOD_remark']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['Principal_remark']) ?></td>
                                            <td class="p-2 border"><?= htmlspecialchars($row['Office_remark']) ?></td>
                                            <td class="p-2 border">
                                                <form method="POST">
                                                    <input type="hidden" name="leave_id" value="<?= $row['Staff_id'] ?>">
                                                    <input type="hidden" name="from_date" value="<?= $row['From_date'] ?>">
                                                    <input type="hidden" name="to_date" value="<?= $row['To_date'] ?>">
                                                    <input type="hidden" name="leave_table" value="<?= htmlspecialchars($leave_table) ?>">
                                                    <textarea name="office_remark" class="p-1 border rounded" placeholder="Add Office Remark"></textarea>
                                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded mt-2">Submit</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    function showTab(tab, el) {
        document.querySelectorAll(".tab-content").forEach(div => div.style.display = "none");
        document.getElementById(tab).style.display = "block";
        document.querySelectorAll("ul li").forEach(li => li.classList.remove("active-tab"));
        el.classList.add("active-tab");
    }
    document.addEventListener("DOMContentLoaded", () => showTab("Degree", document.querySelector("ul li.active-tab")));
</script>

<style>
    .active-tab {
        background-color: #4A90E2;
        color: white;
    }
</style>