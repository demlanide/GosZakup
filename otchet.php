<?php 
//session_start();
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$database = 'openkcom_gz1';

$link = mysqli_connect($server, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

?>
 <?php
    // Проверяем, пусты ли переменные логина и id пользователя
  //  if (empty($_SESSION['login']) or empty($_SESSION['id']))
 //   {
    // Если пусты, то мы не выводим ссылку
//		header("Location: https://gz.open-k.com/login.php");
//  echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
//    }
//else{
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Страница импорта</title>

     <!-- Styles -->
    <link href="https://gz.open-k.com//assets/css/core.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/app.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/style.css" rel="stylesheet">

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
          <a href="index.php">Система сбора лотов</a>
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
        <a class="logo d-lg-none" href="index.php">Админ панель</a>

        <ul class="topbar-btns">
          <h3>Модуль отчетности</h3>
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



    
    <main>


      <div class="main-content">
		  <style>
			  select {
				  max-width: 72%;
				  padding: 5px 0px;
			  }
			  .last_select {
				  width: 176px;
			  }
			  .btn {
				  margin-bottom: 20px;
			  }
			  
		  </style>
        
		  <script>var select = document.querySelector('select');
select.addEventListener('change', (event) => {
    alert(this.value);
    alert(event.target.value);
});</script>
        <form method="POST" action="getReport.php">
          <div class="form_body">
            <div class="form-list">
              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Тип отчета
                      </label>
                      <?php
						
						$querystatus ="SELECT * FROM report_types";
//Tolko nazvanie
 $resultstatus = mysqli_query($link, $querystatus) or die("Ошибка " . mysqli_error($link)); 
if($resultstatus)
{
    echo '<select name="reportType" id="select_id" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
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
                  </div>
				  
				  <div class="col-md-3 otdel_class">
                    <div class="form-group">
                      <label>
                        Отдел
                      </label>
						<select name="segment" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">
							<option value="1">Отдел по работе с проф. образованием
							</option>
							<option value="2">Отдел по работе со школами
							</option>
							<option value="3">Общий свод
							</option>
							<option value="4">Свод по закрытым проектам
							</option>
							<option value="5">Отдел по работе с ГЧП
							</option>
						</select>
                    </div>
                  </div>
				  
				  
				  <div class="col-md-3 year_class">
                    <div class="form-group">
                      <label>
                        Выберите год
                      </label>
						<select name="year" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">
							<?php
								$year = date("Y")-1;
							$yearthis = date("Y");
								echo $year;
								?>
							<option value="<?php
								echo $year;
								?>"><?php
								echo $year;
								?>
							</option>
							<option value="<?php
								echo $yearthis;
								?>"><?php
								echo $yearthis;
								?>
							</option>
						</select>
                    </div>
                  </div>
				  
				  <div class="col-md-3 month_class">
                    <div class="form-group">
                      <label>
                        Выберите месяц
                      </label>
						<select name="month" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">
							<option value="01">Январь
							</option>
							<option value="02">Февраль
							</option>
							<option value="03">Март
							</option>
							<option value="04">Апрель
							</option>
							<option value="05">Май
							</option>
							<option value="06">Июнь
							</option>
							<option value="07">Июль
							</option>
							<option value="08">Август
							</option>
							<option value="09">Сентябрь
							</option>
							<option value="10">Октябрь
							</option>
							<option value="11">Ноябрь
							</option>
							<option value="12">Декабрь
							</option>
							
						</select>
                    </div>
                  </div>
				  
              </div>
            </div>
            <div class="form_btns">
              <input type="submit" style="background-color:#33cabb;color:white;" class="btn btn-flat btn-primary" name="submit_btn"  value="Отправить">         
            </div>
          </div>
        </form>
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

    <style>
		.month_class, .year_class {
			display: none;
		}
	</style>


    <!-- Scripts -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://gz.open-k.com/assets/js/core.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/app.min.js"></script>
    <script src="https://gz.open-k.com/assets/js/script.js"></script>
	
    <script type="text/javascript"> 
	  $("#select_id").change(function() {
		  if($("#select_id").val() == 8) {
			$(".otdel_class").css({"display": "none"});
		    $(".month_class").css({"display": "block"});
			$(".year_class").css({"display": "block"});
		  }
		  else {
			$(".otdel_class").css({"display": "block"});
		    $(".month_class").css({"display": "none"});
			$(".year_class").css({"display": "none"});
		  }
			  
	  });
	</script>
  </body>
</html>
<?php
//    }
    ?>