<?php
include 'db_connect.php';

// Debug: Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    echo "Product ID received: " . htmlspecialchars($productId);
} else {
    echo "No product ID provided!";
    exit; // Stop execution if no ID is provided
}

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE ProductId = $productId";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "<script>alert('Product not found!');</script>";
    echo "<script>window.location = 'admin.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $productId = $_POST['productId'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $imageUrl = $_POST['imageUrl'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $category = $_POST['category'];
    $subCategory = $_POST['subCategory'];

    // Update the product details in the database
    $updateSql = "UPDATE products 
                  SET Name = '$name', 
                      Description = '$description', 
                      ImageUrl = '$imageUrl', 
                      Price = $price, 
                      StockQuantity = $stockQuantity, 
                      Category = '$category', 
                      SubCategory = '$subCategory' 
                  WHERE ProductId = $productId";

    if ($conn->query($updateSql)) {
        echo "<script>alert('Product updated successfully!');</script>";
        echo "<script>window.location = 'admin.php';</script>";
    } else {
        echo "<script>alert('Failed to update product: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="update.php?id=<?php echo $productId; ?>" method="POST">
        <input type="hidden" name="productId" value="<?php echo $product['ProductId']; ?>">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $product['Name']; ?>" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?php echo $product['Description']; ?></textarea>
        </div>
        <div>
            <label for="imageUrl">Image URL</label>
            <input type="url" id="imageUrl" name="imageUrl" value="<?php echo $product['ImageUrl']; ?>">
        </div> 
        <div>
            <label for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['Price']; ?>" required>
        </div>
        <div>
            <label for="stockQuantity">Stock Quantity</label>
            <input type="number" id="stockQuantity" name="stockQuantity" value="<?php echo $product['StockQuantity']; ?>" required>
        </div>
        <div>
            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="<?php echo $product['Category']; ?>">
        </div>
        <div>
            <label for="subCategory">Sub-Category</label>
            <input type="text" id="subCategory" name="subCategory" value="<?php echo $product['SubCategory']; ?>">
        </div>
        <button type="submit" name="update_product">Update Product</button>
    </form>
</body>
</html>
