<?php
// Include the database connection file
include('db_connect.php');

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL queries to check in Admins and Customers tables
    $customerQuery = $conn->prepare("SELECT * FROM Customers WHERE Email = ? AND Password = ?");
    $customerQuery->bind_param("ss", $email, $password);
    $customerQuery->execute();
    $customerResult = $customerQuery->get_result();

    // Check if the user exists as a customer
    if ($customerResult->num_rows > 0) {
        $userData = $customerResult->fetch_assoc();
        
        // Store user details in session
        $_SESSION['user_id'] = $userData['CustomerId'];
        $_SESSION['first_name'] = $userData['FirstName'];
        $_SESSION['last_name'] = $userData['LastName'];
        $_SESSION['email'] = $userData['Email'];

        // Redirect to the index.php page
        header("Location: index.php");
        exit();
    } else {
        // Display error if no matching records are found
        echo "<script>alert('Invalid email or password!'); window.location.href = 'signin.php';</script>";
    }

    $customerQuery->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-80">
      <h1 class="text-2xl font-bold text-center mb-6">Sign In</h1>
      <!-- Display error message -->
      <?php if (!empty($error)): ?>
        <div class="mb-4 text-red-600 text-sm text-center"><?php echo $error; ?></div>
      <?php endif; ?>
      <form action="signin.php" method="POST">
        <div class="mb-4">
          <label
            for="email"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Email</label
          >
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            class="w-full px-4 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label
            for="password"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Password</label
          >
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>

        <button
          type="submit"
          class="w-full bg-gray-600 text-white py-2 rounded-md hover:bg-gray-700"
        >
          Sign In
        </button>
      </form>
      <a
        href="signup.php"
        class="block text-center text-sm text-gray-800 mt-4 hover:underline"
        >Don't have an account? Sign up!</a
      >
    </div>
  </body>
</html>
