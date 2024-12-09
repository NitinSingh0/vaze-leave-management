<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Principal Report Page</title>

    <link rel="stylesheet" href="./output.css">
    <?php include('../../library/library.php'); ?>

    <!-- <script src="scripts.js"></script> -->
</head>
<?php include('../layouts/header.php'); ?>

<body class="bg-gray-100 p-6 pl-0">
    
    <div class="mt-11 flex h-screen">
        <!-- Sidebar -->
        <?php include('../layouts/sidebar.php'); ?>

        <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8 justify-items-center">
            <h1 class="text-2xl font-bold mb-4">Principal Report Page</h1>

            <!-- Tabs for Department and Individual Teacher -->
            <div class="mb-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="department-tab" class="tab-btn text-gray-700 py-4 px-1 border-b-2 border-blue-500">Department Report</button>
                    <button id="teacher-tab" class="tab-btn text-gray-500 hover:text-gray-700 py-4 px-1">Individual Teacher Report</button>
                </nav>
            </div>

            <!-- Department Report Form (default visible) -->
            <div id="department-form" class="report-form">
                <label class="block mb-2">Select College:</label>
                <select id="college" class="block w-full border rounded p-2 mb-4">
                    <option value="" disabled selected>Select College</option>
                    <option value="D">Degree</option>
                    <option value="J">Junior</option>
                </select>

                <label class="block mb-2">Select Department:</label>

                <select id="department" class="block w-full border rounded p-2 mb-4">

                </select>

                <button id="download-department-report" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Department Report</button>
            </div>

            <!-- Teacher Report Form (initially hidden) -->
            <div id="teacher-form" class="report-form hidden">
                <label class="block mb-2">Select College:</label>
                <select id="college-teacher" class="block w-full border rounded p-2 mb-4">
                    <option value="" disabled selected>Select College</option>
                    <option value="D">Degree</option>
                    <option value="J">Junior</option>
                </select>

                <label class="block mb-2">Select Department:</label>
                <select id="department-teacher" class="block w-full border rounded p-2 mb-4">

                </select>

                <label class="block mb-2">Select Staff:</label>
                <select id="staff" class="block w-full border rounded p-2 mb-4">

                </select>

                <button id="download-teacher-report" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Teacher Report</button>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Set default view to Department Report tab
                $("#department-form").show();
                $("#teacher-form").hide();

                // Tab switching
                $("#department-tab").on("click", function() {
                    $(".tab-btn").removeClass("text-gray-700 border-blue-500").addClass("text-gray-500");
                    $(this).removeClass("text-gray-500").addClass("text-gray-700 border-blue-500");

                    $(".report-form").hide();
                    $("#department-form").show();
                });

                $("#teacher-tab").on("click", function() {
                    $(".tab-btn").removeClass("text-gray-700 border-blue-500").addClass("text-gray-500");
                    $(this).removeClass("text-gray-500").addClass("text-gray-700 border-blue-500");

                    $(".report-form").hide();
                    $("#teacher-form").show();
                });

                // Load departments for Department Report tab
                $("#college").change(function() {
                    let collegeType = $(this).val();
                    console.log("Department Report - College selected:", collegeType); // Debugging log

                    if (collegeType) {
                        $.ajax({
                            url: "get_departments.php",
                            method: "POST",
                            data: {
                                college: collegeType
                            },
                            success: function(response) {
                                console.log("Response received:", response);
                                // Check if the response contains proper <option> tags
                                if (response.indexOf('<option') !== -1) {
                                    //$("#department").empty(); // Clear existing options
                                    $("#department").append('<option value="" disabled selected>Select Department</option>');
                                    // Append new options directly
                                    $(response).appendTo("#department");
                                } else {
                                    console.error("Response doesn't contain valid options.");
                                }
                            },
                            error: function(error) {
                                console.error("Error loading departments:", error);
                            }
                        });
                    }
                });


                // Load departments for Individual Teacher tab
                $("#college-teacher").change(function() {
                    let collegeType = $(this).val();
                    console.log("Individual Teacher Report - College selected:", collegeType); // Debugging log

                    if (collegeType) {
                        $.ajax({
                            url: "get_departments.php",
                            method: "POST",
                            data: {
                                college: collegeType
                            },
                            success: function(response) {
                                console.log("Individual Teacher Report - Departments loaded:", response); // Debugging log
                                $("#department-teacher").html('<option value="" disabled selected>Select Department</option>' + response);
                            },
                            error: function(error) {
                                console.error("Individual Teacher Report - Error loading departments:", error);
                            }
                        });
                    }
                });

                // Load staff based on selected department
                $("#department-teacher").change(function() {
                    let departmentId = $(this).val();

                    if (departmentId) {
                        $.ajax({
                            url: "get_staff.php",
                            method: "POST",
                            data: {
                                department_id: departmentId
                            },
                            success: function(response) {
                                $("#staff").html('<option value="" disabled selected>Select Staff</option>' + response);
                            },
                            error: function(error) {
                                console.error("Error loading staff:", error);
                            }
                        });
                    }
                });

                // Download reports
                $("#download-department-report").on("click", function() {
                    let college = $("#college").val();
                    let department = $("#department").val();
                    window.location.href = `generate_report.php?report_type=department&college=${college}&department=${department}`;
                });

                $("#download-teacher-report").on("click", function() {
                    let college = $("#college-teacher").val();
                    let department = $("#department-teacher").val();
                    let staff = $("#staff").val();
                    window.location.href = `generate_report.php?report_type=teacher&college=${college}&department=${department}&staff=${staff}`;
                });
            });
        </script>
</body>

</html>