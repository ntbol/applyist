<?php
    session_start();

    $token = addslashes(htmlspecialchars($_GET['token']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Password - Applyist</title>
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
                        <h1 class="job-title">Set new password</h1>
                        <form class="login-form" action="app_logic.php?token=<?=$token?>" method="post">
                            <!-- form validation messages -->
                            <?php include('php/messages.php'); ?>
                            <div class="form-group">
                                <input type="password" name="new_pass" class="form-control" placeholder="New password">
                            </div>
                            <div class="form-group">
                                <input type="password" name="new_pass_c" class="form-control" placeholder="Confirm new password">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="new_password" class="btn btn-theme btn-block">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php' ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>