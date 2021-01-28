<?php
session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");
?>
 <?php
    // Проверяем, пусты ли переменные логина и id пользователя
/*    if (empty($_SESSION['login']) or empty($_SESSION['id'])){
    // Если пусты, то мы не выводим ссылку
	header("Location: https://gz.open-k.com/login.php");
    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
    }
else{
*/  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TheAdmin - Responsive admin and web application ui kit">
    <meta name="keywords" content="admin, dashboard, web app, sass, ui kit, ui framework, bootstrap">

    <title>Пользователи &mdash; </title>

    <!-- Styles -->
    <link href="../../assets/css/core.min.css" rel="stylesheet">
    <link href="../../assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../../assets/img/apple-touch-icon.png">
    <link rel="icon" href="../../assets/img/favicon.png">
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

<h3>Список пользователей</h3>
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
           


          </header>


          <div class="media-list-body bg-white b-1">
            




       
<?php
							$query = 'SELECT * FROM `users`';
							$result = mysqli_query($dblink, $query);
								while ($rows = mysqli_fetch_row($result)) {
									?>
<div class="media align-items-center">

              <a class="flexbox align-items-center flex-grow gap-items" href="#qv-user-details<?php echo $rows[0];?>" data-toggle="quickview">
                <img class="avatar" src="/assets1/img/avatar-.png" alt="...">

                <div class="media-body text-truncate">
					
                  <h6><?php echo $rows[1];?></h6>
                  <small>
                    <span><?php echo $rows[5];?></span>
                    <span class="divider-dash"><?php echo $rows[3];?></span>
                  </small>
                </div>
              </a>

            </div>

			  <!--Quickview - User detail-->
    <div id="qv-user-details<?php echo $rows[0];?>" class="quickview quickview-lg">
      <div class="quickview-body">

        <div class="card card-inverse">

          <div class="card-body text-center pb-50">
            <a href="#">
              <img class="avatar avatar-xxl avatar-bordered" src="assets/img/avatar/1.jpg">
            </a>
            <h4 class="mt-2 mb-0"><a class="hover-primary text-white" href="#"><?php echo $rows[1];?></a></h4>
          </div>
        </div>

        <div class="quickview-block form-type-material">
          <div class="form-group">
            <input type="text" class="form-control" value="<?php echo $rows[3];?>">
            <label>Имя</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" value="<?php echo $rows[5];?>">
            <label>Почтовый адрес Email</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" value="<?php echo $rows[0];?>">
            <label>ID Юзера</label>
          </div>

        </div>
      </div>

      <footer class="p-12 text-right">
      </footer>
    </div>
    <!-- END Quickview - User detail -->
<?php
}
						?>








            
			  
          </div>


          <footer class="flexbox align-items-center py-20">

          </footer>

        </div>


      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © 2017. All rights reserved.</p>
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
    <script src="../../assets/js/core.min.js"></script>
    <script src="../../assets/js/app.min.js"></script>
    <script src="assets/js/script.js"></script>

  </body>
</html>
<?php
 //   echo "Вы вошли на сайт, как ".$_SESSION['login'];
 //   }
    ?>