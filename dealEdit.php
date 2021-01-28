<?php

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
//	$json = '[{"id": 44253507, "status_id": 37340923}]';
	$json = json_encode(array(array('id'=>44253507, 'status_id'=>37340923)));
echo $json;
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/leads'; //Формируем URL для запроса
	$headers = [
	    'Authorization: Bearer ' . $access_token,
		'X-HTTP-Method-Override: PATCH'
	];
	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
	curl_setopt($curl,CURLOPT_URL, $link);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $json);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'PATCH'); 
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
	echo $out;

/*	получение списка статусов
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
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v4/leads/pipelines/3711946/statuses'; //Формируем URL для запроса
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
echo $out;
	$out = json_decode($out, true);
*/

?>