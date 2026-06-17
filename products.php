<?php
require_once 'config.php';

$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$search = isset($_GET['search']) ? $db->real_escape_string($_GET['search']) : '';

$query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.status = 'active'";

if ($category_id) {
    $query .= " AND p.category_id = $category_id";
}

if ($search) {
    $query .= " AND p.name LIKE '%$search%'";
}

$result = $db->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);

// Get categories for filter
$cat_query = "SELECT * FROM categories";
$cat_result = $db->query($cat_query);
$categories = $cat_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo SITE_NAME; ?></title>
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
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">All Products</h2>

            <!-- Search & Filter -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo $search; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <select class="form-select" onchange="window.location.href='products.php?category=' + this.value">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($category_id == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo $cat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card card h-100 shadow-sm">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <small class="text-muted"><?php echo $product['category_name']; ?></small>
                                <h5 class="card-title mt-2"><?php echo $product['name']; ?></h5>
                                <p class="card-text text-muted"><?php echo substr($product['description'], 0, 60); ?>...</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <?php if ($product['discount_price']): ?>
                                            <span class="text-muted"><del><?php echo CURRENCY_SYMBOL; echo $product['price']; ?></del></span>
                                            <h6 class="text-danger"><?php echo CURRENCY_SYMBOL; echo $product['discount_price']; ?></h6>
                                        <?php else: ?>
                                            <h6><?php echo CURRENCY_SYMBOL; echo $product['price']; ?></h6>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm mt-3 w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">No products found.</div>
                    </div>
                <?php endif; ?>
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
