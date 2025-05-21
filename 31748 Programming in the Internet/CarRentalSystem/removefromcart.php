<?php
session_start();

if (isset($_POST['car_id'])) {
    $carId = (int)$_POST['car_id'];
    if (isset($_SESSION['cart'][$carId])) {
        unset($_SESSION['cart'][$carId]);
    }
}

header('Location: cart.php');
exit;
?>