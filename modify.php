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

    //Restricts access based on user id
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

    //Updates record
    if (isset($_POST["update"])) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
            $id = $_GET['listid'];
            $title = addslashes(htmlspecialchars($_POST['title']));
            $company = addslashes(htmlspecialchars($_POST['company']));
            $location = addslashes(htmlspecialchars($_POST['location']));
            $link = addslashes(htmlspecialchars($_POST['link']));
            $status = addslashes(htmlspecialchars($_POST['status']));
            $sql = "UPDATE listings SET title='$title', company='$company', location='$location', link='$link', status='$status' WHERE id='$id'";
            if ($pdo->query($sql)) {
                header('Location: dashboard.php');
                exit;
            } else {
                echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
                header('Location: dashboard.php');
            }
            $pdo = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        header('Location: dashboard.php');
    }

    // Removes record
    if (isset($_POST["remove"])) {
        $id = $_GET['listid'];
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM listings WHERE id = '$id'";
            $pdo->exec($sql);
            header('Location: dashboard.php');
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $pdo = null;
        header('Location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html>
	<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158932799-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-158932799-1');
        </script>

        <meta charset="utf-8">
		<title>Modify <?=$modify['title']?> - Applyist</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="css/custom.css" type="text/css">
	</head>
	<body>
    <div id="page-container">
        <div id="content-wrap">
            <?php include('php/nav.php'); ?>
                <div class="container">
                    <p><a href="dashboard.php" style="color: black!important"><span class="fas fa-chevron-left"></span> Back to Dashboard</a></p>
                    <h1 class="job-title">Modify Job</h1>
                    <form action="" method="post">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <span class="form-info">Position Title:</span>
                                <input type="text" name="title" id="title" value="<?=$modify['title']?>" class="form-control-theme">
                            </div>
                            <div class="col-md-6">
                                <span class="form-info">Company Name:</span>
                                <input type="text" name="company" id="company" value="<?=$modify['company']?>" class="form-control-theme">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <span class="form-info">Job Location:</span>
                                <input type="text" name="location" id="location" value="<?=$modify['location']?>" class="form-control-theme">
                            </div>
                            <div class="col-md-6">
                                <span class="form-info">Posting Link:</span>
                                <input type="text" name="link" id="link" value="<?=$modify['link']?>" class="form-control-theme">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <span class="form-info">Current Status:</span>
                                <select name="status" id="status" class="form-control-theme">
                                    <option value="<?=$modify['status']?>" selected='selected'><?=ucwords($modify['status'])?></option>
                                    <option value="applied">Applied</option>
                                    <option value="interviewing">Interviewing</option>
                                    <option value="under review">Under Review</option>
                                    <option value="offer received">Offer Received</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <span class="form-info invisible">Current Status:</span>
                                <input type="submit" name="remove" class="btn btn-theme-second btn-block" value="Remove" href="delete.php?id=<?=$modify['id']?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="submit" name="update" class="btn btn-theme btn-block" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php include 'php/footer.php' ?>
        </div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
	</html>