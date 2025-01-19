<?php
// Include the database connection file
include 'db_connect.php';

// Handle form submission to update the status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'], $_POST['status'])) {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['status'];

    // Update the order status in the database
    $stmt = $conn->prepare("UPDATE orders SET OrderStatus = ? WHERE OrderId = ?");
    $stmt->bind_param("si", $newStatus, $orderId);

    if ($stmt->execute()) {
        $message = "Order status updated successfully!";
    } else {
        $message = "Failed to update order status.";
    }

    $stmt->close();
}

// Fetch orders with relevant data
$sql = "SELECT orders.OrderId, orders.OrderedDate, orders.DeliveryAddress, 
               orders.OrderStatus, customers.PhoneNumber, products.Name AS ProductName 
        FROM orders
        JOIN customers ON orders.CustomerId = customers.CustomerId
        JOIN products ON orders.ProductId = products.ProductId";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="container mx-auto bg-white p-5 rounded shadow">
        <h1 class="text-2xl font-bold mb-5">Orders</h1>

        <!-- Display message if available -->
        <?php if (isset($message)): ?>
            <div class="mb-5 p-4 text-white bg-green-500 rounded">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2 text-left">Order ID</th>
                        <th class="border border-gray-300 p-2 text-left">Date</th>
                        <th class="border border-gray-300 p-2 text-left">Product Name</th>
                        <th class="border border-gray-300 p-2 text-left">Address</th>
                        <th class="border border-gray-300 p-2 text-left">Phone Number</th>
                        <th class="border border-gray-300 p-2 text-left">Status</th>
                        <th class="border border-gray-300 p-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='odd:bg-white even:bg-gray-100'>";
                            echo "<td class='border border-gray-300 p-2'>" . $row['OrderId'] . "</td>";
                            echo "<td class='border border-gray-300 p-2'>" . $row['OrderedDate'] . "</td>";
                            echo "<td class='border border-gray-300 p-2'>" . $row['ProductName'] . "</td>";
                            echo "<td class='border border-gray-300 p-2'>" . $row['DeliveryAddress'] . "</td>";
                            echo "<td class='border border-gray-300 p-2'>" . $row['PhoneNumber'] . "</td>";
                            echo "<td class='border border-gray-300 p-2'>";
                            echo "<form method='POST' action=''>
                                    <input type='hidden' name='orderId' value='" . $row['OrderId'] . "'>
                                    <select name='status' class='border border-gray-300 rounded p-2 w-full sm:w-auto'>
                                        <option value='Pending'" . ($row['OrderStatus'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='Processing'" . ($row['OrderStatus'] == 'Processing' ? ' selected' : '') . ">Processing</option>
                                        <option value='Shipped'" . ($row['OrderStatus'] == 'Shipped' ? ' selected' : '') . ">Shipped</option>
                                        <option value='Delivered'" . ($row['OrderStatus'] == 'Delivered' ? ' selected' : '') . ">Delivered</option>
                                        <option value='Cancelled'" . ($row['OrderStatus'] == 'Cancelled' ? ' selected' : '') . ">Cancelled</option>
                                    </select>
                                  </td>";
                            echo "<td class='border border-gray-300 p-2 text-center'>
                                    <button type='submit' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600'>Update</button>
                                  </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='border border-gray-300 p-2 text-center'>No orders found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
