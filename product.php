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
    $userId = $_SESSION['user_id']; // Correct version
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

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $userId = $_SESSION['user_id'];
    $productId = $product['ProductId'];
    $rating = $_POST['rating'];
    $reviewText = $_POST['review_text'];

    $insertReviewQuery = "INSERT INTO reviews (CustomerId, ProductId, Rating, ReviewText) VALUES (?, ?, ?, ?)";
    $insertReviewStmt = $conn->prepare($insertReviewQuery);
    $insertReviewStmt->bind_param("iiis", $userId, $productId, $rating, $reviewText);
    $insertReviewStmt->execute();

    // Redirect to the same page to display the new review
    header("Location: " . $_SERVER['REQUEST_URI']);
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
    <nav class="flex flex-wrap items-center justify-between p-4 border-b border-black space-y-4 sm:space-y-0">
        <div class="flex flex-wrap justify-center space-x-4 lg:space-x-8">
            <a href="leathergoods.php" class="hover:text-gray-500">Leather Goods</a>
            <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
            <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
        </div>
        <div class="flex flex-col items-center sm:flex-row sm:items-center space-y-4 sm:space-y-0 space-x-0 sm:space-x-6">
            <span class="text-2xl sm:text-4xl font-serif">Aurora Luxe</span>
            <div class="flex space-x-4 items-center">
                <a href="cart.php">
                    <img src="images/cart.png" alt="Cart" class="w-6 h-6 hover:opacity-75">
                </a>
                <a href="myprofile.php">
                    <img src="images/profile icon.png" alt="Profile" class="w-6 h-6 hover:opacity-75">
                </a>
            </div>
        </div>
    </nav>

    <!-- Product Details Section -->
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Product Image -->
            <div class="flex justify-center">
                <img src="<?php echo $product['ImageUrl']; ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>" class="w-full max-w-xs md:max-w-md object-cover rounded shadow-md">
            </div>
            <!-- Product Details -->
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold"><?php echo htmlspecialchars($product['Name']); ?></h1>
                <p class="text-gray-600 text-lg mt-4">LKR <?php echo number_format($product['Price'], 2); ?></p>
                <!-- Add to Cart Form -->
                <form method="POST" class="mt-6">
                    <div class="flex items-center space-x-4">
                        <input type="number" name="quantity" value="1" min="1" class="border p-2 rounded-md w-20 text-center">
                        <button type="submit" name="add_to_cart" class="bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800">
                            Add to Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Description Section -->
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Product Description</h2>
        <p class="text-gray-600 leading-relaxed">
            <?php echo nl2br(htmlspecialchars($product['Description'])); ?>
        </p>
    </div>

    <!-- Reviews Section -->
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Reviews</h2>
        
        <!-- Display Existing Reviews -->
        <div class="space-y-4">
            <?php
            $reviewQuery = "SELECT r.Rating, r.ReviewText, r.ReviewDate, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName 
            FROM reviews r 
            JOIN customers c ON r.CustomerId = c.CustomerId 
            WHERE r.ProductId = ?
            ORDER BY r.ReviewDate DESC";

            $reviewStmt = $conn->prepare($reviewQuery);
            $reviewStmt->bind_param("i", $product['ProductId']);
            $reviewStmt->execute();
            $reviewResult = $reviewStmt->get_result();

            if ($reviewResult->num_rows > 0) {
                while ($review = $reviewResult->fetch_assoc()) {
                    echo '<div class="border p-4 rounded-md bg-gray-50">';
                    echo '<h3 class="font-semibold">' . htmlspecialchars($review['CustomerName']) . '</h3>';
                    echo '<p class="text-gray-600">Rating: ' . str_repeat('⭐', $review['Rating']) . '</p>';
                    echo '<p>' . nl2br(htmlspecialchars($review['ReviewText'])) . '</p>';
                    echo '<span class="text-sm text-gray-500">' . $review['ReviewDate'] . '</span>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-gray-600">No reviews yet. Be the first to review!</p>';
            }
            ?>
        </div>

        <!-- Submit a Review -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-4">Write a Review</h3>
                <form method="POST">
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                        <select name="rating" id="rating" class="border p-2 rounded-md w-full" required>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="review_text" class="block text-sm font-medium text-gray-700">Review</label>
                        <textarea name="review_text" id="review_text" rows="4" class="border p-2 rounded-md w-full" required></textarea>
                    </div>
                    <button type="submit" name="submit_review" class="bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800">
                        Submit Review
                    </button>
                </form>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mt-4">Please <a href="login.php" class="text-blue-500">log in</a> to write a review.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-10 mt-10">
        <p class="text-gray-700 text-sm">© 2024 Aurora Luxe. All Rights Reserved.</p>
    </footer>
</body>
</html>
