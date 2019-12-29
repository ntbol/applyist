<?php
//register.php

session_start();

//Require password hasher
require 'lib/password.php';

//Require MYSQL connection
require 'php/connect.php';


if(isset($_POST['register'])){

	//Retriving feild values
	$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
	$password = !empty($_POST['password']) ? trim($_POST['password']) : null;
	$email = !empty($_POST['email']) ? trim($_POST['email']) : null;

	//Checking if the supplied username already exists
	//Preparing SQL statement
	$sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	//Fetch the row
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	//Username already exists error
	if($row['num'] > 0){
		die('That username already exists!');
	}

	//Hasing the password
	$passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

	//Preparing insert statement
	$sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
	$stmt = $pdo->prepare($sql);
	//Bind varibles
	$stmt->bindValue(':username', $username);
	$stmt->bindValue(':password', $passwordHash);
	$stmt->bindValue(':email', $email);

	//Execute the statement
	$result = $stmt->execute();

	//If signup was successful
	if($result) {
		echo "Thank you for signing up :D";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Register a New Account - Applyist</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php"><h1 class="nav">applyist</h1></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto "></ul>
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link small-text-bold ">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link small-text-bold active">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link small-text-bold ">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="container">
        <div class="row">
            <div class="col-md-6">
            <h1 class="job-title">Register</h1>
            <form action="register.php" method="post">
                <div class="form-group">
                    <input type="text"  id="email" name="email" placeholder="email address" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text"  id="username" name="username" placeholder="username" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="register" value="Register" class="btn btn-theme btn-block">
                </div>
            </form>
                <p>Have an account? <a href="login.php">Login Here</a></p>
            </div>
        </div>
	</div>



	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>