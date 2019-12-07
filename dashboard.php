<?php

	session_start();

	require 'php/connect.php';

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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$user['username']?>'s Dashboard - Applyist</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-6">
			<h1>Hello, <?=$user['username']?></h1>
		</div>
		<div class="col-6" align="right" style="padding-top: 15px;">
			<form action="php/logout.php" method="post">
				<button class="btn btn-danger">Logout</button>
			</form>
		</div>
	</div>

<a href="new.php" class="btn btn-secondary">Add Job</a>
<hr>
	

<?php foreach ($listing as $list): ?>
	<?php $var = $list['id'];?>
	<div class="row">
		<div class="col-6">
			<h2><?=$list['title']?></h2>
			<h5><b><?=$list['company']?></b> | <?=$list['location']?></h5>
			<h5>Status: <b><?=ucwords($list['status'])?></b></h5>
		</div>
		<div class="col-6" align="right" style="padding-top: 15px">
			<form action="modify.php" method="post">
				<?php $_SESSION['listid'] = $list['id']; ?>
				<button class="btn btn-primary">Modify</button>
			</form>
		</div>
	</div>
<?php endforeach; ?>

</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>