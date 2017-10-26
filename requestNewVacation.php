<?php
session_start();

if ($_SESSION['id']) {
    $user_id = $_SESSION['id'];

    require_once 'bd.php';

    $newFirstDay = $_POST["newFirstDay"];
    $newLastDay = $_POST["newLastDay"];

    $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

    mysqli_set_charset($link, "utf8");
    $query2 = "
      INSERT INTO vacation
      VALUES('', '$newFirstDay', '$newLastDay', '$user_id')
    ";

    $result2 = MYSQLI_QUERY($link, $query2);
    echo "Заявка в рассмотрении";

} else echo "Ошибка!";