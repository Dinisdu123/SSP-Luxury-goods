<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cartId'];
    $quantity = $_POST['quantity'];

    // Update quantity and total price
    $updateQuery = "UPDATE cart c
                    JOIN products p ON c.ProductId = p.ProductId
                    SET c.Quantity = ?, c.TotalPrice = ? * (p.Price + 400)
                    WHERE c.CartId = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("idi", $quantity, $quantity, $cartId);
    $stmt->execute();

    header("Location: cart.php");
    exit;
}
