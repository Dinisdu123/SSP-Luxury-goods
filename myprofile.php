<?php
// Include the database connection file
include('db_connect.php');

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve user details from the session
$userId = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'];
$lastName = $_SESSION['last_name'];
$email = $_SESSION['email'];

// Fetch user details from the database
$query = "SELECT Address, PhoneNumber FROM customers WHERE CustomerId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($address, $phoneNumber);
$stmt->fetch();
$stmt->close();

// Fetch order history from the database
$query = "SELECT OrderId, OrderedDate, DeliveryAddress, OrderStatus, TotalPrice FROM orders WHERE CustomerId = ? ORDER BY OrderedDate DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$orderHistory = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <header class="bg-gray-800 text-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold">Name of the Website</h1>
                <nav class="flex space-x-4">
                    <a href="leatherGoods.php" class="hover:text-gray-400">Leather Goods</a>
                    <a href="fragrances.php" class="hover:text-gray-400">Fragrances</a>
                    <a href="accessories.php" class="hover:text-gray-400">Accessories</a>
                    <a href="myprofile.php" class="hover:text-gray-400">
                        <img src="images/profile icon.png" alt="Profile" class="h-8 w-8 rounded-full">
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Profile Section -->
    <main class="max-w-6xl mx-auto px-4 mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center space-x-6">
                <!-- Profile Image -->
                <div>
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/001/840/612/small_2x/picture-profile-icon-male-icon-human-or-people-sign-and-symbol-free-vector.jpg" alt="Profile" class="h-20 w-20 rounded-full border">
                </div>
                <!-- User Info -->
                <div>
                    <h2 class="text-2xl font-bold">Hello, <?php echo $firstName; ?>!</h2>
                    <p class="text-gray-600"><?php echo $email; ?></p>
                    <p class="text-gray-600">Phone: <?php echo $phoneNumber; ?></p>
                    <p class="text-gray-600">Address: <?php echo $address; ?></p>
                    <a href="logout.php" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Sign Out</a>
                </div>
            </div>

            <!-- Order History -->
            <section class="mt-6">
                <h3 class="text-xl font-bold mb-4">Order History</h3>
                <?php if (!empty($orderHistory)) { ?>
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Order ID</th>
                                    <th class="py-2">Ordered Date</th>
                                    <th class="py-2">Delivery Address</th>
                                    <th class="py-2">Order Status</th>
                                    <th class="py-2">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderHistory as $order) { ?>
                                    <tr class="border-b">
                                        <td class="py-2"><?php echo $order['OrderId']; ?></td>
                                        <td class="py-2"><?php echo date("d M Y, H:i", strtotime($order['OrderedDate'])); ?></td>
                                        <td class="py-2"><?php echo $order['DeliveryAddress']; ?></td>
                                        <td class="py-2"><?php echo $order['OrderStatus']; ?></td>
                                        <td class="py-2">$<?php echo number_format($order['TotalPrice'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                        <p class="text-gray-500">You haven't placed any orders yet.</p>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>
</body>
</html>
