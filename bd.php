<?php

$host = 'localhost'; // ����� �������
$database = 'holiday'; // ��� ���� ������
$user = 'root'; // ��� ������������
$password = ''; // ������


$link = mysqli_connect($host, $user, $password, $database)
or die("������ " . mysqli_error($link));

mysqli_set_charset($link, "utf8");


?>