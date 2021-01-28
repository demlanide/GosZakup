<?php
header("refresh: 3; url=https://gz.open-k.com/register.php");

    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
 if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }
    //если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
 $password = stripslashes($password);
    $password = htmlspecialchars($password);
 //удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);
 // подключаемся к базе
    include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
 // проверка на существование пользователя с таким же логином
$result = mysqli_query($db, "SELECT id FROM `users` WHERE login='$login'");
    $myrow = mysqli_fetch_array($result);
    if (!empty($myrow['id_user'])) {
    exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин. Через 3 секунды вас вернет на предыдущую страницу");
    }
 // если такого нет, то сохраняем данные
$imya = $_POST['imya'];
$email = $_POST['email'];
$prava = $_POST['prava'];
$result2 = mysqli_query ($db, "INSERT INTO users (login,password,name,email,id_allowance) VALUES('$login','$password','$imya','$email','$prava')");
    // Проверяем, есть ли ошибки
    if ($result2=='TRUE')
    {
    echo 'Пользователь успешно создан! <a href="/index.php">Перейти на главную</a> Через 3 секунды вас вернет на предыдущую страницу';
    }
 else {
    echo "Ошибка! Вы не зарегистрированы. Через 3 секунды вас вернет на предыдущую страницу";
    }
    ?>