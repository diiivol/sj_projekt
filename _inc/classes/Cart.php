<?php
class Cart {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    
    public function addProduct($product_id, $quantity) {
        if(!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id] += $quantity;
    }
    
    public function removeProduct($product_id) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]--;
            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    public function getCart() {
        return $_SESSION['cart'];
    }
}
?>