<?php 
//session_start();
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$database = 'openkcom_gz1';

$link = mysqli_connect($server, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
?>