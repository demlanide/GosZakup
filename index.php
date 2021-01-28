<?php
session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");
?>
 <?php
    /* Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['login']) or empty($_SESSION['id'])){
    // Если пусты, то мы не выводим ссылку
	header("Location: https://gz.open-k.com/login.php");
    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
    }*/
//else{
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TheAdmin - Responsive admin and web application ui kit">
    <meta name="keywords" content="admin, dashboard, web app, sass, ui kit, ui framework, bootstrap">

    <title>Главная панель</title>

    <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
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

          <h3>Главная страница</h3>
        </ul>
      </div>

      <div class="topbar-right">

       <?php // echo "Привет, ".$_SESSION['login'];?>
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







          <div class="col-md-6 col-lg-4">
            <div class="card card-body">
              <h6>
                <span class="text-uppercase">Общая сумма всех выгруженных тендеров</span>
              </h6>
              <br>
              <p class="fs-28 fw-100">
				  <?php $querytosummu = "SELECT ROUND(SUM(price)) FROM lots";
$resultsummu = mysqli_query($dblink, $querytosummu) or die("Ошибка " . mysqli_error($dblink));
if($resultsummu){
while ($row = mysqli_fetch_row($resultsummu)) {
        echo number_format($row[0], 0, ',', ' ');
    }
}

				  ?>
				  ₸</p>
              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="text-gray fs-12"><i class="ti-stats-up text-success mr-1"></i> Общая сумма в ₸</div>
            </div>
          </div>




          <div class="col-md-6 col-lg-4">
            <div class="card card-body">
              <h6>
                <span class="text-uppercase">Всего выгружено тендеров</span>
                <span class="float-right"><a class="btn btn-xs btn-primary" href="/product1.php">Фильтрация тендеров</a></span>
              </h6>
              <br>
              <p class="fs-28 fw-100">
				  <?php $querytocount = "SELECT COUNT(*) FROM lots  WHERE MONTH(`publish_date`) = MONTH(NOW())";
					$resultcount = mysqli_query($dblink, $querytocount) or die("Ошибка " . mysqli_error($dblink));
					if($resultcount){
					while ($row = mysqli_fetch_row($resultcount)) {
							echo number_format($row[0], 0, ',', ' ') . ' Лотов';
						}
					}
				  echo '<br>';
				  $querytosummu = "SELECT ROUND(SUM(price)) FROM lots WHERE MONTH(`publish_date`) = MONTH(NOW())";
					$resultsummu = mysqli_query($dblink, $querytosummu) or die("Ошибка " . mysqli_error($dblink));
					if($resultsummu){
					while ($row_sum = mysqli_fetch_row($resultsummu)) {
							echo number_format($row_sum[0], 0, ',', ' ');
						}
					}
				  ?> ₸
				</p>
              <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="text-gray fs-12"><i class="ti-stats-down text-danger mr-1"></i> За прошедший Месяц</div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"><strong>Последние</strong> Выгруженные тендеры</h5>
                 <!--<select class="form-control form-control-sm" data-provide="selectpicker" data-width="140">
                  <option>Сегодня</option>
                  <option>Вчера</option>
                  <option>Последняя неделя</option>
                  <option>Последний месяц</option>
                </select>-->
             </div>

              <div class="card-body bl-3 border-success flexbox flex-justified">
                <div>
                  <div class="fs-12 text-muted"><i class="ti-time mr-1"></i> 7 дней </div>
                  <div class="fs-18 text-success">
					  <?php
					  $querytosummu = "SELECT COUNT(*) FROM lots WHERE `publish_date` >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
";
						$resultsummu = mysqli_query($dblink, $querytosummu) or die("Ошибка " . mysqli_error($dblink));
						if($resultsummu){
						while ($row_sum = mysqli_fetch_row($resultsummu)) {
								echo number_format($row_sum[0], 0, ',', ' '). ' Лотов';
							}
						}
					   ?>
				 </div>
                </div>

                <div>
                  <div class="fs-12 text-muted"><i class="ti-time mr-1"></i> 31 день</div>
                  <div class="fs-18 text-danger">
					  <?php
					  $querytocount = "SELECT COUNT(*) FROM lots  WHERE MONTH(`publish_date`) = MONTH(NOW())";
							$resultcount = mysqli_query($dblink, $querytocount) or die("Ошибка " . mysqli_error($dblink));
							if($resultcount){
							while ($row = mysqli_fetch_row($resultcount)) {
									echo number_format($row[0], 0, ',', ' ') . ' Лотов';
								}
							}
					  ?> </div>
                </div>

                <div class="fs-40 fw-100 text-right pr-2 text-success" style="font-size: 34px !important;">
				<?php  $querytosummu = "SELECT ROUND(SUM(price)) FROM lots WHERE MONTH(`publish_date`) = MONTH(NOW())";
					$resultsummu = mysqli_query($dblink, $querytosummu) or die("Ошибка " . mysqli_error($dblink));
					if($resultsummu){
					while ($row_sum = mysqli_fetch_row($resultsummu)) {
							echo number_format($row_sum[0], 0, ',', ' ');
						}
					}
				  ?>₸</div>
              </div>

              <table class="table table-striped table-hover">
                <tbody>
					<?php $queryto5last = "SELECT * FROM lots ORDER BY announcement DESC LIMIT 5";
$result5last = mysqli_query($dblink, $queryto5last) or die("Ошибка " . mysqli_error($dblink));
if($result5last){
while ($row = mysqli_fetch_row($result5last)) {
        
    ?>
				 
                  <tr>
                    <td><a class="hover-info" href="#"><?php echo $row[2];?></a></td>
                    <td class="text-muted w-80px"><?php echo $row[14];?></td>
                    <td class="text-success fw-500 w-90px"><?php echo number_format($row[9], 0, ',', ' '); ?>₸</td>
                  </tr>
<?php 
}
}
 ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"><strong>Лоты со статусом</strong> Прием Заявок</h5>
              </div>

              <table class="table table-striped table-hover table-responsive">
                <thead>
                  <tr>
                    <th>#номер лота</th>
                    <th>Категория</th>
                    <th>Дата окончания</th>
                  </tr>
                </thead>
                <tbody>
<?php $queryto5active = "SELECT * FROM lots WHERE id_status=3 ORDER BY announcement DESC LIMIT 5";
$result5active = mysqli_query($dblink, $queryto5active) or die("Ошибка " . mysqli_error($dblink));
if($result5active){
while ($row = mysqli_fetch_row($result5active)) {
    ?>
                  <tr>
                    <td><?php echo $row[4];?></td>
                    <td><?php echo $row[2];?></td>
                    <td><?php echo $row[14];?></td>
                  </tr>  
<?php 
}
}
 ?>
                </tbody>
              </table>

            </div>
          </div>








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

    <!-- END Global quickview -->



    <!-- Scripts -->
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/script.js"></script>

  </body>
</html>
<?php
//echo "Вы вошли на сайт, как ".$_SESSION['login'];
    //}
    ?>