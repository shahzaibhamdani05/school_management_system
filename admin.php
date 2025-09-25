<?php
$msg = "";
if($_SERVER["REQUEST_METHOD"]=="POST"):
    $pname =$_POST["pname"];
    $price = $_POST["price"];
    $link = $_POST["link"];

    $image = $_FILES["image"]["name"];
    $temp_name = $_FILES ["image"]["tmp_name"];
    $file_uploaded = move_uploaded_file($temp_name,"productimage/".$image);


    $conn = mysqli_connect("localhost","root","","ecstore");
    $query ="INSERT INTO ecommerce (pname,price,image,link) VALUES ('$pname','$price','$image','$link')";
    $result = mysqli_query($conn,$query);
    if($result){
        $msg = "<p class = 'font-bold text-green-600'>Product Post Sucessfully </p>";
    
         
    }else{
        $msg = "<p class = 'font-bold text-red-600'> Something Wrong " . mysqli_error($conn) . " </p>" ;
    }
endif;
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-3xl font-extrabold text-gray-800 text-center mb-6">Add New Product</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
      
      <div>
        <label class="block text-gray-700 font-medium mb-1">Product Name</label>
        <input type="text" name="pname" placeholder="Product Name" required
          class="w-full px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Price</label>
        <input type="text" name="price" placeholder="Price" required
          class="w-full px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Product Image</label>
        <input type="file" name="image"
          class="w-full text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700
                 hover:file:bg-purple-200 cursor-pointer">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Affiliate Link</label>
        <input type="text" name="link" placeholder="Product Link" required
          class="w-full px-4 py-2 border rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
      </div>

      <div>
        <input type="submit" value="Add Product"
          class="w-full bg-purple-600 text-white py-3 rounded-xl text-lg font-semibold shadow-md 
                 hover:bg-purple-700 transition cursor-pointer">
      </div>
      <div><?php echo $msg ?></div>

    </form>
  </div>

</body>
</html>
