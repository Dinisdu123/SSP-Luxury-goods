<?php
// Include the database connection file
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $imageUrl = $_POST['imageUrl'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $category = $_POST['category'];
    $subCategory = $_POST['subCategory'];

    // Construct the SQL query
    $sql = "INSERT INTO products (Name, Description, ImageUrl, Price, StockQuantity, Category, SubCategory) 
            VALUES ('$name', '$description', '$imageUrl', '$price', '$stockQuantity', '$category', '$subCategory')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Add Product</h1>
        <form action="add_product.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full  border-gray-300 shadow-sm ">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="imageUrl" class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="url" id="imageUrl" name="imageUrl"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" id="price" name="price" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm ">
            </div>
            <div class="mb-4">
                <label for="stockQuantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                <input type="number" id="stockQuantity" name="stockQuantity" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" id="category" name="category"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm ">
            </div>
            <div class="mb-4">
                <label for="subCategory" class="block text-sm font-medium text-gray-700">Sub-Category</label>
                <input type="text" id="subCategory" name="subCategory"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit"
                class="w-full bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Add Product</button>
        </form>
    </div>
</body>
</html>
