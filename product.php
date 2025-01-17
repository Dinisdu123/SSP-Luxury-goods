<?php
// Include the database connection file
include 'db_connect.php';

session_start(); // Ensure session is started to access user information

// Get the product name from the URL
$productName = urldecode($_GET['name']);

// Fetch product details from the database
$sql = "SELECT * FROM Products WHERE Name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productName);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Check if the product exists
if (!$product) {
    echo "Product not found.";
    exit;
}

// Handle add to cart logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $userId = $_SESSION['UserId']; // Assuming UserId is stored in session
    $productId = $product['ProductId'];
    $quantity = $_POST['quantity'];

    // Check if the product already exists in the cart
    $checkQuery = "SELECT * FROM cart WHERE UserId = ? AND ProductId = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $userId, $productId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update quantity and total price
        $row = $checkResult->fetch_assoc();
        $newQuantity = $row['Quantity'] + $quantity;
        $newTotalPrice = $newQuantity * ($product['Price'] + 400);

        $updateQuery = "UPDATE cart SET Quantity = ?, TotalPrice = ? WHERE CartId = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("idi", $newQuantity, $newTotalPrice, $row['CartId']);
        $updateStmt->execute();
    } else {
        // Insert a new row in the cart
        $totalPrice = $quantity * ($product['Price'] + 400);
        $insertQuery = "INSERT INTO cart (UserId, ProductId, Quantity, TotalPrice) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iiid", $userId, $productId, $quantity, $totalPrice);
        $insertStmt->execute();
    }

    // Redirect to cart page after adding
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo htmlspecialchars($product['Name']); ?> - Aurora Luxe</title>
</head>
<body class="bg-white text-black">
    <!-- Navigation Bar -->
    <nav class="flex items-center justify-between p-4 border-b border-black">
        <div class="flex space-x-8">
            <a href="leathergoods.php" class="hover:text-gray-500">Leather Goods</a>
            <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
            <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
        </div>
        <div class="flex items-center space-x-6">
            <span class="text-4xl font-serif">Aurora Luxe</span>
            <div class="flex space-x-4 items-center">
                <a href="cart.php">
                    <img src="images/cart.png" alt="" class="w-6 h-6 hover:opacity-75">
                </a>
                <a href="signin.php">
                    <img src="images/profile icon.png" alt="" class="w-6 h-6 hover:opacity-75">
                </a>
            </div>
        </div>
    </nav>

    <!-- Product Details Section -->
    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Product Image -->
            <div>
                <img src="<?php echo $product['ImageUrl']; ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>" class="w-full h-auto object-cover rounded">
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-4xl font-serif mb-4"><?php echo htmlspecialchars($product['Name']); ?></h1>
                <p class="text-2xl text-gray-700 mb-6">LKR <?php echo number_format($product['Price'], 2); ?></p>
                <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($product['Description']); ?></p>
                <!-- Add to Cart Form -->
                <form method="POST">
                    <input type="number" name="quantity" value="1" min="1" class="border p-2 rounded-md mb-4">
                    <button type="submit" name="add_to_cart" class="bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Description Section -->
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold mb-4">Product Description</h2>
        <p class="text-gray-600 leading-relaxed">
            <?php echo nl2br(htmlspecialchars($product['Description'])); ?>
        </p>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-10 mt-10">
        <p class="text-gray-700 text-sm">© 2024 Aurora Luxe. All Rights Reserved.</p>
    </footer>
</body>
</html>
