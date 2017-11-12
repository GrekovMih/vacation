<?php session_start();

$password = $_POST['password'];
$login = $_POST['login'];
$tablename = 'admin';
$nextPageName = 'statistics.php';
$idname = 'idadmin';

require_once '../authAll.php';

auth($login, $password, $tablename, $nextPageName, $idname);


