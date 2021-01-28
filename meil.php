<?php
$emails = array(
    "dauletaltynbekoff@gmail.com"
//    , "dkv"
);
$to = implode(',', $emails);
$title = "Новое сообщение - gz.open-k.com";
$message .= "Имя: " . $_POST['name'] . "<br>";
$message .= "Email: " . $_POST['email'] . "<br>";
$message .= "Сообщение: " . $_POST['message'] . "<br>";
//$message .= "Текст письма: " . $_POST['message'] . "<br>";

$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers .= "From: no-reply <no-reply@cg-company.org>\r\n";

$result = mail($to, $title, $message, $headers);
if ($result) {
    echo 'Ваша заявка отправлено успешно';
} else {
    echo 'Заявка не отправлено';
}
?>