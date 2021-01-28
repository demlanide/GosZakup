<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function getuserid($email)
{
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
		'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
		'grant_type' => 'refresh_token',
		'refresh_token' => $refresh,
		'redirect_uri' => 'https://gz.open-k.com',
	];

	/**
	 * Нам необходимо инициировать запрос к серверу.
	 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
	 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
	 */
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	/** Устанавливаем необходимые опции для сеанса cURL  */
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
	/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

	try
	{
		/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
		if ($code < 200 || $code > 204) {
			throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}

	/**
	 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 * нам придётся перевести ответ в формат, понятный PHP
	 */
	$response = json_decode($out, true);

	$access_token = $response['access_token']; //Access токен
	$refresh_token = $response['refresh_token']; //Refresh токен
	$token_type = $response['token_type']; //Тип токена
	$expires_in = $response['expires_in']; //Через сколько действие токена истекает
	$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
	fwrite($fd, $refresh_token);
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/users'; //Формируем URL для запроса
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

	try
	{
	    if ($code < 200 || $code > 204) {
	        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		echo $out;
	    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}
	$out = json_decode($out, true);
	for ($i = 0; $i < count($out["_embedded"]["users"]); $i++) {
		if ($out["_embedded"]["users"][$i]["email"] == $email)
		{
			$id = $out["_embedded"]["users"][$i]["id"];
			return $id;
		}
	}
	return 0;
}

function upamo($query) {
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
		'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
		'grant_type' => 'refresh_token',
		'refresh_token' => $refresh,
		'redirect_uri' => 'https://gz.open-k.com',
	];

	/**
	 * Нам необходимо инициировать запрос к серверу.
	 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
	 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
	 */
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	/** Устанавливаем необходимые опции для сеанса cURL  */
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
	/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

	try
	{
		/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
		if ($code < 200 || $code > 204) {
			throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}

	/**
	 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 * нам придётся перевести ответ в формат, понятный PHP
	 */
	$response = json_decode($out, true);

	$access_token = $response['access_token']; //Access токен
	$refresh_token = $response['refresh_token']; //Refresh токен
	$token_type = $response['token_type']; //Тип токена
	$expires_in = $response['expires_in']; //Через сколько действие токена истекает
	$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
	fwrite($fd, $refresh_token);
	fclose($fd);
	$json = json_encode(['query'=>$query]);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/leads'; //Формируем URL для запроса
	$headers = [
	    'Authorization: Bearer ' . $access_token
	];
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
	curl_setopt($curl,CURLOPT_URL, $link);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
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

	try
	{
	    if ($code < 200 || $code > 204) {
	        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		echo $out;
	    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}
	echo $out;
	$out = json_decode($out, true);
	return $out['_embedded']['leads'][0]['id'];
}

function connect($id_cont, $id_lead) {
    $fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
		'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
		'grant_type' => 'refresh_token',
		'refresh_token' => $refresh,
		'redirect_uri' => 'https://gz.open-k.com',
	];

	/**
	 * Нам необходимо инициировать запрос к серверу.
	 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
	 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
	 */
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	/** Устанавливаем необходимые опции для сеанса cURL  */
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
	/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

	try
	{
		/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
		if ($code < 200 || $code > 204) {
			throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}

	/**
	 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 * нам придётся перевести ответ в формат, понятный PHP
	 */
	$response = json_decode($out, true);

	$access_token = $response['access_token']; //Access токен
	$refresh_token = $response['refresh_token']; //Refresh токен
	$token_type = $response['token_type']; //Тип токена
	$expires_in = $response['expires_in']; //Через сколько действие токена истекает
	$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
	fwrite($fd, $refresh_token);
    fclose($fd);
    $query = array("to_entity_id"=>$id_lead, "to_entity_type"=>"leads", "metadata"=>NULL);
	$json = json_encode(['query'=>$query]);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/contacts/' . $id_cont . '/link'; //Формируем URL для запроса
	$headers = [
	    'Authorization: Bearer ' . $access_token
	];
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
	curl_setopt($curl,CURLOPT_URL, $link);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_HEADER, false);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $json);
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

	try
	{
	    if ($code < 200 || $code > 204) {
	        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
        echo $out;
	    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
}

function addcont($name) {
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	$data = [
		'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
		'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
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

	try
	{
		if ($code < 200 || $code > 204) {
			throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
	}

	$response = json_decode($out, true);

	$access_token = $response['access_token']; //Access токен
	$refresh_token = $response['refresh_token']; //Refresh токен
	$token_type = $response['token_type']; //Тип токена
	$expires_in = $response['expires_in']; //Через сколько действие токена истекает
	$fd = fopen("tokens.txt", 'w') or die("не удалось создать файл");
	fwrite($fd, $refresh_token);
    fclose($fd);
    $query = array(
        'name'=>$name
    );
	$json = json_encode(['query'=>$query]);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/contacts'; //Формируем URL для запроса
	$headers = [
	    'Authorization: Bearer ' . $access_token
	];
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
	curl_setopt($curl,CURLOPT_URL, $link);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
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

	try
	{
	    if ($code < 200 || $code > 204) {
	        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		}
	}
	catch(\Exception $e)
	{
		echo $out;
	    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    $out = json_decode($out, true);
    return $out["_embedded"]["contacts"][0]["id"];
}

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';
$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);

$lotNumber = $_POST['lotNumber'];
$lotName = $_POST['lotName'];
$trdMethod = (int)$_POST['trdMethod'];
$lotStatus = (int)$_POST['lotStatus'];
$purchaser = $_POST['purchaser'];
$amountFrom = (float)$_POST['amountFrom'];
$amountTo = (float)$_POST['amountTo'];
$purchaseItem = (int)$_POST['purchaseItem'];
$annoNum = $_POST['annoNum'];
$place = (int)$_POST['place'];
$id_user = (int)$_POST['user'];
$email = mysqli_query($dblink, "SELECT email FROM users WHERE id_user = $id_user")->fetch_array(MYSQLI_NUM)[0];
if (strpos($email, "kazinterservice"))
	$user = getuserid($email);
else
	$user = 0;
$button = $_POST;
if ($button['search'] == "Поиск") {
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
	$result = mysqli_query($dblink, $query);
	$result1 = mysqli_query($dblink, $query);
	$result2 = mysqli_query($dblink, $query);
	if ($result == false) {
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
		while ($hasNextPage == 1)
		{
			$arr = array();
			$cquery = "query{
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
			$hasNextPage = $arr["extensions"]["pageInfo"]["hasNextPage"];
			$after = ", after: ".$arr["extensions"]["pageInfo"]["lastId"];
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
			mysqli_query($dblink, "INSERT INTO taken_lots (id_lot, id_status, id_user, id_amo) VALUES ($id_lot, 1, $id_user, $id_amo)");
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
		$query = $query.$user.")";
	} else
		$query = $query."NULL)";
	mysqli_query($dblink, $query);
	header("Location: https://gz.open-k.com/fastfilter.php");
}
?>
 <?php
   /* // Проверяем, пусты ли переменные логина и id пользователя
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Результат фильтрования</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link href="https://gz.open-k.com/assets/css/core.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/app.min.css" rel="stylesheet">
    <link href="https://gz.open-k.com/assets/css/style.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="https://gz.open-k.com/assets/img/apple-touch-icon.png">
    <link rel="icon" href="https://gz.open-k.com/assets/assets/img/favicon.png">
	   <style type="text/css">
		   .form-group{border-bottom-style: inset;}
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
        <a class="logo d-lg-none" href="index.html"><img src="assets/img/logo.png" alt="logo"></a>

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

        <div class="media-list media-list-divided media-list-hover" data-provide="selectall">

          <header class="flexbox align-items-center media-list-header bg-transparent b-0 py-16 pl-20">
            <div class="flexbox align-items-center">
            
     
       
				
			  <!--<label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>Выбрать все-->
			
				
              <span class="divider-line mx-1"></span>

            </div>

          </header>
			<table class="table">
 

          <div class="media-list-body bg-white b-1">
		
		 
<form action="checkbox-form.php" method="post">
	
<?php 
	$fori=0;
	while ($row = mysqli_fetch_row($result1)) { 
?>
			  
            <div class="media align-items-center">
             <!-- <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input" name="chosenbox[]" value="<? echo $row[0];?>">
                <span class="custom-control-indicator"></span>
              </label>-->

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-detailss<? echo $row[0];?>" data-toggle="quickview">

                <div class="media-body text-truncate">
                 <!--<h6 title="Наименование лота"><? echo $row[8];echo' - '; echo $row[7];?></h6>
                  <small>
                    <span title="Номер лота"><? echo $row[4];?></span>
                    <span class="divider-dash" title="Последнее обновление лота"><? echo $row[14];?></span>
                    <span class="divider-dash" title="Статус лота"><?php
							$querystatus = 'SELECT * FROM `statuses` WHERE id_status="'.$row[5].'"';
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
						?>
						</span>
                  </small>
					<h6 title="Предмет закупки"><span style="color:green;">Предмет закупки:</span> <? echo $row[2];?></h6>
					-->
					
					<div style="width:100%;" class="horizontal-scroll-wrapper"><div style="width:2%;float:left;white-space: pre-wrap;">
						<?php $fori++; echo $fori; ?></div>
					<div style="width:8%;float:left;white-space: pre-wrap;"><? echo $row[4];?></div>
					<div style="width:8%;float:left;white-space: pre-wrap;"><? echo $row[2];?></div>
					<div style="width:4%;float:left;white-space: pre-wrap;"><? echo $row[6];?></div>
					<div style="width:7%;float:left;white-space: pre-wrap;"><? echo $row[9];?></div>
					<div style="width:10%;float:left;white-space: pre-wrap;">Место поставки</div>
					<div style="width:10%;float:left;white-space: pre-wrap;">Условия поставки</div>
					<div style="width:10%;float:left;white-space: pre-wrap;"><? echo $row[8];?></div>
					<div style="width:10%;float:left;white-space: pre-wrap;"><? echo $row[13];?></div>
					<div style="width:10%;float:left;white-space: pre-wrap;"><? echo $row[14];?></div>
					<div style="width:10%;float:left;white-space: pre-wrap;"><? echo $row[15];?></div>
					<div style="width:10%;float:left;white-space: pre-wrap;"><? echo $row[3];?></div>
					<div style="width:10%">Ссылка на лот</div>
						</div>
					<!--<thead>
    <tr>
      <th scope="col">ID</th>              
		<th scope="col">Номер на госзакупе</th>       
		<th scope="col">Наименование</th>	 
		<th scope="col">Регион</th>                   
		<th scope="col">Сумма</th>      	 	
		<th scope="col">Место поставки</th>       
		<th scope="col">Условия поставки </th>		       
		<th scope="col">Заказчик БИН</th>
		<th scope="col">Дата публикации</th>
		<th scope="col">Дата начала</th>
		<th scope="col">Дата окончания</th>
		<th scope="col">Способ закупки</th>
		<th scope="col">Ссылка на лот</th>
			</tr>
  </thead>-->
		
                </div>
              </a>

             <!-- <span class="lead text-fade"><? echo number_format($row[9], 2, ',', ' '); ?>₸<br>
				Статус: <?php 
		$querystatkart = 'SELECT * FROM `statuses_new` WHERE id_status="'.$row[10].'"';
		$resultstatkart = mysqli_query($dblink, $querystatkart);
    while ($rowdd = mysqli_fetch_row($resultstatkart)) {
			echo $rowdd[1];
	}?></span>-->
					
            </div>
			
	
<?php }

			  ?>
<!--<?php $fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
$refresh = trim(fgets($fd));
fclose($fd);
$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
/** Соберем данные для запроса */
$data = [
	'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
	'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
	'grant_type' => 'refresh_token',
	'refresh_token' => $refresh,
	'redirect_uri' => 'https://gz.open-k.com',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
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
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
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
/** Соберем данные для запроса */
$data = [
	'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
	'client_secret' => 'ar1Ix0Ot1HLCVinc6tuRVBmSUiHZf8BmelYbqseNipZDt106Nv3QWwtEyR94ylmS',
	'grant_type' => 'refresh_token',
	'refresh_token' => $refresh,
	'redirect_uri' => 'https://gz.open-k.com',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
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
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
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
	else 
		echo '<input style="margin-left:19px;" class="btn btn-sm btn-primary" type="submit" name="formSubmit" value="Отправить" />
';
	}
else
	echo "Данный аккаунт не зарегистрирован в нашей системе";
	?>
-->
</form>
			  	<?php 
while ($row = mysqli_fetch_row($result2)) { 
	$idlott = $row[0];
?>
	<!-- Quickview - User detail -->
    <div id="qv-user-detailss<? echo $row[0];?>" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Карточка лота <? echo $row[0];?></p>
		  <?php 
$queryggs = 'SELECT * FROM `favorite_lots` WHERE id_lot="'.$row[0].'"';
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
	$querytaken = 'SELECT * FROM `taken_lots` WHERE id_lot="'.$row[0].'"';
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
		
		$queryidstat = 'SELECT * FROM `statuses_new` WHERE id_status="'.$rows[10].'"';
		$resultidstat = mysqli_query($dblink, $queryidstat);
		$querynewstat = 'SELECT * FROM `statuses_new` WHERE `id_status` NOT IN (1, 9)';
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
	 
			$queryotvetstvenniy = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
		$resultotvetstvenniy = mysqli_query($dblink, $queryotvetstvenniy);
		$querylistu = 'SELECT * FROM `users`';
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
			
			
			$querydepart = 'SELECT * FROM `departments` WHERE id_department="'.$rows[2].'"';
		$resultdepart = mysqli_query($dblink, $querydepart);
		$querydepartments = 'SELECT * FROM `departments`';
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
							$queryfiles = 'SELECT * FROM `files` WHERE lot_number ="'.$row[4].'"';
							$resultfiles = mysqli_query($dblink, $queryfiles);
								while ($rows = mysqli_fetch_row($resultfiles)) {
											echo '<a href="'.$rows[3].'">'.$rows[2].'</a><br><br>';
								}
						?>
				 
				 </span>
          </div>
	
			<div class="form-group">
            <span><b>Способ закупки:</b> <?php
							$querymethodz = 'SELECT * FROM `purchase_methods` WHERE id_purchase_method="'.$row[3].'"';
							$resultmethodz = mysqli_query($dblink, $querymethodz);
								while ($rows = mysqli_fetch_row($resultmethodz)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
			<div class="form-group">
            <span><b>Место поставки:</b> <?php
										//$bezzap = preg_replace('/[^0-9]/s', '', $row[6]); 
							$querymestop = 'SELECT * FROM `places` WHERE id_place="'.preg_replace('/[^0-9]/s', '', $row[6]).'"';
							$resultmestop = mysqli_query($dblink, $querymestop);
								while ($rows = mysqli_fetch_row($resultmestop)) {
											echo $rows[1];				
								}
						?></span>
          </div>
			
          <div class="form-group">
            <span><b>Статус лота:</b> <?php
							$querystatus = 'SELECT * FROM `statuses` WHERE id_status="'.$row[5].'"';
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
							$querycomment = 'SELECT * FROM `operations` WHERE id_lot="'.$row[0].'"';
							$resultcomment = mysqli_query($dblink, $querycomment);
										  $i0=1;
								while ($rows = mysqli_fetch_row($resultcomment)) {
								echo	$i0++;echo') ';
									echo $rows[3];
									//Imya kommentatora
									$querycommentuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
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
							$queryhistory = 'SELECT * FROM `operations` WHERE id_lot="'.$row[0].'"';
							$resulthistory = mysqli_query($dblink, $queryhistory);
										  $if0=1;
								while ($rows = mysqli_fetch_row($resulthistory)) {
								echo	$if0++;echo') ';
									if($rows[2]==1){
									echo 'Лот был прикреплен к менеджеру в '.$rows[1];
									$queryhistuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
							$resulthistuser = mysqli_query($dblink, $queryhistuser);
								while ($rows1 = mysqli_fetch_row($resulthistuser)) {
											echo '<br>За менеджером: <span class="text-success">'.$rows1[1].'</span>';			
								}
									}
									if($rows[2]==2){
									echo 'Был добавлен комментарий в '.$rows[1];
										$queryhistuser = 'SELECT * FROM `users` WHERE id_user="'.$rows[5].'"';
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


  </body>
</html>