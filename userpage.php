<?php
$conn = mysqli_connect("localhost","root","","ecstore");
$query = "SELECT * FROM ecommerce";
$result = mysqli_query($conn,$query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-white shadow-md sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-purple-600">MyStore</h1>
      <nav class="space-x-6">
        <a href="userpage.php" class="text-gray-600 hover:text-purple-600 font-medium">Home</a>
        <a href="#" class="text-gray-600 hover:text-purple-600 font-medium">Products</a>
        <a href="cart.php" class="relative inline-flex items-center text-gray-600 hover:text-purple-600 font-medium">
          🛒 Cart
          <span class="absolute -top-2 -right-3 bg-purple-600 text-white text-xs px-2 py-0.5 rounded-full">0</span>
        </a>
      </nav>
    </div>
  </header>

  <!-- Products -->
  <main class="max-w-6xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <?php foreach($data as $row): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
          <!-- Fixed Image Box -->
          <div class="w-full h-56 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img src="productimage/<?php echo htmlspecialchars($row['image']); ?>" 
                 alt="Product Image" 
                 class="w-full h-full object-cover">
          </div>
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-1">
              <?php echo htmlspecialchars($row['pname']); ?>
            </h3>
            <p class="text-purple-600 font-semibold mb-3">$<?php echo htmlspecialchars($row['price']); ?></p>
            <div class="flex justify-between">
              <a href="<?php echo htmlspecialchars($row['link']); ?>" 
                 class="bg-purple-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-purple-700 transition" target = "_blank">
                Buy Now
              </a>
              <form action="cart.php" method="post">
             <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <input type="hidden" name="pname" value="<?php echo htmlspecialchars($row['pname']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
            <input type="hidden" name="image" value="<?php echo htmlspecialchars($row['image']); ?>">
             <button type="submit" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-300 transition">
                        Add to Cart
                    </button>
                  </form>

           </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

</body>
</html>
