<?php /*session_start();

if ($_SESSION['id']) {
    $user_id = $_SESSION['id'];
*/
    require_once 'bd.php';

    $newFirstDay = $_POST["newFirstDay"];
    $newLastDay = $_POST["newLastDay"];
    $userid = $_POST['userid'];


    mysqli_set_charset($link, "utf8");
    $query2 = "
      INSERT INTO vacation
      VALUES('', '$newFirstDay', '$newLastDay', '$userid')
    ";

    $result2 = MYSQLI_QUERY($link, $query2) or die("Ошибка записи" . mysqli_error($link));
    echo "Заявка в рассмотрении";

//} else echo "Ошибка!";