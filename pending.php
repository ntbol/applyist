<?php include('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Password Reset Pending - Applyist</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/custom.css" type="text/css">
    </head>
    <body>
    <div id="page-container">
        <div id="content-wrap">
        <?php include('php/regnav.php'); ?>
            <form class="login-form" action="login.php" method="post" style="text-align: center;">
                <p>
                    We sent an email to  <b><?php echo $_GET['email'] ?></b> to help you recover your account.
                </p>
                <p>Please login into your email account and click on the link we sent to reset your password</p>
            </form>
        </div>
        <?php include 'php/footer.php' ?>
    </div>
    </body>
</html>