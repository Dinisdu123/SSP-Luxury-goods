<?php
// Include the database connection file
include 'db_connect.php';

// Fetch jwelleries
$sql_mens = "SELECT Name, Price, ImageUrl From Products Where Category = 'accesories' and SubCategory = 'jwelleries'";
$mens = $conn->query($sql_mens);

//Fetch footwear
$sql_ladies = "SELECT Name, Price, ImageUrl FROM Products WHERE Category = 'accesories' AND SubCategory = 'footwear'";

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
                <a href="myprofile.php">
                    <img src="images/profile icon.png" alt="" class="w-6 h-6 hover:opacity-75">
                </a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-8">
        <!-- Jewelleries Section -->
        <div>
            <h2 class="text-2xl font-bold text-center mb-6">Jewelleries</h2>
            <div class="flex flex-wrap justify-center gap-6">
            <?php
            if ($mens->num_rows > 0) {
                while ($row = $mens->fetch_assoc()) {
                $productIdentifier = urlencode($row['Name']);
            echo '
                <div class="bg-white rounded-lg shadow-lg p-4 w-64">
                <a href="product.php?name=' . $productIdentifier . '">
                    <img src="' . $row['ImageUrl'] . '" alt="' . $row['Name'] . '" class="w-full h-48 object-cover rounded-t-md">
                </a>
                <h3 class="text-lg font-medium mt-4">' . $row['Name'] . '</h3>
                <p class="text-gray-600 mt-2">$' . $row['Price'] . '</p>
                <button class="mt-4 bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800">
                    Add to cart
                </button>
        </div>';
    }
} else {
    echo '<p class="text-gray-500">No products found in this category.</p>';
}
?>


            </div>
        </div>
        <!-- Footwear Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-center mb-6">Footwear</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <?php
                if ($ladies->num_rows > 0) {
                    while ($row = $ladies->fetch_assoc()) {
                        // Use 'Name' as the unique identifier
                        $productIdentifier = urlencode($row['Name']);
                        echo '
                        <div class="bg-white rounded-lg shadow-lg p-4 w-64">
                            <a href="product.php?name=' . $productIdentifier . '">
                                <img src="' . $row['ImageUrl'] . '" alt="' . $row['Name'] . '" class="w-full h-48 object-cover rounded-t-md">
                            </a>
                            <h3 class="text-lg font-medium mt-4">' . $row['Name'] . '</h3>
                            <p class="text-gray-600 mt-2">$' . $row['Price'] . '</p>
                            <button class="mt-4 bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800">
                                Add to cart
                            </button>
                        </div>';
                    }
                } else {
                    echo '<p class="text-gray-500">No products found in this category.</p>';
                }
                ?>
            </div>
        </div>
</body>
</html>