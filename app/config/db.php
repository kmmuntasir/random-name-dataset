<?php
	$dbhost = "localhost";
	$dbname = "test";
	$dbuser = "root";
	$dbpass = "";

	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	if(!$con) die("Database Connection Error");

	$_SESSION['dbcon'] = $con;
?>
