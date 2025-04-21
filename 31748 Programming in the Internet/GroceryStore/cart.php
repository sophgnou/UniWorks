<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'assignment1');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch products
$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);

// Check if query succeeded
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
} 

// Initialize variables
$products = [];
$searchQuery = "";
/*
$keywords = $_REQUEST['search'];
$query_string = "select * FROM products WHERE product_name LIKE '%$keywords%'";
$num_rows = mysqli_query( $connection, $query_string);

if ($num_rows > 0) {
    print "<table border='0'>";
    while ($row = mysqli_fetch_assoc(result: $result)) {
        echo "<tr>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['unit_price'] . "</td>";
        echo "</tr>";
    }
    print "</table>";
}
*/

// Close connection (optional, PHP will close it automatically when script ends)
mysqli_close($connection);
?> 


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Grocery Store</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="grocerystore" content="assessment 1" />
        <link rel="stylesheet" href="styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>

    <body>
        <!-- somehow putting the logo and aligning it to the nav bar is really hard, so this is the method that works for me -->
         <!-- how tf do I do the toggle function -->
        <header>
            <nav class="navbar">
                <a href="index.php" class="logo"><i class="material-icons logo">storefront</i></a>
                <a href="index.html" class="home active"><i class="material-icons">home</i> Home</a>
                <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
                <div class="dropdown">
                    <button data-toggle-nav class="dropbtn" onClick="toggleNav()"><i class="material-icons">arrow_drop_down_circle</i> Categories</button>
                <div class="dropcontent" id="contentDown">
                        <a href="#">Frozen</a>
                        <a href="#">Meat</a>
                        <a href="#">Drinks</a>
                        <a href="#">Dairy Product</a>
                        <a href="#">Health Care</a>
                        <a href="#">Home Supplies</a>
                        <a href="#">Pet Items</a>
                </div>
            </nav>
        </header>

        <main>
            <div class="page-text">
                <h1>Your Shopping Cart</h1>
            </div>

            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="cart-item">
                        <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p>Price: $<?= number_format($item['price'], 2) ?></p>
                            <p>Quantity: <?= $item['quantity'] ?></p>
                            <p>Subtotal: $<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                            <button class="remove-from-cart" data-product-id="<?= $id ?>">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        
            <div class="cart-total">
                <h2>Total: $<?= number_format(
                    array_sum(array_map(
                        function($item) { return $item['price'] * $item['quantity']; },
                        $_SESSION['cart']
                    )),
                    2
                ) ?></h2>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        </main>


        <footer>
            <!-- contact details & uni student deetails -->
            <h2>Contact</h2>
            <ul>
                <li>123 Fake Street, Suburb, State, Country 1234</li>
                <li>XXXX-XXX-XXX</li>
                <li><a href="" id="linkedin">Linkedin</a></li>
            </ul>
            <p id="copyright"><i class="material-icons link">copyright</i> 2025 Sophie Gnoukhanthone 14241994</p>
        </footer>
        <script src="js/togglenav.js"></script>
    </body>
</html>