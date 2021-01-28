<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function putindb($arr, $dblink)
{
	for ($i = 0; $i < count($arr["data"]["Lots"]); $i++)
	{
		$lotNumber = $arr["data"]["Lots"][$i]["lotNumber"];
		if (mysqli_query($dblink, "SELECT count(*) FROM lots WHERE lot_number = '$lotNumber'")->fetch_array(MYSQLI_NUM)[0] != 0)
			break;
		$id_status = $arr["data"]["Lots"][$i]["refLotStatusId"];
		$id_purchase_method = $arr["data"]["Lots"][$i]["refTradeMethodsId"];
		$id_purchase_item = $arr["data"]["Lots"][$i]["TrdBuy"]["refSubjectTypeId"];
		$id_places = $arr["data"]["Lots"][$i]["plnPointKatoList"];
		$id_status = mysqli_query($dblink, "SELECT id_status FROM statuses WHERE id_gz = ".$id_status)->fetch_array(MYSQLI_NUM)[0];
		$id_purchase_method = mysqli_query($dblink, "SELECT id_purchase_method FROM purchase_methods WHERE id_gz = ".$id_purchase_method)->fetch_array(MYSQLI_NUM)[0];
		$id_purchase_item = mysqli_query($dblink, "SELECT id_purchase_item FROM purchase_items WHERE id_gz = ".$id_purchase_item)->fetch_array(MYSQLI_NUM)[0];
		$str = ",";
		if ($id_places[0] != "")
		{
			for ($j = 0; $j < count($id_places); $j++)
			{
				$id = mysqli_query($dblink, "SELECT id_place FROM places WHERE id_kato = ".substr(strval($id_places[$j]), 0, 2));
				if ($id)
					$str = $str.$id->fetch_array(MYSQLI_NUM)[0].',';
			}
		}	
		else {
			$str = "none";
		}
		$link = "https://www.goszakup.gov.kz/ru/announce/index/".substr($arr["data"]["Lots"][$i]["trdBuyNumberAnno"], 0, -2);
		$sre = "INSERT INTO lots(name, id_purchase_method, lot_number, id_status, ids_place, purchaser_name, purchaser_BIN, price, count, announcement, id_purchase_item, publish_date, trading_start_date, trading_finish_date, last_update, description, link) VALUES ('".$arr["data"]["Lots"][$i]["nameRu"]."', ".$id_purchase_method.", '".$arr["data"]["Lots"][$i]["lotNumber"]."', ".$id_status.", '".$str."', '".$arr["data"]["Lots"][$i]["customerNameRu"]."', ".$arr["data"]["Lots"][$i]["customerBin"].", ".$arr["data"]["Lots"][$i]["amount"].", ".$arr["data"]["Lots"][$i]["count"].", '".$arr["data"]["Lots"][$i]["trdBuyNumberAnno"]."', ".$id_purchase_item.", '".$arr["data"]["Lots"][$i]["TrdBuy"]["publishDate"]."', '".$arr["data"]["Lots"][$i]["TrdBuy"]["startDate"]."', '".$arr["data"]["Lots"][$i]["TrdBuy"]["endDate"]."', '".$arr["data"]["Lots"][$i]["lastUpdateDate"]."', '".$arr["data"]["Lots"][$i]["descriptionRu"]."', '$link');";
		$sre2 = "UPDATE lots SET id_status=".$id_status.", trading_start_date='".$arr["data"]["Lots"][$i]["TrdBuy"]["startDate"]."', trading_finish_date='".$arr["data"]["Lots"][$i]["TrdBuy"]["endDate"]."', last_update= '".$arr["data"]["Lots"][$i]["lastUpdateDate"]."', description='".$arr["data"]["Lots"][$i]["descriptionRu"]."') WHERE lot_number='".$arr["data"]["Lots"][$i]["lotNumber"]."';";
		$check_double = mysqli_query("SELECT lot_number FROM lots WHERE lot_number = '".$arr["data"]["Lots"][$i]["lotNumber"]."'");
		if (mysqli_num_rows($check_double) > 0){
                            $row=mysqli_fetch_array($result);
                            do{
								mysqli_query($dblink, $sre2);
							}while($rows = mysqli_fetch_array($result));
		}else{
			mysqli_query($dblink, $sre);
		}

		
		$lotNumber = $arr["data"]["Lots"][$i]["lotNumber"];
		for ($j = 0; $j < count($arr["data"]["Lots"][$i]["Files"]); $j++) {
			$sre = "INSERT INTO files(lot_number, name, link) VALUES ('$lotNumber', '".$arr["data"]["Lots"][$i]["Files"][$j]['nameRu']."', '".$arr['data']['Lots'][$i]['Files'][$j]['filePath']."');";
			mysqli_query($dblink, $sre);
		}
	}
}

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);
$arr = mysqli_query($dblink, "SELECT * FROM saved_filters")->fetch_all(MYSQLI_ASSOC);
$date_yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")-1));
for ($i = 0; $i < count($arr); $i++) {
	$lotNumber = $arr[$i]['lotNumber'];
	$lotName = $arr[$i]['lotName'];
	$lotName = str_replace('"', '\"', $lotName);
	if (mysqli_query($dblink, "SELECT id_gz FROM purchase_methods WHERE id_purchase_method = ".$arr[$i]['trdMethod']) != false)
		$trdMethod = mysqli_query($dblink, "SELECT id_gz FROM purchase_methods WHERE id_purchase_method = ".$arr[$i]['trdMethod'])->fetch_array(MYSQLI_NUM)[0];
	else
		$trdMethod = null;
	$lotStatus = $arr[$i]['lotStatus'];
	$purchaser = $arr[$i]['purchaser'];
	$purchaser = str_replace('"', '\"', $purchaser);
	if (mysqli_query($dblink, "SELECT id_gz FROM purchase_items WHERE id_purchase_item = ".$arr[$i]['purchaseItem']) != false)
		$purchaseItem = mysqli_query($dblink, "SELECT id_gz FROM purchase_items WHERE id_purchase_item = ".$arr[$i]['purchaseItem'])->fetch_array(MYSQLI_NUM)[0];
	else
		$purchaseItem = null;
	$annoNum = $arr[$i]['annoNum'];
	if (mysqli_query($dblink, "SELECT id_kato FROM places WHERE id_place = ".$arr[$i]['place']) != false)
		$place = mysqli_query($dblink, "SELECT id_kato FROM places WHERE id_place = ".$arr[$i]['place'])->fetch_array(MYSQLI_NUM)[0];
	else
		$place = null;
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
	if ($trdMethod != NULL) {
		if ($flag == 1)
			$filter = $filter.", ";
		else
			$flag = 1;
		$filter = $filter."refTradeMethodsId: $trdMethod";
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
	echo $filter;
	while ($hasNextPage == 1)
	{
		$arr = array();
		$query = "query{
   			Lots(filter: {".$filter.", lastUpdateDate: \"$date_yesterday\"}, limit: 200$after) {
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
		$json = json_encode(['query' => $query, 'variables' => $variables]);
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
		$arr1 = json_decode(curl_exec($tuCurl), true);
		putindb($arr1, $dblink);
		print_r($arr1);
		curl_close($tuCurl);
		$hasNextPage = $arr["extensions"]["pageInfo"]["hasNextPage"];
		$after = ", after: ".$arr["extensions"]["pageInfo"]["lastId"];
	}
}
?>