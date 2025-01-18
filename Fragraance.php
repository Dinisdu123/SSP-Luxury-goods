<?php
// Include the database connection file
include 'db_connect.php';

// Fetch dhouder bags
$sql_mens = "SELECT Name, Price, ImageUrl From Products Where Category = 'fragrances' and SubCategory = 'mens'";
$mens = $conn->query($sql_mens);

//Fetch minibags
$sql_ladies = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'fragrances' AND SubCategory = 'ladies'";

$ladies = $conn->query($sql_ladies);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Aurora Luxe</title>
</head>
<body class=" bg-white text-black">
    <nav class="flex items-center justify-between p-4 border-b border-black">
        <div class="flex space-x-8">
            <a href="leathergoods.php" class="hover:text-gray-500">Leather Goods</a>
            <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
            <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
        </div>  
        <div class= "flex items-center space-x-6">
            <span class="text-4xl font-serif">Aurora luxe</span>
            <div class="flex space-x-4 items-center">
                <a href="cart.php">
                    <img src="images/cart.png" alt="" class="w-6 h-6 ml-20 hover:opacity-75">
                </a>
                <a href="signin.php">
                    <img src="images/profile icon.png" alt="" class="w-6 h-6 hover:opacity-75">
                </a>
            </div>
        </div>
    </nav>
    <!-- cover photo fragrances page -->
    <div class="mt-2 flex bg-gray-200 h-[350px]">
            <!-- Image Section -->
        <div class="w-1/2">
            <img src="images/fragrances-cover-photo.jpg" alt="Fragrances Cover photo" class="w-full h-full object-cover">
        </div>
            <!-- Text Section -->
        <div class="w-1/2 flex flex-col justify-center items-center px-10">
            <h1 class="text-4xl font-serif text-center mt-5 mb-5">Elevate Your Essence</h1>
            <p class="leading-7 text-center">
                Discover our curated collection of luxurious fragrances, crafted to captivate the senses and leave a lasting
                impression. From timeless classics to modern masterpieces, each scent is an exquisite expression of elegance and
                individuality. Whether you seek a signature fragrance for every day or a unique scent for special occasions, our
                selection offers the perfect blend of sophistication and allure.
            </p>
        </div>
    </div>
    <!-- fragrances display -->
    <!-- Mens Section -->
    <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-2 text-center mt-4">Mens</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php
                if ($mens->num_rows > 0) {
                    while ($row = $mens->fetch_assoc()) {
                        echo "<a href='product.php?name=" . urlencode($row['Name']) . "' class='block'>";

                        echo "<div class='bg-white p-4 text-center flex flex-col items-center'>";
                        echo "<img src='" . $row['ImageUrl'] . "' alt='" . $row['Name'] . "' class='h-40 w-40 object-cover mb-4 rounded'>";
                        echo "<p class='text-gray-600 text-center'>LKR " . $row['Price'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-gray-500'>No products found.</p>";
                }
                ?>
            </div>
    </div>
    <!-- Ladies Section -->
    <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-2 text-center mt-4">Ladies</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php
                if ($ladies->num_rows > 0) {
                    while ($row = $ladies->fetch_assoc()) {
                        echo "<a href='product.php?name=" . urlencode($row['Name']) . "' class='block'>";
                        echo "<div class='bg-white p-4 text-center flex flex-col items-center'>";
                        echo "<img src='" . $row['ImageUrl'] . "' alt='" . $row['Name'] . "' class='h-40 w-40 object-cover mb-4 rounded'>";
                        echo "<p class='text-gray-600 text-center'>LKR " . $row['Price'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-gray-500'>No products found.</p>";
                }
                ?>
            </div>
    </div>
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