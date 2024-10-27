<!-- Sidebar and Main Content Container -->
<div class="flex h-screen">
    <!-- Static Sidebar on Large Screens -->
    <aside class="hidden lg:flex flex-col w-1/5 bg-white border-r h-full px-4 py-6">
        <ul class="space-y-4">
            <li>
                <details class="group">
                    <summary class="flex items-center justify-between px-4 py-2 text-gray-700 cursor-pointer font-medium">
                        Apply Leave
                        <span class="transition duration-300 transform group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4-4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul class="mt-2 pl-4 space-y-2">
                        <li><a href="#" class="block px-4 py-2 text-gray-700">CL</a></li>
                        <li><a href="#" class="block px-4 py-2 text-gray-700">DL</a></li>
                        <li><a href="#" class="block px-4 py-2 text-gray-700">Medical Leave</a></li>
                    </ul>
                </details>
            </li>
            <li><a href="#" class="block px-4 py-2 text-gray-700">Check Status</a></li>
            <li><a href="#" class="block px-4 py-2 text-gray-700">Summary</a></li>
        </ul>
    </aside>

    <!-- Mobile Sidebar Toggle Button -->
    <button class="lg:hidden fixed top-4 left-4 z-50 bg-gray-200 p-2 rounded-md" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar for Mobile Screen -->
    <aside id="mobileSidebar" class="fixed top-0 left-0 w-3/4 max-w-xs h-full bg-white border-r z-40 transform -translate-x-full transition-transform duration-300 lg:hidden">
        <div class="p-4">
            <ul class="space-y-4">
                <li>
                    <details class="group">
                        <summary class="flex items-center justify-between px-4 py-2 text-gray-700 cursor-pointer font-medium">
                            Apply Leave
                            <span class="transition duration-300 transform group-open:-rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4-4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 pl-4 space-y-2">
                            <li><a href="#" class="block px-4 py-2 text-gray-700">CL</a></li>
                            <li><a href="#" class="block px-4 py-2 text-gray-700">DL</a></li>
                            <li><a href="#" class="block px-4 py-2 text-gray-700">Medical Leave</a></li>
                        </ul>
                    </details>
                </li>
                <li><a href="#" class="block px-4 py-2 text-gray-700">Check Status</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-700">Summary</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-8">
        <!-- Responsive Grid for Leave Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Casual Leave Chart -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Casual Leave</h2>
                <canvas id="casualLeaveChart"></canvas>
                <div class="mt-4">
                    <p class="text-gray-600">Total Leaves: <span id="casualTotalLeaves"></span></p>
                    <p class="text-gray-600">Used Leaves: <span id="casualUsedLeaves"></span></p>
                    <p class="text-gray-600">Remaining Leaves: <span id="casualRemainingLeaves"></span></p>
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
    </main>
</div>

<!-- PHP Leave Data -->
<?php
// Example data for each leave type
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

<!-- Chart.js Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Casual Leave Chart
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
                            label: function(context) {
                                return `${context.label}: ${context.raw} days`;
                            }
                        }
                    }
                }
            }
        });

        // Update Casual Leave Statistics
        document.getElementById('casualTotalLeaves').textContent = casualLeaves.total;
        document.getElementById('casualUsedLeaves').textContent = casualLeaves.used;
        document.getElementById('casualRemainingLeaves').textContent = casualLeaves.remaining;

        // Duty Leave Chart
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
                            label: function(context) {
                                return `${context.label}: ${context.raw} days`;
                            }
                        }
                    }
                }
            }
        });

        // Update Duty Leave Statistics
        document.getElementById('dutyTotalLeaves').textContent = dutyLeaves.total;
        document.getElementById('dutyUsedLeaves').textContent = dutyLeaves.used;
        document.getElementById('dutyRemainingLeaves').textContent = dutyLeaves.remaining;

        // Medical Leave Chart
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
                            label: function(context) {
                                return `${context.label}: ${context.raw} days`;
                            }
                        }
                    }
                }
            }
        });

        // Update Medical Leave Statistics
        document.getElementById('medicalTotalLeaves').textContent = medicalLeaves.total;
        document.getElementById('medicalUsedLeaves').textContent = medicalLeaves.used;
        document.getElementById('medicalRemainingLeaves').textContent = medicalLeaves.remaining;
    });

    // Sidebar toggle function for mobile view
    function toggleSidebar() {
        const sidebar = document.getElementById('mobileSidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>