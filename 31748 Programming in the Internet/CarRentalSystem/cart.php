<?php
session_start();

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

$totalCost = 0;

/*
// Handle remove from cart requests
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit();
}

// Handle quantity updates
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        if (isset($_SESSION['cart'][$product_id])) {
            $quantity = (int)$quantity;
            if ($quantity > 0 && $quantity <= $_SESSION['cart'][$product_id]['max_stock']) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// Database connection for stock validation
$connection = mysqli_connect('localhost', 'root', '', 'assignment1'); */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Cart</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="carrental" content="assessment 3" />
        <link rel="stylesheet" href="styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>

    <body>
        <!-- somehow putting the logo and aligning it to the nav bar is really hard, so this is the method that works for me -->
         <!-- how tf do I do the toggle function -->
         <header>
        <nav class="navbar">
            <a href="index.php" class="logo"><i class="material-icons logo">storefront</i></a>
            <a href="index.php" class="home active"><i class="material-icons">home</i> Home</a>
            <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
        </nav>
        </header>

        
    <main>
        <h1>Rental Cart</h1>
        
        <div class="cart-items">
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['brand'].' '.$item['model']) ?>">
                    <div class="item-details">
                        <h3><?= htmlspecialchars($item['brand'].' '.$item['model']) ?></h3>
                        <p><?= $item['days'] ?> day rental</p>
                        <p>Price: $<?= number_format($item['pricePerDay'], 2) ?>/day</p>
                        <p>Subtotal: $<?= number_format($item['pricePerDay'] * $item['days'], 2) ?></p>
                        <form method="post" action="remove_from_cart.php">
                            <input type="hidden" name="car_id" value="<?= $id ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </div>
                </div>
                <?php $totalCost += $item['pricePerDay'] * $item['days']; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="cart-total">
            <h2>Total: $<?= number_format($totalCost, 2) ?></h2>
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
<?php mysqli_close($connection); ?>