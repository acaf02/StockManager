<?php
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