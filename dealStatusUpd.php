<?php

function fetch_stat($id)
{
	$fd = fopen("tokens.txt", 'r') or die("не удалось открыть файл");
	$refresh = trim(fgets($fd));
	fclose($fd);
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
	/** Соберем данные для запроса */
	$data = [
		'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
		'client_secret' => 'ULDgmdQEby9aKrrCk7hVueB0Tq22WKuwxjTZPKeR7O1KeLPjmyi7mglYOrHgEGNQ',
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
	$link = 'https://' . 'kazinterservice' . '.amocrm.ru/api/v3/leads/' . $id; //Формируем URL для запроса
	$headers = [
	    'Authorization: Bearer ' . $access_token
	];
	echo $link;
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
	return $out['status_id'];
}

$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysqli_connect($server, $user, $password);

$database = 'openkcom_gz1';
$selected = mysqli_select_db($dblink, $database);

$statuses = array(
	'2'=>'37340929',
	'3'=>'36042271',
	'4'=>'37340932',
	'5'=>'37340935',
	'6'=>'36042274',
	'7'=>'37340938',
	'8'=>'36042277',
	'9'=>'37340941',
	'10'=>'37340944',
	'11'=>'37340947',
	'12'=>'37340950',
	'13'=>'37340953',
	'14'=>'37340956',
	'15'=>'37340959',
	'16'=>'37340920',
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

$arr = mysqli_query($dblink, "SELECT a.id_amo, b.id_status FROM taken_lots a JOIN lots b ON a.id_lot = b.id_lot")->fetch_all(MYSQLI_ASSOC);

for($i=0;$i<count($arr);$i++)
{
	if ($statuses[$arr[$i]['id_status']] != fetch_stat($arr[$i]['id_amo']))
	{
		$json = $json . '{"id": ' . $arr[$i]['id_amo'] . ', "status_id": ' . $statuses[$arr[$i]['id_status']] . '}';
		if ($i != count($arr) - 1)
			$json = $json . ', ';
		$filter = new LeadsFilter();
				$filter->setQuery($arr[$i]['id_amo']);
			   	
				//Получим сделки по фильтру
				try {
					$leads = $apiClient->leads()->get($filter);
					
				} catch (AmoCRMApiException $e) {
					printError($e);
					die;
				}
				foreach ($leads as $lead) {
					//Получим коллекцию значений полей сделки
					$lead->setStatusId($statuses[$arr[$i]['id_status']]);
				}

				//Сохраним сделку
				try {
					$apiClient->leads()->update($leads);
				} catch (AmoCRMApiException $e) {
					printError($e);
					die;
				}
	}

//$json = $json . ']';

		  		
?>