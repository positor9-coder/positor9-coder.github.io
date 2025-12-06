<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'login1';
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) { die("Conexión fallida: " . mysqli_connect_error()); }
mysqli_set_charset($conn, 'utf8mb4');
?>