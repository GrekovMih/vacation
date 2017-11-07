<?php

$hostBD = 'localhost'; // адрес сервера
$databaseBD = 'holiday'; // имя базы данных
$userBD = 'root'; // имя пользователя
$passwordBD = ''; // пароль


$link = mysqli_connect($hostBD, $userBD, $passwordBD, $databaseBD)
or die("Ошибка " . mysqli_error($link));

mysqli_set_charset($link, "utf8");


?>