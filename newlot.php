<?php
//    session_start();
    ?>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$database = 'openkcom_gz1';
$dblink = mysqli_connect($server, $user, $password, $database);

$namelot = $_POST['namelot'];
$sposobzak = $_POST['sposobzak'];
$nomerl = $_POST['nomerl'];
$statuslot = $_POST['statuslot'];
$mestop = $_POST['mestop'];
$namezakaz = $_POST['namezakaz'];
$binzakaz = $_POST['binzakaz'];
$cena = $_POST['cena'];
$nomerobyav = $_POST['nomerobyav'];
$zaktovar = $_POST['zaktovar'];
$datanachalatorg = $_POST['datanachalatorg'];
$winner = $_POST['winner'];

$querysposobzakupki ="INSERT INTO `lots` (`name`, `id_purchase_method`, `lot_number`, `id_status`, `ids_place`, `purchaser_name`, `purchaser_BIN`, `price`, `announcement`, `id_purchase_item`, `trading_start_date`, `winner`) VALUES ('$namelot', '$sposobzak', '$nomerl', '$statuslot', '$mestop', '$namezakaz', '$binzakaz', '$cena', '$nomerobyav', '$zaktovar', '$datanachalatorg', '$winner')";
$resultsposobzakupki = mysqli_query($dblink, $querysposobzakupki) or die("Ошибка " . mysqli_error($dblink)); 

if($dblink)
	echo '';
else
	die('Ошибка подключения к серверу баз данных.');
?>
 <?php
    // Проверяем, пусты ли переменные логина и id пользователя
/*    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
    // Если пусты, то мы не выводим ссылку
    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
    }
else{
*/  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Страница настройки системы</title>

    <!-- Styles -->
    <link href="https://gz.open-k.com//assets/css/core.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/app.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://gz.open-k.com/assets/img/apple-touch-icon.png">
    <link rel="icon" href="https://gz.open-k.com/assets/img/favicon.png">
	  <style>
	  .card>.table tr td:first-child {
    width: 36%;
}</style>
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
          <a href="index.html">Админ панель</a>
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
        <a class="logo d-lg-none" href="index.html"><img src="/assets/img/logo.png" alt="logo"></a>

        <ul class="topbar-btns">

          <h3>Страница создания нового лота</h3>
        </ul>
      </div>

      <div class="topbar-right">

       <?php echo "Привет, ".$_SESSION['login'];?>
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

        <form class="lookup lookup-circle lookup-right" target="index.html">
          <input type="text" name="s">
        </form>

      </div>
    </header>
    <!-- END Topbar -->



    <!-- Main container -->
    <main>
<span>Новый лот успешно добавлен, добавить еще</span>
      <div class="main-content">
<form action="newlot.php" method="post">
<div class="row">
	<div class="col-md-3">
    <label>Название лота*:<br></label>
    <input required name="namelot" class="form-control" type="text">
 </div>
<div class="col-md-3">
    <label>Способ покупки*:<br></label>
    <?php
						
						$querysposobzakupki ="SELECT * FROM purchase_methods";
//Tolko nazvanie
 $resultsposobzakupki = mysqli_query($dblink, $querysposobzakupki) or die("Ошибка " . mysqli_error($dblink)); 
if($resultsposobzakupki)
{
    echo '<select name="sposobzak" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
    while ($row = mysqli_fetch_row($resultsposobzakupki)) {
        echo '<option value="'.$row[0].'">';
			echo $row[1];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultsposobzakupki);
}
						?>
</div>
<div class="col-md-3">
    <label>Номер лота*:<br></label>
    <input required class="form-control" name="nomerl" type="text">
</div>
	 
<div class="col-md-3">
	<label>Статус лота*:<br></label>
    <?php
						$querystatus ="SELECT * FROM statuses";
//Tolko nazvanie
 $resultstatus = mysqli_query($dblink, $querystatus) or die("Ошибка " . mysqli_error($dblink)); 
if($resultstatus)
{
    echo '<select name="statuslot" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
    while ($row = mysqli_fetch_row($resultstatus)) {
        echo '<option value="'.$row[0].'">';
			echo $row[1];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultstatus);
}
						?>
    </div>
<div class="col-md-3">
	<label>Место поставки*:<br></label>
    <?php
$querymestopostavki ="SELECT * FROM places";
//Tolko nazvanie
 $resultmestopostavki = mysqli_query($dblink, $querymestopostavki) or die("Ошибка " . mysqli_error($dblink)); 
if($resultmestopostavki)
{
    echo '<select name="mestop" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
    while ($row = mysqli_fetch_row($resultmestopostavki)) {
        echo '<option value="'.$row[0].'">';
			echo $row[1];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultmestopostavki);
}
						?>
    </div>
	
<div class="col-md-3">
	<label>Имя заказчика*:<br></label>
    <input required class="form-control" name="namezakaz" type="text">
    </div>
<div class="col-md-3">
	<label>БИН заказчика*:<br></label>
    <input required class="form-control" name="binzakaz" type="text" size="15" maxlength="15">
    </div>
<div class="col-md-3">
	<label>Цена*:<br></label>
    <input required class="form-control" name="cena" type="text" size="15" maxlength="15">
    </div>
<div class="col-md-3">
	<label>Номер объявления*:<br></label>
    <input required class="form-control" name="nomerobyav" type="text" size="15" maxlength="15">
    </div>
<div class="col-md-3">
	<label>Предмет закупки*:<br></label>
    <?php
$querypredmetzakupki ="SELECT * FROM purchase_items";
//Tolko nazvanie
 $resultpredmetzakupki = mysqli_query($dblink, $querypredmetzakupki) or die("Ошибка " . mysqli_error($dblink)); 
if($resultpredmetzakupki)
{
    echo '<select class="last_select" name="zaktovar" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
    while ($row = mysqli_fetch_row($resultpredmetzakupki)) {
        echo '<option value="'.$row[0].'">';
			echo $row[1];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultpredmetzakupki);
}
						?>
    </div>
<div class="col-md-3">
	<label>Дата начала торгов:<br></label>
    <input class="form-control" name="datanachalatorg" type="text" size="15" maxlength="15">
    </div>
<div class="col-md-3">
	<label>Победитель:<br></label>
    <input class="form-control" name="winner" type="text" size="15" maxlength="15">
    </div>
</div>
	<br>
    <input class="btn btn-xs btn-primary" type="submit" name="submit" value="Сохранить">

	
</form>

     
      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © 2020. All rights reserved.</p>
          </div>


        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->



    <!-- Global quickview -->
    <div id="qv-global" class="quickview" data-url="https://gz.open-k.com/assets/data/quickview-global.html">
      <div class="spinner-linear">
        <div class="line"></div>
      </div>
    </div>
    <!-- END Global quickview -->



    <!-- Scripts -->
    <script src="https://gz.open-k.com/assets/js/core.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/app.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/script.js"></script>

  </body>
</html>
<?php
//    echo "Вы вошли на сайт, как ".$_SESSION['login'];
//    }
    ?>
