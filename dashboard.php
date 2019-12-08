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
	<title><?=ucwords($user['username'])?>'s Dashboard - Applyist</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/custom.css" type="text/css">
</head>
<body>
 	<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><h1 class="nav">applyist</h1></a>
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
	<div class="row">
		<div class="col-3">
			<a href="new.php" class="btn btn-theme btn-block">Add Job</a>
		</div>
	</div>
	<hr>
	

<?php foreach ($listing as $list): ?>
	<? $myVar = $list['id'] ?>
	<div class="row floats">
			<div class="col-6">
				<h2><?=$list['title']?></h2>
				<h5><b><?=$list['company']?></b> | <?=$list['location']?></h5>
				<h5>Status: <b><?=ucwords($list['status'])?></b></h5>
			</div>
			<div class="col-6" align="right" style="padding-top: 15px">
				<?php $myVar = $list['id'];?>
				<form action="modify.php" method="get">
					<input type="hidden" name="listid" value="<?php echo $myVar; ?>">
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