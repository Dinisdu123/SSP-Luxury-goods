<?php
  include 'db_connect.php';
  $sql = "SELECT * FROM Products WHERE SubCategory LIKE '%New Arrivals%'";
  $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aurora Luxe</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white text-black">
    <nav class="flex items-center justify-between p-4 border-b border-black">
      <div class="flex space-x-8">
        <a href="leatherGoods.php" class="hover:text-gray-500">Leather goods</a>
        <a href="Fragraance.php" class="hover:text-gray-500">Fragrances</a>
        <a href="accesories.php" class="hover:text-gray-500">Accessories</a>
      </div>
      <div class="flex items-center space-x-6">
        <span class="text-4xl font-serif">Aurora Luxe</span>
        <div class="flex space-x-4 items-center">
          <a href="#">
            <img
              src="images/cart.png"
              alt="cart Icon"
              class="w-6 h-6 ml-20 hover:opacity-75"
            />
          </a>
          <a href="myprofile.php">
            <img
              src="images/profile icon.png"
              alt="Profile Icon"
              class="w-8 h-8 hover:opacity-85"
            />
          </a>
        </div>
      </div>
    </nav>
    <div>
      <img
        src="https://montaka.com/wp-content/uploads/elementor/thumbs/Luxury-resale-cover-scaled-2-pxem0mlp1o9yp0fp4a4ag4tvp9i9qobk1snu58yt0w.jpg"
        alt="cover page"
        class="w-[1390px] mt-4 ml-5 mr-5"
      />
      <h2 class="text-4xl text-center font-ariel mt-10">New arrivels</h2>
    </div>
    <!-- New arrivals -->
    <div class="container mx-auto p-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<div class="bg-white shadow-md rounded-lg overflow-hidden">';
                  echo '<img class="w-full h-48 object-cover" src="' . $row['ImageUrl'] . '" alt="Product Image">';
                  echo '</div>';
                }
            } else {
                echo "<p class='text-center text-gray-600'>No new arrivals available.</p>";
            }
            ?>
        </div>
        <div class= "flex justify-center">
        <button class="bg-gray-500 text-white py-2 px-10 rounded ">See all</button>
        </div>
    </div>
    <div>

    
      <!-- paragraphy -->
      <h2 class="text-center">Experience True Luxury</h2>
      <br>
      <p class="w-[470px] text-center mx-auto">Luxury is more than a statement—it’s a way of life. Indulge in the finest craftsmanship, where every detail tells 
        a story of sophistication and elegance. From rare finds to timeless treasures, embrace the extraordinary and 
        elevate your lifestyle with unmatched exclusivity
      </p>
    </div>
    <br>
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
                    <li><a href="#" class="hover:underline">About us</a></li>
                </ul>
            </div>

            <!-- Categories  -->
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

<?php
$conn->close();
?>
