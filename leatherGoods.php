<?php
// Include the database connection file
include 'db_connect.php';

// Fetch dhouder bags
$sql_shoulderBag = "SELECT Name, Price, ImageUrl From Products Where Category = 'leather goods' and SubCategory = 'shoulder bags'";
$shoulderBag = $conn->query($sql_shoulderBag);

//Fetch minibags
$sql_miniBags = "SELECT Name, Price , ImageUrl From Products Where Category = 'leather goods' and SubCategory = 'minibags'";
$miniBags = $conn->query($sql_miniBags);

//Fetch backpacks
$sql_backpacks = "SELECT Name, Price , ImageUrl From Products Where Category = 'leather goods' and SubCategory = 'backpacks'";
$backpacks = $conn->query($sql_backpacks);

//Fetch wallets
$sql_wallets = "SELECT Name , Price , ImageUrl From Products Where Category = 'leather goods' and SubCategory = 'wallets'";
$wallets = $conn->query($sql_wallets);
?>

<DOCTYPE html>
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
          <a href="#">
            <img
              src="images/profile icon.png"
              alt="Profile Icon"
              class="w-8 h-8 hover:opacity-85"
            />
          </a>
        </div>
      </div>
    </nav>
    <!-- Product category -->
    <div class="grid grid-cols-4 mr-[130px] ml-[130px]">
        <div class="flex items-center justify-center"><img src ="https://cdn.mitchellstores.com/rails/active_storage/representations/proxy/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBMDhqQ0E9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--51fdac4dbed052160c89526d1513a53425169a0f/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaDdDam9MWm05eWJXRjBTU0lJYW5CbkJqb0dSVlE2QzNKbGMybDZaVWtpRHpJNE1EQjROREl3TUQ0R093WlVPZ3B6ZEhKcGNGUTZFR0YxZEc4dGIzSnBaVzUwVkRvTWNYVmhiR2wwZVVraUNEYzFKUVk3QmxRPSIsImV4cCI6bnVsbCwicHVyIjoidmFyaWF0aW9uIn19--2194f4ba90266e988b82b869a61bc64b50c6873c/uploading-1307082-jpg20221021-13-s9tgjr.jpg" alt="prada shooulder bag" class="w-[200px] h-[200px]"></div>
        <div class="flex items-center justify-center"><img src="https://cdn-images.farfetch-contents.com/25/76/87/10/25768710_55982729_480.jpg" alt="Mini bags" class="w-[200px] h-[200px]"></div>
        <div class="flex items-center justify-center"><img src="https://cdn-images.farfetch-contents.com/26/41/00/43/26410043_56000810_1000.jpg" alt="Backpacks" class="w-[200px] h-[200px]"></div>
        <div class="flex items-center justify-center"><img src="https://cdn-images.farfetch-contents.com/27/53/93/86/27539386_57294969_1000.jpg" alt="Wallets" class="w-[200px] h-[200px]"></div>
        <div class="flex items-center justify-center">Shoulder bag</div>
        <div class="flex items-center justify-center">Mini bag</div>
        <div class="flex items-center justify-center">Backpacks</div>
        <div class="flex items-center justify-center">Wallets</div>
    </div>
    <br>
    <hr>
    <br><br>
    <!-- product display - Shoulder bags -->
    <div>
        <h2 class="text-center text-2xl">Shoulder bags</h2>
        <div class="flex flex-wrap -mx-4">
        <?php
        if ($shoulderBag->num_rows > 0) {
            while ($row = $shoulderBag->fetch_assoc()) {
                ?>
                <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-4  flex items-center justify-center">
                    <div>
                        <img src="<?php echo $row['ImageUrl']; ?>" alt="<?php echo $row['Name']; ?>" class="w-48 h-48 mb-4 ">
                        <h3 class="text-lg font-semibold mb-2 text-center"><?php echo $row['Name']; ?></h3>
                        <p class="text-center">LKR <?php echo $row['Price']; ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>
    </div>
    <br><br>
    <!-- product display - mini bag -->
    <div>
        <h2 class="text-center text-2xl">Mini bag</h2>
        <div class="flex flex-wrap -mx-4">
        <?php
        if ($miniBags->num_rows > 0 ){
            while ($row = $shoulderBag->fetch_assoc()) {
                ?>
                <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-4  flex items-center justify-center">
                    <div>
                        <img src="<?php echo $row['ImageUrl']; ?>" alt="<?php echo $row['Name']; ?>" class="w-48 h-48 mb-4 ">
                        <h3 class="text-lg font-semibold mb-2 text-center"><?php echo $row['Name']; ?></h3>
                        <p class="text-center">LKR <?php echo $row['Price']; ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>
    </div>
    <!-- product display - backpacks -->
    <div>
        <h2 class="text-center text-2xl">Backpacks</h2>
        <div class="flex flex-wrap -mx-4">
        <?php
        if ($backpacks->num_rows > 0 ){
            while ($row = $backpacks->fetch_assoc()) {
                ?>
                <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-4  flex items-center justify-center">
                    <div>
                        <img src="<?php echo $row['ImageUrl']; ?>" alt="<?php echo $row['Name']; ?>" class="w-48 h-48 mb-4 ">
                        <h3 class="text-lg font-semibold mb-2 text-center"><?php echo $row['Name']; ?></h3>
                        <p class="text-center">LKR <?php echo $row['Price']; ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>
    </div>
    <!-- product display - wallets -->
    <div>
        <h2 class="text-center text-2xl">Wallets</h2>
        <div class="flex flex-wrap -mx-4">
        <?php
        if ($wallets->num_rows > 0 ){
            while ($row = $wallets->fetch_assoc()) {
                ?>
                <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-4  flex items-center justify-center">
                    <div>
                        <img src="<?php echo $row['ImageUrl']; ?>" alt="<?php echo $row['Name']; ?>" class="w-48 h-48 mb-4 ">
                        <h3 class="text-lg font-semibold mb-2 text-center"><?php echo $row['Name']; ?></h3>
                        <p class="text-center">LKR <?php echo $row['Price']; ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>
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
                    <li><a href="#" class="hover:underline">About us</a></li>
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

            