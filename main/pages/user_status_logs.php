<?php
session_start();

if (!isset($_SESSION['Staff_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Status Logs</title>

    <link rel="stylesheet" href="./output.css">
    <?php include('../../library/library.php'); ?>


</head>
<?php include('../layouts/header.php'); ?>

<body class="bg-gray-100 p-6 pl-0 ">
    <div class="mt-10 flex h-fit">
        <!-- Sidebar -->
        <?php include('../layouts/sidebar.php'); ?>

        <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center ml-[25%]">

            <h1 class="text-2xl font-bold text-gray-800 mb-4">User Status Logs</h1>

            <!-- Filter Section -->
            <div class="mb-4 flex items-center gap-4">
                <input id="usernameFilter"
                    type="text"
                    placeholder="Filter by Username"
                    class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-1/3 rounded-md shadow-sm sm:text-sm">
                <button id="filterButton"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md">
                    Apply Filter
                </button>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">S. No.</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Staff Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Action Performed By</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Action</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody id="logsTableBody" class="divide-y divide-gray-200">
                        <!-- Rows will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            function loadLogs(username = '') {
                $.ajax({
                    url: 'fetch_user_status_logs.php',
                    type: 'GET',
                    data: {
                        username: username
                    },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#logsTableBody');
                        tableBody.empty();

                        if (data.length > 0) {
                            data.forEach((log, index) => {
                                tableBody.append(`
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">${index + 1}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">${log.staff_name}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">${log.action_by}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">${log.action}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">${log.timestamp}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tableBody.append(`
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center text-sm text-gray-500">No records found</td>
                                </tr>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Log the response text
                        console.log(status); // Log the status
                        console.log(error); // Log the error
                        alert('Error fetching data.');
                    }
                });
            }

            // Initial Load
            loadLogs();

            // Filter Button Click
            $('#filterButton').on('click', function() {
                const username = $('#usernameFilter').val();
                loadLogs(username);
            });
        });
    </script>

</body>

</html>