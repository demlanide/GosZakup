<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);

$emails = mysqli_query($dblink, "SELECT email FROM users where status = 'user'")->fetch_all(MYSQLI_NUM);
for ($i=0; $i<count($emails); $i++) {
	$emails[$i][0];
}
?>