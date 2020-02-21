<?php require('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Password Reset - Applyist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
</head>
<body>
    <?php include('php/regnav.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="job-title">Reset password</h1>
                <form action="forgot.php" method="post">
                    <!-- form validation messages -->
                    <?php include('php/messages.php'); ?>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="reset-password" value="Reset" class="btn btn-theme btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>