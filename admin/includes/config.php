<?php
	// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	date_default_timezone_get("PRC");
	header("Content-Type:text/html;charset=utf-8");

	$conn=mysqli_connect("localhost","root","") or die("连接失败");

	mysqli_select_db($conn,"news");

	mysqli_query($conn,"SET NAMES UTF8");

	$pre_="pre_";

	include("headers.php");
 ?>
