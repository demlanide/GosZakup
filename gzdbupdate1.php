<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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

function get_winner($lotNumber, $dblink) {
	$anno = mysqli_query($dblink, "SELECT announcement FROM lots WHERE lot_number = '$lotNumber'")->fetch_array(MYSQLI_NUM)[0];
	$anno = substr($anno, 0, -2);
	//echo $anno;
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
	$winner = substr($txt, $pos+8, $pos1-$pos-10);
	$winner = trim($winner);
	return $winner;
}

$file = file("dailyupd.txt");
if (count($file) < 100)
	$lim = count($file);
else
	$lim = 100;
for ($i = 0; $i < $lim; $i++) {
	$data = explode('!', $file[$i]);
	$lotquery = "query{
		Lots(filter: {lotNumber: \"$data[0]\"}) {
			refLotStatusId
			lastUpdateDate
		}
	}";
	$variables = "";
	$json = json_encode(['query' => $lotquery, 'variables' => $variables]);
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
	$new_stat = $arr["data"]["Lots"][0]["refLotStatusId"];
	$lastupd = $arr["data"]["Lots"][0]["lastUpdateDate"];
	if ($new_stat != $data[1]) {
		if ($new_stat == 360) {
			$winner = get_winner($data[0], $dblink);
			mysqli_query($dblink, "UPDATE lots SET winner = '$winner' WHERE lot_number = '$data[0]'");
		}
		mysqli_query($dblink, "UPDATE lots SET id_status = (SELECT id_status FROM statuses WHERE id_gz = $new_stat) WHERE lot_number = '$data[0]'");
		mysqli_query($dblink, "UPDATE lots SET last_update = '$lastupd' WHERE lot_number = '$data[0]'");
		if (mysqli_query($dblink, "SELECT name FROM statuses WHERE id_gz = $new_stat") != false)
			$name_status = mysqli_query($dblink, "SELECT name FROM statuses WHERE id_gz = $new_stat")->fetch_array(MYSQLI_NUM)[0];
		$id_lot = mysqli_query($dblink, "SELECT id_lot FROM lots WHERE lot_number = '$data[0]'")->fetch_array(MYSQLI_NUM)[0];
		$today = date("Y-m-d H:i:s");
		mysqli_query($dblink, "INSERT INTO operations (operation_date, operation_type, comm, id_lot) VALUES ('$today', 3, 'Изменение статуса на $name_status', $id_lot)");
	}
	unset($file[$i]);
}
if (count($file) > 0)
{
	$fp=fopen("dailyupd.txt","w"); 
	fputs($fp,implode("",$file)); 
	fclose($fp);
	header("Location: https://gz.open-k.com/gzdbupdate1.php");
} else
	header("Location: https://gz.open-k.com/gzdbupdate2.php");
?>