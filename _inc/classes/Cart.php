<?php

class Cart
{
    /**
     * Constructor of the class, which is automatically called when an object of this class is created
     */
    public function __construct()
    {
        // If the 'cart' key is not set in the session, we set it to an empty array
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    /**
     * Method for adding a product to the cart
     *
     * @param int $product_id
     * @param int $quantity
     */
    public function addProduct(int $product_id, int $quantity): void
    {
        // If the product is not yet in the cart, we set its quantity to 0
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        // We add the requested quantity of the product to the cart
        $_SESSION['cart'][$product_id] += $quantity;
    }

    /**
     * Method for removing a product from the cart
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        // If the product is in the cart, we remove it
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    /**
     * Method for getting the contents of the cart
     *
     * @return array
     */
    public function select(): array
    {
        // We return the contents of the cart
        return $_SESSION['cart'];
    }
}