<?php
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch dashboard statistics
$total_products = $db->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_orders = $db->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_users = $db->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_revenue = $db->query("SELECT SUM(total_amount) as sum FROM orders WHERE payment_status = 'completed'")->fetch_assoc()['sum'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-dark text-white p-4" style="min-height: 100vh;">
                <h4 class="mb-4">Admin Panel</h4>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="index.php" class="text-white text-decoration-none">Dashboard</a></li>
                    <li class="mb-3"><a href="products.php" class="text-white text-decoration-none">Products</a></li>
                    <li class="mb-3"><a href="orders.php" class="text-white text-decoration-none">Orders</a></li>
                    <li class="mb-3"><a href="users.php" class="text-white text-decoration-none">Users</a></li>
                    <li class="mb-3"><a href="logout.php" class="text-white text-decoration-none">Logout</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <h1 class="mb-4">Dashboard</h1>

                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <h2><?php echo $total_products; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <h2><?php echo $total_orders; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <h2><?php echo $total_users; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Revenue</h5>
                                <h2><?php echo CURRENCY_SYMBOL; echo number_format($total_revenue); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
