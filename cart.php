<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Include the database connection
include 'db_connect.php';

// Fetch user's cart items from the database
$sql = "SELECT c.CartId, c.Quantity, c.TotalPrice, p.Name, p.ImageUrl, p.Price 
        FROM cart c 
        JOIN products p ON c.ProductId = p.ProductId 
        WHERE c.UserId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

// Calculate the subtotal
$subtotal = 0;
if (!empty($cartItems)) {
    foreach ($cartItems as $item) {
        $subtotal += $item['TotalPrice'];
    }
}

// Fixed delivery fee
$deliveryFee = 400;

// Calculate the total
$total = $subtotal + $deliveryFee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Shopping Cart</title>
</head>
<body class="bg-gray-100 text-black">
    <!-- Container -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <h1 class="text-3xl sm:text-4xl font-bold mb-6 text-center sm:text-left">Shopping Cart</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-300 py-4 space-y-4 sm:space-y-0">
                            <img src="<?php echo htmlspecialchars($item['ImageUrl']); ?>" alt="<?php echo htmlspecialchars($item['Name']); ?>" class="w-20 h-20 object-cover rounded">
                            <div class="flex-1 sm:px-4 text-center sm:text-left">
                                <h2 class="font-semibold"><?php echo htmlspecialchars($item['Name']); ?></h2>
                                <p class="text-sm text-gray-600">LKR <?php echo number_format($item['Price'], 2); ?></p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                                <form method="POST" action="update_cart.php" class="flex items-center space-x-2">
                                    <input type="hidden" name="cartId" value="<?php echo $item['CartId']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['Quantity']; ?>" min="1" class="border p-2 rounded w-16 text-center">
                                    <button type="submit" class="text-blue-500 hover:underline">Update</button>
                                </form>
                                <form method="POST" action="remove_cart.php">
                                    <input type="hidden" name="cartId" value="<?php echo $item['CartId']; ?>">
                                    <button type="submit" class="text-red-500 hover:underline">Remove</button>
                                </form>
                            </div>
                            <p class="font-semibold text-center sm:text-left">LKR <?php echo number_format($item['TotalPrice'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center">Your cart is empty.</p>
                <?php endif; ?>
            </div>

            <!-- Order Summary -->
            <div class="border p-6 rounded-md bg-white shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-center sm:text-left">Order Summary</h2>
                <div class="flex justify-between mb-2 text-sm sm:text-base">
                    <span>Subtotal</span>
                    <span>LKR <?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="flex justify-between mb-2 text-sm sm:text-base">
                    <span>Delivery Fee</span>
                    <span>LKR <?php echo number_format($deliveryFee, 2); ?></span>
                </div>
                <hr class="mb-4">
                <div class="flex justify-between font-semibold text-lg">
                    <span>Total</span>
                    <span>LKR <?php echo number_format($total, 2); ?></span>
                </div>

                <!-- Checkout Form -->
                <form method="POST" action="checkout.php">
                    <input type="hidden" name="subtotal" value="<?php echo htmlspecialchars($subtotal); ?>">
                    <input type="hidden" name="shipping" value="<?php echo htmlspecialchars($deliveryFee); ?>">
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total); ?>">
                    <button type="submit" class="bg-black text-white py-2 px-6 rounded-md mt-6 w-full hover:bg-gray-800">Checkout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
