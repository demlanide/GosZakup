<?php
//session_start();
$servername = "srv-db-plesk09.ps.kz:3306";
$database = "openkcom_gz1";
$username = "openkcom_gz1";
$password = "@Admin111";

$conn = mysqli_connect($servername, $username, $password, $database);
$sebestoimost = $_POST['sebestoimost'];
$newstat = $_POST['newstat'];
$otvetstvenniy = $_POST['otvetstvenniy'];
$otdel = $_POST['otdel'];
$idlot = $_POST['idlot'];
$cenands = (int)($_POST['sebestoimost']*1.12);


$add = "UPDATE `taken_lots` SET `id_department` = '$otdel', `cost` = '$sebestoimost', `nds_cost` = '$cenands', `id_user` = '$otvetstvenniy', `id_status` = '$newstat' WHERE `taken_lots`.`id_lot` = $idlot";
mysqli_query($conn, $add);

?>