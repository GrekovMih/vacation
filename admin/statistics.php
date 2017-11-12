<?php session_start();
if (empty($_SESSION['idadmin']))
    header("Location: index.html");
else {
?>

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

        echo "<h1> Количество дней отпуска за каждый год: </h1>";
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
                $monthday[$YEAR][$fmonth] += $interval->days;                 //мб путаница что включается, что нет


            } elseif ($fmonth < $lmonth) { // есть же ограничения на максимальный срок отпуска? не может он быть в 3х месяцах

                $lastDayofMonth = (mktime(0, 0, 0, $fmonth + 1, 0, $YEAR));
                $lastDayofMonth = date("Y-m-d", $lastDayofMonth);
                $lastDayofMonth = date_create($lastDayofMonth);

                $interval = date_diff($lastDayofMonth, $firstDay);
                $monthday[$YEAR][$fmonth] += $interval->days;

                if (empty ($monthday[$lastDay->format('Y')][$lmonth])) $monthday[$lastDay->format('Y')][$lmonth] = 0;

                $monthday[$lastDay->format('Y')][$lmonth] += $lastDay->format('d');

            }

        } while ($row = mysqli_fetch_array($result));


        foreach ($monthday as $key => $value) {

            $sum = array_sum($monthday[$key]);
            echo "За $key год в сумме отдыхали (или будут отдыхать): $sum (дней) <br />";

            $max = max($monthday[$key]);
            $maxMonth = array_keys($monthday[$key], $max)[0];

            echo "Больше всего отдыхали (или будут отдыхать) в $maxMonth месяце    $max (дней) <br> ";

            $min = min($monthday[$key]);
            $minMonth = array_keys($monthday[$key], $min)[0];

            echo "Меньше всего отдыхали (или будут отдыхать) в $minMonth месяце    $min (дней) <br> ";

        }
    }

    ?>

</div>

</body>
</html>