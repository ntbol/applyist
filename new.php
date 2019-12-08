<?php

	session_start();

	require 'php/connect.php';

	//Check if user is logged in
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
		header('Location: login.php');
		exit;
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>New Listing - Applyist</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="css/custom.css" type="text/css">
	</head>
	<body>
		<div class="container">
			<p><a href="dashboard.php">Head back to dashboard</a></p>
			<h1>New Job</h1>
			<form action="" method="post">
				Position Title:
				<div class="form-group">
					<input type="text" name="title" id="title"  class="form-control" placeholder="Position Title">
				</div>
				Company:
				<div class="form-group">
					<input type="text" name="company" id="company"  class="form-control" placeholder="Company">
				</div>
				Location:
				<div class="form-group">
					<input type="text" name="location" id="location" class="form-control" placeholder="Location">
				</div>
				Date Applied:
				<div class="form-group">
					<input type="date" name="date" id="date" class="form-control">
				</div>
				Link to Posting:
				<div class="form-group">
					<input type="text" name="link" id="link" class="form-control" placeholder="Link to Posting">
				</div>
				Current Status:
				<div class="form-group">
					  <select name="status" id="status" class="form-control">
						    <option value="applied">Applied</option>
						    <option value="interviewing">Interviewing</option>
						    <option value="under review">Under Review</option>
						    <option value="got an offer">Got and Offer</option>
						    <option value="rejected">Rejected</option>
					  </select>
				</div>
				<div class="row">
					<div class="form-group col-12">
						<input type="submit" name="submit" class="btn btn-theme btn-block" value="Submit">
					</div>
				</div>
			</form>		
		</div>
		<?php
		if(isset($_POST["submit"])){
			$userid = $_SESSION['user_id'];

			$hostname='localhost:3308';
			$username='root';
			$password='';
			try {
			$dbh = new PDO("mysql:host=$hostname;dbname=applyist",$username,$password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
			$sql = "INSERT INTO listings (title, company, location, link, status, userid, date_applied)
			VALUES ('".$_POST["title"]."','".$_POST["company"]."','".$_POST["location"]."','".$_POST["link"]."','".$_POST["status"]."','".$userid."','".$_POST["date"]."')";
				if ($dbh->query($sql)) {
				echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
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
		}
		?>



		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
	</html>