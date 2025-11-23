<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "login_sistema";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Falha na Conexão? ". $conn->connect_error);
}
?>