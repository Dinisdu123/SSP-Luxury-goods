<?php
// Include the database connection
include 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$userId = $_SESSION['user_id']; // Get logged-in user's ID

// Check if the cart is empty
$cartQuery = "SELECT * FROM cart WHERE UserId = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("i", $userId);
$cartStmt->execute();
$cartItems = $cartStmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($cartItems)) {
    // Redirect to cart.php if the cart is empty
    header("Location: cart.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs only after the form is submitted
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $address1 = $_POST['address_line_1'] ?? '';
    $address2 = $_POST['address_line_2'] ?? '';
    $city = $_POST['city'] ?? '';
    $postalCode = $_POST['postal_code'] ?? '';
    $contactNumber = $_POST['contact_number'] ?? '';
    $deliveryAddress = "$firstName $lastName, $address1, $address2, $city, $postalCode, Contact: $contactNumber";

    $subtotal = $_POST['subtotal'] ?? 0;
    $shipping = $_POST['shipping'] ?? 0;
    $totalPrice = $_POST['total_price'] ?? 0;

    if (!empty($firstName) && !empty($lastName) && !empty($address1) && !empty($city) && !empty($postalCode) && !empty($contactNumber)) {
        foreach ($cartItems as $item) {
            $productId = $item['ProductId'];
            $quantity = $item['Quantity'];
            $itemTotalPrice = $item['TotalPrice'];

            // Insert order into orders table
            $orderQuery = "INSERT INTO orders (CustomerId, DeliveryAddress, TotalPrice, ProductId) VALUES (?, ?, ?, ?)";
            $orderStmt = $conn->prepare($orderQuery);
            $orderStmt->bind_param("isdi", $userId, $deliveryAddress, $itemTotalPrice, $productId);
            $orderStmt->execute();
        }

        // Clear the user's cart after successful order placement
        $clearCartQuery = "DELETE FROM cart WHERE UserId = ?";
        $clearCartStmt = $conn->prepare($clearCartQuery);
        $clearCartStmt->bind_param("i", $userId);
        $clearCartStmt->execute();

        // Redirect to thankyou.html after placing the order
        header("Location: thankyou.html");
        exit();
    } else {
        $errorMessage = "Please fill in all required fields.";
    }
}

// Retrieve POST data if available for display purposes
$subtotal = $_POST['subtotal'] ?? 0;
$shipping = $_POST['shipping'] ?? 0;
$totalPrice = $_POST['total_price'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Checkout</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <h1 class="text-3xl sm:text-4xl font-bold mb-6 text-center sm:text-left">Checkout</h1>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Order Details -->
            <div class="p-6 border bg-white shadow-md rounded-md">
                <h2 class="text-2xl font-semibold mb-4 text-center lg:text-left">Your order details</h2>
                <div class="space-y-2 text-center lg:text-left">
                    <p>Subtotal: <span class="font-medium">LKR <?php echo number_format($subtotal, 2); ?></span></p>
                    <p>Shipping: <span class="font-medium">LKR <?php echo number_format($shipping, 2); ?></span></p>
                    <p>Total: <span class="font-bold text-lg">LKR <?php echo number_format($totalPrice, 2); ?></span></p>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="p-6 border bg-white shadow-md rounded-md">
                <?php if (!empty($errorMessage)): ?>
                    <p class="text-red-500 mb-4"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="subtotal" value="<?php echo htmlspecialchars($subtotal); ?>">
                    <input type="hidden" name="shipping" value="<?php echo htmlspecialchars($shipping); ?>">
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($totalPrice); ?>">

                    <h2 class="text-2xl font-semibold mb-4 text-center lg:text-left">Contact Information</h2>
                    <div class="space-y-4">
                        <input type="text" name="first_name" placeholder="First name" required class="border p-2 rounded-md w-full">
                        <input type="text" name="last_name" placeholder="Last name" required class="border p-2 rounded-md w-full">
                    </div>

                    <h2 class="text-2xl font-semibold mt-6 mb-4 text-center lg:text-left">Address</h2>
                    <div class="space-y-4">
                        <input type="text" name="address_line_1" placeholder="Address line 1" required class="border p-2 rounded-md w-full">
                        <input type="text" name="address_line_2" placeholder="Address line 2" class="border p-2 rounded-md w-full">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="text" name="city" placeholder="City" required class="border p-2 rounded-md w-full">
                            <input type="text" name="postal_code" placeholder="Postal code" required class="border p-2 rounded-md w-full">
                        </div>
                        <input type="text" name="contact_number" placeholder="Contact Number" required class="border p-2 rounded-md w-full">
                    </div>

                    <button type="submit" class="bg-black text-white py-2 px-6 rounded-md mt-6 w-full hover:bg-gray-800">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
