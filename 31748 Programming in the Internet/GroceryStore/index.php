<?php
// cart
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart requests
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    // Database connection
    $connection = mysqli_connect('localhost', 'root', '', 'assignment1');
    
    // Check if product exists and has sufficient stock
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($connection, $query);
    
    if ($result && $product = mysqli_fetch_assoc($result)) {
        if ($product['in_stock'] >= $quantity) {
            // Add to cart or update quantity
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['product_name'],
                    'price' => $product['unit_price'],
                    'quantity' => $quantity,
                    'unit' => $product['unit_quantity'],
                    'max_stock' => $product['in_stock']
                ];
            }
        } else {
            $_SESSION['error'] = "Not enough stock available for {$product['product_name']}";
        }
    }
    mysqli_close($connection);
    
    // Redirect to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'assignment1');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
// Initialize variables
$products = [];
$searchQuery = "";

/*
// Fetch products
$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);

// Check if query succeeded
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
} 
    */

// Check if search form was submitted
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);
    $query = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
    $searchQuery = " - Search results for: " . htmlspecialchars($_GET['search']);
} else {
    // Default query (all products)
    $query = "SELECT p.* FROM products p
              INNER JOIN (
                  SELECT product_name, MIN(product_id) as min_id
                  FROM products
                  GROUP BY product_name, unit_quantity
              ) as unique_products
              ON p.product_id = unique_products.min_id
              ORDER BY p.product_name";
}

// Execute query
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Fetch all results into array
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

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
                <a href="index.php" class="home active"><i class="material-icons">home</i> Home</a>
                <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
                <div class="dropdown">
                    <button data-toggle-nav class="dropbtn" onClick="toggleNav()" aria-expanded="false" aria-controls="contentDown"><i class="material-icons">arrow_drop_down_circle</i> Food & Groceries</button>
                    <div class="dropcontent" id="contentDown">
                        <div class="submenu">
                            <a href="#">Frozen</a>
                        </div>

                        <div class="submenu">
                            <a href="#">Fresh</a>
                            <div class="submenu-cont">
                                <a href="#">Meat</a>
                                <a herf="#">Fruits</a>
                                <a href="#">Dairy</a>
                            </div>
                        </div>


                        <div class="submenu">
                            <a href="#">Beverages</a>
                        </div>
                        <div class="submenu">
                            <a href="#">Snacks</a>
                        </div>

                        <div class="submenu">
                            <a href="#">Household</a>
                            <div class="submenu-cont">
                                <a href="#">Health Care</a>
                                <a href="#">Home Supplies</a>
                                <a href="#">Pet Items</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="search-cont">
                <form class="search-bar" action="index.php" method="get">
                    <input type="text" placeholder="Search products..." name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit"><i class="material-icons">search</i></button>
                </form>
            </div>
        </header>

        <main>
        <!-- doing the grid layout gives me the shits, I cannot do this properlyyyyy 16/04/25 -->
        <!-- I finally figured it out... 17/04/25-->
            <div class="page-text">
                <h1>Groceries <?= $searchQuery ?> </h1>
                <p>Here is what is avaliable.</p>
            </div>
    
            <a href="cart.php">
                <button id="cart-button"><i class="material-icons">shopping_cart</i></button>
            </a>

            <div class="display">
            <?php foreach ($products as $product): ?>
                <div class="item">
                    <img src="images/product_<?= $product['product_id'] ?>.jpg" height="125" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <div class="item-content">
                        <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                        <p><?= htmlspecialchars($product['unit_quantity']) ?></p>
                        <p class="price">$<?= number_format($product['unit_price'], 2) ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['in_stock'] ?>">
                            <button type="submit" name="add_to_cart" class="add-to-cart">
                                <span class="cart-text">ADD TO CART</span>
                                <i class="material-icons cart-icon">add_shopping_cart</i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
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
        <!--<script type="text/javascript">
        function toggleNav() {
        const dropContent = document.getElementById('contentDown');
        const dropBtn = document.querySelector('[data-toggle-nav]');
        
        dropContent.classList.toggle('show');
        dropBtn.classList.toggle('active');
        }

        // Close when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                const dropContent = document.getElementById('contentDown');
                const dropBtn = document.querySelector('[data-toggle-nav]');
                
                dropContent.classList.remove('show');
                dropBtn.classList.remove('active');
            }
        });
        </script>-->
    </body>
</html>