<?php
// Include the database connection file
include('db_connect.php');

// Initialize variables for error and success messages
$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate input
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $checkEmailQuery = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
        $checkEmailQuery->bind_param("s", $email);
        $checkEmailQuery->execute();
        $emailResult = $checkEmailQuery->get_result();

        if ($emailResult->num_rows > 0) {
            $error = "Email is already registered!";
        } else {
            // Insert user into the Customers table
            $insertQuery = $conn->prepare("INSERT INTO Customers (Email, Password, Address, FirstName, LastName, PhoneNumber) VALUES (?, ?, '', ?, ?, '')");
            $insertQuery->bind_param("ssss", $email, $password, $firstName, $lastName);

            if ($insertQuery->execute()) {
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Failed to register. Please try again.";
            }

            $insertQuery->close();
        }

        $checkEmailQuery->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold text-center mb-6">Sign Up</h1>
        <!-- Display error or success message -->
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600 text-sm text-center"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="mb-4 text-green-600 text-sm text-center"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="signup.php" method="POST">
            <!-- First Name and Last Name -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input 
                        type="text" 
                        id="first-name" 
                        name="first_name" 
                        placeholder="First Name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>
                <div>
                    <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input 
                        type="text" 
                        id="last-name" 
                        name="last_name" 
                        placeholder="Last Name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Enter your email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required
                >
            </div>

            <!-- Password and Confirm Password -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm-password" 
                        name="confirm_password" 
                        placeholder="Confirm Password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-gray-600 text-white py-2 rounded-md hover:bg-gray-700 focus:ring-2 focus:ring-gray-400 focus:outline-none"
            >
                Sign Up
            </button>
        </form>
    </div>
</body>
</html>
