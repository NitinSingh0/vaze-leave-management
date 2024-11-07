<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            loadContent('$page');
        });
    </script>";
}
?>

<!-- Main Container -->
<div class="mt-11 flex h-screen">
    <!-- Sidebar -->
    <?php include('../layouts/sidebar.php');
    ?>


    <!-- Main Content Area with margin for sidebar -->
    <main id="mainContent" class="flex-1 p-8 ml-[20%] overflow-auto">
        <!-- Placeholder for dynamic content (Charts or other data will load here) -->
        <div id="dynamicContent">
            <!-- Responsive Grid for Leave Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Casual Leave Chart -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Casual Leave</h2>
                    <canvas id="casualLeaveChart"></canvas>
                    <div class="mt-4">
                        <p class="text-gray-600">Total Leaves: <span id="casualTotalLeaves"></span></p>
                        <p class="text-gray-600">Used Leaves: <span id="casualUsedLeaves"></span></p>
                        <p class="text-gray-600 ">Remaining Leaves: <span id="casualRemainingLeaves"></span></p>

                    </div>
                </div>

                <!-- Duty Leave Chart -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Duty Leave</h2>
                    <canvas id="dutyLeaveChart"></canvas>
                    <div class="mt-4">
                        <p class="text-gray-600">Total Leaves: <span id="dutyTotalLeaves"></span></p>
                        <p class="text-gray-600">Used Leaves: <span id="dutyUsedLeaves"></span></p>
                        <p class="text-gray-600">Remaining Leaves: <span id="dutyRemainingLeaves"></span></p>
                    </div>
                </div>

                <!-- Medical/Half-Pay Leave Chart -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Medical/Half-Pay Leave</h2>
                    <canvas id="medicalLeaveChart"></canvas>
                    <div class="mt-4">
                        <p class="text-gray-600">Total Leaves: <span id="medicalTotalLeaves"></span></p>
                        <p class="text-gray-600">Used Leaves: <span id="medicalUsedLeaves"></span></p>
                        <p class="text-gray-600">Remaining Leaves: <span id="medicalRemainingLeaves"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- PHP Leave Data -->
<?php
// Sample job role for demonstration purposes
$jobRole = $_SESSION['job_role']; // Assume job_role is stored in session

$casualLeavesTotal = 12;
$casualLeavesUsed = 5;
$casualLeavesRemaining = $casualLeavesTotal - $casualLeavesUsed;

$dutyLeavesTotal = 10;
$dutyLeavesUsed = 3;
$dutyLeavesRemaining = $dutyLeavesTotal - $dutyLeavesUsed;

$medicalLeavesTotal = 8;
$medicalLeavesUsed = 2;
$medicalLeavesRemaining = $medicalLeavesTotal - $medicalLeavesUsed;

echo "<script>
    const casualLeaves = { total: $casualLeavesTotal, used: $casualLeavesUsed, remaining: $casualLeavesRemaining };
    const dutyLeaves = { total: $dutyLeavesTotal, used: $dutyLeavesUsed, remaining: $dutyLeavesRemaining };
    const medicalLeaves = { total: $medicalLeavesTotal, used: $medicalLeavesUsed, remaining: $medicalLeavesRemaining };
</script>";
?>

<!-- JavaScript for AJAX and Chart.js -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Chart(document.getElementById('casualLeaveChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Used', 'Remaining'],
                datasets: [{
                    data: [casualLeaves.used, casualLeaves.remaining],
                    backgroundColor: ['#ff6384', '#36a2eb']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw} days`
                        }
                    }
                }
            }
        });

        document.getElementById('casualTotalLeaves').textContent = casualLeaves.total;
        document.getElementById('casualUsedLeaves').textContent = casualLeaves.used;
        document.getElementById('casualRemainingLeaves').textContent = casualLeaves.remaining;

        new Chart(document.getElementById('dutyLeaveChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Used', 'Remaining'],
                datasets: [{
                    data: [dutyLeaves.used, dutyLeaves.remaining],
                    backgroundColor: ['#ffce56', '#36a2eb']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw} days`
                        }
                    }
                }
            }
        });

        document.getElementById('dutyTotalLeaves').textContent = dutyLeaves.total;
        document.getElementById('dutyUsedLeaves').textContent = dutyLeaves.used;
        document.getElementById('dutyRemainingLeaves').textContent = dutyLeaves.remaining;

        new Chart(document.getElementById('medicalLeaveChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Used', 'Remaining'],
                datasets: [{
                    data: [medicalLeaves.used, medicalLeaves.remaining],
                    backgroundColor: ['#4bc0c0', '#36a2eb']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw} days`
                        }
                    }
                }
            }
        });

        document.getElementById('medicalTotalLeaves').textContent = medicalLeaves.total;
        document.getElementById('medicalUsedLeaves').textContent = medicalLeaves.used;
        document.getElementById('medicalRemainingLeaves').textContent = medicalLeaves.remaining;
    });
</script>