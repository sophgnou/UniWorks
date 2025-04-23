<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
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
            <div class="order-summary">
                <h2>Order Summary</h2>
                <table class="checkout-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?> (<?= $item['unit'] ?>)</td>
                                <td><?= $item['quantity'] ?></td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="total-label">Total:</td>
                            <td class="total-amount">$<?= number_format($total, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="payment-method">
                <h2>Payment Method</h2>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" checked required>
                        Credit Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="paypal">
                        PayPal
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="bank_transfer">
                        Bank Transfer
                    </label>
                </div>
                
                <div id="credit-card-details" class="payment-details">
                    <div class="form-group">
                        <label for="card_number">Card Number:</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                    </div>
                    <div class="form-group">
                        <label for="card_name">Name on Card:</label>
                        <input type="text" id="card_name" name="card_name">
                    </div>
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date:</label>
                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>

            <h2>Checkout</h2>
            <form name="form1" id="form1" method="post" action="validation_php.php">
            <table border="0">
            <tr>
               <td style="width:110px">
                  Full Name
                  <span style="color:red">*</span>
               </td>
               <td style="width:150px">
                  <input type="text" id="fullnaem " name="fullname" required>
               </td>
            </tr>
            <tr>
               <td>
                  Address
                  <span style="color:red">*</span>
               </td>
               <td>
                  <input type="text" id="street" name="street" required>
               </td>
               <td>
                  <input type="text" id="suburb" name="suburb" required>
               </td>
               <td>
               <select name="state" id="state">
                    <option value="NSW">NSW</option>
                    <option value="ACT">ACT</option>
                    <option value="VIC">VIC</option>
                    <option value="QLD">QLD</option>
                    <option value="SA">SA</option>
                    <option value="WA">WA</option>
                    <option value="NT">NT</option>
                    <option value="TAS">TAS</option>
                </select>
                </td>
                <td>
                  <input type="text" id="country" name="country" required>
               </td>
                <td>
                  <input type="number" id="postcode" name="postcode" required>
                </td>
            </tr>
            <tr>
               <td>
                Email
                <span style="color:red">*</span>
               </td>
               <td>
                  <input type="email" id="email" name="email" required>
               </td>
            </tr>
            <tr>
               <td>
                Phone Number
                <span style="color:red">*</span>
               </td>
               <td>
                  <input type="tel" id="phone" name="phone" required>
               </td>
            </tr>
            <tr>
               <td colspan="2" align="center">
                  <input type="submit" value = "Submit">
               </td>
            </tr>
         </table>
      </form>
      

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
        <script src="checkout.js"></script>
    </body>
</html>