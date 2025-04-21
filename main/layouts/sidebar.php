<?php
error_reporting(0);
session_start();

$Staff_id = $_SESSION['Staff_id'];

if (!$Staff_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}

if (file_exists('../../config/connect.php')) {
    include('../../config/connect.php');
} else {
    include('../../../config/connect.php');
}

$sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $jobRole = $row['Job_role'];
    $designation = $row['Designation'];
    $status=$row['status'];
    if ($status!='A') {
        echo "<script>alert('Account Deactivated... Contact The Admin!!.'); window.location.href='login.php';</script>";
        exit;
    }
}
$currentSubPage = basename($_SERVER['PHP_SELF']);
$currentPage = isset($_GET['page']) ? $_GET['page'] : '';
//$currentPage = $_GET['page'] ?? '';
// echo "<script>alert('" . $currentPage . " " . $currentSubPage . "');</script>";
?>

<!-- Sidebar -->
<aside class="fixed flex flex-col w-64 bg-white border-r h-full px-4 py-6 overflow-y-auto shadow-lg" id="sidebar">
    <ul class="space-y-2">
        <!-- Dashboard -->
        <li>
            <a href="index.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium transition <?php echo ($currentPage == '' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <!-- Apply Leave Section -->
        <?php if (strcasecmp(trim($designation), 'Principal') != 0): ?>
            <li>
                <details class="group">
                    <summary class="flex items-center justify-between px-4 py-2 cursor-pointer font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-calendar-plus"></i> Apply Leave
                        </span>
                        <i class="fas fa-chevron-down transform transition-transform group-open:rotate-180"></i>
                    </summary>
                    <ul class="mt-2 pl-6 space-y-1 text-sm text-gray-600">
                        <li><a href="#" onclick="loadContent('dl')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'dl' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">Duty Leave</a></li>
                        <li><a href="#" onclick="loadContent('cl')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'cl' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">Casual Leave</a></li>

                        <?php if ($jobRole == 'TD'): ?>
                            <li><a href="#" onclick="loadContent('medical')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'medical' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">MHM</a></li>
                        <?php elseif ($jobRole == 'TJ'): ?>
                            <li><a href="#" onclick="loadContent('medical')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'medical' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">EHM</a></li>
                        <?php elseif ($jobRole == 'NL'): ?>
                            <li><a href="#" onclick="loadContent('mediacl')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'mediacl' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">MHM</a></li>
                            <li><a href="#" onclick="loadContent('APPLY_OFF_PAY')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'APPLY_OFF_PAY' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">OFF Pay</a></li>
                        <?php elseif ($jobRole == 'NO' || $jobRole == 'OO'): ?>
                            <li><a href="#" onclick="loadContent('APPLY_OFF_PAY')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'APPLY_OFF_PAY' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">OFF Pay</a></li>
                            <li><a href="#" onclick="loadContent('medical')" class="block px-4 py-2 rounded-lg hover:bg-gray-200 <?php echo ($currentPage == 'medical' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>">MHME</a></li>
                        <?php endif; ?>
                    </ul>
                </details>
            </li>
            <li><a href="#" onclick="loadContent('status')" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentPage == 'status' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-eye"></i> Check Status</a></li>
            <li><a href="#" onclick="loadContent('summary')" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentPage == 'summary' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-list-alt"></i> Summary</a></li>
        <?php endif; ?>

        <!-- Common Options -->


        <!-- Registrar -->
        <?php if (strcasecmp(trim($designation), 'Registrar') === 0): ?>
            <li><a href="user_status_logs.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'user_status_logs.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?> "><i class="fas fa-user-clock"></i> User Status Log</a></li>
        <?php endif; ?>

        <!-- Role-Based Sections -->
        <?php if ($designation == 'Principal'): ?>
            <li><a href="Report.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'Report.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?> "><i class="fas fa-file-alt"></i> Report</a></li>
        <?php endif; ?>

        <?php if ($designation == 'HOD'): ?>
            <li><a href="HOD.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'HOD.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-tie"></i> HOD Leave Request</a></li>
            <li><a href="HOD_Report.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'HOD_Report.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-chart-line"></i> Generate Report</a></li>
        <?php endif; ?>

        <?php if (strcasecmp(trim($designation), 'Vice Principal') === 0): ?>
            <li><a href="vicePrincipal.php" onclick="loadContent('VicePrincipalLeaveRequest')" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'vicePrincipal.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-check"></i> Vice Principal Leave Request</a></li>
        <?php endif; ?>
    </ul>

    <!-- Admin Options -->
    <?php if ($jobRole == 'OO' || $designation == 'Principal'): ?>
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Admin Options</h3>
            <ul class="space-y-2">
                <?php if ($jobRole == 'OO'): ?>
                    <li><a href="officeRemark.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'officeRemark.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-envelope-open-text"></i> Leave Request</a></li>
                <?php endif; ?>

                <?php if ($designation == 'Principal'): ?>
                    <li><a href="principalRequest.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'principalRequest.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-edit"></i> Principal Leave Request</a></li>
                <?php endif; ?>

                <li><a href="#" onclick="loadContent('registration')" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentPage == 'registration' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-plus"></i> New Registration</a></li>
                <li><a href="assign_leave.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentSubPage == 'assign_leave.php' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-tasks"></i> Assign Leave</a></li>
                <li><a href="#" onclick="loadContent('update')" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentPage == 'update' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-cog"></i> Update Details</a></li>
                <li><a href="#" onclick="loadContent('active/deactive')" class="flex items-center gap-2 px-4 py-2 mb-5 rounded-lg hover:bg-gray-100 text-gray-700 <?php echo ($currentPage == 'active/deactive' ? 'bg-gray-200 text-blue-600 font-semibold' : ''); ?>"><i class="fas fa-user-slash"></i> Deactivate Users</a></li>
            </ul>
        </div>
    <?php endif; ?>
</aside>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Dynamic Page Load Script -->




<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full'); // Hide
        sidebar.classList.toggle('translate-x-0'); // Show
    }
    //   function loadContent(page) {
    //       // Get the base URL up to the directory containing index.php
    //       const baseUrl = `${window.location.origin}/vaze-leave-management/main/pages/`;

    //       // Check if the current page is 'index.php'
    //       const isMainPage = window.location.pathname.includes("index.php");

    //       if (!isMainPage) {
    //           // Redirect to index.php with the 'page' parameter, using the base URL
    //           window.location.href = `${baseUrl}index.php?page=${page}`;
    //       } else {
    //           // If already on index.php, load the content dynamically
    //           fetch(`../components/${page}.php`)
    //               .then(response => response.text())
    //               .then(data => {
    //                   document.getElementById('dynamicContent').innerHTML = data;
    //               })
    //               .catch(error => console.error('Error loading content:', error));
    //       }
    //   }

    //to load the page if dynamicContentContainer div is not availabe. go to index.php then fetch content from components
    function loadContent(page) {
        // Get the base URL up to the directory containing index.php
        const baseUrl = `${window.location.origin}/vaze-leave-management/main/pages/`;

        // Check if the dynamic content container exists
        const dynamicContentContainer = document.getElementById('dynamicContent');

        if (dynamicContentContainer) {
            // If the dynamic content container exists, load the content dynamically
            fetch(`../components/${page}.php`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    dynamicContentContainer.innerHTML = data;
                    // Optionally update the browser history
                    window.history.pushState({
                        page: page
                    }, '', `index.php?page=${page}`);
                })
                .catch(error => console.error('Error loading content:', error));
        } else {
            // If the dynamic content container doesn't exist, redirect to index.php
            const url = new URL(`${baseUrl}index.php`);
            url.searchParams.set('page', page); // Add the 'page' parameter to the URL
            window.location.href = url;
        }
    }

    // Check for `page` parameter in the URL and load the corresponding content
    window.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const page = params.get('page');

        if (page) {
            const dynamicContentContainer = document.getElementById('dynamicContent');
            if (dynamicContentContainer) {
                // Dynamically load the page if the container exists
                fetch(`../components/${page}.php`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(data => {
                        dynamicContentContainer.innerHTML = data;
                    })
                    .catch(error => console.error('Error loading content:', error));
            }
        }
    });


    // Reveal sidebar on page load
    window.addEventListener('load', () => {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.remove('-translate-x-full', 'opacity-0');
        sidebar.classList.add('translate-x-0', 'opacity-100');
    });
</script>