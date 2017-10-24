<?php

$host = 'localhost'; // адрес сервера
$database = 'holiday'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль


$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

mysqli_set_charset($link, "utf8");


?>