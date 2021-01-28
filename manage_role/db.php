<?php 
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$db = new mysqli($server, $user ,$password, 'openkcom_gz1') or die(mysqli_errno());
$db->query("SET names UTF-8") or die(mysqli_errno());
if($db){
	echo "Подключено";
}else{ echo 'notcool';}

?>