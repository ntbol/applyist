<?php
error_reporting(0);
ini_set('display_errors', 0);

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
		$stmtlist = $pdo->prepare("SELECT * FROM listings WHERE userid='$id' ORDER BY date_applied DESC");
		$stmtlist->execute();
		$listing = $stmtlist->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=ucwords($user['username'])?>'s Dashboard - Applyist</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link rel="stylesheet" href="css/custom.css" type="text/css">
</head>
<body>
<?php include('php/nav.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<a href="new.php" class="btn btn-theme btn-block">Add Job</a>
		</div>
		<div class="col-md-9" align="right">
			<h5 class="small-header" style="font-weight: 600;"><a href="#" onclick="toggle_visibility('foo');" class="theme-link">Filter <span class="fas fa-caret-down"></span></a></h5>
		</div>
	</div>
	<div id="foo" class="row" style="padding-top: 20px;display: none;">
		<div class="col-12">
			<div class="floats" style="margin-bottom: 0px; padding: 10px 0px 10px 0px;" align="center">
				<button class="active btn btn-show" data-filter="box">Show All</button>
	            <button class="btn btn-applied" data-filter="applied">Applied</button>
	            <button class="btn btn-under-review" data-filter="under-review">Under Review</button>
	            <button class="btn btn-interviewing" data-filter="interviewing">Interviewing</button>
	            <button class="btn btn-offer-received" data-filter="offer-received">Offer Received</button>
	            <button class="btn btn-rejected" data-filter="rejected">Rejected</button>
			</div>
		</div>
	</div>
	<hr>
	<? $myVar = $list['id'] ?>
	<?php foreach ($listing as $list): ?>
	<?php
		//Allows two word statuses to be used as classes. Adds '-' between each word
		$status = $list['status'];
		$trimmedStatus = str_replace(' ', '-', trim($status));
	?>
	<div id="parent">
		<div class="floats box <?=$trimmedStatus?>">
			<div class="row" style="display: table; width:100%;">
				<div class="statusColor">
					<div class="status-tag"><span class="invisible"><?=$list['status']?></span></div>
				</div>
				<div class="col-10" style="display: table-cell; vertical-align: middle;">
					<h2 class="job-title"><?=$list['title']?></h2>
					<h5 class="small-header"><span class="fas fa-building"></span> <span style="font-weight: 600"><?=$list['company']?></span>&nbsp;&nbsp;&nbsp;<span class="fas fa-map-marker-alt"></span> <?=$list['location']?>&nbsp;&nbsp;&nbsp;<span title="Date Applied On"><span class="far fa-calendar-alt"></span> <?=$list['date_applied']?></span></h5>
					<h5 class="small-header" style="font-style: italic;">
                        <span class="fas fa-rocket"></span> Status: <span style="font-weight: 600; font-style: normal;"><?=ucwords($list['status'])?></span> &nbsp;<span class="fas fa-eye"></span>
                            <?php
                                if($list['link'] == null){
                                    echo "<a href='modify.php?listid=" . $list['id'] . "' class='theme-link'>Please Link Original Job</a>";
                                } else {
                                    echo "<a href=" . $list['link'] . "  class='theme-link' target='_blank'>View Status</a>";
                                }
                            ?>
                    </h5>
				</div>
				<div class="col-2" style="display: table-cell; vertical-align: middle;">
					<?php $myVar = $list['id'];?>
					<form action="modify.php" method="get">
						<input type="hidden" name="listid" value="<?php echo $myVar; ?>">
						<button class="btn btn-theme btn-block">Modify</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php
		if($list === null){
			echo "<div align='center'><i>Oh no... It apears you have applied to no jobs :(<br><a href='new.php'>Add one here</a></i></div>";
		} 
	?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<script>
	$(function() {
	    //var text = $('.image-container>.status-tag').text().toLowerCase(), color;
	    $('.statusColor>.status-tag').each(function(){
	    	console.log($(this).text());
	      var text = $(this).text().toLowerCase();
	    	switch (text) {
	     	case 'applied':
	        color = '#BDC3C7';
	        break;
	     	case 'under review':
	        color = '#F1C40F';
	        break;
	        case 'interviewing':
	        color = '#3498DB';
	        break;
	        case 'offer received':
	        color = '#2ECC71';
	        break;
	        case 'rejected':
	        color = '#E74C3C';
	        break;
	     	default:
	        color = '#ECF0F1';
	    	}
	    	$(this).css('background', color);
	    });
	});

	      $(function(){
			    var $boxs = $("#parent > .box");
			    var $btns = $(".btn").on("click", function() {

			      var active = 
			        $btns.removeClass("active")
			          .filter(this)
			          .addClass("active")
			          .data("filter");

			      $boxs
			        .hide()
			        .filter( "." + active )
			        .fadeIn(450);
			    });
			});

	 function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'none')
          e.style.display = 'block';
       else
          e.style.display = 'none';
    }
</script>

</body>
</html>