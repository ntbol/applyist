<?php
    error_reporting(0);
    ini_set('display_errors', 0);

	session_start();

	require 'php/connect.php';

	//Require password hasher
	require 'lib/password.php';

	//Assigns session id to a varible
    $userid = $_SESSION['user_id'];

    //Check if user is logged in
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
		header('Location: login.php');
		exit;
	}

	//Pull username from ID
	if (isset($_SESSION['user_id'])) {
		$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
		$stmt->execute([$_SESSION['user_id']]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	//Pull users jobs from ID
	$id = $_SESSION['user_id'];
		$stmtlist = $pdo->prepare("SELECT * FROM listings WHERE userid='$id' ORDER BY id");
		$stmtlist->execute();
		$listing = $stmtlist->fetchAll(PDO::FETCH_ASSOC);


	// Updates profile picture
	if(isset($_POST["updatePic"])){
			$profile_img = $_POST['test'];
			try {
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
			$sql = "UPDATE users SET profile_img = '$profile_img' WHERE id = '$userid'";
				if ($pdo->query($sql)) {
 					header('Location: '.$_SERVER['REQUEST_URI']);
				}
				else{
				echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
				}			
			$pdo = null;
			}
			catch(PDOException $e)
			{
			echo $e->getMessage();
			}
		}

	//Update Email Address
	if ($_POST['newEmail'] == $_POST['confirmEmail']){
		if(isset($_POST["updateEmail"])){
			$email = $_POST['confirmEmail'];
			try {
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
			$sql = "UPDATE users SET email = '$email' WHERE id = '$userid'";
				if ($pdo->query($sql)) {
 					header('Location: '.$_SERVER['REQUEST_URI']);
				}
				else{
				echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
				}			
			$pdo = null;
			}
			catch(PDOException $e)
			{
			echo $e->getMessage();
			}
		}
	} else {
		echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
	}

	//Update Password
	if ($_POST['newPassword'] == $_POST['confirmPassword']){
		if(isset($_POST["updatePass"])){
			$password = $_POST['confirmPassword'];
			$passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
			try {
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
			$sql = "UPDATE users SET password = '$passwordHash' WHERE id = '$userid'";
				if ($pdo->query($sql)) {
 					header('Location: '.$_SERVER['REQUEST_URI']);
				}
				else{
				echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
				}			
			$pdo = null;
			}
			catch(PDOException $e)
			{
			echo $e->getMessage();
			}
		}
	} else {
		echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=ucwords($user['username'])?>'s Profile - Applyist</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/custom.css" type="text/css">
    </head>
    <body>
    <?php include('php/nav.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="dashboard.php" class="btn btn-theme btn-block">Back to Dashboard</a>
            </div>
            <div class="col-md-9" align="right">

            </div>
        </div>
        <hr>
        <div class="row">
            <!-- Change Password -->
            <div class="col-md-6" style="padding-top: 15px;">
                <h4 class="small-header-bold">Update Password</h4>
                <form action="" method="post">
                    <h5 class="form-info">Current Password :</h5>
                    <input type="password" name="currentPassword" class="form-control">
                    <h5 class="form-info">New Password :</h5>
                    <input type="password" name="newPassword" class="form-control">
                    <h5 class="form-info">Confirm New Password :</h5>
                    <input type="password" name="confirmPassword" class="form-control">
                    <div style="padding-top: 15px">
                        <input type="submit" name="updatePass" class="btn btn-theme btn-block" value="Update Password">
                    </div>
                </form>
            </div>
            <!-- Change Email -->
            <div class="col-md-6" style="padding-top: 15px;">
                <h4 class="small-header-bold">Update Email</h4>
                <form action="" method="post">
                    <h5 class="form-info">Current Email :</h5>
                    <input type="email" name="currentEmail" class="form-control" value="<?=$user['email']?>">
                    <h5 class="form-info">New Email :</h5>
                    <input type="email" name="newEmail" class="form-control">
                    <h5 class="form-info">Confirm New Email :</h5>
                    <input type="email" name="confirmEmail" class="form-control">
                    <div style="padding-top: 15px">
                        <input type="submit" name="updateEmail" class="btn btn-theme btn-block" value="Update Email">
                    </div>
                </form>
            </div>
            <!-- Change Profile Img -->
            <div class="col-md-12" style="padding-top: 35px;">
                <h4 class="small-header-bold">Update Profile Picture</h4>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <label>
                              <input type="radio" name="test" value="gray.jpg">
                              <img src="img/gray.jpg" class="big-profile">
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <label>
                              <input type="radio" name="test" value="yellow.jpg">
                              <img src="img/yellow.jpg" class="big-profile">
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <label>
                              <input type="radio" name="test" value="blue.jpg">
                              <img src="img/blue.jpg" class="big-profile">
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <label>
                              <input type="radio" name="test" value="green.jpg">
                              <img src="img/green.jpg" class="big-profile">
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <label>
                              <input type="radio" name="test" value="red.jpg">
                              <img src="img/red.jpg" class="big-profile">
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 col-4" style="padding-top: 15px;">
                            <input type="submit" name="updatePic" class="btn btn-theme-round btn-block" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>