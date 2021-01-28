<?php
$subdomain = $_POST['subdomain'];
$pipeline = $_POST['idvoronki'];
$secretkey = $_POST['secretkey'];
$idint = $_POST['idint'];
$authpass = $_POST['authpass'];
$intsite = $_POST['intsite'];
$idNumber = $_POST['idNumber'];
$idMethod = $_POST['idMethod'];
$idStatus = $_POST['idStatus'];
$idPlaces = $_POST['idPlaces'];
$idPurchaser = $_POST['idPurchaser'];
$idAnno = $_POST['idAnno'];
$idItem = $_POST['idItem'];
$idStartDate = $_POST['idStartDate'];
$idWinner = $_POST['idWinner'];

$rd = fopen("fieldsIds.txt", 'w') or die("не удалось создать файл");
fwrite($rd, $idNumber.PHP_EOL);
fwrite($rd, $idMethod.PHP_EOL);
fwrite($rd, $idStatus.PHP_EOL);
fwrite($rd, $idPlaces.PHP_EOL);
fwrite($rd, $idPurchaser.PHP_EOL);
fwrite($rd, $idAnno.PHP_EOL);
fwrite($rd, $idItem.PHP_EOL);
fwrite($rd, $idStartDate.PHP_EOL);
fwrite($rd, $idWinner);
fclose($rd);

$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

echo $link;

$data = [
	'client_id' => $idint,
	'client_secret' => $secretkey,
	'grant_type' => 'authorization_code',
	'code' => $authpass,
	'redirect_uri' => $intsite,
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
	echo $out."<br>";
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
fwrite($fd, $refresh_token.PHP_EOL);
fwrite($fd, $pipeline.PHP_EOL);
fwrite($fd, $secretkey.PHP_EOL);
fwrite($fd, $idint.PHP_EOL);
fwrite($fd, $intsite.PHP_EOL);
fwrite($fd, $subdomain);
fclose($fd);
?>