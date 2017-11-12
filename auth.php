<?php session_start();

$password = $_POST['password'];
$login = $_POST['login'];
$tablename = 'user';
$nextPageName = 'myVacation.php';
$idname = 'iduser';

require_once 'authAll.php';

auth($login, $password, $tablename, $nextPageName, $idname);


