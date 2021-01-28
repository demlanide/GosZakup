<?php
include("db.php");
$keycode = $_POST["keycode"];
echo $keycode;
$query = mysqli_query($link,"INSERT INTO saved_filters (lotName) VALUES ('$keycode')") or die(mysqli_error());
if($query){
echo " Успешно добавлено";
}else{
echo " Действие имеет ошибку";
}
?>