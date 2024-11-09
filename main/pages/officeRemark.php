<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Principal Report Page</title>

    <link rel="stylesheet" href="./output.css">
    <?php include('../../library/library.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .active {
            display: block;
        }

        .inactive {
            display: none;
        }

        .active-tab {
            background-color: #bfdbfe;
            /* Light blue for active tab */
            color: #1e3a8a;
            /* Dark blue text color */
        }
    </style>
    <!-- <script src="scripts.js"></script> -->
</head>


<body class="bg-gray-100  ">

    <?php include('../layouts/header.php'); ?>

    <div class="mt-11 flex h-screen">
        <!-- Sidebar -->
        <?php include('../layouts/sidebar.php');
        ?>


        <?php
        include('../components/officeRemark.php');
        ?>

    </div>
</body>

</html>