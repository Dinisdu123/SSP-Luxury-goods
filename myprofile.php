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
$firstName = $_SESSION['first_name'];
$lastName = $_SESSION['last_name'];
$email = $_SESSION['email'];
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
                <!-- Website name -->
                <h1 class="text-xl font-bold">Name of the Website</h1>
                <!-- Navbar links -->
                <nav class="flex space-x-4">
                    <a href="leatherGoods.php" class="hover:text-gray-400">Leather Goods</a>
                    <a href="fragrances.php" class="hover:text-gray-400">Fragrances</a>
                    <a href="accessories.php" class="hover:text-gray-400">Accessories</a>
                    <a href="myprofile.php" class="hover:text-gray-400">
                        <img src="profile_icon.png" alt="Profile" class="h-8 w-8 rounded-full">
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
                    <img src="user_placeholder.png" alt="Profile" class="h-20 w-20 rounded-full border">
                </div>
                <!-- User Info -->
                <div>
                    <h2 class="text-2xl font-bold">Hello, <?php echo $firstName; ?>!</h2>
                    <p class="text-gray-600"><?php echo $email; ?></p>
                    <a href="logout.php" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Sign Out</a>
                </div>
            </div>

            <!-- Order History -->
            <section class="mt-6">
                <h3 class="text-xl font-bold mb-4">Order History</h3>
                <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                    <p class="text-gray-500">You haven't placed any orders yet.</p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
