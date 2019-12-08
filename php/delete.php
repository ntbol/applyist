<?php
session_start();
if(isset($_POST["remove"])){
	$hostname='localhost:3308';
	$username='root';
	$password='';
	try {
	$dbh = new PDO("mysql:host=$hostname;dbname=applyist",$username,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_SESSION['deleteid'];
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