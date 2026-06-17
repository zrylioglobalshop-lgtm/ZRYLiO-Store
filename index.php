<?php
require_once 'config.php';

// Fetch Featured Products
$query = "SELECT * FROM products WHERE status = 'active' LIMIT 6";
$result = $db->query($query);
$featured_products = $result->fetch_all(MYSQLI_ASSOC);

// Fetch Categories
$cat_query = "SELECT * FROM categories";
$cat_result = $db->query($cat_query);
$categories = $cat_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Home</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="customer-dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section bg-gradient text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Welcome to ZRYLiO Store</h1>
            <p class="lead">Best E-Commerce Platform for Electronics, Fashion & More</p>
            <a href="products.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Browse Categories</h2>
            <div class="row g-4">
                <?php foreach ($categories as $cat): ?>
                <div class="col-md-4">
                    <div class="category-card card h-100 shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $cat['name']; ?></h5>
                            <p class="card-text"><?php echo substr($cat['description'], 0, 50); ?>...</p>
                            <a href="products.php?category=<?php echo $cat['id']; ?>" class="btn btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row g-4">
                <?php foreach ($featured_products as $product): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 shadow-sm">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text text-muted"><?php echo substr($product['description'], 0, 50); ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <?php if ($product['discount_price']): ?>
                                        <span class="text-muted"><del><?php echo CURRENCY_SYMBOL; echo $product['price']; ?></del></span>
                                        <h6 class="text-danger"><?php echo CURRENCY_SYMBOL; echo $product['discount_price']; ?></h6>
                                    <?php else: ?>
                                        <h6><?php echo CURRENCY_SYMBOL; echo $product['price']; ?></h6>
                                    <?php endif; ?>
                                </div>
                                <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
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
