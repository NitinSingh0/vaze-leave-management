<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 dark:text-black">

    <div class=" bg-white border rounded-lg px-8 py-6 mx-auto my-8 max-w-4xl">
        <h1 class="text-2xl font-bold text-center mb-6 dark:text-black">Deactivate Staff</h1>
        <!-- Tabs -->
        <div class="flex border-b">
            <button id="teaching-tab" class="px-4 py-2 text-blue-500 font-semibold focus:outline-none border-b-2 border-blue-500">Teaching</button>
            <button id="nonteaching-tab" class="px-4 py-2 text-gray-500 font-semibold focus:outline-none border-b-2 border-transparent hover:text-blue-500">Non-Teaching</button>
        </div>

        <!-- Teaching Section -->
        <div id="teaching-section" class="mt-6">
            <div class="flex space-x-4 mb-4">
                <!-- Type Selection -->
                <div class="dark:text-black">
                    <label for="teaching-type" class="block text-gray-700 p-2">Type</label>
                    <select id="teaching-type" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="">Select Type</option>
                        <option value="degree">Degree</option>
                        <option value="junior">Junior</option>
                    </select>
                </div>
                <!-- Department Selection -->
                <div class="dark:text-black">
                    <label for="teaching-department" class="block text-gray-700 p-2">Department</label>
                    <select id="teaching-department" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="">Select Department</option>
                        <option value="science">Science</option>
                        <option value="commerce">Commercefdsfdsfdsfdfsdfds</option>
                        <option value="arts">Arts</option>
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
            </div>
            <br>
            <!-- Table -->
            <div id="teaching-table" class="hidden overflow-x-auto">
                <table class="w-full bg-white rounded-lg shadow-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date of Joining</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="teaching-staff-list"></tbody>
                </table>
            </div>



        </div>

        <!-- Non-Teaching Section -->
        <div id="nonteaching-section" class="mt-6 hidden">
            <div class="flex space-x-4 mb-4">
                <!-- Type Selection -->
                <div>
                    <label for="nonteaching-type" class="block text-gray-700  p-2 ">Type</label>
                    <select id="nonteaching-type" class="w-full border border-gray-300 p-2 rounded-lg focus:border-blue-400">
                        <option value="">Select Type</option>
                        <option value="laboratory">Laboratory</option>
                        <option value="office">Office</option>
                        <option value="office-operator">Office Operator</option>
                    </select>
                </div>
            </div>
            <!-- Table -->
            <div id="nonteaching-table" class="hidden overflow-x-auto">
                <table class="w-full bg-white rounded-lg shadow-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date of Joining</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="nonteaching-staff-list"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle Tabs
        const teachingTab = document.getElementById('teaching-tab');
        const nonTeachingTab = document.getElementById('nonteaching-tab');
        const teachingSection = document.getElementById('teaching-section');
        const nonTeachingSection = document.getElementById('nonteaching-section');

        teachingTab.addEventListener('click', () => {
            teachingSection.classList.remove('hidden');
            nonTeachingSection.classList.add('hidden');
            teachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            nonTeachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');
        });

        nonTeachingTab.addEventListener('click', () => {
            nonTeachingSection.classList.remove('hidden');
            teachingSection.classList.add('hidden');
            nonTeachingTab.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
            teachingTab.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500');
        });

        // Example data for demonstration purposes
        const exampleData = [{
                name: "John Doe",
                status: "Active",
                doj: "2020-01-10"
            },
            {
                name: "Jane Smith",
                status: "Deactive",
                doj: "2019-04-15"
            }
        ];

        // Populate Table (Teaching/Non-Teaching)
        function populateTable(type, department = "") {
            const tbody = type === "teaching" ? document.getElementById("teaching-staff-list") : document.getElementById("nonteaching-staff-list");
            tbody.innerHTML = "";

            exampleData.forEach(staff => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td class="px-4 py-2 text-center">${staff.name}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="${staff.status === 'Active' ? 'text-green-500' : 'text-red-500'}">${staff.status}</span>
                    </td>
                    <td class="px-4 py-2 text-center">${staff.doj}</td>
                    <td class="px-4 py-2 text-center">
                        <button class=" w-full p-6 text-sm ${staff.status === 'Active' ? 'bg-red-500 text-white px-4 py-2 rounded-lg' : ' bg-green-500 text-white px-4 py-2 rounded-lg'} hover:underline ">
                            ${staff.status === 'Active' ? 'Deactivate' : 'Activate'}
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            document.getElementById(`${type}-table`).classList.remove("hidden");
        }

        // Event Listeners for dropdown changes to load data
        document.getElementById('teaching-type').addEventListener('change', () => {
            if (document.getElementById('teaching-department').value !== "") {
                populateTable("teaching");
            }
        });
        document.getElementById('teaching-department').addEventListener('change', () => {
            if (document.getElementById('teaching-type').value !== "") {
                populateTable("teaching");
            }
        });
        document.getElementById('nonteaching-type').addEventListener('change', () => {
            populateTable("nonteaching");
        });
    </script>
</body>

</html>