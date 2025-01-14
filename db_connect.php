<?php
$host = 'localhost';
$username = 'root';
$password = 'Dinidu123';
$database = 'ecommerce';
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>