<?php
session_start();

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
$connection = mysqli_connect('localhost', 'root', '', 'assignment1');
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
                <a href="index.php" class="home active"><i class="material-icons">home</i> Home</a>
                <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
                <div class="dropdown">
                    <button data-toggle-nav class="dropbtn" onClick="toggleNav()"><i class="material-icons">arrow_drop_down_circle</i> Food & Groceries</button>
                <div class="dropcontent" id="contentDown">
                    <div class="submenu">
                        <a href="#">Frozen</a>

                        <a href="">Fresh</a>
                        <div class="submenu-cont">
                            <a href="#">Meat</a>
                            <a herf="#">Fruits</a>
                            <a href="#">Dairy</a>
                        </div>

                        <a href="#">Beverages</a>
                        <a href="">Snacks</a>

                        <a href="">Household</a>
                        <div class="submenu-cont">
                            <a href="#">Health Care</a>
                            <a href="#">Home Supplies</a>
                            <a href="#">Pet Items</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        
    <main>
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <form method="post" action="cart.php">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product_id => $item): 
                            // Verify current stock
                            $query = "SELECT in_stock FROM products WHERE product_id = $product_id";
                            $result = mysqli_query($connection, $query);
                            $current_stock = mysqli_fetch_assoc($result)['in_stock'];
                            
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?> (<?= $item['unit'] ?>)</td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $product_id ?>]" 
                                           value="<?= $item['quantity'] ?>" 
                                           min="1" 
                                           max="<?= min($item['max_stock'], $current_stock) ?>">
                                </td>
                                <td>$<?= number_format($subtotal, 2) ?></td>
                                <td><a href="cart.php?remove=<?= $product_id ?>">Remove</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td>$<?= number_format($total, 2) ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="update-btn">Update Cart</button>
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                </div>
            </form>
        <?php endif; ?>
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