<?php
include 'db_connect.php';

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM products WHERE ProductId = $delete_id";
    if ($conn->query($delete_sql)) {
        echo "<script>alert('Product deleted successfully!');</script>";
        echo "<script>window.location = 'admin.php';</script>";
    } else {
        echo "<script>alert('Failed to delete product!');</script>";
    }
}

// Fetch products
$product = "SELECT * FROM products";
$allProduct = $conn->query($product);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex flex-wrap justify-between items-center">
        <!-- Logo -->
        <div class="text-lg font-bold mb-4 sm:mb-0 w-full sm:w-auto text-center sm:text-left">
            E-commerce Admin
        </div>
        
        <!-- Navigation Links -->
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto text-center sm:justify-end">
            <a href="admin.php" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded w-full sm:w-auto">
                Products
            </a>
            <a href="orders.php" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded w-full sm:w-auto">
                Orders
            </a>
            <a href="add_product.php" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded w-full sm:w-auto">
                Add Product
            </a>
        </div>
    </div>
</nav>


    <!-- Main Content -->
    <div class="container mx-auto my-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            if ($allProduct->num_rows > 0) {
                while ($row = $allProduct->fetch_assoc()) {
                    echo '<div class="bg-white shadow p-4 rounded">';
                    echo '<img src="' . $row['ImageUrl'] . '" alt="Product" class="h-40 w-full object-cover mb-4">';
                    echo '<div class="text-center font-bold mb-2">' . $row['Name'] . '</div>';
                    echo '<div class="flex flex-col sm:flex-row justify-center items-center gap-2 mt-4">';
                    echo '<a href="update.php?id=' . $row['ProductId'] . '" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 w-full sm:w-auto text-center">Update</a>';
                    echo '<a href="admin.php?delete_id=' . $row['ProductId'] . '" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 w-full sm:w-auto text-center" onclick="return confirm(\'Are you sure you want to delete this product?\')">Remove</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-gray-500 col-span-4 text-center">No products available</p>';
            }
            ?>
        </div>
    </div>

    <footer class="bg-gray-200 text-center lg:text-left h-[260px] mb-0">
        <div class="max-w-7xl mx-auto py-10">
            <div class="flex flex-col sm:flex-row justify-between text-sm text-gray-800">
                <!-- Quick Links -->
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
                        <span class="block w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs" onclick="window.open('https://www.instagram.com/louisvuitton/')">
                            <img src="https://i.pinimg.com/474x/1e/d6/e0/1ed6e0a9e69176a5fdb7e090a1046b86.jpg" alt="instagram logo">
                        </span>
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
