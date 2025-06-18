<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V. G. VAZE</title>
    <?php include('../../library/library.php'); ?>
    <?php include('../../config/connect.php'); ?>
    <link rel="stylesheet" href="../../css/common/header.css" />
</head>

<body class="bg-white dark:bg-black">
    <!--
    /***************
    NAVBAR 
    ****************/
    -->

    <!--
    /***************
    MAIN CONTENTS 
    ****************/
    -->
    <?php include('../Components/forgot.php'); ?>

    <!--
    /***************
    FOOTER
    ****************/
    -->

</body>
<?php include('../../library/AOS.php'); ?>

</html>