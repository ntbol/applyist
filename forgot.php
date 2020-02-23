<?php require('app_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158932799-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-158932799-1');
    </script>

    <meta charset="utf-8">
    <title>Password Reset - Applyist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
</head>
<body>
<div id="page-container">
    <div id="content-wrap">
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
    </div>
    <?php include 'php/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</div>
</body>
</html>