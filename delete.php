<?php /*session_start();

if ($_SESSION['id']) {
    $userid = $_SESSION['id'];
*/
    require_once 'bd.php';

    $idvacation = $_POST["cancelVacation"];


    $query2 = "
      DELETE FROM vacation
      WHERE idvacation = '$idvacation'
    ";

    $result2 = MYSQLI_QUERY($link, $query2) or die("Ошибка записи" . mysqli_error($link));

    echo "Заявка на отпуск отменена";

//} else echo "Ошибка!";