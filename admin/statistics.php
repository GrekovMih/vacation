<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статистика</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


<div class="main">

    <?php

    require_once '../bd.php';

    $login = $_POST['login'];
    $password = $_POST['password']; // надо бы делать хэширование пароля и тд для безопасности, но если портал во внутренней сети, думаю можно без этого

    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    $login = trim($login);
    $password = trim($password);


    $sql_select = "
      SELECT password
      FROM   admin
      WHERE login = '$login'
    ";
    $result = mysqli_query($link, $sql_select) or die("ошибка " . mysqli_error($link));
    $row = mysqli_fetch_array($result);


    if ($row['password'] == $password) {

        echo "<h1> Количество дней отпуска за каждый год </h1>";
        $YEAR = 0;
        $month = 0;


        $sql_select = "
          SELECT  lastDay, firstDay
          FROM   vacation
          ORDER BY firstDay
        ";

        $result = mysqli_query($link, $sql_select) or die("ошибка " . mysqli_error($link));
        $row = mysqli_fetch_array($result);


        do {
            $firstDay = $row['firstDay'];
            $lastDay = $row['lastDay'];
           // echo " <br> $firstDay -  $lastDay ";

            $lastDay = date_create($lastDay);
            $firstDay = date_create($firstDay);

            $YEAR = $firstDay->format('Y');

            $fmonth = $firstDay->format('m');
            $lmonth = $lastDay->format('m');


            if (empty ($monthday[$YEAR][$fmonth])) $monthday[$YEAR][$fmonth] = 0;


            if ($fmonth == $lmonth) {

                $interval = date_diff($lastDay, $firstDay);
                $monthday[$YEAR][$fmonth] += $interval->days + 1;                 //мб путаница что включается, что нет


            } elseif ($fmonth < $lmonth) { // есть же ограничения на максимальный срок отпуска? не может он быть в 3х месяцах

                $lastDayofMonth = (mktime(0, 0, 0, $fmonth + 1, 0, $YEAR));
                $lastDayofMonth = date("Y-m-d", $lastDayofMonth);
                $lastDayofMonth = date_create($lastDayofMonth);

                $interval = date_diff($lastDayofMonth, $firstDay);
                $monthday[$YEAR][$fmonth] += $interval->days + 1;

                if (empty ($monthday[$lastDay->format('Y')][$lmonth])) $monthday[$lastDay->format('Y')][$lmonth] = 0;

                $monthday[$lastDay->format('Y')][$lmonth] += $lastDay->format('d');

            }

        } while ($row = mysqli_fetch_array($result));


        foreach ($monthday as $key => $value) {

            $sum = array_sum($monthday[$key]);
            echo "За $key год в сумме отдыхали: $sum (дней) <br />";

            $max = max($monthday[$key]);
            $maxMonth = array_keys($monthday[$key], $max)[0];

            echo "Больше всего отдыхали в $maxMonth месяце    $max (дней) <br> ";

            $min = min($monthday[$key]);
            $minMonth = array_keys($monthday[$key], $min)[0];

            echo "Меньше всего отдыхали в $minMonth месяце    $min (дней) <br> ";

        }



    } else {
        echo "Ошибка авторизации";
    }
    ?>

</div>

</body>
</html>