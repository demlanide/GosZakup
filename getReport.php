<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function getSeg($i) {
	if ($i == 1)
		return " WHERE b.id_department = 1";
	else if ($i == 2)
		return " WHERE b.id_department = 2";
	else if ($i == 4)
		return " WHERE b.id_status = 10";
	else if ($i == 5)
		return " WHERE b.id_department = 3";
	else
		return "";
}

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);

$report = $_POST['reportType'];
$segment = $_POST['segment'];

if ($report == 1) {
	$list = array(array('Регион тендера', 'Статус лота', 'УО/ОО Колледж/Университет/Др.орг.', 'Номер лота', 'Заказчик', 'Наименование', 'Дополнительная характеристика', 'Цена за ед.', 'Кол-во', 'Ед. изм.', 'Плановая сумма', 'Дата заявки', 'Окончание приема заявок', 'ФИО менеджера', 'Статус лота1', 'Цена победителя', 'Доставка', 'Местоположение', 'Комментарий2', 'Способ.з-к', 'Ресурс'));
	$query = "SELECT a.ids_place, a.id_status, a.lot_number, a.purchaser_name, a.name, a.count, a.price, a.publish_date, a.trading_finish_date, b.id_user, b.id_status as new_stat FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if ($arr[$i]["ids_place"] == "none")
        	$places = "Места поставки не указаны";
    	else {
        	$places_arr = explode(',', $arr[$i]["ids_place"]);
        	$places = "";
        	for ($j = 1; $j < count($places_arr); $j+=2)
			{
				$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
				if ($vart)
            		$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
			}
        	$places = substr($places, 0, -2);
    	}
		$arr[$i]["ids_place"] = $places;
		if (mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"]) != false)
			$arr[$i]["id_status"] = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_status"] = "";
		if (mysqli_query($dblink, "SELECT name FROM statuses_new WHERE id_status = ".$arr[$i]["new_stat"]) != false)
			$arr[$i]["new_stat"] = mysqli_query($dblink, "SELECT name FROM statuses_new WHERE id_status = ".$arr[$i]["new_stat"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["new_stat"] = "";
		if (mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"]) != false)
			$arr[$i]["id_user"] = mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_user"] = "";
		array_push($list, array($arr[$i]["ids_place"], $arr[$i]["id_status"], "", $arr[$i]["lot_number"], $arr[$i]["purchaser_name"], $arr[$i]["name"], "", "", $arr[$i]["count"], "", $arr[$i]["price"], $arr[$i]["publish_date"], $arr[$i]["trading_finish_date"], $arr[$i]["id_user"], $arr[$i]["id_status"], "", "", "", "", "", ""));
	}
} else if ($report == 2) {
	$list = array(array('Номер', 'Наименования проекта/Заказчик', 'Оборудование', 'Общая сумма (с НДС)', 'Себес.', 'Маржа (тг)', 'Бонус за проект', 'Маржа (сверх себеса)', 'Маржа (от объема)', 'Ответственный', 'Наименование поставщика'));
	$query = "SELECT a.purchaser_name, a.name, b.nds_cost, b.cost FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		array_push($list, array($i+1, $arr[$i]["purchaser_name"], $arr[$i]["name"], $arr[$i]["nds_cost"], $arr[$i]["cost"], "", "", "", "", "", ""));
	}
} else if ($report == 3) {
	$list = array(array('Номер', 'Заказчик', 'Номер договора', 'Дата заключения', 'Статус', 'Сумма с НДС', 'Срок поставки'));
	$query = "SELECT a.purchaser_name, a.id_status, b.nds_cost FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if (mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"]) != false)
			$arr[$i]["id_status"] = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_status"] = "";
		array_push($list, array($i+1, $arr[$i]["purchaser_name"], "", "", $arr[$i]["id_status"], $arr[$i]["nds_cost"], ""));
	}
} else if ($report == 4) {
	$list = array(array('Номер', 'Наименования проекта/Заказчик', 'Оборудование', 'Общая сумма (с НДС)', 'Себес.', 'Маржа (тг)', 'Бонус за проект', 'Маржа (сверх себеса)', 'Маржа (от объема)', 'Ответственный', 'Статус'));
	$query = "SELECT a.purchaser_name, a.name, b.nds_cost, b.cost, b.id_status, b.id_user FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if (mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"]) != false)
			$arr[$i]["id_status"] = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_status = ".$arr[$i]["id_status"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_status"] = "";
		if (mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"]) != false)
			$arr[$i]["id_user"] = mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_user"] = "";
		array_push($list, array($i+1, $arr[$i]["purchaser_name"], $arr[$i]["name"], $arr[$i]["nds_cost"], $arr[$i]["cost"], "", "", "", "", $arr[$i]["id_user"], $arr[$i]["id_status"]));
	}
} else if ($report == 5) {
	$list = array(array('Наименования проекта/Заказчик', 'Оборудование', 'Общая сумма (с НДС)', 'Себес.', 'Маржа (тг)', 'Бонус за проект', 'Маржа (от объема)', 'Ответственный'));
	$query = "SELECT a.purchaser_name, a.name, b.nds_cost, b.cost FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		array_push($list, array($arr[$i]["purchaser_name"], $arr[$i]["name"], $arr[$i]["nds_cost"], $arr[$i]["cost"], "", "", "", ""));
	}
} else if ($report == 6) {
	$list = array(array('Размещающий менеджер', 'Дата размещения', 'Заказчик / Покупатель', 'ТХ модели', 'ТС / ТЗ', 'Количество', ' Бюджет на ед.', 'Дата поставки'));
	$query = "SELECT b.id_user, a.count FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment);
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if (mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"]) != false)
			$arr[$i]["id_user"] = mysqli_query($dblink, "SELECT name FROM users WHERE id_user = ".$arr[$i]["id_user"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_user"] = "";
		array_push($list, array($arr[$i]["id_user"], "", "", "", "", $arr[$i]["count"], "", ""));
	}
} else if ($report == 7) {
	$list = array(array('Номер', 'Виды закупок по которым  чаще проводится тендер', 'закупки/заявки', 'сумма'));
	$query = "SELECT a.name, count(a.name), sum(a.price) FROM lots a JOIN taken_lots b ON a.id_lot = b.id_lot".getSeg($segment)." GROUP BY a.name";
	echo $query;
	$arr = mysqli_query($dblink, $query)->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		array_push($list, array($i+1, $arr[$i]["name"], $arr[$i]["count(a.name)"], $arr[$i]["sum(a.price)"]));
	}
} else if ($report == 8) {
	$year = $_POST['year'];
	$month = $_POST['month'];
	if ($month[0] == 0)
		$month1 = $month[1];
	if ($year == date("Y", time())-1 && $month1 < date("M", time())) {
		header("Location: https://gz.open-k.com/reportredir.php");
	}
	$date = " last_update LIKE '%".$year."-".$month."%'";
	$list = array(array('Рейтинг регионов по ГЗ'));
	array_push($list, array('Номер', 'Регион', 'Фактическая сумма закупок "Открытый конкурс" и "Аукцион"'));
	$arr = mysqli_query($dblink, "SELECT ids_place, sum(price) FROM `lots` WHERE".$date." AND (id_purchase_method = 3 OR id_purchase_method = 4) GROUP BY ids_place")->fetch_all(MYSQLI_ASSOC);
	$k = 1;
	for ($i = 0; $i < count($arr); $i++) {
		if ($arr[$i]["ids_place"] == "none")
        	$places = "Места поставки не указаны";
    	else {
        	$places_arr = explode(',', $arr[$i]["ids_place"]);
        	$places = "";
        	for ($j = 1; $j < count($places_arr); $j+=2)
			{
				$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
				if ($vart)
            		$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
			}
        	$places = substr($places, 0, -2);
    	}
		if (strpos($places, ',') == false && $places != "" && $places != "Места поставки не указаны")
		{
			$arr[$i]["ids_place"] = $places;
			array_push($list, array($k, $arr[$i]["ids_place"], $arr[$i]["sum(price)"]));
			$k = $k + 1;
		}
	}
	array_push($list, array(' '));
	array_push($list, array('Заказщик', 'факт.сумма закупок ГУ'));
	$arr = mysqli_query($dblink, "SELECT b.name, sum(a.price) FROM lots a JOIN groups b ON a.id_group = b.id_group WHERE".$date." GROUP BY a.id_group ORDER BY a.id_group")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		array_push($list, array($arr[$i]["name"], $arr[$i]["sum(a.price)"]));
	}
	array_push($list, array(' '));
	array_push($list, array('Рейтинг поставщиков по общей сумме ГЗ'));
	array_push($list, array('Наименование, БИН', 'Номер', 'Регион', 'Наименование', 'Поставщик/Победитель', 'Общая сумма сделок', 'Колледж/Школа/УО/ОО', 'Заказщики'));
	$arr = mysqli_query($dblink, "SELECT ids_place, name, winner, sum(price), id_group, purchaser_name FROM lots WHERE".$date." AND winner is not null AND winner != '' AND winner != 'Часто задаваемые вопросы' GROUP by winner, purchaser_name, name ORDER BY sum(price) DESC")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if ($arr[$i]["ids_place"] == "none")
        	$places = "Места поставки не указаны";
    	else {
        	$places_arr = explode(',', $arr[$i]["ids_place"]);
        	$places = "";
        	for ($j = 1; $j < count($places_arr); $j+=2)
			{
				$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
				if ($vart)
            		$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
			}
        	$places = substr($places, 0, -2);
    	}
		$arr[$i]["ids_place"] = $places;
		if (mysqli_query($dblink, "SELECT name FROM groups WHERE id_group = ".$arr[$i]["id_group"]) != false)
			$arr[$i]["id_group"] = mysqli_query($dblink, "SELECT name FROM groups WHERE id_group = ".$arr[$i]["id_group"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_group"] = "";
		array_push($list, array(' ', $i+1, $arr[$i]["ids_place"], $arr[$i]["name"], $arr[$i]["winner"], $arr[$i]["sum(price)"], $arr[$i]["id_group"], $arr[$i]["purchaser_name"]));
	}
	array_push($list, array(' '));
	array_push($list, array('Мониторинг цен. и скидок по товарам'));
	array_push($list, array('Наименование, БИН', 'Лот', 'Регион', 'Наименование', 'Характеристика', 'Победитель', 'Плановая цена', 'Цена со скидкой', 'Скидка', 'Колледж/Школа/УО/ОО', 'Заказщики'));
	$arr = mysqli_query($dblink, "SELECT lot_number, ids_place, name, description, winner, price, id_group, purchaser_name FROM lots WHERE".$date." AND id_status = 10 ORDER BY name")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($arr); $i++) {
		if ($arr[$i]["ids_place"] == "none")
        	$places = "Места поставки не указаны";
    	else {
        	$places_arr = explode(',', $arr[$i]["ids_place"]);
        	$places = "";
        	for ($j = 1; $j < count($places_arr); $j+=2)
			{
				$vart = mysqli_query($dblink, "SELECT name FROM places WHERE id_place = $places_arr[$j]");
				if ($vart)
            		$places = $places.$vart->fetch_array(MYSQLI_NUM)[0].", ";
			}
        	$places = substr($places, 0, -2);
    	}
		$arr[$i]["ids_place"] = $places;
		if (mysqli_query($dblink, "SELECT name FROM groups WHERE id_group = ".$arr[$i]["id_group"]) != false)
			$arr[$i]["id_group"] = mysqli_query($dblink, "SELECT name FROM groups WHERE id_group = ".$arr[$i]["id_group"])->fetch_array(MYSQLI_NUM)[0];
		else
			$arr[$i]["id_group"] = "";
		array_push($list, array(' ', $arr[$i]["lot_number"], $arr[$i]["ids_place"], $arr[$i]["name"], $arr[$i]["description"], $arr[$i]["winner"], $arr[$i]["price"], ' ', ' ', $arr[$i]["id_group"], $arr[$i]["purchaser_name"]));
	}
}

$fp = fopen('report.xls', 'w');
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

foreach ($list as $fields) {
	fputcsv($fp, $fields, ";");
}

fclose($fp);

// имя файла, с которым он будет сохранен
$file_name = "report.xls"; 
// путь до файла
$file_path = "report.xls";
 
// код 200, все хорошо
header("HTTP/1.1 200 OK"); 
header("Content-type: application/vnd.ms-excel; charset=utf-8"); // тип файла
// дата по Гринвичу
header('Expires: ' . gmdate('D, d M Y H:i:s') . 
' GMT'); 
// определяем браузер
$ua = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
$isMSIE = preg_match('@MSIE ([0-9].[0-9]{1,2})@', $ua);
if ($isMSIE){
    // если это Internet Explorer  
    // объясняем браузеру, что выводим файл
    header('
        Content-Disposition: attachment; filename="' . $file_name . '"'
    ); 
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
}else{
    // если это НЕ Internet Explorer 
    // объясняем браузеру, что выводим файл
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Pragma: no-cache');
}
// вывод файла в браузере
readfile($file_path);
?>