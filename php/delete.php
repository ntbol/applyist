<?php
session_start();
if(isset($_POST["remove"])){
	try {
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_SESSION['deleteid'];
	$sql = "DELETE FROM listings WHERE id = '$id'";
	$pdo->exec($sql);
        header ('Location: dashboard.php');
    }
	catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
    $pdo = null;
	header('Location: dashboard.php');
}
?>