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
    <nav class="flex items-center justify-between p-4 border-b border-black">
        <div class="flex space-x-8">
            <a href="leathergoods.php" class="hover:text-gray-500">Leather Goods</a>
            <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
            <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
        </div>  
        <div class= "flex items-center space-x-6">
            <span class="text-4xl font-serif">Aurora luxe</span>
            <div class="flex space-x-4 items-center">
                <a href="">
                    <img src="images/cart.png" alt="" class="w-6 h-6 ml-20 hover:opacity-75">
                </a>
                <a href="signin.php">
                    <img src="images/profile icon.png" alt="" class="w-6 h-6 hover:opacity-75">
                </a>
            </div>
        </div>
    </nav>

    <div class="grid grid-cols-4 gap-4 mr-[130px] ml-[130px] mt-8">
    <!-- Shoulder Bag -->
    <a href="#shoulder-bags" class="flex flex-col items-center">
        <img src="https://cdn.mitchellstores.com/rails/active_storage/representations/proxy/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBMDhqQ0E9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--51fdac4dbed052160c89526d1513a53425169a0f/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaDdDam9MWm05eWJXRjBTU0lJYW5CbkJqb0dSVlE2QzNKbGMybDZaVWtpRHpJNE1EQjROREl3TUQ0R093WlVPZ3B6ZEhKcGNGUTZFR0YxZEc4dGIzSnBaVzUwVkRvTWNYVmhiR2wwZVVraUNEYzFKUVk3QmxRPSIsImV4cCI6bnVsbCwicHVyIjoidmFyaWF0aW9uIn19--2194f4ba90266e988b82b869a61bc64b50c6873c/uploading-1307082-jpg20221021-13-s9tgjr.jpg"
            alt="Prada Shoulder Bag" class="w-[200px] h-[200px] mb-2">
        <span class="text-center text-lg font-medium">Shoulder Bag</span>
    </a>
    <!-- Mini Bag -->
    <a href="#mini-bags" class="flex flex-col items-center">
        <img src="https://cdn-images.farfetch-contents.com/25/76/87/10/25768710_55982729_480.jpg" alt="Mini Bags" class="w-[200px] h-[200px] mb-2">
        <span class="text-center text-lg font-medium">Mini Bag</span>
    </a>
    <!-- Backpacks -->
    <a href="#backpacks" class="flex flex-col items-center">
        <img src="https://cdn-images.farfetch-contents.com/26/41/00/43/26410043_56000810_1000.jpg" alt="Backpacks" class="w-[200px] h-[200px] mb-2">
        <span class="text-center text-lg font-medium">Backpacks</span>
    </a>
    <!-- Wallets -->
    <a href="#wallets" class="flex flex-col items-center">
        <img src="https://cdn-images.farfetch-contents.com/27/53/93/86/27539386_57294969_1000.jpg" alt="Wallets" class="w-[200px] h-[200px] mb-2">
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
        echo "<div id='$id' class='mt-10'>";
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

   <!-- footer -->
   <footer class="bg-gray-200 text-center lg:text-left h-[260px] mb-0">
    <div class="max-w-7xl mx-auto py-10">
        <div class="flex flex-col sm:flex-row justify-between text-sm text-gray-800">
            <!-- Quick Links  -->
            <div class="sm:text-left flex-1">
                <h6 class="font-bold mb-4">Quick links</h6>
                <ul>
                    <li class="mb-2"><a href="index.php" class="hover:underline">Home</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">New arrivals</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">Shop</a></li>
                    <li><a href="aboutus.html" class="hover:underline">About us</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="sm:text-center flex-1">
                <h6 class="font-bold mb-4">Categories</h6>
                <ul>
                    <li class="mb-2"><a href="#" class="hover:underline">Leather goods</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">Fragrances</a></li>
                    <li><a href="#" class="hover:underline">Accessories</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div class="sm:text-right flex-1">
                <h6 class="font-bold mb-4">Contact us</h6>
                <p class="mb-2">+94 77 123 4567</p>
                <p class="mb-2">+94 11 234 5678</p>
                <p class="mb-4">auroraluxe@gmail.com</p>
                <div class="flex space-x-4 justify-center sm:justify-end">
                    <span class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs "onclick="window.open('https:www.instagram.com/louisvuitton/')"><img src="https://i.pinimg.com/474x/1e/d6/e0/1ed6e0a9e69176a5fdb7e090a1046b86.jpg" alt="instagram logo"></span>
                    <span class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs">3#</span>
                    <span class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs">3#</span>
                </div>
            </div>
        </div>
        <div class="text-center mt-10 text-gray-700 text-xs">
            © 2024 auroraluxe All Rights Reserved.
        </div>
    </div>
    </footer>
</body>
</html>
