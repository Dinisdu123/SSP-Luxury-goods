<?php
// Include the database connection file
include 'db_connect.php';

// Fetch dhouder bags
$sql_mens = "SELECT Name, Price, ImageUrl From Products Where Category = 'fragrances' and SubCategory = 'mens'";
$mens = $conn->query($sql_mens);

// Fetch minibags
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

    <!-- Cover Photo Section -->
    <div class="mt-2 flex flex-col lg:flex-row bg-gray-200 h-auto lg:h-[350px]">
        <div class="lg:w-1/2 w-full">
            <img src="images/fragrances-cover-photo.jpg" alt="Fragrances Cover" class="w-full h-full object-cover">
        </div>
        <div class="lg:w-1/2 w-full flex flex-col justify-center items-center px-6 py-6">
            <h1 class="text-4xl font-serif text-center mb-5">Elevate Your Essence</h1>
            <p class="leading-7 text-center">
                Discover our curated collection of luxurious fragrances, crafted to captivate the senses and leave a lasting
                impression. From timeless classics to modern masterpieces, each scent is an exquisite expression of elegance and
                individuality. Whether you seek a signature fragrance for every day or a unique scent for special occasions, our
                selection offers the perfect blend of sophistication and allure.
            </p>
        </div>
    </div>

    <!-- Fragrances Display -->
    <div class="container mx-auto px-4">
        <!-- Men's Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-4 text-center">Men's</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php
                if ($mens->num_rows > 0) {
                    while ($row = $mens->fetch_assoc()) {
                        echo "<a href='product.php?name=" . urlencode($row['Name']) . "' class='block'>";
                        echo "<div class='bg-white p-4 text-center flex flex-col items-center'>";
                        echo "<img src='" . $row['ImageUrl'] . "' alt='" . $row['Name'] . "' class='h-40 w-40 object-cover mb-4 rounded'>";
                        echo "<p class='text-gray-800 font-medium'>" . $row['Name'] . "</p>";
                        echo "<p class='text-gray-600'>LKR " . $row['Price'] . "</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    echo "<p class='text-gray-500'>No products found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Ladies' Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-4 text-center">Ladies'</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php
                if ($ladies->num_rows > 0) {
                    while ($row = $ladies->fetch_assoc()) {
                        echo "<a href='product.php?name=" . urlencode($row['Name']) . "' class='block'>";
                        echo "<div class='bg-white p-4 text-center flex flex-col items-center'>";
                        echo "<img src='" . $row['ImageUrl'] . "' alt='" . $row['Name'] . "' class='h-40 w-40 object-cover mb-4 rounded'>";
                        echo "<p class='text-gray-800 font-medium'>" . $row['Name'] . "</p>";
                        echo "<p class='text-gray-600'>LKR " . $row['Price'] . "</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    echo "<p class='text-gray-500'>No products found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-10">
        <div class="container mx-auto px-4">
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
