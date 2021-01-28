<?php 
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password);
$db = new mysqli($server, $user ,$password, 'openkcom_gz1') or die(mysqli_errno());
$db->query("SET names UTF8") or die(mysqli_errno());


?>