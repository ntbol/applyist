<?php

	session_start();

	require 'php/connect.php';

	//Check if user is logged in
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
		header('Location: login.php');
		exit;
	}



	if(isset($_GET['listid'])){
		$stmt = $pdo->prepare("SELECT * FROM listings WHERE id = ?");
		$stmt->execute([$_GET['listid']]);
		$modify = $stmt->fetch(PDO::FETCH_ASSOC);
}

	if($_SESSION['user_id'] != $modify['userid']){
		header('Location: dashboard.php');
		exit;
	}

		//Pull username from ID
	if (isset($_SESSION['user_id'])) {
		$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
		$stmt->execute([$_SESSION['user_id']]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Modify <?=$modify['title']?> - Applyist</title>
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
	                   <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle small-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          Hey, <?=ucwords($user['username'])?> !
				        </a>
				        	<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 5px">
				        		<a class="dropdown-item" href="#">Change Password</a>
				        		<div class="dropdown-divider"></div>
				          		<form action="php/logout.php" method="post">
									<button class="btn-block btn btn-danger">Logout</button>
								</form>
				        	</div>
				      	</li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	    
		<div class="container">
			<p><a href="dashboard.php" style="color: black!important"><span class="fas fa-chevron-left"></span> Back to Dashboard</a></p>
			<h1>Modify Job</h1>
			<hr>
			<form action="" method="post">
				<div class="form-group">
					Position Title:
					<input type="text" name="title" id="title" value="<?=$modify['title']?>" class="form-control">
				</div>
				<div class="form-group">
					Company Name:
					<input type="text" name="company" id="company" value="<?=$modify['company']?>" class="form-control">
				</div>
				<div class="form-group">
					Job Location:
					<input type="text" name="location" id="location" value="<?=$modify['location']?>" class="form-control">
				</div>
				<div class="form-group">
					Posting Link:
					<input type="text" name="link" id="link" value="<?=$modify['link']?>" class="form-control">
				</div>
				<div class="form-group">
					Current Status:
					  <select name="status" id="status" class="form-control">
						    <option value="applied">Applied</option>
						    <option value="interviewing">Interviewing</option>
						    <option value="under review">Under Review</option>
						    <option value="offer received">Offer Received</option>
						    <option value="rejected">Rejected</option>
					  </select>
				</div>
				<div class="row">
					<div class="form-group col-6">
						<input type="submit" name="update" class="btn btn-theme btn-block" value="Update">
					</div>
					<div class="form-group col-6">
						<input type="submit" name="remove" class="btn btn-theme-second btn-block" value="Remove" href="delete.php?id=<?=$modify['id']?>">
					</div>
				</div>
			</form>		
		</div>
		<?php
		if(isset($_POST["update"])){

			$hostname='localhost:3308';
			$username='root';
			$password='';
			try {
			$dbh = new PDO("mysql:host=$hostname;dbname=applyist",$username,$password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
			$id = $_GET['listid'];
			$title = htmlspecialchars($_POST['title']);
			$company = htmlspecialchars($_POST['company']);
			$location = htmlspecialchars($_POST['location']);
			$link = htmlspecialchars($_POST['link']);
			$status = htmlspecialchars($_POST['status']);
			$sql = "UPDATE listings SET title='$title', company='$company', location='$location', link='$link', status='$status' WHERE id='$id'";
				if ($dbh->query($sql)) {
				echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
				header('dashboard.php');
				}
				else{
				echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
				}			
			$dbh = null;
			}
			catch(PDOException $e)
			{
			echo $e->getMessage();
			}
			header('Location: dashboard.php');
		}

		
		if(isset($_POST["remove"])){
			$hostname='localhost:3308';
			$username='root';
			$password='';
			try {
			$dbh = new PDO("mysql:host=$hostname;dbname=applyist",$username,$password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$id = $_GET['listid'];
			$sql = "DELETE FROM listings WHERE id = '$id'";
			$dbh->exec($sql);
			echo "Record deleted successfully";
		    }
			catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		    }
		    $dbh = null;
			header('Location: dashboard.php');
		}

		?>



		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
	</html>