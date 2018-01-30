<?php 
	session_start();
	unset($_COOKIE["websiteManager"]);
	setcookie("websiteManager", NULL, -1);
	$id = $_SESSION["authentif"];
	$delete = ("DELETE FROM sessions WHERE id_user = $id");
	unset($_SESSION);
	session_destroy();
	header("location:index.php");
?>