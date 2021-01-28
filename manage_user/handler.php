<?php
 include("db.php");
// Подключаем файл конфигурации

 
// Получаем значение переменной "search" из файла "script.js".
    // Помещаем поисковой запрос в переменной
    $Name = $_POST['search'];
	$id = $_POST['id'];
    // Запрос для выбора из базы данных
    $Query = "SELECT name FROM roles WHERE name LIKE '%$Name' LIMIT 5";
 
    //Производим поиск в базе данных
    $ExecQuery = mysqli_query($db, $Query) or die(mysqli_error());
		if(mysqli_num_rows($ExecQuery)>0){
			echo '<ul>';
			$rows = mysqli_fetch_array($ExecQuery);
			do{
			echo '<li style="background: #F3F5F7; list-style: none; border-radius:3px; padding-left:0px !important; padding:3px; cursor:pointer; margin-bottom: 5px; " onclick="fill(\''.$rows["name"].'\',\''.$id.'\')">
				<a onclick="fill(\''.$rows["name"].'\',\''.$id.'\')">
				   '. $rows["name"].'
				</a>
        </li>';
		}while($rows = mysqli_fetch_array($ExecQuery));
		}?>
    </ul>