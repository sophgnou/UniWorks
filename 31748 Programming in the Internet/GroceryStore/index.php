<?php


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

// Check if search form was submitted
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);
    $query = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
    $searchQuery = " - Search results for: " . htmlspecialchars($_GET['search']);
} else {
    // Default query (all products)
    $query = "SELECT * FROM products";
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
    
            <a href="cart.html">
                <button id="cart-button"><i class="material-icons">shopping_cart</i></button>
            </a>

            <div class="display">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="item">
                            <img src="images/product_<?= $product['product_id'] ?>.jpg" height="125" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <div class="item-content">
                                <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                                <p><?= htmlspecialchars($product['unit_quantity']) ?></p>
                                <p class="price">$<?= number_format($product['unit_price'], 2) ?></p>
                                <button type="submit" class="add-to-cart" data-product-id="<?= $product['product_id'] ?>"></button>>
                                    <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">No products found matching your search.</p>
                <?php endif; ?>
            </div>  
            <!--
            <div class="row">
                <div class="display">
                    <div class="item">
                        <img src="images/dog1.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 1</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog2.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 2</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog3.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 3</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog4.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 4</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog5.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 5</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog6.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 6</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog7.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 7</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog8.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 8</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/dog9.jpg" height="125">
                        <div class="item-content">
                            <h3>Item 9</h3>
                            <p>item description</p>
                            <p class="price">price</p>
                            <button type="submit" class="add-to-cart">
                                <p>ADD TO CART <i class="material-icons">add_shopping_cart</i></p>
                            </button>
                        </div>
                    </div>  
                </div> -->
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