<?php
    session_start();
    if (isset($_SESSION["counter"])){
        $_SESSION["counter"] +=1;
    } 
    else{
        $_SESSION["counter"] = 1;
    }

    $counter = $_session["counter"];
    $msg="You have visited this page ".counter" times.";

    session_destry();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Grocery Store</title>
        <meta charset="uts-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="grocerystore" content="assessment 1" />
        <link rel="stylesheet" href="styles.css" />
    </head>

    <body>
        
         <header>
            <img src="#" alt="grocery store logo">
            <nav class="topnav">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Home</a>
            </nav>

            <div>

            </div>

            <form class="search" action="action.php">
                <input type="text" placeholder="Search..." name="searchbar">
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>

            <script>

            </script>
         </header>
        
    </body>

</html>
