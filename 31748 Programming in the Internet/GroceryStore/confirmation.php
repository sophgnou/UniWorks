<?php
session_start();

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$orderId = $_GET['order_id'];
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
<header>
        <nav class="navbar">
            <a href="index.php" class="logo"><i class="material-icons logo">storefront</i></a>
            <a href="index.php" class="home active"><i class="material-icons">home</i> Home</a>
            <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
            <div class="dropdown">
                <button class="dropbtn" onClick="toggleNav()" aria-expanded="false" aria-controls="contentDown">
                    <i class="material-icons">arrow_drop_down_circle</i> Categories
                </button>
                <div class="dropcontent" id="contentDown">
                    <a href="index.php?category=frozen">Frozen</a>
                    
                    <div class="submenu">
                        <a href="#">Fresh ▸</a>
                        <div class="submenu-cont">
                            <a href="index.php?category=meat">Meat</a>
                            <a href="index.php?category=fruits">Fruits</a>
                            <a href="index.php?category=dairy">Dairy</a>
                        </div>
                    </div>
                    
                    <a href="index.php?category=beverages">Beverages</a>
                    <a href="index.php?category=snacks">Snacks</a>
                    
                    <div class="submenu">
                        <a href="#">Household ▸</a>
                        <div class="submenu-cont">
                            <a href="index.php?category=health">Health Care</a>
                            <a href="index.php?category=home">Home Supplies</a>
                            <a href="index.php?category=pet">Pet Items</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        </header>

    <main>
        <div class="confirmation-container">
            <h1>Order Confirmation</h1>
            <div class="confirmation-message">
                <i class="material-icons">check_circle</i>
                <h2>Thank you for your order!</h2>
                <p>Your order #<?= htmlspecialchars($orderId) ?> has been received and is being processed.</p>
                <p>A confirmation email has been sent to your email address.</p>
            </div>
            
            <div class="confirmation-actions">
                <a href="index.php" class="continue-shopping">Continue Shopping</a>
                <a href="order_details.php?order_id=<?= $orderId ?>" class="view-order">View Order Details</a>
            </div>
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
        <script src="js/add-to-cart.js"></script>
</footer>
</body>
</html>