<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Leave Management Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaze Leave Management</title>
    <link rel="stylesheet" href="./output.css">
    <?php include('../../library/library.php'); ?>
    <!-- <link rel="stylesheet" href="" /> -->


</head>

<body class="bg-white dark:bg-black text-white">
    <?php include('../layouts/header.php'); ?>

    <?php include('../components/Main.php'); ?>
    <?php include('../layouts/footer.php'); ?>


    <!-- New egistration ajax for username -->
    <script>
        function change(a) {
            //alert(a.value);
            const username = a.value;
            const warning = document.getElementById("usernameWarning");

            if (username.length > 0) {

                $.ajax({
                    url: "../pages/check_username.php", // PHP file to check username
                    method: "POST",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response === "exists") {
                            warning.classList.remove("hidden"); // Show warning if username exists
                        } else {
                            warning.classList.add("hidden"); // Hide warning if username is available
                        }
                    }
                });
            } else {
                warning.classList.add("hidden"); // Hide warning if input is empty
            }
        }
    </script>
</body>
<?php include('../../library/AOS.php'); ?>

</html>