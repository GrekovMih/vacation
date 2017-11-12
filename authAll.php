<?php session_start();

$password = $_POST['password'];
$login = $_POST['login'];

function auth($login, $password, $tablename, $nextPageName, $idname)
{

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
      FROM   $tablename
      WHERE login = '$login'
    ";

        $result = mysqli_query($link, $sql_select) or die("ошибка " . mysqli_error($link));
        $row = mysqli_fetch_array($result);


        if (($row['password'] == $password) && (!empty($row['password']))) {

            $_SESSION[$idname] = $row[$idname];
            header("Location: $nextPageName");

        } else {


            echo "Ошибка авторизации:";

            if ((empty($row['password']))) {
                echo " данного пользователя не существует";
            } elseif ($row['password'] != $password) {
                echo " неверный пароль";

            }


        }


    }

}


