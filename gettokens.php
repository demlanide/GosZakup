<?php
$subdomain = 'kazinterservice'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
	'client_id' => 'df258d5e-55a9-44e7-9b5c-7c8f13633485',
	'client_secret' => 'ULDgmdQEby9aKrrCk7hVueB0Tq22WKuwxjTZPKeR7O1KeLPjmyi7mglYOrHgEGNQ',
	'grant_type' => 'authorization_code',
	'code' => 'def50200c3e199c88e212f29c5ea199ab9cbccd871298ca25e38cf98639d2dd0711d93a7d39850876aba1bddcf163c287d99175ba22c92354c6c9c36d965c3478ad25aa459666b6082d6d1d4a2d8410d5ac2db1da3370307aec332702ed78375be02958870d4fbcaf04c993fb7123c882c924652efa13e786bef0f63f67df8b356bb2ec9e93f4c49655d675153b66ea8d43421bdab3495bee90bdfb95a755afe8000cd642bed51d84cf84f6214d8a8e945b2b2512b7b6cc6ddd36902835b7adca10da2df079cae65237b2e4fefa0510c6b6be9b17704a621a1194e20faf4c0cb92288ceaa44de94baf4a005a32900003adcbb1c68aa984308bcc5c3167da0099207b5ff78caa954b79959c91254aee2e0791167ec9b15ea600e3a284ec2929ce8d6e0e2f1e05855cbb89dedcc06f1dada35e07c5e2b5022b8522206c9000be987a4c7304063de536e00ae7b2e778e0f12e819ce898052d265d41e24335bdc2b07b61be7bfd59fc87fe7b42eafbf99b7b61e454c040c33fb7486fef0482213a27d1c2319e2a4e36e5dec0e5468c87eccd5dcda6f5ae7f747068fa5e8bbea5e4be579fd31e5fb85ac0af70eebee53c4758d75750e88909d514e6290221aa90',
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
?>