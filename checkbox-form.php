<?php
//session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	  <style>.preloader {
    position: unset !important;</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Страница результатов отправки</title>

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

          <h3>Страница результатов отправки</h3>
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


<script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)<=0) {
        location.href = 'product1.php';
    }
    i.innerHTML = parseInt(i.innerHTML)-1;
}
setInterval(function(){ countdown(); },1000);
</script>
    <!-- Main container -->
    <main>
      <div class="main-content">
		  <br><br>
<p style="font-size:16px;">Вы будете перенаправлены на страницу фильтрации через <span id="counter">10</span> секунд<br><span style="color:#000f80;">Сообщение о выгрузке Лотов было отправлено всем участникам!</span></p>
<?php

$statuses = array(
	'2'=>'37430350',
	'3'=>'37430353',
	'4'=>'37430545',
	'5'=>'37430551',
	'6'=>'37430356',
	'7'=>'143',
	'8'=>'37430515',
	'9'=>'37430548',
	'10'=>'37430557',
	'11'=>'37430554',
	'12'=>'37430743',
	'13'=>'37430560',
	'14'=>'37430563',
	'15'=>'37430566',
	'16'=>'37430584',
	'17'=>'37340962',
	'18'=>'37340965',
	'19'=>'37340968',
	'20'=>'37340971',
	'21'=>'36042283',
	'22'=>'37340974',
	'23'=>'37340977',
	'24'=>'37340980',
	'25'=>'37340983',
	'26'=>'37340989',
	'27'=>'37340992',
	'28'=>'37340923',
	'29'=>'37340926'
);



$checkboxes = $_POST['chosenbox'];
if(empty($checkboxes)) {
    echo("Вы не выбрали ни одного лота.");
} 
else {
   	$Num = count($checkboxes);
	echo 'Все успешно выгружено в AMO CRM<br> Вернуться на <a href="/product1.php">предыдущую страницу</a> <br>';
    echo("Вы выбрали $Num лотов: ");
    for($i=0; $i < $Num; $i++){
      	echo($checkboxes[$i]. " ");
    }
}

if(isset($_POST['useer'])){
$user = $_POST['useer'];
}else{
$user = 12;
}
$email = mysqli_query($dblink, "SELECT email FROM users WHERE id_user = $user")->fetch_array(MYSQLI_NUM)[0];
if (strpos($email, "kazinterservice"))
	$user = getuserid($email);
else
	$user = 0;
$counter = 0;
for ($i = 0; $i < count($checkboxes); $i++) {
	if (mysqli_query($dblink, "SELECT count(*) FROM taken_lots WHERE id_lot = $checkboxes[$i]")->fetch_array(MYSQLI_NUM)[0] != 0)
		break;
    $arr = mysqli_query($dblink, "SELECT * FROM lots WHERE id_lot = $checkboxes[$i]")->fetch_array(MYSQLI_ASSOC);
	$name = $arr["name"];
	$name = str_replace('"', '\"', $name);
    $price = (int)$arr["price"];
    $lotNumber = $arr["lot_number"];
	$winner = $arr["winner"];
	if($winner !=""){
	$winner = $arr["winner"];
	}else{
		$winner = "Победитель не определен";
	}
    $purchaseMethod = mysqli_query($dblink, "SELECT name FROM purchase_methods WHERE id_purchase_method = ".$arr["id_purchase_method"])->fetch_array(MYSQLI_NUM)[0];
    $status = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr["id_status"])->fetch_array(MYSQLI_NUM)[0];
    if ($arr["ids_place"] == "none")
        $places = "Места поставки не указаны";
    else {
        $places_arr = explode(',', $arr["ids_place"]);
        $places = "";
        for ($j = 1; $j < count($places_arr); $j+=2)
		{
			$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
			if ($vart)
            	$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
		}
        $places = substr($places, 0, -2);
    }
	if (mysqli_query($dblink, "SELECT id_user FROM places WHERE id_place = ".$places_arr[1]) != false)
		$id_user = mysqli_query($dblink, "SELECT id_user FROM places WHERE id_place = ".$places_arr[1])->fetch_array(MYSQLI_NUM)[0];
    $purchaserName = $arr["purchaser_name"];
    $anno = $arr["announcement"];
    $purchaseItem = mysqli_query($dblink, "SELECT name FROM purchase_items WHERE id_purchase_item = ".$arr["id_purchase_item"])->fetch_array(MYSQLI_NUM)[0];
	$publishDate = $arr["publish_date"];
	$tradingStartDate = $arr["trading_start_date"];
	$tradingFinishDate = $arr["trading_finish_date"];
	$link = $arr["link"];
	$stat_id = (int)$statuses[$arr["id_status"]];
	$stringQuery = array("name"=>"$name", 
						 "price"=>$price, 
						 "pipeline_id"=>3911218,
						 "status_id"=>$stat_id,
						 "responsible_user_id"=>$user,
						 "custom_fields_values"=>array(
							array(
						"field_id"=>1312743,
						"values"=>array(
							array("value"=>"$winner")
						)
					),
					array(
						"field_id"=>1312745,
						"values"=>array(
							array("value"=>"$purchaseMethod")
						)
					),
					array(
						"field_id"=>1312747,
						"values"=>array(
							array("value"=>"$places")
						)
					),
					array(
						"field_id"=>1312753,
						"values"=>array(
							array("value"=>"$purchaseItem")
						)
					),
					array(
						"field_id"=>1312755,
						"values"=>array(
							array("value"=>"$publishDate")
						)
					),
					array(
						"field_id"=>1312757,
						"values"=>array(
							array("value"=>"$tradingStartDate")
						)
					),
					array(
						"field_id"=>1312759,
						"values"=>array(
							array("value"=>"$tradingFinishDate")
						)
					),
					array(
						"field_id"=>1312955,
						"values"=>array(
							array("value"=>"$link")
						)
					)
				)
			);
			$id_amo = upamo($stringQuery);
			$id_lot = $arr["id_lot"];
			$email = $arr["purchaser_email"];
			$id_cont = checkcont($purchaserName);
			if ($id_cont == NULL)
				$id_cont = addcont($purchaserName, $email);
			connect($id_cont, $id_amo);
			if (mysqli_query($dblink, "SELECT * FROM files WHERE lot_number = '$lotNumber'") != false) {
				$docs = mysqli_query($dblink, "SELECT * FROM files WHERE lot_number = '$lotNumber'")->fetch_all(MYSQLI_ASSOC);
				for ($g=0; $g<count($docs); $g++) {
					comments($id_amo, $docs[$g]["name"], $docs[$g]["link"]);
				}
			}
			mysqli_query($dblink, "INSERT INTO taken_lots (id_lot, id_status, id_user, id_amo, lot_number) VALUES ($id_lot, 1, $id_user, $id_amo, '$lotNumber')");
			usleep(100000);
}


//EMAIL UVEDOMLENIE
$queryemail = "SELECT * FROM users ";
$result3 = mysqli_query($dblink, $queryemail);
while ($row = mysqli_fetch_row($result3)) {
	$array[] = $row[5];
}

//$to = implode(',', $array);
$to = "v.klimov@open-k.com";
$title = "Новая выгрузка в amoCRM - gz.open-k.com";
$message = "Новые лоты были выгружены на amoCRM!<br>";
//$message .= "Текст письма: " . $_POST['message'] . "<br>";

$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers .= "From: no-reply <no-reply@gz.open-k.com>\r\n";

$result = mail($to, $title, $message, $headers);
if ($result) {
    echo 'Ваша заявка отправлено успешно';
} else {
    echo 'Заявка не отправлено';
}

?>
     
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

