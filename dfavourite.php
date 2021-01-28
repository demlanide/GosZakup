<?php
session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");;

$favourite = $_POST['favourite'];

$querysposobzakupki ="DELETE FROM `favorite_lots` WHERE `favorite_lots`.`id_lot` = ('$favourite')";
$resultsposobzakupki = mysqli_query($dblink, $querysposobzakupki) or die("Ошибка " . mysqli_error($dblink)); 

if($dblink)
	echo '';
else
	die('Ошибка подключения к серверу баз данных.');

?>