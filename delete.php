<?php
session_start();

if ($_SESSION['id']) {
    $userid = $_SESSION['id'];

    require_once 'bd.php';

    $idvacation = $_POST["cancelVacation"];
    $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
    mysqli_set_charset($link, "utf8");
    $query2 = "
    DELETE FROM vacation
    WHERE idvacation = '$idvacation'
    ";

    $result2 = MYSQLI_QUERY($link, $query2);

    echo "Заявка на отпуск отменена";

} else echo "Ошибка!";