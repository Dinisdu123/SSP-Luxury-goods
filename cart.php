<?php
session_start();
include 'db_connect.php';

$userId = $_SESSION['UserId'];

// Fetch cart items for the user
$query = "SELECT c.CartId, p.Name, p.ImageUrl, c.Quantity, c.TotalPrice 
          FROM cart c
          INNER JOIN Products p ON c.ProductId = p.ProductId
          WHERE c.UserId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$subtotal = 0;
$deliveryCharges = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Shopping Cart - Aurora Luxe</title>
</head>
<body class="bg-white text-black">
    <h1 class="text-3xl font-serif text-center mt-6">Shopping Cart</h1>
    <div class="container mx-auto mt-10">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="flex items-center justify-between border-b py-4">
                <img src="<?php echo $row['ImageUrl']; ?>" alt="Product Image" class="w-20 h-20 object-cover">
                <div>
                    <h2 class="text-xl"><?php echo htmlspecialchars($row['Name']); ?></h2>
                    <p>Quantity: <?php echo $row['Quantity']; ?></p>
                </div>
                <p>LKR <?php echo number_format($row['TotalPrice'], 2); ?></p>
                <form method="POST" action="remove_from_cart.php">
                    <input type="hidden" name="CartId" value="<?php echo $row['CartId']; ?>">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Remove</button>
                </form>
            </div>
            <?php
                $subtotal += $row['TotalPrice'] - ($row['Quantity'] * 400);
                $deliveryCharges += $row['Quantity'] * 400;
            ?>
        <?php endwhile; ?>
        <div class="mt-6 text-right">
            <p>Subtotal: LKR <?php echo number_format($subtotal, 2); ?></p>
            <p>Delivery Charges: LKR <?php echo number_format($deliveryCharges, 2); ?></p>
            <h2 class="text-2xl font-bold">Total: LKR <?php echo number_format($subtotal + $deliveryCharges, 2); ?></h2>
        </div>
    </div>
</body>
</html>
