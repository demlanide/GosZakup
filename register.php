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

if($dblink)
	echo '';
else
	die('Ошибка подключения к серверу баз данных.');
?>
 <?php
    // Проверяем, пусты ли переменные логина и id пользователя
//    if (empty($_SESSION['login']) or empty($_SESSION['id']))
//    {
    // Если пусты, то мы не выводим ссылку
//		header("Location: https://gz.open-k.com/login.php");
//    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
//    }
//else{
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TheAdmin - Responsive admin and web application ui kit">
    <meta name="keywords" content="admin, dashboard, web app, sass, ui kit, ui framework, bootstrap">

    <title>Регистрация новых пользователей</title>

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
        <a class="logo d-lg-none" href="index.html"><img src="/assets/img/logo.png" alt="logo"></a>

        <ul class="topbar-btns">

          <h3>Страница регистрации новых пользователей</h3>
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
        <div class="row">

<?php // if($_SESSION['login'] == 'ads'){
	?>
<form action="save_user.php" method="post">
<p>
    <label>Логин для нового пользователя(используется для входа в систему):<br></label>
    <input required name="login" class="form-control" type="text" size="15" maxlength="15">
    </p>
	<p>
    <label>Имя пользователя:<br></label>
    <input required name="imya" class="form-control" type="text" size="15" maxlength="15">
    </p>
<p>
    <label>Пароль для нового пользователя:<br></label>
    <input required class="form-control" name="password" type="password" size="15" maxlength="15">
    </p>
	<p>
	<label>Email для уведомлений:<br></label>
    <input required class="form-control" name="email" type="email">
    </p>
	<?php
	$querynewstat = 'SELECT * FROM `allowance`';
		$resultnewstat = mysqli_query($dblink, $querynewstat);
		 	echo '<p><div class="form-group">
                      <label>
                        Права доступа:<br>
                      </label><select name="prava"  class="form-control form-control-sm" data-width="100%">';
    while ($rowd = mysqli_fetch_row($resultnewstat)) {
        echo '<option value="'.$rowd[0].'">';
			echo $rowd[1];
			echo'</option>';
	}
	echo'</select></div></p>'
	?>
<p>
    <input class="btn btn-xs btn-primary" type="submit" name="submit" value="Зарегистрировать">
</p></form>
<?php 
//}
?>
        </div>
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
 //   }
    ?>
