<?php
session_start();

// Validate and process the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $requiredFields = ['fullname', 'street', 'suburb', 'state', 'country', 'postcode', 'email', 'phone'];
    $errors = [];
    
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required";
        }
    }
    
    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate phone (Australian format)
    if (!preg_match('/^(\+?61|0)[2-478](?:[ -]?[0-9]){8}$/', $_POST['phone'])) {
        $errors[] = "Invalid Australian phone number";
    }
    
    // If no errors, process the order
    if (empty($errors)) {
        // Database connection
        $connection = mysqli_connect('localhost', 'root', '', 'assignment1');
        
        // Save customer information
        $query = "INSERT INTO orders (fullname, street, suburb, state, country, postcode, email, phone, payment_method, total) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        mysqli_stmt_bind_param($stmt, 'customerdata', 
            $_POST['fullname'],
            $_POST['street'],
            $_POST['suburb'],
            $_POST['state'],
            $_POST['country'],
            $_POST['postcode'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['payment_method'],
            $total
        );
        
        mysqli_stmt_execute($stmt);
        $orderId = mysqli_insert_id($connection);
        
        // Save order items
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'iiid', $orderId, $product_id, $item['quantity'], $item['price']);
            mysqli_stmt_execute($stmt);
            
            // Update product stock
            $query = "UPDATE products SET in_stock = in_stock - ? WHERE product_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $item['quantity'], $product_id);
            mysqli_stmt_execute($stmt);
        }
        
        mysqli_close($connection);
        
        // Clear the cart and redirect to confirmation
        unset($_SESSION['cart']);
        header("Location: confirmation.php?order_id=$orderId");
        exit();
    } else {
        // Show errors
        $_SESSION['checkout_errors'] = $errors;
        header("Location: checkout.php");
        exit();
    }
} else {
    // Not a POST request, redirect to checkout
    header("Location: checkout.php");
    exit();
}