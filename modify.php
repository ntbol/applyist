<?php

	session_start();

	require 'php/connect.php';

	//Check if user is logged in
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
		header('Location: login.php');
		exit;
	}


	if(isset($_SESSION['listid'])){
		$stmt = $pdo->prepare("SELECT * FROM listings WHERE id = ?");
		$stmt->execute([$_SESSION['listid']]);
		$modify = $stmt->fetch(PDO::FETCH_ASSOC);
}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Modify <?=$modify['title']?> Listing - Applyist</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<p><a href="dashboard.php">Head back to dashboard</a></p>
			<h1>Modify Listing</h1>
			<form action="" method="post">
				<div class="form-group">
					<input type="text" name="title" id="title" value="<?=$modify['title']?>" class="form-control">
				</div>
				<div class="form-group">
					<input type="text" name="company" id="company" value="<?=$modify['company']?>" class="form-control">
				</div>
				<div class="form-group">
					<input type="text" name="location" id="location" value="<?=$modify['location']?>" class="form-control">
				</div>
				<div class="form-group">
					<input type="text" name="link" id="link" value="<?=$modify['link']?>" class="form-control">
				</div>
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
					<div class="form-group col-6">
						<input type="submit" name="update" class="btn btn-primary btn-block" value="Update">
					</div>
					<div class="form-group col-6">
						<input type="submit" name="remove" class="btn btn-danger btn-block" value="Remove" href="delete.php?id=<?=$modify['id']?>">
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
			$id = $_SESSION['listid'];
			$title = htmlspecialchars($_POST['title']);
			$company = htmlspecialchars($_POST['company']);
			$location = htmlspecialchars($_POST['location']);
			$link = htmlspecialchars($_POST['link']);
			$status = htmlspecialchars($_POST['status']);
			$sql = "UPDATE listings SET title='$title', company='$company', location='$location', link='$link', status='$status' WHERE id='$id'";
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
			header('Location: dashboard.php');
		}

		?>



		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
	</html>