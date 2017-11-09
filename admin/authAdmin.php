<?php session_start();

$password = $_POST['password'];
$login = $_POST['login'];
$tablename = 'admin';
$nextPageName = 'statistics.php';
$idname = 'idadmin';

require_once '../authAll.php';

auth($login, $password, $tablename, $nextPageName, $idname);


/*
if ((empty ($login)) || (empty($password)))
    echo "Пустые поля";
else {

    require_once 'bd.php';

    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    $login = trim($login);
    $password = trim($password);


    $sql_select = "
      SELECT *
      FROM   user
      WHERE login = '$login'
    ";

    $result = mysqli_query($link, $sql_select) or die("ошибка " . mysqli_error($link));
    $row = mysqli_fetch_array($result);


    if (($row['password'] == $password) && (!empty($row['password']))) {

        $_SESSION['id'] = $row['iduser'];
        header('Location: myVacation.php');

    } else {


        echo "Ошибка авторизации:";

        if ((empty($row['password']))) {
            echo " данного пользователя не существует";
        } elseif ($row['password'] != $password) {
            echo " неверный пароль";

        }


    }


}
?>
*/