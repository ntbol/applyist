<?php

require 'lib/password.php';

session_start();
$errors = [];
$user_id = "";
// connect to database
$db = mysqli_connect('mysql.applyistapp.com', 'appylistadmin', '!@PAintman12', 'applyistapp');


if (isset($_POST['reset-password'])) {
    $email = addslashes(htmlspecialchars($_POST['email']));
    // ensure that the user exists on our system
    $query = "SELECT email FROM users WHERE email='$email'";
    $results = mysqli_query($db, $query);

    if (empty($email)) {
        array_push($errors, "Your email is required");
    }else if(mysqli_num_rows($results) <= 0) {
        array_push($errors, "Sorry, no user exists on our system with that email");
    }
    // generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
        // store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
        $results = mysqli_query($db, $sql);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Reset your password on Applyist";
        $msg = "
           <html>
                <head>
                    <title>Reset your password on Applyist</title>
                </head>
                <body>
                    <h2>Oh no!</h2>
                    <h4>Looks like you lost your password :(</h4>
                    <h4>Dont worry <a href=\"applyistapp.com/new_pass.php?token=" . $token . "\"><b> we got you</b></a>!</h4>
                    <p style = 'margin-bottom: 0px'> -Applyist Support </p>
                    <img src = 'applyistapp.com/img/applyemaillogo.png' width ='120px'>
                </body>
            </html>
        ";
        $msg = wordwrap($msg,70);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: support@applyistapp.com" . "\r\n";
        mail($to, $subject, $msg, $headers);
        header('location: pending.php?email=' . $email);
    }
}

// ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, addslashes(htmlspecialchars($_POST['new_pass'])));
    $new_pass_c = mysqli_real_escape_string($db, addslashes(htmlspecialchars($_POST['new_pass_c'])));

    // Grab to token that came from the email link
    $token = addslashes(htmlspecialchars($_GET['token']));
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
    if (count($errors) == 0) {
        // select email address of user from the password_reset table
        $sql = "SELECT email FROM password_resets WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        $pass_hash = password_hash($new_pass, PASSWORD_BCRYPT, array("cost" => 12));
        $sql = "UPDATE users SET password='$pass_hash' WHERE email='$email'";
        $results = mysqli_query($db, $sql);
        header('location: login.php');
    }
}
?>