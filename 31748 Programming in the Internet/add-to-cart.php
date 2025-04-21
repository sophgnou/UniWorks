<?php
session_start();

// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'assignment1');
if (!$connection) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// Get product details
$productId = $_POST['product_id'] ?? null;
$action = $_POST['action'] ?? 'add';

if (!$productId) {
    die(json_encode(['success' => false, 'error' => 'No product specified']));
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add/remove actions
if ($action === 'add') {
    // Check if product exists in database
    $query = "SELECT * FROM products WHERE product_id = $productId";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Add to cart or increment quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['product_name'],
                'price' => $product['unit_price'],
                'quantity' => 1,
                'image' => 'images/product_' . $productId . '.jpg'
            ];
        }
        
        echo json_encode([
            'success' => true,
            'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Product not found']);
    }
}

mysqli_close($connection);
?>