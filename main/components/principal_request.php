<?php
    include('../../config/connect.php');

    $message = ""; // Message to display for success or error
    $messageType = "";

    // Check if the logged-in user is the Principal
    session_start();
    $staff_id = $_SESSION['Staff_id'];
    if (!isset($staff_id)) {
        header("Location: login.php");
        exit();
    }


    $principal_query = "SELECT * FROM staff WHERE Staff_id = $staff_id AND Designation = 'Principal'";
    $principal_result = $conn->query($principal_query);

    if ($principal_result && $principal_result->num_rows > 0) {
        // Queries for each leave type in each tab
        $leave_queries = [
            "Degree" => [
                "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                               FROM d_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.leave_approval_status = 'HA' AND d.College = 'D' AND d.Name != 'office_lab'",
                "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                             FROM d_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.leave_approval_status = 'HA' AND d.College = 'D' AND d.Name != 'office_lab'",
                "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                                FROM d_mhm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.leave_approval_status = 'HA' AND d.College = 'D' AND d.Name != 'office_lab'"
            ],
            "Junior" => [
                "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                               FROM j_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.leave_approval_status = 'HA' AND d.College = 'J'",
                "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                             FROM j_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.leave_approval_status = 'HA' AND d.College = 'J'",
                "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.HOD_remark, l.leave_approval_status, s.Name, d.Name AS Department
                                FROM j_ehm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.leave_approval_status = 'HA' AND d.College = 'J'"
            ],
            "Non-Teaching" => [
                "Casual Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.leave_approval_status, s.Name, d.Name AS Department
                               FROM n_cl_leave AS l
                               JOIN staff AS s ON l.Staff_id = s.Staff_id
                               JOIN department AS d ON s.D_id = d.D_id
                               WHERE l.leave_approval_status = 'HA' AND d.Name = 'office_lab'",
                "Duty Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Nature AS Reason, l.Type, l.Date_of_application, l.leave_approval_status, s.Name, d.Name AS Department
                             FROM n_dl_leave AS l
                             JOIN staff AS s ON l.Staff_id = s.Staff_id
                             JOIN department AS d ON s.D_id = d.D_id
                             WHERE l.leave_approval_status = 'HA' AND d.Name = 'office_lab'",
                "Medical Leave" => "SELECT l.Staff_id, l.From_date, l.To_date, l.No_of_days, l.Reason, l.Date_of_application, l.leave_approval_status, s.Name, d.Name AS Department
                                FROM n_emhm_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.leave_approval_status = 'HA' AND d.Name = 'office_lab'",
                "Off Pay Leave" => "SELECT s.Name AS Staff_name, d.Name AS Department, l.Date_of_application, l.Extra_duty_date, l.Nature_of_work, l.Off_leave_date, l.A_year
                                FROM n_off_pay_leave AS l
                                JOIN staff AS s ON l.Staff_id = s.Staff_id
                                JOIN department AS d ON s.D_id = d.D_id
                                WHERE l.leave_approval_status = 'HA' AND d.Name = 'office_lab'"
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
        die("Access Denied: Only Principals can access this page.");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $leave_id = $_POST['leave_id'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $principal_remark = $_POST['principal_remark'];
        $status = $_POST['status']; // 'PA' for approve, 'PD' for decline
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

        $update_query = "UPDATE $leave_table SET Principal_remark = '$principal_remark', leave_approval_status = '$status' 
                     WHERE Staff_id = $leave_id AND From_date = '$from_date' AND To_date = '$to_date'";
        if ($conn->query($update_query)) {
            $message = "Leave request updated successfully.";
            $messageType = "success";
        } else {
            $message = "Error updating record: " . $conn->error;
            $messageType = "error";
        }
    }
    ?>



<main class="bg-gray-100 min-h-screen flex flex-col items-center p-6 ml-[20vw]">
    <div class="w-full max-w-6xl bg-white shadow-lg rounded-lg p-6">
        <?php if (!empty($message)): ?>
            <div id="alert-box" class="p-4 mb-4 rounded <?= $messageType == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
            <script>
                // Hide the alert box after 3 seconds
                setTimeout(function() {
                    const alertBox = document.getElementById("alert-box");
                    if (alertBox) alertBox.style.display = "none";
                }, 3000);
            </script>
        <?php endif; ?>

        <ul class="flex justify-center mb-4 space-x-4 text-gray-600">
            <li class="cursor-pointer py-2 px-4 rounded <?= $tab == 'Degree' ? 'active-tab' : '' ?>" onclick="showTab('Degree', this)">Degree</li>
            <li class="cursor-pointer py-2 px-4 rounded <?= $tab == 'Junior' ? 'active-tab' : '' ?>" onclick="showTab('Junior', this)">Junior</li>
            <li class="cursor-pointer py-2 px-4 rounded <?= $tab == 'Non-Teaching' ? 'active-tab' : '' ?>" onclick="showTab('Non-Teaching', this)">Non-Teaching</li>
        </ul>

        <?php foreach ($leave_results as $tab => $leave_types): ?>
            <div id="<?= $tab ?>" class="tab-content <?= $tab == 'Degree' ? 'active' : 'inactive' ?>">
                <h2 class="text-xl font-semibold mb-4 text-gray-700"><?= $tab ?> Leave Requests</h2>
                <?php foreach ($leave_types as $leave_type => $leave_result): ?>
                    <h3 class="text-lg font-medium mb-2 text-gray-600"><?= $leave_type ?></h3>
                    <div class="overflow-auto">
                        <table class="w-full border-collapse border border-gray-200 text-left mb-6">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 border border-gray-200">Staff Name</th>
                                    <th class="p-3 border border-gray-200">Department</th>
                                    <th class="p-3 border border-gray-200">From Date</th>
                                    <th class="p-3 border border-gray-200">To Date</th>
                                    <th class="p-3 border border-gray-200">No. of Days</th>
                                    <th class="p-3 border border-gray-200">Reason</th>
                                    <th class="p-3 border border-gray-200">Date of Application</th>
                                    <th class="p-3 border border-gray-200">HOD Remark</th>
                                    <th class="p-3 border border-gray-200">Principal Remark</th>
                                    <th class="p-3 border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $leave_result->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['Name']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['Department']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['From_date']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['To_date']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['No_of_days']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['Reason']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['Date_of_application']) ?></td>
                                        <td class="p-3 border border-gray-200"><?= htmlspecialchars($row['HOD_remark']) ?></td>
                                        <td class="p-3 border border-gray-200">
                                            <form method="post" class="flex flex-col">
                                                <input type="hidden" name="leave_id" value="<?= $row['Staff_id'] ?>">
                                                <input type="hidden" name="from_date" value="<?= $row['From_date'] ?>">
                                                <input type="hidden" name="to_date" value="<?= $row['To_date'] ?>">
                                                <input type="hidden" name="leave_table" value="<?= strtolower($tab[0]) . "_" . strtolower($leave_type[0]) . "_leave" ?>">
                                                <input type="text" name="principal_remark" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                                        </td>
                                        <td class="p-3 border border-gray-200">
                                            <button type="submit" name="status" value="PA" class="px-4 py-1 bg-green-500 text-white rounded hover:bg-green-600">Approve</button>
                                            <button type="submit" name="status" value="PD" class="px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 mt-2">Decline</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function showTab(tabName, element) {
            // Hide all tabs and remove the active class from all tab buttons
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('inactive');
                tab.classList.remove('active');
            });
            document.querySelectorAll('.flex li').forEach(tabButton => {
                tabButton.classList.remove('active-tab');
            });
            // Show the selected tab and add the active class to the clicked button
            document.getElementById(tabName).classList.remove('inactive');
            document.getElementById(tabName).classList.add('active');
            element.classList.add('active-tab');
        }
    </script>
</main>