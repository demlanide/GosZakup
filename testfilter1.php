<?php
session_start();
include("app/database/db.php");
include("app/amocrm/amocrm.php");
   /* // Проверяем, пусты ли переменные логина и id пользователя
   if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
    // Если пусты, то мы не выводим ссылку
		header("Location: https://gz.open-k.com/login.php");
    echo "Вы вошли на сайт, как гость<br><a href='/login.php'>Эта страница  доступна только зарегистрированным пользователям</a>";
    }
else{*/
//POST Data
if (isset($_POST['lotNumber'])){
    $_SESSION['lotNumber'] = trim($_POST['lotNumber']);
	$lotNumber = $_POST['lotNumber'];
}
if (isset($_SESSION['lotNumber'])) {
    $lotNumber = $_SESSION['lotNumber'];
}
if (isset($_POST['place'])){
    $_SESSION['place'] = trim($_POST['place']);
	$place = (int)$_POST['place'];
}
if (isset($_SESSION['place'])) {
    $place = $_SESSION['place'];
}
if (isset($_POST['lotName'])){
    $_SESSION['lotName'] = trim($_POST['lotName']);
	$lotName = $_POST['lotName'];
}
if (isset($_SESSION['lotName'])) {
    $lotName = $_SESSION['lotName'];
}
if (isset($_POST['trdMethod'])){
    $_SESSION['trdMethod'] = trim($_POST['trdMethod']);
	$trdMethod = (int)$_POST['trdMethod'];

}
if (isset($_SESSION['trdMethod'])) {
    $trdMethod = $_SESSION['trdMethod'];
}
if (isset($_POST['lotStatus'])){
    $_SESSION['lotStatus'] = trim($_POST['lotStatus']);
	$lotStatus = (int)$_POST['lotStatus'];
}
if (isset($_SESSION['lotStatus'])) {
    $lotStatus = $_SESSION['lotStatus'];
}
if (isset($_POST['purchaser'])){
    $_SESSION['purchaser'] = trim($_POST['purchaser']);
	$purchaser = $_POST['purchaser'];
}
if (isset($_SESSION['purchaser'])) {
    $purchaser = $_SESSION['purchaser'];
}
if (isset($_POST['amountFrom'])){
    $_SESSION['amountFrom'] = trim($_POST['amountFrom']);
	$amountFrom = (float)$_POST['amountFrom'];
}
if (isset($_SESSION['amountFrom'])) {
    $amountFrom = $_SESSION['amountFrom'];
}
if (isset($_POST['amountTo'])){
    $_SESSION['amountTo'] = trim($_POST['amountTo']);
	$amountTo = $_SESSION['amountTo'];
}
if (isset($_SESSION['amountTo'])) {
	$amountTo = (float)$_POST['amountTo'];
}
if (isset($_POST['purchaseItem'])){
    $_SESSION['purchaseItem'] = trim($_POST['purchaseItem']);
	$purchaseItem = (int)$_POST['purchaseItem'];
}
if (isset($_SESSION['purchaseItem'])) {
    $purchaseItem = $_SESSION['purchaseItem'];
}
$annoNum = $_POST['annoNum'];
$id_user = (int)$_POST['user'];


//Query strings
$email = mysqli_query($dblink, "SELECT email FROM users WHERE id_user = $id_user")->fetch_array(MYSQLI_NUM)[0];
if (strpos($email, "kazinterservice")){
	$user = getuserid($email);
}else{
	$user = 0;
}
$button = $_POST;
//Filters for querys
if ($button['search'] == "Поиск" || isset($_GET['pagell'])) {
//querytofilter2
	$queryto2 = "SELECT * FROM lots WHERE ";
	if ($lotNumber != "") {
		$flag = 1;
		$queryto2 = $queryto2."lot_number = '$lotNumber'";
	}
	if ($lotName != "") {
		if ($flag == 1)
			$query = $queryto2." AND ";
		$queryto2 = $queryto2."name LIKE '%$lotName%'";
		$flag = 1;
	}
	if ($trdMethod != 1) {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."id_purchase_method = $trdMethod";
		$flag = 1;
	}
	if ($lotStatus != 1) {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."id_status = $lotStatus";
		$flag = 1;
	}
	if ($purchaser != "") {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."purchaser_name = '$purchaser'";
		$flag = 1;
	}
	if ($amountFrom != 0) {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."price > $amountFrom";
		$flag = 1;
	}
	if ($amountTo != 0) {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."price < $amountTo";
		$flag = 1;
	}
	if ($purchaseItem != 1) {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."id_purchase_item = $purchaseItem";
		$flag = 1;
	}
	if ($annoNum != "") {
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."announcement = '$annoNum'";
		$flag = 1;
	}
	if ($place != 1) {
		$placestr = ",".$place.",";
		if ($flag == 1)
			$queryto2 = $queryto2." AND ";
		$queryto2 = $queryto2."ids_place LIKE '%$placestr%'";
		$flag = 1;
	}
	//querytofilter2
	$flag = 0;
	$query = "SELECT * FROM lots WHERE ";
	if ($lotNumber != "") {
		$flag = 1;
		$query = $query."lot_number = '$lotNumber'";
	}
	if ($lotName != "") {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."name LIKE '%$lotName%'";
		$flag = 1;
	}
	if ($trdMethod != 1) {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."id_purchase_method = $trdMethod";
		$flag = 1;
	}
	if ($lotStatus != 1) {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."id_status = $lotStatus";
		$flag = 1;
	}
	if ($purchaser != "") {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."purchaser_name = '$purchaser'";
		$flag = 1;
	}
	if ($amountFrom != 0) {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."price > $amountFrom";
		$flag = 1;
	}
	if ($amountTo != 0) {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."price < $amountTo";
		$flag = 1;
	}
	if ($purchaseItem != 1) {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."id_purchase_item = $purchaseItem";
		$flag = 1;
	}
	if ($annoNum != "") {
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."announcement = '$annoNum'";
		$flag = 1;
	}
	if ($place != 1) {
		$placestr = ",".$place.",";
		if ($flag == 1)
			$query = $query." AND ";
		$query = $query."ids_place LIKE '%$placestr%'";
		$flag = 1;
	}
	//dd
		$per_page=100;
if (isset($_GET['pagell'])) $pagell=($_GET['pagell']-1);
$start=abs($pagell*$per_page);
	
	$query = $query." LIMIT $start,$per_page";

	$flagq = 0;
	$q="SELECT count(*) FROM `lots` WHERE ";
	if ($lotNumber != "") {
		$flagq = 1;
		$q = $q."lot_number = '$lotNumber'";
	}
	if ($lotName != "") {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."name LIKE '%$lotName%'";
		$flagq = 1;
	}
	if ($trdMethod != 1) {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."id_purchase_method = $trdMethod";
		$flagq = 1;
	}
	if ($lotStatus != 1) {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."id_status = $lotStatus";
		$flagq = 1;
	}
	if ($purchaser != "") {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."purchaser_name = '$purchaser'";
		$flagq = 1;
	}
	if ($amountFrom != 0) {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."price > $amountFrom";
		$flagq = 1;
	}
	if ($amountTo != 0) {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."price < $amountTo";
		$flagq = 1;
	}
	if ($purchaseItem != 1) {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."id_purchase_item = $purchaseItem";
		$flagq = 1;
	}
	if ($annoNum != "") {
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."announcement = '$annoNum'";
		$flagq = 1;
	}
	if ($place != 1) {
		$placestr = ",".$place.",";
		if ($flagq == 1)
			$q = $q." AND ";
		$q = $q."ids_place LIKE '%$placestr%'";
		$flagq = 1;
	}
	//dd
echo $q;
	$respag=mysqli_query($dblink, $q);
while($row=mysqli_fetch_array($respag)) {
  echo ++$start.". ".$row['field']."<br>\n";
}
$respag=mysqli_query($dblink, $q);
$row=mysqli_fetch_row($respag);
$total_rows=$row[0];
	$num_pages=ceil($total_rows/$per_page);
	//Query strings in query funcs
	$result = mysqli_query($dblink, $query);
	$result1 = mysqli_query($dblink, $query);
	$result2 = mysqli_query($dblink, $query);
	$check = $result->fetch_all(MYSQLI_NUM);
	if ($result == false || $check == []) {
		$date_yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")-1));
		$filter = "";
		$flag = 0;			 
		if ($lotNumber != NULL) {
			$filter = $filter."lotNumber: \"$lotNumber\"";
			$flag = 1;
		}
		if ($lotName != NULL) {
			if ($flag == 1)
				$filter = $filter.", ";
			else
				$flag = 1;
			$lotName = trim($lotName);
			if (strpos($lotName, ' ') == false)
				$filter = $filter."nameRu: \"?$lotName\"";
			else
				$filter = $filter."nameRu: \"*$lotName\"";
		}
		if ($trdMethod != 1) {
			if ($flag == 1)
				$filter = $filter.", ";
			else
				$flag = 1;
			if (mysqli_query($dblink, "SELECT id_gz FROM purchase_methods WHERE id_purchase_method = $trdMethod") != false) {
				$trdMethod = mysqli_query($dblink, "SELECT id_gz FROM purchase_methods WHERE id_purchase_method = $trdMethod")->fetch_array(MYSQLI_NUM)[0];
				$filter = $filter."refTradeMethodsId: $trdMethod";
			}
		}
		if ($purchaser != NULL) {
			if ($flag == 1)
				$filter = $filter.", ";
			else
				$flag = 1;
			$purchaser = trim($purchaser);
			if (strpos($purchaser, ' ') == false)
				$filter = $filter."customerNameRu: \"?$purchaser\"";
			else
				$filter = $filter."customerNameRu: \"*$purchaser\"";
		}
		$hasNextPage = 1;
		$after = "";
		while ($hasNextPage == 1)
		{
			$arr = array();
			$cquery = "query{
				Lots(filter: {".$filter.", lastUpdateDate: \"$date_yesterday\"}, limit: 50$after) {
				lotNumber
				refLotStatusId
				count
				amount
				nameRu
				descriptionRu
				customerBin
				customerNameRu
				trdBuyNumberAnno
				refTradeMethodsId
				plnPointKatoList
				TrdBuy {
					refSubjectTypeId
					startDate
					endDate
					publishDate
				}
				lastUpdateDate
				Files {
					filePath
					nameRu
				}
				}
			}";
			$variables = "";
			$json = json_encode(['query' => $cquery, 'variables' => $variables]);
			$a = array("Authorization: Bearer 1c46e6d8bc8c0adaeb84f92cad780405", "Content-Type: application/json");
			$tuCurl = curl_init();
			curl_setopt($tuCurl, CURLOPT_URL, "https://ows.goszakup.gov.kz/v3/graphql");
			curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
			curl_setopt($tuCurl, CURLOPT_HEADER, 0);
			curl_setopt($tuCurl, CURLOPT_POST, 1);
			curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($tuCurl, CURLOPT_HTTPHEADER, $a);
			curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $json);
			curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
			$arr = json_decode(curl_exec($tuCurl), true);
			putindb($arr, $dblink);
			curl_close($tuCurl);
			$hasNextPage = 0;//$arr["extensions"]["pageInfo"]["hasNextPage"];
			//$after = ", after: ".$arr["extensions"]["pageInfo"]["lastId"];
		}
		$result = mysqli_query($dblink, $query);
	}
	if ($result != false) {
		$checkboxes = $result->fetch_all(MYSQLI_ASSOC);
		for ($i = 0; $i < count($checkboxes); $i++) {
			$name = $checkboxes[$i]["name"];
			$name = str_replace('"', '\"', $name);
			$price = $checkboxes[$i]["price"];
			$price = (int)$price;
			$lotNumber = $checkboxes[$i]["lot_number"];
			if (mysqli_query($dblink, "SELECT count(*) FROM taken_lots WHERE lot_number = '$lotNumber'"))
				if (mysqli_query($dblink, "SELECT count(*) FROM taken_lots WHERE lot_number = '$lotNumber'")->fetch_array(MYSQLI_NUM)[0] != 0)
					continue;
			$purchaseMethod = mysqli_query($dblink, "SELECT name FROM purchase_methods WHERE id_purchase_method = ".$checkboxes[$i]["id_purchase_method"])->fetch_array(MYSQLI_NUM)[0];
			$status = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$checkboxes[$i]["id_status"])->fetch_array(MYSQLI_NUM)[0];
			if ($checkboxes[$i]["ids_place"] == "none")
				$places = "Места поставки не указаны";
			else {
				$places_arr = explode(',', $checkboxes[$i]["ids_place"]);
				$places = "";
				for ($j = 1; $j < count($places_arr); $j+=2)
				{
					$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
					if ($vart)
						$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
				}
				$places = substr($places, 0, -2);
			}
			if (mysqli_query($dblink, "SELECT id_kato FROM places WHERE id_place = ".$places_arr[1]) != false)
				$id_user = mysqli_query($dblink, "SELECT id_kato FROM places WHERE id_place = ".$places_arr[1])->fetch_array(MYSQLI_NUM)[0];
			$purchaserName = $checkboxes[$i]["purchaser_name"];
			$purchaserName = str_replace('"', '\"', $purchaserName);
			$anno = $checkboxes[$i]["announcement"];
			$purchaseItem = mysqli_query($dblink, "SELECT name FROM purchase_items WHERE id_purchase_item = ".$checkboxes[$i]["id_purchase_item"])->fetch_array(MYSQLI_NUM)[0];
			$publishDate = $checkboxes[$i]["publish_date"];
			$tradingStartDate = $checkboxes[$i]["trading_start_date"];
			$tradingFinishDate = $checkboxes[$i]["trading_finish_date"];
			$link = $checkboxes[$i]["link"];
			$stringQuery = array("name"=>"$name", 
								 "price"=>$price, 
								 "pipeline_id"=>3711946, 
								 "responsible_user_id"=>$user,
								 "custom_fields_values"=>array(
					array(
						"field_id"=>1312743,
						"values"=>array(
							array("value"=>"$lotNumber")
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
			$id_lot = $checkboxes[$i]["id_lot"];
			$id_cont = addcont($purchaserName);
			connect($id_cont, $id_amo);
			if (mysqli_query($dblink, "SELECT * FROM files WHERE lot_number = '$lotNumber'") != false) {
				$docs = mysqli_query($dblink, "SELECT * FROM files WHERE lot_number = '$lotNumber'")->fetch_all(MYSQLI_ASSOC);
				for ($g=0; $g<count($docs); $g++) {
					comments($id_amo, $docs[$g]["name"], $docs[$g]["link"]);
				}
			}
			if (mysqli_query($dblink, "INSERT INTO taken_lots (id_lot, id_status, id_user, id_amo, lot_number) VALUES ($id_lot, 1, $id_user, $id_amo, '$lotNumber')") == false)
				echo "INSERT INTO taken_lots (id_lot, id_status, id_user, id_amo, lot_number) VALUES ($id_lot, 1, $id_user, $id_amo, '$lotNumber')";
			//mysqli_query($dblink, "INSERT INTO taken_lots (id_lot, id_status, id_user, id_amo, lot_number) VALUES ($id_lot, 1, $id_user, $id_amo, '$lotNumber')");
			usleep(100000);
		}
	}
} else {
	$query = "INSERT INTO saved_filters(lotNumber, lotName, trdMethod, lotStatus, purchaser, amountFrom, amountTo, purchaseItem, annoNum, place, user) VALUES (";
	if ($lotNumber != "") {
		$query = $query.$lotNumber.", ";
	} else
		$query = $query."NULL, ";
	if ($lotName != "") {
		$query = $query."'$lotName', ";
	} else
		$query = $query."NULL, ";
	if ($trdMethod != 1) {
		$query = $query.$trdMethod.", ";
	} else
		$query = $query."NULL, ";
	if ($lotStatus != 1) {
		$query = $query.$lotStatus.", ";
	} else
		$query = $query."NULL, ";
	if ($purchaser != "") {
		$query = $query."'$purchaser', ";
	} else
		$query = $query."NULL, ";
	if ($amountFrom != 0) {
		$query = $query.$amountFrom.", ";
	} else
		$query = $query."NULL, ";
	if ($amountTo != 0) {
		$query = $query.$amountTo.", ";
	} else
		$query = $query."NULL, ";
	if ($purchaseItem != 1) {
		$query = $query.$purchaseItem.", ";
	} else
		$query = $query."NULL, ";
	if ($annoNum != "") {
		$query = $query."'$annoNum', ";
	} else
		$query = $query."NULL, ";
	if ($place != 1) {
		$query = $query.$place.", ";
	} else
		$query = $query."NULL, ";
	if ($user != 1) {
		$query = $query.$id_user.")";
	} else
		$query = $query."NULL)";
	mysqli_query($dblink, $query);
	header("Location: https://gz.open-k.com/fastfilter.php");
}


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
				top: 82px;
		   }
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
		   table{
			   width:100%
		   }
		  th:hover{
			  cursor:pointer;
		   }
		  tr, td, th{
			  border: 1px solid gray;
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
		  include ('menu.php');
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
		  		include ('usermenu.php');
				?>
            </div>
          </li>
        </ul>
      </div>
    </header>
    <!-- END Topbar -->



    <!-- Main container -->
<main>	
	
		  	<!--<?php /*for($i=1;$i<=$num_pages;$i++) {
  if ($i-1 == $pagell) {
    echo $i." ";
  } else {
    echo '<a href="'.$_SERVER['PHP_SELF'].'?pagell='.$i.'&place='.$place.'">'.$i.'</a> ';
  }
}
	 */ ?>-->
  <div class="main-content">
	  <form method="POST" action="filter1.php">
          <div class="form_body">
            <div class="form-list">
              <div class="row">
                 <div class="col-md-3">
                    <div class="form-group">
                      <label for="">
                        Номер лота
                      </label>
                      <input type="text" class="form-control" name="lotNumber" placeholder="Номер лота" <?php if($_POST['lotNumber'] != ''){$nomerlotaa = $_POST['lotNumber']; echo ' value="'.$nomerlotaa.'"';} ?>>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Наименование лота
                      </label>
                      <input type="text" class="form-control" name="lotName" placeholder="Наименование лота" <?php if($_POST['lotName'] != ''){$lotnamee = $_POST['lotName']; echo ' value="'.$lotnamee.'"';} ?>>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Способ закупки<br>
                      </label>
                      <?php
							//Tolko nazvanie						
							$querysposobzakupki ="SELECT id_purchase_method,name FROM purchase_methods";
							$resultsposobzakupki = mysqli_query($dblink, $querysposobzakupki) or die("Ошибка " . mysqli_error($dblink)); 
							if($resultsposobzakupki)
							{
								echo '<select name="trdMethod" class="form-control form-control-sm" data-width="100%">';
							if($_POST['trdMethod'] != ''){
								$trdmethodd = $_POST['trdMethod'];
								$querysposobzakupki1 ="SELECT id_purchase_method,name FROM purchase_methods WHERE id_purchase_method = ".$trdmethodd;
								$resultsposobzakupki1 = mysqli_query($dblink, $querysposobzakupki1) or die("Ошибка " . mysqli_error($dblink));
									echo '<option value="'.$trdmethodd.'">';
										while ($row = mysqli_fetch_row($resultsposobzakupki1)) {
											echo $row[1];
										}
									echo'</option>';
							}
								while ($row = mysqli_fetch_row($resultsposobzakupki)) {
									echo '<option value="'.$row[0].'">';
										echo $row[1];
									echo'</option>';
								}
								echo "</select>";
								mysqli_free_result($resultsposobzakupki);}
							
						?>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Статус лота
                      </label>
                      <?php
						 $querystatus ="SELECT id_status,name FROM statuses";
						//Tolko nazvanie
						 $resultstatus = mysqli_query($dblink, $querystatus) or die("Ошибка " . mysqli_error($dblink)); 
						if($resultstatus)
						{
							echo '<select name="lotStatus" class="form-control form-control-sm">';
							if($_POST['lotStatus'] != ''){
								$lotstatuss = $_POST['lotStatus'];
								$querystatus1 ="SELECT id_status,name FROM statuses WHERE id_status = ".$lotstatuss;
								$resultstatus1 = mysqli_query($dblink, $querystatus1) or die("Ошибка " . mysqli_error($dblink));
								echo '<option value="'.$lotstatuss.'">';
									while ($row = mysqli_fetch_row($resultstatus1)) {
										echo $row[1];
									}
								echo'</option>';	
							}while ($row = mysqli_fetch_row($resultstatus)) {
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
              </div>

              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Место поставки
                      </label>
                      <?php
                                $querymestopostavki ="SELECT * FROM places";
                                //Tolko nazvanie
                                 $resultmestopostavki = mysqli_query($dblink, $querymestopostavki) or die("Ошибка " . mysqli_error($dblink)); 
                                if($resultmestopostavki)
                                {
                                    echo '<select name="place" class="form-control form-control-sm">';
                                    if($_POST['place'] != ''){
                                    $placee = $_POST['place'];
                                        $querymestopostavki1 ="SELECT * FROM places WHERE id_place = ".$placee;
                                $resultmestopostavki1 = mysqli_query($dblink, $querymestopostavki1) or die("Ошибка " . mysqli_error($dblink));
                                        echo '<option value="'.$placee.'">';
                                            while ($row = mysqli_fetch_row($resultmestopostavki1)) {
                                                echo $row[1];
                                            }
                                        echo'</option>';	
                                    }while ($row = mysqli_fetch_row($resultmestopostavki)){
                                        echo '<option value="'.$row[0].'">';
                                            echo $row[1];
                                        echo'</option>';
                                    }
                                    echo "</select>";

                                    mysqli_free_result($resultmestopostavki);
                                }
						?>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Имя заказчика
                      </label>
                      <input type="text" class="form-control" name="purchaser" placeholder="Имя заказчика" <?php 
							 if($purchaser!=''){
								 echo 'value="'.$purchaser.'"';
							 } 
							 ?>
							 >
                    </div>
                  </div>
                  <div class="col-md-3">
					  <div class="form-group">
                      	  <label>
                        	Сумма закупки от и до
						  </label>
						  <div class="row justify-content-md-center">
							  <div class="col-md-6">
								  <input class="form-control" type="number" name="amountFrom" placeholder="от" <?php if($amountFrom != ''){
echo ' value="'.$amountFrom.'"';} ?>>
							  </div>
							  <div class="col-md-6">
								  <input class="form-control" type="number" name="amountTo" placeholder="до" <?php if($amountTo!= ''){

echo ' value="'.$amounTo.'"';} ?>>
							  </div>
						  </div>
					  </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Предмет закупки
                      </label>
                      <?php
							$querypredmetzakupki ="SELECT * FROM purchase_items";
							//Tolko nazvanie
							 $resultpredmetzakupki = mysqli_query($dblink, $querypredmetzakupki) or die("Ошибка " . mysqli_error($dblink)); 
							if($resultpredmetzakupki)
							{
								echo '<select name="purchaseItem" class="last_select form-control form-control-sm" >';
								if($purchaseItem != ''){
									$querypredmetzakupki1 ="SELECT id_purchase_item, name FROM purchase_items WHERE id_purchase_item = ".$purchaseItem;
									$resultpredmetzakupki1 = mysqli_query($dblink, $querypredmetzakupki1) or die("Ошибка " . mysqli_error($dblink));
										echo '<option value="'.$purchaseItem.'">';
											while ($row = mysqli_fetch_row($resultpredmetzakupki1)) {
												echo $row[1];
											}
										echo'</option>';	
								}while ($row = mysqli_fetch_row($resultpredmetzakupki)) {
									echo '<option value="'.$row[0].'">';
										echo $row[1];
										echo'</option>';
								}
								echo "</select>";

								mysqli_free_result($resultpredmetzakupki);
							}
						?>
                    </div>
                  </div>
				  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Номер объявления
                      </label>
                      <input type="text" class="form-control" name="annoNum" placeholder="Номер объявления" <?php if($annoNum != ''){echo ' value="'.$annoNum.'"';} ?>>
                    </div>
                  </div>
				  <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        Назначить ответственного
                      </label>
                      <?php
							$queryusers ="SELECT id_user,name  FROM users";
							//Tolko nazvanie
							 $resultusers = mysqli_query($dblink, $queryusers) or die("Ошибка " . mysqli_error($dblink)); 
							if($resultusers)
							{
								echo '<select name="user" class="last_select form-control form-control-sm" >';
								if($id_user != null){
									$queryusersotv ="SELECT id_user,name FROM users WHERE id_user = $id_user";
									$resultusersotv = mysqli_query($dblink, $queryusersotv) or die("Ошибка " . mysqli_error($dblink));
										while ($rowvv = mysqli_fetch_row($resultusersotv)) {
											echo '<option value="'.$rowvv[0].'">';
												echo $rowvv[1];
											echo'</option>';
										}
								}while ($row = mysqli_fetch_row($resultusers)) {
											echo '<option value="'.$row[0].'">';
												echo $row[1];
											echo'</option>';
										}
								echo "</select>";

								mysqli_free_result($resultusers);
							}
						?>
                    </div>
                  </div>
              </div>
            </div>
            <div class="form_btns">
              <input type="submit" style="background-color:#33cabb;color:white;" class="btn btn-flat btn-primary" name="search"  value="Поиск">      
			  <input type="submit" style="background-color:#33cabb;color:white; margin-left: 10px;" class="btn btn-flat btn-primary" name="save"  value="Сохранить фильтр">         
            </div>
		
          </div>
        </form>
<!--Конец-->
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
		<div class="media-list media-list-divided media-list-hover" data-provide="selectall">
			<div class="media-list-body bg-white b-1" style="width: fit-content;">
				<table cellpadding="13" cellspacing="13" id="mytable">
				  <thead>
					  <form action="testfilter2.php" method="POST">
							<tr>
							  <th id="sl" scope="col" width="30">
								  <div class="flexbox align-items-center">
									<div class="custom-control custom-checkbox">
										  <input type="checkbox" class="custom-control-input" form="formcheck">
									</div>
									<input type="submit" value="Отправить" form="formcheck">
									<span class="divider-line mx-1"></span>
								  </div> 
								</th>              
								<th id="nm" scope="col" style="width: 150px;">Наименование</th>	 
								<th scope="col">
									<?php
										$querymestopostavki ="SELECT id_place,name FROM places";
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
									?>
								</th>                   
								<th id="sum" scope="col">Сумма</th>      	 	      
								<th scope="col">Условия поставки </th>		       
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
					  		<input type="hidden" name="query" value="<?=$queryto2?>">
						  <input type="hidden" name="queryq" value="<?=$q?>">
							<div id="savebutton1">
								<div class="button-item">
									<input class="btn-1" type="submit" value="Применить фильтр">
								</div>
							</div>
					</form>
  				</thead>
				<tbody>
					<form method="post" action="checkbox-form.php" id="formcheck">
						<input type="hidden" name="useer" value="<?php if($id_user != null){echo $id_user;}?>">
						<?php 
							$fori=0;
							while ($row = mysqli_fetch_row($result1)) { 
						?>
					<tr <?php
							$green = 'SELECT * FROM taken_lots WHERE id_lot="'.$row[0].'"';
							$resgreen = mysqli_query($dblink, $green) or die("Ошибка " . mysqli_error($dblink));
							$num_ans=mysqli_fetch_row ($resgreen);
									if($num_ans!=0){
										echo 'style="background: greenyellow;"';
										}
						?> class="horizontal-scroll-wrapper">
						<td style="width:30px;" width="94">
							<div class="flexbox align-items-center">
							  <div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="chosenbox[]" form="formcheck" value="<? echo $row[0];?>">
							  </div>
							</div>
						</td>
					<td><a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-detailss<? echo $row[0];?>" data-toggle="quickview">
<? echo $row[2];?></a></td>
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
						?>
                    </td>
					<td><? echo $row[9];?></td>
					<td>Условия поставки</td>
					<td><? echo $row[8];?></td>
					<td ><? echo $row[13];?></td>
					<td><? echo $row[14];?></td>
					<td><? echo $row[15];?></td>
					<td>
						<?php
                            $querypmeth = 'SELECT * FROM purchase_methods WHERE id_purchase_method="'.$row[3].'"';
                             $resultpmeth = mysqli_query($dblink, $querypmeth) or die("Ошибка " . mysqli_error($dblink)); 
                            while($rowde = mysqli_fetch_row($resultpmeth)) { 
                            echo $rowde[1];
                            }
						?>
                    </td>
					<td style=""><a href="<? echo $row[20];?>">Ссылка на лот</a></td>
				</tr>
                <!--</div>
            </div>-->
			
	
<?php }
$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
$refresh = trim(fgets($fd));
fclose($fd);
$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
$data = [
	'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
	'client_secret' => 'ULDgmdQEby9aKrrCk7hVueB0Tq22WKuwxjTZPKeR7O1KeLPjmyi7mglYOrHgEGNQ',
	'grant_type' => 'refresh_token',
	'refresh_token' => $refresh,
	'redirect_uri' => 'https://gz.open-k.com',
];

$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$code = (int)$code;
$errors = [
	400 => 'Bad request',
	401 => 'Unauthorized',
	403 => 'Forbidden',
	404 => 'Not found',
	500 => 'Internal server error',
	502 => 'Bad gateway',
	503 => 'Service unavailable',
];


$response = json_decode($out, true);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает
$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
fwrite($fd, $refresh_token);
fclose($fd);
//$json = json_encode(['query'=>json_decode($query)]);
$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/account'; //Формируем URL для запроса
$headers = [
    'Authorization: Bearer ' . $access_token
];
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$code = (int)$code;
$errors = [
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
];
$out = json_decode($out, true);
$id = $out["current_user_id"];
$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
$refresh = trim(fgets($fd));
fclose($fd);
$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
$data = [
	'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
	'client_secret' => 'ULDgmdQEby9aKrrCk7hVueB0Tq22WKuwxjTZPKeR7O1KeLPjmyi7mglYOrHgEGNQ',
	'grant_type' => 'refresh_token',
	'refresh_token' => $refresh,
	'redirect_uri' => 'https://gz.open-k.com',
];


$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$code = (int)$code;
$errors = [
	400 => 'Bad request',
	401 => 'Unauthorized',
	403 => 'Forbidden',
	404 => 'Not found',
	500 => 'Internal server error',
	502 => 'Bad gateway',
	503 => 'Service unavailable',
];


$response = json_decode($out, true);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает
$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
fwrite($fd, $refresh_token);
fclose($fd);
//$json = json_encode(['query'=>json_decode($query)]);
$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/users/'.$id; //Формируем URL для запроса
$headers = [
    'Authorization: Bearer ' . $access_token
];
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$code = (int)$code;
$errors = [
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
];
$out = json_decode($out, true);
$accemail = $out["email"];
if (mysqli_query($dblink, "SELECT id_allowance FROM users WHERE email = '$accemail'") != false) {
	$allowance = mysqli_query($dblink, "SELECT id_allowance FROM users WHERE email = '$accemail'")->fetch_array(MYSQLI_NUM)[0];
	if ($allowance == 1) {
		echo 'У вас нет прав на отправку в AMOCRM';
	}
	else{
	}
}
else
	echo "Данный аккаунт не зарегистрирован в нашей системе";
	?>
-->
	
	<header class="flexbox align-items-center media-list-header bg-transparent b-0 py-16 pl-20">
        
    </header>
</form>
	
</tbody>

</table>
			  	<?php 
					while ($row = mysqli_fetch_row($result2)) { 
						$idlott = $row[0];
				?>
	<!-- Quickview - User detail -->
    <div id="qv-user-detailss<? echo $row[0];?>" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Карточка лота <? echo $row[0];?></p>
		  <?php 
$queryggs = 'SELECT * FROM favorite_lots WHERE id_lot="'.$row[0].'"';
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
	$querytaken = 'SELECT * FROM taken_lots WHERE id_lot="'.$row[0].'"';
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
		
		$queryidstat = 'SELECT * FROM statuses_new WHERE id_status="'.$rows[9].'"';
		$resultidstat = mysqli_query($dblink, $queryidstat);
		$querynewstat = 'SELECT * FROM statuses_new WHERE id_status NOT IN (1, 9)';
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
	 
			$queryotvetstvenniy = 'SELECT * FROM users WHERE id_user="'.$rows[5].'"';
		$resultotvetstvenniy = mysqli_query($dblink, $queryotvetstvenniy);
		$querylistu = 'SELECT * FROM users';
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
			
			
			$querydepart = 'SELECT * FROM departments WHERE id_department="'.$rows[2].'"';
		$resultdepart = mysqli_query($dblink, $querydepart);
		$querydepartments = 'SELECT * FROM departments';
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
							$queryfiles = 'SELECT * FROM files WHERE lot_number ="'.$row[4].'"';
							$resultfiles = mysqli_query($dblink, $queryfiles);
								while ($rows = mysqli_fetch_row($resultfiles)) {
											echo '<a href="'.$rows[3].'">'.$rows[2].'</a><br><br>';
								}
						?>
				 
				 </span>
          </div>
	
			<div class="form-group">
            <span><b>Способ закупки:</b> <?php
							$querymethodz = 'SELECT * FROM purchase_methods WHERE id_purchase_method="'.$row[3].'"';
							$resultmethodz = mysqli_query($dblink, $querymethodz);
								while ($rows = mysqli_fetch_row($resultmethodz)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
			<div class="form-group">
            <span><b>Место поставки:</b> <?php
										//$bezzap = preg_replace('/[^0-9]/s', '', $row[6]); 
							$querymestop = 'SELECT * FROM places WHERE id_place="'.preg_replace('/[^0-9]/s', '', $row[6]).'"';
							$resultmestop = mysqli_query($dblink, $querymestop);
								while ($rows = mysqli_fetch_row($resultmestop)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
          <div class="form-group">
            <span><b>Статус лота:</b> <?php
							$querystatus = 'SELECT * FROM statuses WHERE id_status="'.$row[5].'"';
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
							$querycomment = 'SELECT * FROM operations WHERE id_lot="'.$row[0].'"';
							$resultcomment = mysqli_query($dblink, $querycomment);
										  $i0=1;
								while ($rows = mysqli_fetch_row($resultcomment)) {
								echo	$i0++;echo') ';
									echo $rows[3];
									//Imya kommentatora
									$querycommentuser = 'SELECT * FROM users WHERE id_user="'.$rows[5].'"';
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
							$queryhistory = 'SELECT * FROM operations WHERE id_lot="'.$row[0].'"';
							$resulthistory = mysqli_query($dblink, $queryhistory);
										  $if0=1;
								while ($rows = mysqli_fetch_row($resulthistory)) {
								echo	$if0++;echo') ';
									if($rows[2]==1){
									echo 'Лот был прикреплен к менеджеру в '.$rows[1];
									$queryhistuser = 'SELECT * FROM users WHERE id_user="'.$rows[5].'"';
							$resulthistuser = mysqli_query($dblink, $queryhistuser);
								while ($rows1 = mysqli_fetch_row($resulthistuser)) {
											echo '<br>За менеджером: <span class="text-success">'.$rows1[1].'</span>';			
								}
									}
									if($rows[2]==2){
									echo 'Был добавлен комментарий в '.$rows[1];
										$queryhistuser = 'SELECT * FROM users WHERE id_user="'.$rows[5].'"';
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
document.getElementById('savebutton1').style.display='none';
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