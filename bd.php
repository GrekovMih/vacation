<?php

$hostBD = 'localhost'; // ����� �������
$databaseBD = 'holiday'; // ��� ���� ������
$userBD = 'root'; // ��� ������������
$passwordBD = ''; // ������


$link = mysqli_connect($hostBD, $userBD, $passwordBD, $databaseBD)
or die("������ " . mysqli_error($link));

mysqli_set_charset($link, "utf8");


?>