<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Leaves - Staff Leave Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-active {
            @apply bg-blue-600 text-white;
        }

        .subtab-active {
            @apply bg-blue-500 text-white;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6 max-w-3xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Assign Leaves</h1>

        <!-- Main Tabs -->
        <div class="mb-6">
            <button id="teachingTab" class="px-6 py-2 rounded-l-lg bg-blue-600 text-white focus:outline-none">Teaching</button>
            <button id="nonTeachingTab" class="px-6 py-2 rounded-r-lg bg-gray-300 text-gray-700 focus:outline-none">Non Teaching</button>
        </div>

        <!-- Teaching Form -->
        <div id="teachingForm" class="bg-white rounded-lg shadow-md p-6">
            <form>
                <div class="mb-4">
                    <label for="academicYearTeaching" class="block text-gray-700 font-semibold mb-2">Academic Year</label>
                    <input type="text" id="academicYearTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="typeTeaching" class="block text-gray-700 font-semibold mb-2">Type</label>
                    <select id="typeTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="degree">Degree</option>
                        <option value="junior">Junior</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="departmentTeaching" class="block text-gray-700 font-semibold mb-2">Department</label>
                    <input type="text" id="departmentTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Teaching Sub Tabs -->
                <div class="mb-4">
                    <button type="button" id="teacherWiseTab" class="px-4 py-2 rounded-l-lg bg-blue-500 text-white focus:outline-none">Teacher Wise</button>
                    <button type="button" id="departmentWiseTab" class="px-4 py-2 rounded-r-lg bg-gray-300 text-gray-700 focus:outline-none">Department Wise</button>
                </div>

                <!-- Teacher Wise Fields -->
                <div id="teacherWiseFields" class="mb-4">
                    <div class="mb-4">
                        <label for="casualLeaveTeacher" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveTeacher" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="medicalLeaveTeacher" class="block text-gray-700 font-semibold mb-2">Medical Leave</label>
                        <input type="number" id="medicalLeaveTeacher" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                </div>

                <!-- Department Wise Fields (initially hidden) -->
                <div id="departmentWiseFields" class="mb-4 hidden">
                    <div class="mb-4">
                        <label for="casualLeaveDept" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveDept" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="maternityLeaveDept" class="block text-gray-700 font-semibold mb-2">Maternity Leave</label>
                        <input type="number" id="maternityLeaveDept" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit</button>
            </form>
        </div>

        <!-- Non Teaching Form (initially hidden) -->
        <div id="nonTeachingForm" class="bg-white rounded-lg shadow-md p-6 hidden">
            <form>
                <div class="mb-4">
                    <label for="academicYearNonTeaching" class="block text-gray-700 font-semibold mb-2">Academic Year</label>
                    <input type="text" id="academicYearNonTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="typeNonTeaching" class="block text-gray-700 font-semibold mb-2">Type</label>
                    <select id="typeNonTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="laboratory">Laboratory</option>
                        <option value="office">Office</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="departmentNonTeaching" class="block text-gray-700 font-semibold mb-2">Department</label>
                    <input type="text" id="departmentNonTeaching" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Non Teaching Sub Tabs -->
                <div class="mb-4">
                    <button type="button" id="individualTab" class="px-4 py-2 rounded-l-lg bg-blue-500 text-white focus:outline-none">Individual</button>
                    <button type="button" id="allTab" class="px-4 py-2 rounded-r-lg bg-gray-300 text-gray-700 focus:outline-none">All</button>
                </div>

                <!-- Individual Fields -->
                <div id="individualFields" class="mb-4">
                    <div class="mb-4">
                        <label for="casualLeaveIndividual" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveIndividual" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="medicalLeaveIndividual" class="block text-gray-700 font-semibold mb-2">Medical Leave</label>
                        <input type="number" id="medicalLeaveIndividual" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                </div>

                <!-- All Fields (initially hidden) -->
                <div id="allFields" class="mb-4 hidden">
                    <div class="mb-4">
                        <label for="casualLeaveAll" class="block text-gray-700 font-semibold mb-2">Casual Leave</label>
                        <input type="number" id="casualLeaveAll" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                    <div class="mb-4">
                        <label for="maternityLeaveAll" class="block text-gray-700 font-semibold mb-2">Maternity Leave</label>
                        <input type="number" id="maternityLeaveAll" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // Main tab switching
        const teachingTab = document.getElementById('teachingTab');
        const nonTeachingTab = document.getElementById('nonTeachingTab');
        const teachingForm = document.getElementById('teachingForm');
        const nonTeachingForm = document.getElementById('nonTeachingForm');

        teachingTab.addEventListener('click', () => {
            teachingTab.classList.add('tab-active');
            nonTeachingTab.classList.remove('tab-active');
            teachingForm.classList.remove('hidden');
            nonTeachingForm.classList.add('hidden');
        });

        nonTeachingTab.addEventListener('click', () => {
            nonTeachingTab.classList.add('tab-active');
            teachingTab.classList.remove('tab-active');
            nonTeachingForm.classList.remove('hidden');
            teachingForm.classList.add('hidden');
        });

        // Teaching sub-tab switching
        const teacherWiseTab = document.getElementById('teacherWiseTab');
        const departmentWiseTab = document.getElementById('departmentWiseTab');
        const teacherWiseFields = document.getElementById('teacherWiseFields');
        const departmentWiseFields = document.getElementById('departmentWiseFields');

        teacherWiseTab.addEventListener('click', () => {
            teacherWiseTab.classList.add('subtab-active');
            departmentWiseTab.classList.remove('subtab-active');
            teacherWiseFields.classList.remove('hidden');
            departmentWiseFields.classList.add('hidden');
        });

        departmentWiseTab.addEventListener('click', () => {
            departmentWiseTab.classList.add('subtab-active');
            teacherWiseTab.classList.remove('subtab-active');
            departmentWiseFields.classList.remove('hidden');
            teacherWiseFields.classList.add('hidden');
        });

        // Non-Teaching sub-tab switching
        const individualTab = document.getElementById('individualTab');
        const allTab = document.getElementById('allTab');
        const individualFields = document.getElementById('individualFields');
        const allFields = document.getElementById('allFields');

        individualTab.addEventListener('click', () => {
            individualTab.classList.add('subtab-active');
            allTab.classList.remove('subtab-active');
            individualFields.classList.remove('hidden');
            allFields.classList.add('hidden');
        });

        allTab.addEventListener('click', () => {
            allTab.classList.add('subtab-active');
            individualTab.classList.remove('subtab-active');
            allFields.classList.remove('hidden');
            individualFields.classList.add('hidden');
        });
    </script>
</body>

</html>