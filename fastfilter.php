<?php
session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");
    /*// Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
    // Если пусты, то мы не выводим ссылку
		header("Location: https://gz.open-k.com/login.php");
    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
    }
else{*/
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Настройка фильтров</title>

     <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
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
        <a class="logo d-lg-none" href="index.php">Система сбора лотов</a>

        <ul class="topbar-btns">
          <h3>Изменение фильтров</h3>
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
		  <h1>Выберите нужный ID фильтра</h1>
        <form method="POST" action="filter2.php">
<div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        ID фильтра можете посмотреть ниже:
                      </label>
                      <?php
$querysavedfilters ="SELECT * FROM saved_filters";
$resultsavedfilters = mysqli_query($link, $querysavedfilters) or die("Ошибка " . mysqli_error($link)); 	
if($resultsavedfilters){
    echo '<select name="query" class="form-control form-control-sm" data-provide="selectpicker" data-width="100%">';
    while ($row = mysqli_fetch_row($resultsavedfilters)) {
        echo '<option value="SELECT * FROM `lots` where id_lot IS NOT NULL';
		if($row[1] != 0){
		echo " AND lot_number = '$row[1]'";
		}
		if($row[2] != NULL){
		echo " AND name LIKE '$row[2]'";
		}
		if($row[3] != 0){
		echo ' AND id_purchase_method = '.$row[3];
		}
		if($row[4] != 0){
		echo ' AND id_status = '.$row[4];
		}
		if($row[5] != 0){
		echo ' AND purchaser_name = '.$row[5];
		}
		if($row[6] != 0){
		echo ' AND price > '.$row[6];
		}
		if($row[7] != 0){
		echo ' AND price < '.$row[7];
		}
		if($row[8] != 0){
		echo ' AND id_purchase_item = '.$row[8];
		}
		if($row[9] != 0){
		echo ' AND announcement = '.$row[9];
		}
		if($row[10] != 0){
		echo " AND ids_place = ',$row[10],'";
		}
		if($row[11] != 0){
		echo ' AND id_user = '.$row[11];
		}
		echo '">';
			echo $row[0];
			echo'</option>';
    }
    echo "</select>";
     
    mysqli_free_result($resultsavedfilters);
}
						?>
                    </div>
                  </div>
	</div>
            
			<div class="form_btns">
              <input type="submit" style="background-color:#33cabb;color:white;" class="btn btn-flat btn-primary" name="save"  value="Выбрать фильтр">         
            </div>
        </form>
		  		  <h2>Описание Фильтров:</h2>
		  <table class="table">
			  
<?php
		  $querysavedfilters ="SELECT * FROM saved_filters";
 $resultsavedfilters = mysqli_query($link, $querysavedfilters) or die("Ошибка " . mysqli_error($link)); 
while ($row = mysqli_fetch_row($resultsavedfilters)) {
$rows01[]=$row[0];
$rows02[]=$row[1];
$rows03[]=$row[2];
$rows04[]=$row[3];
$rows05[] =$row[4];
$rows06[]=$row[5];
$rows07[]=$row[6];
$rows08[]=$row[7];
$rows010[]=$row[8];
$rows11[]=$row[10];
$rows12[]=$row[11];
$rows13[]=$row[12];
if($row[0] != 0){
echo '<tr><td>'.$row[0];
echo '</td>';
}
	?>
<td>  <?php
if($row[1] != null){
echo $row[1];
} 
?>
	</td>
			  <td>
	<?php
	if($row[2] != null){
echo $row[2];
}
?>
				  </td>
<td>		  
<?php
	if($row[3] != null){
		$querydost = 'SELECT * FROM `purchase_methods` WHERE id_purchase_method="'.$row[3].'"';
		$resultdost = mysqli_query($link, $querydost) or die("Ошибка " . mysqli_error($link)); 
    while ($rowd = mysqli_fetch_row($resultdost)) {
			echo $rowd[1];
    }
}
	?>
	</td><td><?php
	if($row[4] != null){
$querystat = 'SELECT * FROM `statuses` WHERE id_status="'.$row[4].'"';
		$resultstat = mysqli_query($link, $querystat) or die("Ошибка " . mysqli_error($link)); 
    while ($rowd = mysqli_fetch_row($resultstat)) {
			echo $rowd[1];
    }
}
	?>
			 </td><td> <?php
	if($row[5] != null){
echo $row[5];
}
	?>
				 </td><td><?php
	if($row[6] != null){
echo $row[6];
}
	?>
			  </td><td>
			  <?php
	if($row[7] != NULL){
echo $row[7];
}
	?></td><td>
			  <?php
	if($row[8] != NULL){
$queryzak = 'SELECT * FROM `purchase_items` WHERE id_purchase_item="'.$row[8].'"';
		$resultzak = mysqli_query($link, $queryzak) or die("Ошибка " . mysqli_error($link)); 
    while ($rowd = mysqli_fetch_row($resultzak)) {
			echo $rowd[1];
    }
}
	?></td><td><?php
	if($row[10] != NULL){
$querypo = 'SELECT * FROM `places` WHERE id_place="'.$row[10].'"';
		$resultpo = mysqli_query($link, $querypo) or die("Ошибка " . mysqli_error($link)); 
    while ($rowd = mysqli_fetch_row($resultpo)) {
			echo $rowd[1];
    }
}
	//if($row[11] != NULL){
//$querypo = 'SELECT * FROM `users` WHERE id_user="'.$row[11].'"';
//		$resultpo = mysqli_query($link, $querypo) or die("Ошибка " . mysqli_error($link)); 
  //  while ($rowd = mysqli_fetch_row($resultpo)) {
	//		echo '<td> <input type="checkbox" >'.$rowd[3];
		//	echo '</td>';
   // }
	?></td><td><?php
	echo '<input type="checkbox" id="'.$row[0].'" '.$row[12].'  onchange="updateFilters(this.id)">';
//}
	?></td><?php
}	
		  ?>
			  <thead>
    <tr>
     <th scope="col">ID</th>
       <th scope="col">Номер лота</th>
       <th scope="col">Наименование лота</th>
		<th scope="col">Способ закупки лота</th>
	 <th scope="col">Статус лота</th>
		<th scope="col">Имя заказчика</th>
     <th scope="col">Сумма от</th>
      <th scope="col">Сумма до</th> 
	 <th scope="col">Предмет закупки</th>
      <th scope="col">Место поставки</th>
	<th scope="col">Включить</th>
    </tr>
  </thead>
			  </table>
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
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/script.js"></script>
	  <script>
	  function updateFilters(id){
	  var keycode = document.getElementById(id).checked;
		$.ajax({
			type: 'POST',
			url: 'filt/filters.php',
			data: { 
				'keycode': keycode,
				'id': id
			},
			success: function(msg){
				alert(msg);
			}
		});
	  }
	  </script>
	  

  </body>
</html>
<?php
    //}
    ?>