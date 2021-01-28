<?php
$db_host = 'localhost:3306';
$db_user = 'a0286623_dostarmed';
$db_pass = 'Xugalomvj578@';
$db_database = 'a0286623_dostarmed';
	
$link = mysqli_connect($db_host, $db_user, $db_pass,$db_database) or die("No connection with database" .mysqli_error());
mysqli_query($link,"SET names utf8");
?>
    