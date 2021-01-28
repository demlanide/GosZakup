<?php
//session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password);


$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);
?>
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
          <a href="../">Система сбора лотов</a>
        </span>
        <span class="sidebar-toggle-fold"></span>
      </header>

      <nav class="sidebar-navigation">
       <?php 
		  include '../menu.php';
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
		  include '../usermenu.php';
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
			  <th></th><th></th>
			  <form method="post" action="del.php">
				  <th><a class="checkall" onclick="checkedAll()" href="#" style="background-color: #48B0F7; border-radius: 5px; color:white; padding:10px; cursor: pointer;">Выбрать все</a></th>  
				  <th><a class="checkall" href="../manage_role/" style="background-color: #48B0F7; border-radius: 5px; color:white; padding:10px; cursor: pointer;">Управление ролями</a></th>
				  	  <th><a class="checkall" href="../register.php" style="background-color: #48B0F7; border-radius: 5px; color:white; padding:10px; cursor: pointer;">Добавить нового</a></th>
				  <th><button class="delete" type="submit" name='delete' value='Delete Selected Items' style="background-color: #48B0F7; border-radius: 5px; color:white; padding:5px; border:none; cursor: pointer;">Удалить</button></th>
						<?php
							$query = 'SELECT * FROM `users`';
							$result = mysqli_query($dblink, $query);
			  				
			  				if(mysqli_num_rows($result)>0){
			  				$rows = mysqli_fetch_array($result);
			  					do{
								 echo '
									<div class="media align-items-center">
										<a class="flexbox align-items-center flex-grow gap-items" href="#qv-user-details'.$rows["id_user"].'" data-toggle="quickview">
												  <img class="avatar" src="/assets1/img/avatar-.png" alt="...">
												  <div class="media-body text-truncate">
												  <h6>'.$rows["name"].'</h6>
												  <small>
														<span>'.$rows["email"].'</span>
														<span class="divider-dash">'.$rows["login"].'</span>
												  </small>
												</div>
										</a>
										<input type="checkbox" name="cbox[]" id="checkbox[]" class="cbox'.$rows["id_user"].'" value="'.$rows["id_user"].'">
									</div>
									<div id="qv-user-details'.$rows["id_user"].'" class="quickview quickview-lg">
									  <div class="quickview-body">
										<div class="card card-inverse">
										  <div class="card-body text-center pb-50">
											<a href="#">
											  <img class="avatar avatar-xxl avatar-bordered" src="assets/img/avatar/1.jpg">
											</a> 
											<h4 class="mt-2 mb-0"><a class="hover-primary text-white" href="#">'.$rows["login"].'</a></h4>
										  </div>
										</div>
										<div class="quickview-block form-type-material">
										 <div class="form-group">
											<input type="text"   id="username'.$rows["id_user"].'" class="form-control" value="'.$rows["name"].'">
											<label>Имя</label>
										 </div>
										 <div class="form-group">
											<input type="text" id="email'.$rows["id_user"].'" class="form-control" value="'.$rows["email"].'">
											<label>Почтовый адрес Email</label>
										  </div>
										  <div class="form-group">
											<input type="text"  id="user_id'.$rows["id_user"].'"  class="form-control" value="'.$rows["id_user"].'">
											<label>ID Юзера</label>
										  </div>
										  <div class="form-group">
											<input type="text"   onkeyup="dynSearch(this.id)" id="user_role'.$rows["id_user"].'"  class="form-control search'.$rows["id_user"].'" value="'.$rows["status"].'"><div id="user_role'.$rows["id_user"].'display"></div>
											<label>Роль</label><br>
											<a class="change" style="background-color: #48B0F7; border-radius: 5px; color:white; padding:10px; margin-top: 150px;" href="#" id="'.$rows["id_user"].'" style="cursor: pointer;" onclick="update(this.id)">Изменить</A>
										  </div>
										</div>
										</div>
										</div>
									';
								}
								while ($rows = mysqli_fetch_array($result));
							}
							?>
			  </form>	
		</div>
			
    </div>
   </div>


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
	<script src="handler.js"></script>
<script type="text/javascript">

function checkedAll () {
	checkboxes = document.getElementsByName('cbox[]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		  if(checkboxes[i].checked){
		  	checkboxes[i].checked = false;
		  }else{
			checkboxes[i].checked = true;
		  }
	  }
 }

</script>
<script>

 	function dynSearch(id){
    // Обработчик события keyup, сработает после того как пользователь отпустит кнопку, после ввода чего-либо в поле поиска.
    // Поле поиска из файла 'index.php' имеет id='search'
    
 
        // Присваиваем значение из поля поиска, переменной 'name'.
        var name = document.getElementById(id).value;
 
        // Проверяем если значение переменной 'name' является пустым
        if (name === "") {
 
            // Если переменная 'name' имеет пустое значение, то очищаем блок div с id = 'display'
            document.getElementById(id+"display").innerHTML="Ничего не найдено";
 
        }
        else {
            // Иначе, если переменная 'name' не пустая, то вызываем ajax функцию.
 
            $.ajax({
 
                type: "POST", // Указываем что будем обращатся к серверу через метод 'POST'
                url: "handler.php", // Указываем путь к обработчику. То есть указывем куда будем отправлять данные на сервере.
                data: {
                    // В этом объекте, добавляем данные, которые хотим отправить на сервер
                    search: name,
					id: id// Присваиваем значение переменной 'name', свойству 'search'.
                },
                success: function(response) {
                    // Если ajax запрос выполнен успешно, то, добавляем результат внутри div, у которого id = 'display'.
                     document.getElementById(id+'display').innerHTML=response;
                }
 
            });
 
        }
	}
 

function fill(Value,id) {
    // Функция 'fill', является обработчиком события 'click'.
    // Она вызывается, когда пользователь кликает по элементу из результата поиска.
    document.getElementById(id).value = Value; // Берем значение элемента из результата поиска и добавляем его в значение поля поиска
   document.getElementById(id+'display').innerHTML = "";// Скрываем результаты поиска
 
}
function update(id) {
name = document.getElementById('username'+id).value;
email = document.getElementById('email'+id).value;
role = document.getElementById('user_role'+id).value;
console.log(name + email);
$.ajax({
   type: "POST",
   url: "us_update.php",
   data: 'name='+name+'&email='+email+'&role='+role+'&id='+id,
   success: function(msg){
     alert(msg);
   }
});
	 
 }
</script>
  </body>
</html>
<?php
 //   echo "Вы вошли на сайт, как ".$_SESSION['login'];
 //   }
    ?>