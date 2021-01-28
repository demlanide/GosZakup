<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function get_winner($lotNumber, $dblink) {
	$anno = mysqli_query($dblink, "SELECT announcement FROM lots WHERE lot_number = '$lotNumber'")->fetch_array(MYSQLI_NUM)[0];
	$anno = substr($anno, 0, -2);
	$url_winner = "http://www.goszakup.gov.kz/ru/announce/index/".$anno."?tab=winners";
	$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
	);  
	$script = file_get_contents($url_winner, false, stream_context_create($arrContextOptions));

  	$txt = $script;
	$pos = strpos($txt, $lotNumber);
	$pos = strpos($txt, "_blank", $pos);
	$pos1 = strpos($txt, "<", $pos);
	$winner = substr($txt, $pos+8, $pos1-$pos);
	return $winner;
}

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysqli_connect($server, $user, $password);

/*if($dblink)
echo 'Соединение установлено.';
else
die('Ошибка подключения к серверу баз данных.');*/

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);
/*if($selected)
	echo ' Подключение к базе данных прошло успешно.';
else
	die(' База данных не найдена или отсутствует доступ.');*/

//обновление статусов незавершенных лотов
$lotNumbers = mysqli_query($dblink, "SELECT lot_number FROM lots WHERE NOT id_status=7 AND NOT id_status=10 AND NOT id_status=18 AND NOT id_status=13")->fetch_all(MYSQLI_ASSOC);
$fd = fopen("dailyupd.txt", 'w');
for ($i = 0; $i < count($lotNumbers); $i++)
{
	$lotNumbers[$i] = $lotNumbers[$i]["lot_number"];
	$old_stat = mysqli_query($dblink, "SELECT id_gz FROM statuses WHERE id_status = (SELECT id_status FROM lots WHERE lot_number = '$lotNumbers[$i]' LIMIT 1)")->fetch_all(MYSQLI_ASSOC)[0]["id_gz"];
	fwrite($fd, $lotNumbers[$i].'!'.$old_stat.PHP_EOL);
}
?>