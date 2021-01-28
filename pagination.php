<?php
//session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password);

if($dblink)
	echo 'Соединение установлено.';
else
	die('Ошибка подключения к серверу баз данных.');

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);


$query = "SELECT * FROM `lots`";
$result = mysqli_query($dblink, $query);
$result1 = mysqli_query($dblink, $query);

//Pagination start
$num = 20;
$page = $_GET['page'];
$querypag = "SELECT COUNT(*) FROM `lots`";
$resultpag = mysqli_query($dblink, $querypag);
$resultpag1 = mysqli_query($dblink, $querypag);

?>


 <?php
    // Проверяем, пусты ли переменные логина и id пользователя
  //  if (empty($_SESSION['login']) or empty($_SESSION['id']))
   // {
    // Если пусты, то мы не выводим ссылку
//		header("Location: https://gz.open-k.com/login.php");
 //   echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
 //   }
//else{
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Результат фильтрования</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Styles -->
    <link href="https://gz.open-k.com/assets/css/core.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/app.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://gz.open-k.com/assets/img/apple-touch-icon.png">
    <link rel="icon" href="https://gz.open-k.com/assets/assets/img/favicon.png">
	  <style>
		  .form-group{border-bottom-style: inset;}</style>
	  <style type="text/css">
table{width:100%}
		  th:hover{cursor:pointer;}
		  tr, td, th{border: 1px solid gray;}
	  #savebutton1{
    position: fixed;
    right: 100px;
    top: 160px;}
		   .btn-1 {
  padding: 1em 3em;
  border: 3px solid #4A90E2;
  transition: all 300ms ease;
  box-shadow: 0px 4px 10px 2px rgba(0, 0, 0, 0.2);
}
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
        <a class="logo d-lg-none" href="index.html"><img src="assets/img/logo.png" alt="logo"></a>

        <ul class="topbar-btns">

  <h3>Выгруженные лоты</h3>

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


      <div class="main-content">

        <div class="media-list media-list-divided media-list-hover" data-provide="selectall">

          <header class="flexbox align-items-center media-list-header bg-transparent b-0 py-16 pl-20">
            <div class="flexbox align-items-center">
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
		<th scope="col">Заказчик БИН</th>
		<th id="dp" scope="col"><select name="publishdat" onchange="showhideBlocks(this.value)">
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
					  <input type="hidden" name="query" value="SELECT * FROM `lots` where id_lot = id_lot">
	<div id="savebutton1">
		<div class="button-item">
      <input class="btn-1" type="submit" value="Применить фильтр">
    </div>
		</div>
					  
	</form>
  </thead>
				  <tbody>
<?php 

while ($rowpag = mysqli_fetch_row($resultpag)) { 
$total = intval(($rowpag[0] - 1) / $num) + 1;
echo 'Всего страниц: '.$total;
$page = intval($page);
	if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
	$start = $page * $num - $num;
$querypag = "SELECT * FROM lots ORDER BY publish_date DESC LIMIT $start, $num";
$resultpagd = mysqli_query($dblink, $querypag);
//while ( $postrow = mysqli_fetch_array($resultpagd)){
	$fori=0;
while ( $row = mysqli_fetch_array($resultpagd)){
//
//$querygg = 'SELECT * FROM `lots` WHERE id_lot="'.$postrow[1].'"';
//$resultgg = mysqli_query($dblink, $querygg);
//while ($row = mysqli_fetch_row($resultgg)) {
?>
			<!-- `tut-->   
           <!--<div class="media align-items-center">-->   
             
 <!--<div class="media align-items-center">

              

                <div class="media-body text-truncate">-->
					<tr style="" class="horizontal-scroll-wrapper">
						<td style="width:30px;" width="94"><? echo $row[0];?>
						<?php // $fori++; echo $fori; ?></td>
					<td style=""><a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-detailss<? echo $row[0];?>" data-toggle="quickview"><? echo $row[4];?></a></td>
					<td><? echo $row[2];?></td>
					<td><?php
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
					<td><? echo $row[8];?></td>
					<td ><? echo $row[13];?></td>
					<td><? echo $row[14];?></td>
					<td><? echo $row[15];?></td>
					<td><?php
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
					
				  
<!--tut-->

<?php  }
}
/* echo '<thead>
    <tr>
      <th id="sl" scope="col" width="30">ID</th>              
		<th scope="col">Номер на госзакупе</th>       
		<th id="nm" scope="col">Наименование</th>	 
		<th scope="col">Регион</th>                   
		<th id="sum" scope="col">Сумма</th>      	 		       
		<th scope="col">Заказчик БИН</th>
		<th id="dp" scope="col">Дата публикации</th>
		<th id="dn" scope="col">Дата начала</th>
		<th id="do" scope="col">Дата окончания</th>
		<th scope="col">Способ закупки</th>
		<th scope="col">Ссылка на лот</th>
			</tr>
  </thead>';*/
echo '</table>';
//}
$pervpage = '';
$page2left = '';
$page1left = '';
$page1right = '';
$page2right = '';
$nextpage = '';	  
if ($page != 1) $pervpage = '<a href= ./pagination.php?page=1>В начало </a>  |  <a href= ./pagination.php?page='. ($page - 1) .'>Предыдущая страница</a>  | ';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' | <a href= /pagination.php?page='. ($page + 1) .'>Еще</a>  | 
                                   <a href= ./pagination.php?page=' .$total. '>Последняя страница</a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 2 > 0) $page2left = ' <a href= ./pagination.php?page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href= ./pagination.php?page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
if($page + 2 <= $total) $page2right = ' | <a href= ./pagination.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href= ./pagination.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод меню
echo $pervpage.$page2left.$page1left;
echo'<b>';
echo $page;
echo '</b>';
echo $page1right.$page2right.$nextpage;

//Pagination end			  ?>


			  	<?php 
while ($rowpag = mysqli_fetch_row($resultpag1)) { 
$total = intval(($rowpag[0] - 1) / $num) + 1;
$page = intval($page);
	if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
	$start = $page * $num - $num;
$querypag = "SELECT * FROM lots ORDER BY publish_date DESC LIMIT $start, $num";
$resultpagd = mysqli_query($dblink, $querypag);
while ($row = mysqli_fetch_row($resultpagd)) { 
//$querygg = 'SELECT * FROM `lots` WHERE id_lot="'.$rows[1].'"';
//$resultgg = mysqli_query($dblink, $querygg);
//while ($row = mysqli_fetch_row($resultgg)) {
	$idlott = $row[0];
?>
	<!-- Quickview - User detail -->
    <div id="qv-user-detailss<? echo $idlott?>" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Карточка лота <? echo $row[0];?></p>
<?php 
		$queryggs = 'SELECT * FROM `favorite_lots` WHERE id_lot="'.$row[0].'"';
$resultggs = mysqli_query($dblink, $queryggs);
if(mysqli_num_rows($resultggs) == 0){
?>
		  <form id="favourite<? echo  $idlott;?>" method="post" action="favourite.php">
<div class="rating-area">
	<input type="submit" id="star-5<? echo  $idlott;?>"  >
	<input type="hidden" name="favourite" value="<? echo $row[0];?>">
	<label for="star-5<? echo $row[0];?>" title="В избранное"></label>	
</div>
</form>

<script>$(document).on('click','#star-5<? echo  $idlott;?>',function(e) {
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
		
		$queryidstat = 'SELECT * FROM `statuses_new` WHERE id_status="'.$rows[10].'"';
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
			echo $rowd[3];
			echo'</option>';
    }
	while ($rowe = mysqli_fetch_row($resultlistu)) {
        echo '<option value="'.$rowe[0].'">';
			echo $rowe[3];
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
	<input type="hidden" name="cenands" value="<?php while ($rowsd = mysqli_fetch_row($resulttaken1)) {
			$cenands = (int)($rowsd[3]*1.12);
			echo $cenands;
			}?>">
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
            <span><b>Цена с НДС</b>: <?php echo $cenands; ?></span>
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
									echo $rows[1];
									echo '<br>';
								}
						?>
			  <form id="ajax_form<? echo $row[0];?>" action="" method="post" >
				  <textarea id="commenttext<? echo $row[0];?>" name="comment" style="width:100%;" placeholder="Пишите сюда комментарий"></textarea>
				  <br>
				  <input type="hidden" name="id_lot" value="<? echo $row[0];?>">
				  <input type="hidden" name="id_user" value="<?php
							$queryiduser = 'SELECT * FROM `users` WHERE login ="'.$_SESSION['login'].'"';
							$resultiduser = mysqli_query($dblink, $queryiduser);
								while ($rows = mysqli_fetch_row($resultiduser)) {
									echo $rows[0];
								}
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
			  
  
	<?php //}
}
}
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
//	$("#dp").click(function(){
//    f_dp *= -1;
//    var n = $(this).prevAll().length;
//    sortTable(f_dp,n);
//});
//	$("#do").click(function(){
  //  f_do *= -1;
    //var n = $(this).prevAll().length;
   // sortTable(f_do,n);
//});
	//$("#dn").click(function(){
    //f_dn *= -1;
    //var n = $(this).prevAll().length;
    //sortTable(f_dn,n);
//});
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
<?php
 //   echo "Вы вошли на сайт, как ".$_SESSION['login'];
   // }
    ?>