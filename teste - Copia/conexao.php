<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'extrato_db';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>