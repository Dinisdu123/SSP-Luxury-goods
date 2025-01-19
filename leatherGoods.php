<?php
// Include the database connection file
include 'db_connect.php';

// Fetch products for each category
$sql_shoulderBag = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'leather goods' AND SubCategory = 'shoulder bags'";
$shoulderBag = $conn->query($sql_shoulderBag);

$sql_miniBags = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'leather goods' AND SubCategory = 'minibags'";
$miniBags = $conn->query($sql_miniBags);

$sql_backpacks = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'leather goods' AND SubCategory = 'backpacks'";
$backpacks = $conn->query($sql_backpacks);

$sql_wallets = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'leather goods' AND SubCategory = 'wallets'";
$wallets = $conn->query($sql_wallets);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora Luxe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-white text-black">
    <!-- Navigation Bar -->
    <nav class="flex flex-wrap items-center justify-between p-4 border-b border-black">
        <div class="flex space-x-8">
            <a href="leathergoods.php" class="hover:text-gray-500">Leather Goods</a>
            <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
            <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
        </div>
        <div class="flex items-center space-x-6">
            <span class="text-4xl font-serif">Aurora Luxe</span>
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

    <!-- Category Navigation -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mx-4 sm:mx-12 mt-8">
        <a href="#shoulder-bags" class="flex flex-col items-center">
            <img src="https://cdn.mitchellstores.com/rails/active_storage/representations/proxy/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBMDhqQ0E9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--51fdac4dbed052160c89526d1513a53425169a0f/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaDdDam9MWm05eWJXRjBTU0lJYW5CbkJqb0dSVlE2QzNKbGMybDZaVWtpRHpJNE1EQjROREl3TUQ0R093WlVPZ3B6ZEhKcGNGUTZFR0YxZEc4dGIzSnBaVzUwVkRvTWNYVmhiR2wwZVVraUNEYzFKUVk3QmxRPSIsImV4cCI6bnVsbCwicHVyIjoidmFyaWF0aW9uIn19--2194f4ba90266e988b82b869a61bc64b50c6873c/uploading-1307082-jpg20221021-13-s9tgjr.jpg"
                alt="Prada Shoulder Bag" class="w-48 h-48 mb-2">
            <span class="text-center text-lg font-medium">Shoulder Bag</span>
        </a>
        <a href="#mini-bags" class="flex flex-col items-center">
            <img src="https://cdn-images.farfetch-contents.com/25/76/87/10/25768710_55982729_480.jpg" alt="Mini Bags" class="w-48 h-48 mb-2">
            <span class="text-center text-lg font-medium">Mini Bag</span>
        </a>
        <a href="#backpacks" class="flex flex-col items-center">
            <img src="https://cdn-images.farfetch-contents.com/26/41/00/43/26410043_56000810_1000.jpg" alt="Backpacks" class="w-48 h-48 mb-2">
            <span class="text-center text-lg font-medium">Backpacks</span>
        </a>
        <a href="#wallets" class="flex flex-col items-center">
            <img src="https://cdn-images.farfetch-contents.com/27/53/93/86/27539386_57294969_1000.jpg" alt="Wallets" class="w-48 h-48 mb-2">
            <span class="text-center text-lg font-medium">Wallets</span>
        </a>
    </div>

    <!-- Product Display Sections -->
    <?php
    $categories = [
        'shoulder-bags' => ['name' => 'Shoulder Bags', 'data' => $shoulderBag],
        'mini-bags' => ['name' => 'Mini Bags', 'data' => $miniBags],
        'backpacks' => ['name' => 'Backpacks', 'data' => $backpacks],
        'wallets' => ['name' => 'Wallets', 'data' => $wallets]
    ];

    foreach ($categories as $id => $category) {
        echo "<div id='$id' class='mt-10 mx-4 sm:mx-12'>";
        echo "<h2 class='text-center text-3xl font-bold'>{$category['name']}</h2>";
        echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6'>";
        if ($category['data']->num_rows > 0) {
            while ($row = $category['data']->fetch_assoc()) {
                echo "
                    <div class='flex flex-col items-center text-center'>
                        <a href='product.php?name=" . urlencode($row['Name']) . "'>
                            <img src='{$row['ImageUrl']}' alt='{$row['Name']}' class='w-48 h-48 mb-4 object-cover'>
                        </a>
                        <h3 class='text-lg font-semibold mb-2'>{$row['Name']}</h3>
                        <p>LKR " . number_format($row['Price'], 2) . "</p>
                    </div>
                ";
            }
        } else {
            echo "<p class='text-center col-span-4'>No products found.</p>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap justify-between text-sm text-gray-800">
                <!-- Quick Links -->
                <div class="flex-1 mb-6 sm:mb-0">
                    <h6 class="font-bold mb-4">Quick Links</h6>
                    <ul>
                        <li><a href="index.php" class="hover:underline">Home</a></li>
                        <li><a href="#" class="hover:underline">New Arrivals</a></li>
                        <li><a href="#" class="hover:underline">Shop</a></li>
                        <li><a href="aboutus.html" class="hover:underline">About Us</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="flex-1 mb-6 sm:mb-0">
                    <h6 class="font-bold mb-4">Categories</h6>
                    <ul>
                        <li><a href="#" class="hover:underline">Leather Goods</a></li>
                        <li><a href="#" class="hover:underline">Fragrances</a></li>
                        <li><a href="#" class="hover:underline">Accessories</a></li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div class="flex-1">
                    <h6 class="font-bold mb-4">Contact Us</h6>
                    <p>+94 77 123 4567</p>
                    <p>+94 11 234 5678</p>
                    <p>auroraluxe@gmail.com</p>
                    <div class="flex space-x-4 justify-center sm:justify-start mt-4">
                        <a href="https://www.instagram.com" class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                            <img src="images/instagram-logo.png" alt="Instagram">
                        </a>
                        <a href="https://www.facebook.com" class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                            <img src="images/facebook-logo.png" alt="Facebook">
                        </a>
                    </div>
                </div>
            </div>
            <p class="mt-10 text-gray-700 text-xs">&copy; 2024 Aurora Luxe. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
