<?php
function getuserid($email)
{
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/users'; //Формируем URL для запроса
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
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/leads'; //Формируем URL для запроса
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
	return $out['_embedded']['leads'][0]['id'];
}

function connect($id_cont, $id_lead) {
    $fd = fopen("opengrouptest", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/contacts/' . $id_cont . '/link'; //Формируем URL для запроса
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

function addcont($name, $email) {
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
        'name'=>$name,
		'custom_fields_values'=>array(
			array(
				'field_id'=>937388,
				'values'=>array(
					array(
						'value'=>$email
					)
				)
			)
		)
    );
	$json = json_encode(['query'=>$query]);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/contacts'; //Формируем URL для запроса
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
		  
function checkcont($name) {
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/contacts?query=' . $name; //Формируем URL для запроса
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
    if ($out) {
		for ($inc = 0; $inc < count($out["_embedded"]["contacts"]); $inc++) {
			if ($out["_embedded"]["contacts"][$inc]["name"] == $name)
				return $out["_embedded"]["contacts"][$inc]["id"];
		}
	} else
		return NULL;
}
function comments($id, $name, $doclink) {
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	$data = [
		'client_id' => '809ec797-4187-4efc-a0a6-6a06520e3704',
		'client_secret' => 'WUbcoXWhU5A3OqLD9ghNfCvXqCD09S6hqLMwrTjSRel4x4jYxdhKK7AwY7YNJMeB',
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
	$str = $name.' '.$doclink;
    $query = array(
        'note_type'=>'common',
		'params'=>array('text'=>$str)
    );
	$json = json_encode(['query'=>$query]);
	$link = 'https://' . 'opengrouptest' . '.amocrm.ru/api/v4/leads/' . $id . '/notes'; //Формируем URL для запроса
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
}
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
				if ($id){
					$str = $str.$id->fetch_array(MYSQLI_NUM)[0].',';}
			}
		}	
		else {
			$str = "none";
		}
		$link = "https://www.goszakup.gov.kz/ru/announce/index/".substr($arr["data"]["Lots"][$i]["trdBuyNumberAnno"], 0, -2);
		$sre = "INSERT INTO lots(name, id_purchase_method, lot_number, id_status, ids_place, purchaser_name, purchaser_BIN, price, count, announcement, id_purchase_item, publish_date, trading_start_date, trading_finish_date, last_update, description, link, email) VALUES ('".$arr["data"]["Lots"][$i]["nameRu"]."', ".$id_purchase_method.", '".$arr["data"]["Lots"][$i]["lotNumber"]."', ".$id_status.", '".$str."', '".$arr["data"]["Lots"][$i]["customerNameRu"]."', ".$arr["data"]["Lots"][$i]["customerBin"].", ".$arr["data"]["Lots"][$i]["amount"].", ".$arr["data"]["Lots"][$i]["count"].", '".$arr["data"]["Lots"][$i]["trdBuyNumberAnno"]."', ".$id_purchase_item.", '".$arr["data"]["Lots"][$i]["TrdBuy"]["publishDate"]."', '".$arr["data"]["Lots"][$i]["TrdBuy"]["startDate"]."', '".$arr["data"]["Lots"][$i]["TrdBuy"]["endDate"]."', '".$arr["data"]["Lots"][$i]["lastUpdateDate"]."', '".$arr["data"]["Lots"][$i]["descriptionRu"]."', '$link', '".$arr["data"]["Lots"][$i]["Customer"]["email"]."');";
		mysqli_query($dblink, $sre);
		$lotNumber = $arr["data"]["Lots"][$i]["lotNumber"];
		for ($j = 0; $j < count($arr["data"]["Lots"][$i]["Files"]); $j++) {
			$sre = "INSERT INTO files(lot_number, name, link) VALUES ('$lotNumber', '".$arr["data"]["Lots"][$i]["Files"][$j]['nameRu']."', '".$arr['data']['Lots'][$i]['Files'][$j]['filePath']."');";
			mysqli_query($dblink, $sre);
		}
	}
}
?>