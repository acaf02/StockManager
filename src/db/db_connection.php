<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SM";

//cria conexão
$connection = mysqli_connect($servername, $username, $password, $dbname);

//verifica a conexão
if(!$connection) {
    die("Connection Failed: " . mysqli_connect_error());
}