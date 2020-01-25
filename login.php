<?php
    session_start();

    //Hashing file
    require 'lib/password.php';

    //MYSQL DB connection
    require 'php/connect.php';

    if(isset($_POST['login'])){

        //Retrieve the field values from our login form.
        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

        //Retrieve the user account information for the given username.
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        //Bind value.
        $stmt->bindValue(':username', $username);

        //Execute.
        $stmt->execute();

        //Fetch row.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //If $row is FALSE.
        if($user === false){
            //Could not find a user with that username!
            //PS: You might want to handle this error in a more user-friendly manner!
            header('Location: php/error.php');
        } else{
            //User account found. Check to see if the given password matches the
            //password hash that we stored in our users table.

            //Compare the passwords.
            $validPassword = password_verify($passwordAttempt, $user['password']);

            //If $validPassword is TRUE, the login has been successful.
            if($validPassword){

                //Provide the user with a login session.
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = time();

                //Redirect to our protected page, which we called home.php
                header('Location: dashboard.php');
                exit;

            } else{
                //$validPassword was FALSE. Passwords do not match.
                header('Location: php/error.php');
            }
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Applyist</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/custom.css" type="text/css">
    </head>
    <body>
    <?php include('php/regnav.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                <h1 class="job-title">Login</h1>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" id="username" placeholder="username" placeholder="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="password">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-theme btn-block">
                    </div>
                </form>
                <p>Dont have an account? <a href="register.php">Register Here</a></p>
                <p><a href="forgot.php">Forgot Password?</a></p>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>