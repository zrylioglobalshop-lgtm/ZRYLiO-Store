<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$query = "SELECT c.*, p.name, p.price, p.discount_price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
$result = $db->query($query);
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $price = $item['discount_price'] ? $item['discount_price'] : $item['price'];
    $total += $price * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><?php echo SITE_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="customer-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">Shopping Cart</h2>

            <?php if (count($cart_items) > 0): ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <?php $price = $item['discount_price'] ? $item['discount_price'] : $item['price']; ?>
                                        <tr>
                                            <td><?php echo $item['name']; ?></td>
                                            <td><?php echo CURRENCY_SYMBOL; echo $price; ?></td>
                                            <td>
                                                <input type="number" class="form-control" style="width: 60px;" value="<?php echo $item['quantity']; ?>" min="1">
                                            </td>
                                            <td><?php echo CURRENCY_SYMBOL; echo ($price * $item['quantity']); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-danger">Remove</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Order Summary</h5>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span><?php echo CURRENCY_SYMBOL; echo $total; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span><?php echo CURRENCY_SYMBOL; echo 100; ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h5>Total:</h5>
                                    <h5><?php echo CURRENCY_SYMBOL; echo ($total + 100); ?></h5>
                                </div>
                                <a href="checkout.php" class="btn btn-primary w-100 mt-3">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Your cart is empty. <a href="products.php">Continue shopping</a></div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 ZRYLiO Store. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
