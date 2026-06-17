<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'zrylio_store');

// Site Configuration
define('SITE_NAME', 'ZRYLiO Store');
define('SITE_URL', 'http://localhost/ZRYLIO-Store/');
define('ADMIN_URL', SITE_URL . 'admin/');

// Currency
define('CURRENCY', 'BDT');
define('CURRENCY_SYMBOL', '৳');

// Shipping Countries
define('SHIPPING_COUNTRIES', array('Bangladesh', 'Italy'));

// Database Connection
try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $db->set_charset("utf8");
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

// Session Start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
