<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Principal Report Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Principal Report Page</h1>

        <!-- Tabs for Department and Individual Teacher -->
        <div class="mb-4 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button id="department-tab" class="tab-btn text-gray-500 hover:text-gray-700 py-4 px-1">Department Report</button>
                <button id="teacher-tab" class="tab-btn text-gray-500 hover:text-gray-700 py-4 px-1">Individual Teacher Report</button>
            </nav>
        </div>

        <!-- Department Report Form -->
        <div id="department-form" class="report-form hidden">
            <label class="block mb-2">Select College:</label>
            <select id="college" class="block w-full border rounded p-2 mb-4">
                <option value="D">Degree</option>
                <option value="J">Junior</option>
            </select>

            <label class="block mb-2">Select Department:</label>
            <select id="department" class="block w-full border rounded p-2 mb-4"></select>

            <button id="download-department-report" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Department Report</button>
        </div>

        <!-- Teacher Report Form -->
        <div id="teacher-form" class="report-form hidden">
            <label class="block mb-2">Select College:</label>
            <select id="college-teacher" class="block w-full border rounded p-2 mb-4">
                <option value="D">Degree</option>
                <option value="J">Junior</option>
            </select>

            <label class="block mb-2">Select Department:</label>
            <select id="department-teacher" class="block w-full border rounded p-2 mb-4"></select>

            <label class="block mb-2">Select Staff:</label>
            <select id="staff" class="block w-full border rounded p-2 mb-4"></select>

            <button id="download-teacher-report" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Teacher Report</button>
        </div>
    </div>
</body>

</html>