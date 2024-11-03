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


    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Leave Management Form</h1>

        <!-- Initial Selection Form -->
        <form id="initialForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="academicYear">
                    Academic Year
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="academicYear" type="text" placeholder="e.g., 2023-2024" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="leaveType">
                    Leave Type
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="leaveType" required>
                    <option value="">Select leave type</option>
                    <option value="sick">Sick Leave</option>
                    <option value="vacation">Vacation</option>
                    <option value="personal">Personal Leave</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Next
                </button>
            </div>
        </form>

        <!-- Detailed Leave Form (Initially Hidden) -->
        <form id="detailedForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 hidden">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="applicationDate">
                    Application Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="applicationDate" type="date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                    Department
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="department" type="text" placeholder="Enter your department" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fromDate">
                    From Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fromDate" type="date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="toDate">
                    To Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="toDate" type="date" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                    On Account Of
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="reason" rows="4" placeholder="Enter reason for leave" required></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Submit Leave Request
                </button>
            </div>
        </form>
    </div>
</div>