<?php
$host = 'localhost';
$db = 'user_db';
$user = 'root'; // username default XAMPP
$pass = ''; // password default XAMPP

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>