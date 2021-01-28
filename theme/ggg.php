<html>
	<head>
  <title>description</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
  <meta name="description" content="Сайт об HTML и создании сайтов"> 
 </head> 
<?php
$server = 'srv-db-plesk09.ps.kz:3306';
$user = 'openkcom_gz1';
$password = '@Admin111';

$dblink = mysql_connect($server, $user, $password);

if($dblink)
echo 'Соединение установлено.';
else
die('Ошибка подключения к серверу баз данных.');

$database = 'openkcom_gz1';
$selected = mysql_select_db($database, $dblink);
if($selected)
echo ' Подключение к базе данных прошло успешно.';
else
die(' База данных не найдена или отсутствует доступ.');
?>
</html>