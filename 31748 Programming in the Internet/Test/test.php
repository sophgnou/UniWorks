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
$categoryFilter = "";
/*
// Fetch products
$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);

// Check if query succeeded
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
} 
    */
// Define category mappings
// Define category mappings
$categoryMap = [
    'frozen' => "product_name IN ('Fish Fingers', 'Hamburger Patties', 'Shelled Prawns', 'Tub Ice Cream')",
    'meat' => "product_name = 'T Bone Steak'",
    'fruits' => "product_name IN ('Navel Oranges', 'Bananas', 'Peaches', 'Grapes', 'Apples')",
    'dairy' => "product_name = 'Cheddar Cheese'",
    'beverages' => "product_name IN ('Earl Grey Tea Bags', 'Instant Coffee')",
    'snacks' => "product_name = 'Chocolate Bar'",
    'health' => "product_name IN ('Panadol', 'Bath Soap')",
    'home' => "product_name IN ('Garbage Bags Small', 'Garbage Bags Large', 'Washing Powder', 'Laundry Bleach')",
    'pet' => "product_name IN ('Dry Dog Food', 'Bird Food', 'Cat Food', 'Fish Food')"
];

// Initialize category filter
$categoryFilter = "";

// Check if category filter is set
if (isset($_GET['category']) && array_key_exists($_GET['category'], $categoryMap)) {
    $category = $_GET['category'];
    $categoryFilter = " WHERE " . $categoryMap[$category];
    $searchQuery = " - Category: " . ucfirst($category);
}
// Check if category filter is set
if (isset($_GET['category']) && array_key_exists($_GET['category'], $categoryMap)) {
    $category = $_GET['category'];
    $categoryFilter = " WHERE " . $categoryMap[$category];
    $searchQuery = " - Category: " . ucfirst($category);
}

// Check if search form was submitted
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);
    $query = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
    $searchQuery = " - Search results for: " . htmlspecialchars($_GET['search']);
} else {
    // Default query (all products or filtered by category)
    $query = "SELECT p.* FROM products p
              INNER JOIN (
                  SELECT product_name, MIN(product_id) as min_id
                  FROM products
                  GROUP BY product_name, unit_quantity
              ) as unique_products
              ON p.product_id = unique_products.min_id" 
              . $categoryFilter . 
              " ORDER BY p.product_name";
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
        <title>Rent a Car</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="rentablecars" content="assessment 1" />
        <link rel="stylesheet" href="styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>

    <body> 
        <!-- somehow putting the logo and aligning it to the nav bar is really hard, so this is the method that works for me -->
        <!-- how tf do I do the toggle function -->
        
        <header>
            <nav class="navbar">
                <div class="left-nav">
                    <a href="index.php" class="logo"><i class="material-icons logo">directions_car</i></a>
                </div>
                <div class="right-nav">
                    <a href="index.html" class="home active"><i class="material-icons">home</i> Home</a>
                    <a href="about.html" class="about"><i class="material-icons">info</i> About</a>  
                    <a href="reserve.php" class="reserve"><i class="material-icons">car_rental</i> Reservations</a>
                </div>    
            </nav>
        </header> 

        <main>
        <!-- doing the grid layout gives me the shits, I cannot do this properlyyyyy 16/04/25 -->
        <!-- I finally figured it out... 17/04/25-->
            <div class="landing"></div>    
                <img src="https://images.pexels.com/photos/31982858/pexels-photo-31982858/free-photo-of-car-on-mountain-road-through-autumn-landscape.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="high quality car on the road photo" id="home-img">
                <div class="hometxt">
                    <h1>Need a ride?</h1>
                    <a href="#rentalcars"><button id="rentgo"><p>Rent & Go <i class="material-icons">arrow_forward</i></p></button></a>
                </div>
            </div>
            <div class="page-content">
            <div class="page-text">
                <h1 id="rentalcars">Rental Cars</h1>
                <p>Here is what is avaliable.</p>
            </div>
            <div class="search-cont">
                <form class="search-bar" action="action.php">
                    <input type="text" placeholder="Search products..." name="search">
                    <button type="submit"><i class="material-icons">search</i></button>
                    </form>
                    <div id="search_results">Name suggestions will appear here</div>
            </div>
            <div class="car-cat">
                <div class="dropdown">
                <a href="#" class="category drop-trigger" data-category="car-type"><i class="material-icons">arrow_drop_down</i> Car Type</a>
                    <div class="drop-content" id="car-type-dropdown">
                        <a href="#">SUV</a>
                        <div class="load-spin"></div>
                    </div>
                </div>
                <div class="dropdown">
                <a href="#" class="category drop-trigger" data-category="Brand"><i class="material-icons">arrow_drop_down</i> Brand</a>
                    <div class="drop-content" id="brand-dropdown">
                        <a href="#">Toyota</a>
                        <div class="load-spin"></div>
                    </div>
                </div>
            </div>
            </div>
            <a href="cart.html">
                <button id="cart-button"><i class="material-icons">shopping_cart</i></button>
            </a>
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
        `
        </footer>
        <script src="js/script.js"></script> 
        
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