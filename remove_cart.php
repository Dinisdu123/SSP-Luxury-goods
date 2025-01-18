<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cartId'];

    $deleteQuery = "DELETE FROM cart WHERE CartId = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $cartId);
    $stmt->execute();

    header("Location: cart.php");
    exit;
}
