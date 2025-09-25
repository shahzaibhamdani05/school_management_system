<?php

session_start();

/*
  1) ADD ITEM (from products form POST)
     products form posts: id, pname, price, image
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id    = intval($_POST['id']);               // force integer
    $pname = trim($_POST['pname']);              // trim whitespace
    $price = floatval($_POST['price']);          // numeric price
    $image = isset($_POST['image']) ? $_POST['image'] : '';

    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    // if already in cart -> increment qty, otherwise add new item
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = [
            'id'    => $id,
            'pname' => $pname,
            'price' => $price,
            'image' => $image,
            'qty'   => 1
        ];
    }

    // redirect to avoid duplicate add on refresh
    header("Location: cart.php");
    exit;
}

/*
  2) REMOVE single item via GET: ?remove=ID
*/
if (isset($_GET['remove'])) {
    $rid = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$rid])) {
        unset($_SESSION['cart'][$rid]);
    }
    header("Location: cart.php");
    exit;
}

/*
  3) CLEAR entire cart via GET: ?action=clear
*/
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

/*
  4) UPDATE quantities (form POST with name="qty[ID]")
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $q) {
            $id = intval($id);
            $q  = max(1, intval($q)); // enforce at least 1
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['qty'] = $q;
            }
        }
    }
    header("Location: cart.php");
    exit;
}

/* Prepare cart data for display */
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$grandTotal = 0;
$totalItems = 0;
foreach ($cart as $item) {
    $grandTotal += $item['price'] * $item['qty'];
    $totalItems += $item['qty'];
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-start justify-center p-8">
  <div class="w-full max-w-4xl">

    <div class="bg-white p-6 rounded-lg shadow mb-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">🛒 My Cart</h1>
        <div class="text-sm text-gray-600">Items: <?php echo $totalItems; ?></div>
      </div>
    </div>

    <?php if (empty($cart)): ?>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <p class="mb-4">Your cart is empty.</p>
        <a href="userpage.php" class="px-4 py-2 bg-purple-600 text-white rounded">Continue Shopping</a>
      </div>
    <?php else: ?>
      <form method="post" class="bg-white p-6 rounded-lg shadow">
        <table class="w-full mb-4">
          <thead>
            <tr class="text-left text-sm text-gray-600">
              <th>Product</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart as $c): 
              $subtotal = $c['price'] * $c['qty'];
            ?>
              <tr class="border-t">
                <td class="py-3">
                  <div class="flex items-center gap-3">
                    <?php if (!empty($c['image'])): ?>
                      <img src="productimage/<?php echo htmlspecialchars($c['image']); ?>" alt="" class="w-16 h-12 object-cover rounded">
                    <?php endif; ?>
                    <div>
                      <div class="font-semibold"><?php echo htmlspecialchars($c['pname']); ?></div>
                    </div>
                  </div>
                </td>
                <td class="py-3"><?php echo number_format($c['price'], 2); ?></td>
                <td class="py-3">
                  <input type="number" name="qty[<?php echo $c['id']; ?>]" value="<?php echo $c['qty']; ?>" min="1" class="w-20 border rounded px-2 py-1">
                </td>
                <td class="py-3"><?php echo number_format($subtotal, 2); ?></td>
                <td class="py-3">
                  <a href="cart.php?remove=<?php echo $c['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Remove this item?')">Remove</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="flex justify-between items-center">
          <div>
            <button type="submit" name="update" class="px-4 py-2 bg-indigo-600 text-white rounded mr-3">Update Cart</button>
            <a href="cart.php?action=clear" onclick="return confirm('Clear cart?')" class="px-4 py-2 bg-red-500 text-white rounded">Clear Cart</a>
          </div>
          <div class="text-right">
            <div class="text-gray-600">Grand Total</div>
            <div class="text-2xl font-bold">Rs <?php echo number_format($grandTotal, 2); ?></div>
          </div>
        </div>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>

