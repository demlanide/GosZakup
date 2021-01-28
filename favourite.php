<?php
//session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$database = 'openkcom_gz1';
$dblink = mysqli_connect($server, $user, $password, $database);

$favourite = $_POST['favourite'];

$querysposobzakupki ="INSERT INTO `favorite_lots` (`id_lot`) VALUES ('$favourite')";
$resultsposobzakupki = mysqli_query($dblink, $querysposobzakupki) or die("Ошибка " . mysqli_error($dblink)); 

if($dblink)
	echo '';
else
	die('Ошибка подключения к серверу баз данных.');

?>