<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);

$arr = mysqli_query($dblink, "SELECT id_amo FROM taken_lots WHERE id_status <> 9 AND id_status <> 10")->fetch_all(MYSQLI_NUM);
for ($i = 0; $i < count($arr); $i++) {
	$id = $arr[$i][0];
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
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/leads/'.$id; //Формируем URL для запроса
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
	$c = 0;
	for ($j = 0; $j < count($out["custom_fields_values"]); $j++) {
		if ($out["custom_fields_values"][$j]["field_id"] == 1312787 || $out["custom_fields_values"][$j]["field_id"] == 1312777 || $out["custom_fields_values"][$j]["field_id"] == 1312779 || $out["custom_fields_values"][$j]["field_id"] == 1312781 || $out["custom_fields_values"][$j]["field_id"] == 1312783 || $out["custom_fields_values"][$j]["field_id"] == 1312785 || $out["custom_fields_values"][$j]["field_id"] == 1312789) 
			$c = $c + 1;
	}
	$currentStat = mysqli_query($dblink, "SELECT id_status FROM taken lots WHERE id_amo = $id")->fetch_array(MYSQLI_NUM)[0];
	if ($c > 0 && $currentStat != 10)
		mysqli_query($dblink, "UPDATE taken_lots SET id_status = 9 WHERE id_amo = $id");
}
?>