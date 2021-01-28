<?php
session_start();

//ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$database = 'openkcom_gz1';
$dblink = mysqli_connect($server, $user, $password, $database);
$selected = mysqli_select_db($dblink, $database);


//new
if (isset($_POST['query'])){
    $_SESSION['query'] = trim($_POST['query']);
	$query = $_POST['query'];
}
if (isset($_SESSION['query'])) {
    $query = $_SESSION['query'];
	$old_query = $query;
}
if (isset($_POST['place'])){
    $_SESSION['place'] = trim($_POST['place']);
	$region = $_POST['place'];
}
if (isset($_SESSION['place'])) {
    $region = $_SESSION['place'];
}
if (isset($_POST['publishdat'])){
    $_SESSION['publishdat'] = trim($_POST['publishdat']);
	$pubdate = $_POST['publishdat'];
}
if (isset($_SESSION['publishdat'])) {
    $pubdate = $_SESSION['publishdat'];
}

if (isset($_POST['publisstart'])){
    $_SESSION['publisstart'] = trim($_POST['publisstart']);
	$startdate = $_POST['publisstart'];
}
if (isset($_SESSION['publisstart'])) {
    $startdate = $_SESSION['publisstart'];
}

if (isset($_POST['publishend'])){
    $_SESSION['publishend'] = trim($_POST['publishend']);
	$findate = $_POST['publishend'];
}
if (isset($_SESSION['publishend'])) {
    $findate = $_SESSION['publishend'];
}

if (isset($_POST['queryq'])){
    $_SESSION['queryq'] = trim($_POST['queryq']);
	$q = $_POST['queryq'];
}
if (isset($_SESSION['queryq'])) {
    $q = $_SESSION['queryq'];
}
//
//$query = $_POST['query'];

if($_POST['place'] != NULL){
$region = $_POST['place'];
	if ($region != 0 && $region != 1)
{
    $query = $query." AND ids_place LIKE '%$region%'";
}
}
if($_POST['publishdat'] != NULL){
$pubdate = $_POST['publishdat'];
	if ($pubdate != 0)
{
    if ($pubdate < 10)
        $pubdate = '0'.$pubdate;
    $query = $query." AND publish_date LIKE '%-$pubdate-%'";
}
}
if($_POST['publisstart'] != NULL){
$startdate = $_POST['publisstart'];
	if ($startdate != 0)
{
    if ($startdate < 10)
        $startdate = '0'.$startdate;
    $query = $query." AND trading_start_date LIKE '%-$startdate-%'";
}
}
if($_POST['publishend'] != NULL){
$findate = $_POST['publishend'];
	if ($findate != 0)
{
    if ($findate < 10)
        $findate = '0'.$findate;
    $query = $query." AND trading_finish_date LIKE '%-$findate-%'";
}
}
		$per_page=100;
if (isset($_GET['pagell'])) $pagell=($_GET['pagell']-1);
$start=abs($pagell*$per_page);
	
	$query = $query." LIMIT $start,$per_page";
//$q = $_POST['queryq'];
echo $q;
$respag=mysqli_query($dblink, $q);
while($row=mysqli_fetch_array($respag)) {
  echo ++$start.". ".$row['field']."<br>\n";
}
$respag=mysqli_query($dblink, $q);
$row=mysqli_fetch_row($respag);
$total_rows=$row[0];
$num_pages=ceil($total_rows/$per_page);
echo $num_pages;
//$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_NUM);
$arr = mysqli_query($dblink, $query) or die("Ошибка " . mysqli_error($dblink)); 
$arr1 = mysqli_query($dblink, $query) or die("Ошибка " . mysqli_error($dblink)); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Результат фильтрования</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link href="https://gz.open-k.com/assets/css/core.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/app.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/style.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="https://gz.open-k.com/assets/img/apple-touch-icon.png">
    <link rel="icon" href="https://gz.open-k.com/assets/assets/img/favicon.png">
	   <style type="text/css">
		   .custom-control-input {
     position: unset; 
     z-index: unset; 
     opacity: unset; 
}
		   #savebutton1{
    position: fixed;
    right: 100px;
    top: 82px;}
		   .btn-1 {
  padding: 1em 3em;
  border: 3px solid #4A90E2;
  transition: all 300ms ease;
  box-shadow: 0px 4px 10px 2px rgba(0, 0, 0, 0.2);
}
.btn-1:before {
  position: absolute;
  content: '';
  width: 0%;
  height: 100%;
  top: 0;
  left: 50%;
  z-index: -1;
  transition: all 0ms ease;
}
.btn-1:hover {
  color: white;
  box-shadow: none;
	background: #4A90E2;
}
.btn-1:hover:before {
  position: absolute;
  content: '';
  width: 100%;
  height: 100%;
  
  top: 0;
  left: 0%;
  z-index: -1;
  transition: all 300ms ease;
}
		   .button-parent {
  max-width: 1100px;
  margin: auto;
  text-align: center;
}
.button-parent--inner {
  padding: 4em 1em;
}
.button-item {
  padding-bottom: 2em;
}
		   .form-group{border-bottom-style: inset;}
		   table{width:100%}
		  th:hover{cursor:pointer;}
		  tr, td, th{border: 1px solid gray;}
.rating-area {
	overflow: hidden;
	margin: 0 auto;
}
.rating-area:not(:checked) > input {
	display: none;
}
.rating-area:not(:checked) > label {
	float: right;
	width: 27px;
	padding: 0;
	cursor: pointer;
	font-size: 19px;
	line-height: 32px;
	color: lightgrey;
	text-shadow: 1px 1px #bbb;
}
.rating-area:not(:checked) > label:before {
	content: '★';
}
.rating-area > input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px #c60;
}
.rating-area:not(:checked) > label:hover,
.rating-area:not(:checked) > label:hover ~ label {
	color: gold;
}
.rating-area > input:checked + label:hover,
.rating-area > input:checked + label:hover ~ label,
.rating-area > input:checked ~ label:hover,
.rating-area > input:checked ~ label:hover ~ label,
.rating-area > label:hover ~ input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px goldenrod;
}
.rate-area > label:active {
	position: relative;
}

		  .rating-area1 {
	overflow: hidden;
	margin: 0 auto;
}
.rating-area1:not(:checked) > input {
	display: none;
}
		  .rating-area1:not(:checked) > label:before {
	content: '★';
}
		  .rating-area1:not(:checked) > label {
	float: right;
	width: 27px;
	padding: 0;
	cursor: pointer;
	font-size: 19px;
	line-height: 32px;
	color: gold;
	text-shadow: 1px 1px #bbb;
}
		  .rating-area1 > input:checked ~ label {
	color: lightgrey;
	text-shadow: 1px 1px #c60;
}
.rating-area1:not(:checked) > label:hover,
.rating-area1:not(:checked) > label:hover ~ label {
	color: lightgrey;
}
.rating-area1 > input:checked + label:hover,
.rating-area1 > input:checked + label:hover ~ label,
.rating-area1 > input:checked ~ label:hover,
.rating-area1 > input:checked ~ label:hover ~ label,
.rating-area1 > label:hover ~ input:checked ~ label {
	color: lightgrey;
	text-shadow: 1px 1px lightgrey;
}
		  .rate-area1 > label:active {
	position: relative;
}
</style>
  </head>

  <body>


    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
      </div>
    </div>


    <!-- Sidebar -->
    <aside class="sidebar sidebar-expand-lg sidebar-light sidebar-sm sidebar-color-info">

      <header class="sidebar-header bg-info">
        <span class="logo">
          <a href="index.html">Система сбора лотов</a>
        </span>
        <span class="sidebar-toggle-fold"></span>
      </header>

      <nav class="sidebar-navigation">
        <?php 
		  include 'menu.php';
?>
      </nav>

    </aside>
    <!-- END Sidebar -->



    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>

        <ul class="topbar-btns">

  <h3>Список тендеров</h3>

        </ul>
      </div>

      <div class="topbar-right">
<?php //echo "Привет, ".$_SESSION['login'];?>
        <ul class="topbar-btns">
			
          <li class="dropdown">
            <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="/assets1/img/avatar-.png" alt="Аватарка"></span>
            <div class="dropdown-menu dropdown-menu-right">
              <?php 
		  include 'usermenu.php';
?>
            </div>
          </li>
        </ul>
      </div>
    </header>
    <!-- END Topbar -->



    <!-- Main container -->
    <main>

	  <div style="display:flex;">
	<?php for($i=1;$i<=$num_pages;$i++) {
  if ($i-1 == $pagell) {
    echo 'Вы на странице '.$i." ";
  } else {
    echo '<form style="margin-left: 5px;" method="POST" action="'.$_SERVER['PHP_SELF'].'?pagell='.$i.'">';
	echo '<button type="submit">'.$i.'</button></form>';
  }
}
	  

		?>	
</div>
      <div class="main-content">

        <div class="media-list media-list-divided media-list-hover" data-provide="selectall">

          <header class="flexbox align-items-center media-list-header bg-transparent b-0 py-16 pl-20">
            <div class="flexbox align-items-center">
            
     
       
				
			  <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>Выбрать все
			
				
              <span class="divider-line mx-1"></span>

            </div>

          </header> 

          <div class="media-list-body bg-white b-1" style="width: fit-content;">
<table cellpadding="13" cellspacing="13" id="mytable">
				  <thead><form action="filter2.php" method="POST">
    <tr>
      <th id="sl" scope="col" width="30">ID</th>              
		<th scope="col">Номер на госзакупе</th>       
		<th id="nm" scope="col">Наименование</th>	 
		<th scope="col"><?php
$querymestopostavki ="SELECT * FROM places";
 $resultmestopostavki = mysqli_query($dblink, $querymestopostavki) or die("Ошибка " . mysqli_error($dblink)); 
if($resultmestopostavki){
    echo '<select name="place" onchange="showhideBlocks(this.value)">';
			if($region != NULL){
echo '<option value="0">';
if($region == 1)echo 'Акмолинская область';
if($region == 2)echo 'Актюбинская область';
if($region == 3)echo 'Алматинская область';
if($region == 4)echo 'Атырауская область';
if($region == 5)echo 'Западно-Казахстанская область';
if($region == 6)echo 'Жамбылская область';
if($region == 7)echo 'Карагандинская область';
if($region == 8)echo 'Костанайская область';
if($region == 9)echo 'г. Астана (Нур-Султан)';
if($region == 10)echo 'г. Алматы';
if($region == 11)echo 'Восточно-Казахстанская область';
if($region == 12)echo 'Мангистауская область';
				if($region == 13)echo 'Северо-Казахстанская область';
				if($region == 14)echo 'Южно-Казастанская область';
				if($region == 15)echo 'г. Шымкент';
				if($region == 16)echo 'Кызылординская область';
				if($region == 17)echo 'Павлодарская область';
echo '</option>';
			}

	echo '<option value="0">Регион</option>';
    while ($row = mysqli_fetch_row($resultmestopostavki)) {
        echo '<option value="'.$row[0].'">';
			echo $row[1];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultmestopostavki);
}
						?></th>                   
		<th id="sum" scope="col">Сумма</th>      	 	      
		<th scope="col">Условия поставки </th>		       
		<th scope="col">Заказчик БИН</th>
		<th id="dp" scope="col"><select name="publishdat" onchange="showhideBlocks(this.value)">
<?php 
			if($pubdate != NULL){
echo '<option value="0">';
if($pubdate == 1)echo 'Январь';
if($pubdate == 2)echo 'Февраль';
if($pubdate == 3)echo 'Март';
if($pubdate == 4)echo 'Апрель';
if($pubdate == 5)echo 'Май';
if($pubdate == 6)echo 'Июнь';
if($pubdate == 7)echo 'Июль';
if($pubdate == 8)echo 'Август';
if($pubdate == 9)echo 'Сентябрь';
if($pubdate == 10)echo 'Октябрь';
if($pubdate == 11)echo 'Ноябрь';
if($pubdate == 12)echo 'Декабрь';
echo '</option>';
				
}?>
			<option value="0">Дата публикации</option>
			<option value="1">Январь</option>
			<option value="2">Февраль</option>
			<option value="3">Март</option>
			<option value="4">Апрель</option>
			<option value="5">Май</option>
			<option value="6">Июнь</option>
			<option value="7">Июль</option>
			<option value="8">Август</option>
			<option value="9">Сентябрь</option>
			<option value="10">Октябрь</option>
			<option value="11">Ноябрь</option>
			<option value="12">Декабрь</option>
			</select></th>
		<th id="dn" scope="col"><select name="publisstart" onchange="showhideBlocks(this.value)">
			<?php 
			if($startdate != NULL){
echo '<option value="0">';
if($startdate == 1)echo 'Январь';
if($startdate == 2)echo 'Февраль';
if($startdate == 3)echo 'Март';
if($startdate == 4)echo 'Апрель';
if($startdate == 5)echo 'Май';
if($startdate == 6)echo 'Июнь';
if($startdate == 7)echo 'Июль';
if($startdate == 8)echo 'Август';
if($startdate == 9)echo 'Сентябрь';
if($startdate == 10)echo 'Октябрь';
if($startdate == 11)echo 'Ноябрь';
if($startdate == 12)echo 'Декабрь';
echo '</option>';
				
}?>
			<option value="0">Дата начала</option>
			<option value="1">Январь</option>
			<option value="2">Февраль</option>
			<option value="3">Март</option>
			<option value="4">Апрель</option>
			<option value="5">Май</option>
			<option value="6">Июнь</option>
			<option value="7">Июль</option>
			<option value="8">Август</option>
			<option value="9">Сентябрь</option>
			<option value="10">Октябрь</option>
			<option value="11">Ноябрь</option>
			<option value="12">Декабрь</option>
			</select></th>
		<th id="do" scope="col"><select name="publishend" onchange="showhideBlocks(this.value)">
			<?php 
			if($findate != NULL){
echo '<option value="0">';
if($findate == 1)echo 'Январь';
if($findate == 2)echo 'Февраль';
if($findate == 3)echo 'Март';
if($findate == 4)echo 'Апрель';
if($findate == 5)echo 'Май';
if($findate == 6)echo 'Июнь';
if($findate == 7)echo 'Июль';
if($findate == 8)echo 'Август';
if($findate == 9)echo 'Сентябрь';
if($findate == 10)echo 'Октябрь';
if($findate == 11)echo 'Ноябрь';
if($findate == 12)echo 'Декабрь';
echo '</option>';
				
}?>
			<option value="0">Дата окончания</option>
			<option value="1">Январь</option>
			<option value="2">Февраль</option>
			<option value="3">Март</option>
			<option value="4">Апрель</option>
			<option value="5">Май</option>
			<option value="6">Июнь</option>
			<option value="7">Июль</option>
			<option value="8">Август</option>
			<option value="9">Сентябрь</option>
			<option value="10">Октябрь</option>
			<option value="11">Ноябрь</option>
			<option value="12">Декабрь</option>
			</select></th>
		<th scope="col">Способ закупки</th>
		<th scope="col">Ссылка на лот</th>
			</tr>
					  <input type="hidden" name="query" value="<?php echo $old_query;?>">
	<div id="savebutton1">
		<div class="button-item">
      <input class="btn-1" type="submit" value="Применить фильтр">
    </div>
		</div>
					  
	</form>
  </thead>
<form method="post" action="checkbox-form.php" id="formcheck">
				  <tbody>
<?php 
	$fori=0;
	while ($row = mysqli_fetch_row($arr)) { 
?>
			  
           <!-- <div class="media align-items-center">
                <div class="media-body text-truncate">-->
		<tr <?php
$green = 'SELECT * FROM `taken_lots` WHERE id_lot="'.$row[0].'"';
$resgreen = mysqli_query($dblink, $green) or die("Ошибка " . mysqli_error($dblink));
$num_ans=mysqli_fetch_row ($resgreen);
		if($num_ans!=0){
			echo 'style="background: greenyellow;"';
			}?> class="horizontal-scroll-wrapper">
						<td style="width:30px;" width="94"><? echo $row[0];?>
						<?php // $fori++; echo $fori; ?>
			<div class="flexbox align-items-center">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="chosenbox[]" form="formcheck" value="<?php echo $row[0];?>">
                <label class="custom-control-label"></label>
              </div></div>
			</td>
					<td style=""><a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-detailss<? echo $row[0];?>" data-toggle="quickview"><? echo $row[4];?></a></td>
					<td><? echo $row[2];?></td>
					<td>
						<?php
if ($row[6] != "none")
{
	$str = substr($row[6], 1, -1);
	$places1 = explode(',', $str);
	$itog_places = "";
	foreach ($places1 as $place_id) {
		if (mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $place_id") != false)
			$qwert = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $place_id")->fetch_array(MYSQLI_NUM)[0];
		echo $qwert;
		if (count($places1) > 1)
			echo ', ';
	}

} else 
	echo "Места поставки не указаны";
/*$queryreg = 'SELECT * FROM `places` WHERE id_place="'.preg_replace('/[^0-9]/s', '', $row[6]).'"';
 $resultreg = mysqli_query($dblink, $queryreg) or die("Ошибка " . mysqli_error($dblink)); 
while ($rowd = mysqli_fetch_row($resultreg)) { 
echo $rowd[1];
}*/
						?></td>
					<td><? echo $row[9];?></td>
					<td>Условия поставки</td>
					<td><? echo $row[8];?></td>
					<td ><? echo $row[13];?></td>
					<td><? echo $row[14];?></td>
					<td><? echo $row[15];?></td>
					<td>
						<?php
$querypmeth = 'SELECT * FROM `purchase_methods` WHERE id_purchase_method="'.$row[3].'"';
 $resultpmeth = mysqli_query($dblink, $querypmeth) or die("Ошибка " . mysqli_error($dblink)); 
while($rowde = mysqli_fetch_row($resultpmeth)) { 
echo $rowde[1];
}
						?></td>
					<td style=""><a href="<? echo $row[20];?>">Ссылка на лот</a></td>
						</tr>
                <!--</div>
            </div>-->
			
	
<?php }

			  ?>
<input type="submit" value="Отправить">
</form>
</tbody>
</table>
			  	<?php 
while ($row = mysqli_fetch_row($arr1)) { 
	$idlott = $row[0];
?>
	<!-- Quickview - User detail -->
    <div id="qv-user-detailss<? echo $row[0];?>" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Карточка лота <? echo $row[0];?></p>
		  <?php 
$queryggs = 'SELECT * FROM `favorite_lots` WHERE id_lot="'.$row[0].'"';
$resultggs = mysqli_query($dblink, $queryggs);
if(mysqli_num_rows($resultggs) == 0){
?>
		  <form id="favourite<? echo $row[0];?>" method="post" action="favourite.php">
<div class="rating-area">
	<input type="submit" id="star-5<? echo $row[0];?>"  >
	<input type="hidden" name="favourite" value="<? echo $row[0];?>">
	<label for="star-5<? echo $row[0];?>" title="В избранное"></label>	
</div>
</form>

<script>$(document).on('click','#star-5<? echo $row[0];?>',function(e) {
   e.preventDefault();
  var data = $("#favourite<? echo $row[0];?>").serialize();
  $.ajax({
         data: data,
         type: "post",
         url: "favourite.php",
         success: function(data){
              alert("Лот успешно добавлен в избранное");
         }
});
 });</script>
		  <?php
}else{
		  ?>
<form id="favourite<? echo $row[0];?>" method="post" action="dfavourite.php">
<div class="rating-area1">
	<input type="submit" id="star-5<? echo $row[0];?>"  >
	<input type="hidden" name="favourite" value="<? echo $row[0];?>">
	<label for="star-5<? echo $row[0];?>" title="Удалить с избранных"></label>	
</div>
</form>

<script>$(document).on('click','#star-5<? echo $row[0];?>',function(e) {
   e.preventDefault();
  var data = $("#favourite<? echo $row[0];?>").serialize();
  $.ajax({
         data: data,
         type: "post",
         url: "dfavourite.php",
         success: function(data){
              alert("Лот успешно удален с избранных");
         }
});
 });</script>
		  <?php }?>
        <span class="close"><i class="ti-close"></i></span>
      </header>

      <div class="quickview-body">

        <div class="quickview-block form-type-material">
<?php 
	$querytaken = 'SELECT * FROM `taken_lots` WHERE id_lot="'.$row[0].'"';
		$resulttaken = mysqli_query($dblink, $querytaken);
	$resulttaken1 = mysqli_query($dblink, $querytaken);
	if(mysqli_num_rows($resulttaken) == 0){}else{
?>
<form id="ajax<? echo $row[0];?>form" action="" method="post">
	<input type="hidden" value="<? echo $idlott;?>" name="idlot">
<?php
		while ($rows = mysqli_fetch_row($resulttaken)) {
			echo '<div class="form-group do-float">
            <input type="text" class="form-control" name="sebestoimost" value="'.$rows[3].'">
            <label>Себестоимость</label>
          </div>';
		
		$queryidstat = 'SELECT * FROM `statuses_new` WHERE id_status="'.$rows[9].'"';
		$resultidstat = mysqli_query($dblink, $queryidstat);
		$querynewstat = 'SELECT * FROM `statuses_new` WHERE `id_status` NOT IN (1, 9)';
		$resultnewstat = mysqli_query($dblink, $querynewstat);
		 	echo '<div class="form-group">
                      <label>
                        Статус<br>
                      </label><select name="newstat"  class="form-control form-control-sm" data-width="100%">';
    while ($rowd = mysqli_fetch_row($resultidstat)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
	}
	while ($rowd = mysqli_fetch_row($resultnewstat)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
    }
    echo "</select></div>";
	 
			$queryotvetstvenniy = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
		$resultotvetstvenniy = mysqli_query($dblink, $queryotvetstvenniy);
		$querylistu = 'SELECT * FROM `users`';
		$resultlistu = mysqli_query($dblink, $querylistu);
			echo '<div class="form-group">
                      <label>
                        Отвественный<br>
                      </label><select name="otvetstvenniy"  class="form-control form-control-sm" data-width="100%">';
	if(mysqli_num_rows($resultotvetstvenniy) == 0){
		echo'<option value="0">Выберите пользователя</option>';
	}
    while ($rowd = mysqli_fetch_row($resultotvetstvenniy)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
    }
	while ($rowe = mysqli_fetch_row($resultlistu)) {
        echo '<option value="'.$rowe[0].'">';
			echo $rowe[1];
			echo'</option>';
    }
    echo "</select></div>";
			
			
			$querydepart = 'SELECT * FROM `departments` WHERE id_department="'.$rows[2].'"';
		$resultdepart = mysqli_query($dblink, $querydepart);
		$querydepartments = 'SELECT * FROM `departments`';
		$resultdepartments = mysqli_query($dblink, $querydepartments);
			echo '<div class="form-group">
                      <label>
                        Отдел<br>
                      </label><select name="otdel"  class="form-control form-control-sm" data-width="100%">';
	if(mysqli_num_rows($resultdepart) == 0){
		echo'<option value="0">Выберите отдел</option>';
	}
    while ($rowd = mysqli_fetch_row($resultdepart)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
    }
	while ($rowd = mysqli_fetch_row($resultdepartments)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
    }
    echo "</select></div>";
			
		}

?>
	<input type="hidden" name="cenands" value="">
	<input class="<? echo $row[0];?>btn" type="submit" value="Сохранить">
	</form>
	<div id="result<? echo $row[0];?>form" style="color:green;"></div>
			<script type="text/javascript">
			  $(document).ready(function() {

	 $(".<? echo $row[0];?>btn").click(
        function(){
            sendAjaxForm('result<? echo $row[0];?>form', 'ajax<? echo $row[0];?>form', 'takensave.php');
            return false; 
        }
    );
});
 
function sendAjaxForm(result<? echo $row[0];?>form, ajax<? echo $row[0];?>form, url) {
    jQuery.ajax({
        url:     url, //url страницы (php/sotrudniki.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: jQuery("#"+ajax<? echo $row[0];?>form).serialize(),  // Сериализуем объект
        success: function(response) { //Данные отправлены успешно
            document.getElementById(result<? echo $row[0];?>form).innerHTML = "Данные успешно сохранены. Обновите страницу чтобы увидеть изменения!";
            console.log(response);
        },
        error: function(response) { // Данные не отправлены
            document.getElementById(result<? echo $row[0];?>form).innerHTML = "Ошибка. Данные не отправлены.";
			console.log(response);
        }
    });
}</script>
	<div class="form-group">
            <span><b>Цена с НДС</b>: <?php while ($rows = mysqli_fetch_row($resulttaken1)) {
			echo (int)($rows[3]*1.12);
			}?></span>
          </div>
	<?php } ?>
          <h6>Детали</h6>
          <div class="form-group">
            <span><b>Заказчик</b>: <? echo $row[7];?></span>
          </div>
			
			<div class="form-group">
            <span><b>БИН заказчика</b>: <? echo $row[8];?></span>
          </div>

          <div class="form-group">
            <span><b>Предмет закупки:</b> <? echo $row[2];?></span>
          </div>
			
			 <div class="form-group">
            <span><b>Файлы:</b> <?php
							$queryfiles = 'SELECT * FROM `files` WHERE lot_number ="'.$row[4].'"';
							$resultfiles = mysqli_query($dblink, $queryfiles);
								while ($rows = mysqli_fetch_row($resultfiles)) {
											echo '<a href="'.$rows[3].'">'.$rows[2].'</a><br><br>';
								}
						?>
				 
				 </span>
          </div>
	
			<div class="form-group">
            <span><b>Способ закупки:</b> <?php
							$querymethodz = 'SELECT * FROM `purchase_methods` WHERE id_purchase_method="'.$row[3].'"';
							$resultmethodz = mysqli_query($dblink, $querymethodz);
								while ($rows = mysqli_fetch_row($resultmethodz)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
			<div class="form-group">
            <span><b>Место поставки:</b> <?php
										//$bezzap = preg_replace('/[^0-9]/s', '', $row[6]); 
							$querymestop = 'SELECT * FROM `places` WHERE id_place="'.preg_replace('/[^0-9]/s', '', $row[6]).'"';
							$resultmestop = mysqli_query($dblink, $querymestop);
								while ($rows = mysqli_fetch_row($resultmestop)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
          <div class="form-group">
            <span><b>Статус лота:</b> <?php
							$querystatus = 'SELECT * FROM `statuses` WHERE id_status="'.$row[5].'"';
							$resultstatus = mysqli_query($dblink, $querystatus);
								while ($rows = mysqli_fetch_row($resultstatus)) {
									if($row[5]==10 || $row[5]==3 || $row[5]==16){
											echo '<span class="text-success">'.$rows[1].'</span>';
									}
									else if($row[5]==7 || $row[5]==6 || $row[5]==8){
											echo '<span class="text-warning">'.$rows[1].'</span>';
									}
									else{
								echo '<span class="text-danger">'.$rows[1].'</span>';
									}
								}
						?></span>
          </div>

			 <div class="form-group">
            <span><b>Сумма закупки:</b> <? echo number_format($row[9], 2, ',', ' '); ?>₸</span>
          </div>
			
          <div class="form-group">
            <span><b>Номер лота:</b> <? echo $row[4];?></span>
          </div>
			
			<div class="form-group">
            <span><b>Номер объявления:</b> <? echo $row[10];?></span>
          </div>

          <div class="form-group input-group">
			  <span><b>Победитель лота:</b> <?php 
										  if($row[16] == NULL){
											  echo 'Победитель еще не определен';
										  }else {
											  echo $row[13];
											  }?></span>
          </div>
			
			<div class="form-group">
            <span><b>Последнее обновление лота:</b> <? echo $row[17];?></span>
          </div>
			
			<div class="form-group">
            <span><b>За кем закреплен лот:</b> <? if($row[1]==NULL){
											  echo 'Лот еще ни за кем не закреплен';
										  } else {echo $row[1];}?></span>
          </div>
		
          <div class="form-group" id="commentos">
			  <b>Комментарии:</b><br>
			  <?php
							$querycomment = 'SELECT * FROM `operations` WHERE id_lot="'.$row[0].'"';
							$resultcomment = mysqli_query($dblink, $querycomment);
										  $i0=1;
								while ($rows = mysqli_fetch_row($resultcomment)) {
								echo	$i0++;echo') ';
									echo $rows[3];
									//Imya kommentatora
									$querycommentuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
							$resultcommentuser = mysqli_query($dblink, $querycommentuser);
								while ($rows1 = mysqli_fetch_row($resultcommentuser)) {
											echo '<br>Добавил: <span class="text-success">'.$rows1[1].'</span> в ';			
								}
									//Imya kommentatora end
									echo ' в '.$rows[1];
									echo '<br>';
								}
						?>
			  <form id="ajax_form<? echo $row[0];?>" action="" method="post" >
				  <textarea id="commenttext<? echo $row[0];?>" name="comment" style="width:100%;" placeholder="Пишите сюда комментарий"></textarea>
				  <br>
				  <input type="hidden" name="id_lot" value="<? echo $row[0];?>">
				  <input type="hidden" name="id_user" value="<?php
						//	$queryiduser = 'SELECT * FROM `users` WHERE login ="'.$_SESSION['login'].'"';
						//	$resultiduser = mysqli_query($dblink, $queryiduser);
						//		while ($rows = mysqli_fetch_row($resultiduser)) {
						//			echo $rows[0];
						//		}
						?>">
					
				  <input class="btn<? echo $row[0];?>" type="submit" style="width:100%;" value="Оставить комментарий">
				  </form> 
			  <div id="result_form<? echo $row[0];?>" class="result_form<? echo $row[0];?>" style="color:green;"></div>
          </div>

          <div class="h-40px"></div>

          <h6>История изменений</h6>

         <?php
							$queryhistory = 'SELECT * FROM `operations` WHERE id_lot="'.$row[0].'"';
							$resulthistory = mysqli_query($dblink, $queryhistory);
										  $if0=1;
								while ($rows = mysqli_fetch_row($resulthistory)) {
								echo	$if0++;echo') ';
									if($rows[2]==1){
									echo 'Лот был прикреплен к менеджеру в '.$rows[1];
									$queryhistuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
							$resulthistuser = mysqli_query($dblink, $queryhistuser);
								while ($rows1 = mysqli_fetch_row($resulthistuser)) {
											echo '<br>За менеджером: <span class="text-success">'.$rows1[1].'</span>';			
								}
									}
									if($rows[2]==2){
									echo 'Был добавлен комментарий в '.$rows[1];
										$queryhistuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
							$resulthistuser = mysqli_query($dblink, $queryhistuser);
								while ($rows1 = mysqli_fetch_row($resulthistuser)) {
											echo '<br>Пользователем: <span class="text-success">'.$rows1[1].'</span>';			
								}
									}
									if($rows[2]==3){
									echo 'Изменен статус в '.$rows[1];
									}
									echo '<br>';
								}
						?>


        </div>
      </div>

      <footer class="p-12 flexbox flex-justified">
      </footer>
    </div>

    <!-- END Quickview - User detail -->
			  <script type="text/javascript">
			  $(document).ready(function() {
				  event.preventDefault();
  $('.result_form<? echo $row[0];?>').addClass('hidden');
				  
    $(".btn<? echo $row[0];?>").click(
        function(){
            sendAjaxForm('result_form<? echo $row[0];?>', 'ajax_form<? echo $row[0];?>', 'comment.php');
            return false; 
        }
    );
});
 
function sendAjaxForm(result_form<? echo $row[0];?>, ajax_form<? echo $row[0];?>, url) {
    jQuery.ajax({
        url:     url, //url страницы (php/sotrudniki.php)
        type:     "POST", //метод отправки
        //dataType: "html", //формат данных
        data: jQuery("#"+ajax_form<? echo $row[0];?>).serialize(),  // Сериализуем объект
        success: function(response) { //Данные отправлены успешно
			//$('.result_form<? //echo $row[0];?>').removeClass('hidden');
            //result = jQuery.parseJSON(response);
			//document.getElementById(result_form<?// echo $row[0];?>).innerHTML = "Комментарий успешно добавлен";
            document.getElementById(result_form<? echo $row[0];?>).innerHTML = "Данные отправлены. Обновите страницу чтобы увидеть изменения!";
			document.getElementById('commenttext<? echo $row[0];?>').value = "";
            console.log(response);
        },
        error: function(response) { // Данные не отправлены
            document.getElementById(result_form<? echo $row[0];?>).innerHTML = "Ошибка. Данные не отправлены.";
			console.log(response);
        }
    });
}</script>
			  
  
	<?php }
			  ?>
			  
          </div>


          <footer class="flexbox align-items-center py-20">
            <!--<span class="flex-grow text-right text-lighter pr-2">Показано 1-10 из 1,853</span>-->
          </footer>

        </div>


      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © 2020. All rights reserved.</p>
          </div>

          <div class="col-md-6">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
            </ul>
          </div>
        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->


   

    <!-- Scripts -->
    <script src="https://gz.open-k.com/assets/js/core.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/app.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/script.js"></script>

<script>
	  function sortTable(f,n){
	var rows = $('#mytable tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getVal(a);
		var B = getVal(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getVal(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#mytable').children('tbody').append(row);
	});
}
var f_sl = 1;
var f_nm = 1;
var f_sum = 1;
var f_dp = 1;
var f_do = 1;
var f_dn = 1;
$("#sl").click(function(){
    f_sl *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_sl,n);
});
$("#nm").click(function(){
    f_nm *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_nm,n);
});
$("#sum").click(function(){
    f_sum *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_sum,n);
});
	$("#dp").click(function(){
    f_dp *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_dp,n);
});
	$("#do").click(function(){
    f_do *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_do,n);
});
	$("#dn").click(function(){
    f_dn *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_dn,n);
});
	  </script>
<script>
 $(function () {
     $("#savebutton1").hide();
 });
function showhideBlocks(val){
if (val == 0){
document.getElementById('savebutton1').style.display='none';
}else{
document.getElementById('savebutton1').style.display='block';  
}  
}
</script>
  </body>
</html>