<?php
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password,'openkcom_gz1') or die("No connection with database" .mysqli_error());
mysqli_query($dblink,"SET names UTF8") or die(mysqli_errno());
$id = $_POST["id"];
echo $keycode;
$keycode = $_POST["keycode"];
if($keycode == 'true'){
$keycode = "checked";
}else{
$keycode = "false";
}
$db = mysqli_query($dblink,"UPDATE saved_filters SET chachedfilter='$keycode' WHERE id_filter='$id'");
if($db){
if($keycode == 'checked'){
echo "Статус фильтра изменен";
}else{
echo "Статус фильтра не изменен";

}
}else{
echo " Действие имеет ошибку";
}
?>