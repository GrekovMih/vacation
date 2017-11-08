<?php session_start();
error_reporting(0);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отпуск</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>
<body>


<div class="main">


    <?php

    if (empty($_SESSION['id']))
        echo "Ошибка авторизации";
    else{

    require_once 'bd.php';

    $userid =  $_SESSION['id'];

    $lastDayforCancel = new DateTime('3 days');
    $lastDayforCancel = $lastDayforCancel->format('Y-m-d');
    $holidayBusted = 0;

    $sql_select = "
          SELECT firstDay, lastDay, idvacation
          FROM   user  JOIN  vacation
          on user.iduser = user_iduser
          WHERE user.iduser = '$userid'
          ORDER BY firstDay
        ";
    // или можно просто выводить отпуска, которые еще можно отменить DATE_SUB(CURDATE(), INTERVAL 3 DAY)

    $result = mysqli_query($link, $sql_select) or die("ошибка запроса" . mysqli_error($link));
    $row = mysqli_fetch_array($result);

    echo " Даты ваших отпусков: <br>  <div id='cancelVacation'> ";

    do {

        $firstDay = $row['firstDay'];
        $lastDay = $row['lastDay'];
        $idvacation = $row['idvacation'];

        if ($firstDay > $lastDayforCancel) {
            echo "<p> <input type='checkbox' class='checkboxcancel'   value='$idvacation'>";
        } else
            echo "   <p class='past' >";

        echo " $firstDay -  $lastDay </p> ";

        // находясь в отпуске не берут же новый?

        if ($lastDay < date("Y-m-d")) {
            $lastDay = date_create($lastDay);
            $firstDay = date_create($firstDay);
            $interval = date_diff($lastDay, $firstDay);
            $holidayBusted += $interval->days;
        }else

        if ($firstDay < date("Y-m-d")) {
            $lastDay = date("Y-m-d");
            $lastDay = date_create($lastDay);
            $firstDay = date_create($firstDay);
            $interval = date_diff($lastDay, $firstDay);
            $holidayBusted += $interval->days;
        }


    } while ($row = mysqli_fetch_array($result));


    echo "<h5> Для отмены заявки на отпуск нажимите галочку возле, а затем кнопку 'Отозвать заявку на отпуск' </h5>
        <input type='button' id='form-submit-cancel' class='btn btn-success btn-lg' value='Отозвать заявления на отпуск'> </div>  <br>";


    $holidayYear = 28 + 28 * (date("Y") - 2017);
    $holidayFuture = $holidayYear - $holidayBusted;


    if ($holidayFuture > 0) {
    echo " <br> У вас неотгулянных $holidayFuture    (дней)  <br> "; // учитываются дни, которые уже отгуляны в отпуске.
    // Можно сделать, чтобы учитывались  дни и в заявках, но будет ли это корректно?


    ?>


    <div class="row">

        <div class="well" style="margin-top: 5%;">

            <div id="newVacatoin">

                <h3>Заявление на отпуск</h3>

                <form role="form" id="contactForm" data-toggle="validator" class="shake">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="newFirstDay" class="h4">Первый день отдыха</label> <br>
                            <input type="date" id="newFirstDay" name="newFirstDay"/>

                        </div>

                        <div class="form-group col-sm-6">
                            <label for="newLastDay" class="h4">Последний день отдыха</label> <br>
                            <input type="date" id="newLastDay" name="newLastDay"/>


                        </div>


                    </div>


                    <input type="button" id="form-submit" class="btn btn-success btn-lg pull"
                           value="Согласовать отдых">

                    <div class="clearfix"></div>
                </form>


            </div>
        </div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">


            $("#form-submit-cancel").bind("click", function (event) {

                var selectedCheckBoxes = document.querySelectorAll('input.checkboxcancel:checked'),
                    cancelVacation = Array.from(selectedCheckBoxes).map(cb => cb.value) ;


                $.ajax({
                    url: 'delete.php',
                    type: 'post',
                    data: "cancelVacation=" + cancelVacation,
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        console.log('запрос пошел');
                        $("#cancelVacation").html(data);

                    }


                });


            });


            $("#form-submit").bind("click", function (event) {
                var newFirstDay = $("#newFirstDay").val(),
                    newLastDay = $("#newLastDay").val(),
                    holidayFuture = <?php echo $holidayFuture ?>,
                    firstData = new Date(newFirstDay),
                    lastData = new Date(newLastDay),
                    today = new Date,
                    userid =  <?php echo $userid ?>
                    ;

                if (

                    //  (firstData < today) || (lastData < today) || убрана проверка, теперь можно взять отпуск в прошлом

                    (firstData > lastData)) {
                    alert("Введены некорректные даты");

                } else {

                    if (((lastData.getTime() - firstData.getTime()) / (1000 * 60 * 60 * 24)) < holidayFuture) {


                        $.ajax({
                            url: 'requestNewVacation.php',
                            type: 'post',
                            data: "newFirstDay=" + newFirstDay + "&newLastDay=" + newLastDay + "&userid=" + userid,
                            cache: false,
                            success: function (data) {
                                console.log(data);
                                console.log('запрос пошел');
                                $("#newVacatoin").html(data);

                            }


                        });


                    }


                    else
                        alert("У вас нет такого количества отпускных дней!");

                }

            });

        </script>

        <?php

        } else
            echo "Вы не отдохнете в этом году :(  ";


        }
        ?>
    </div>


</body>
</html>