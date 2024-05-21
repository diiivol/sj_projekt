<?php

class Cart
{
    // Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
    public function __construct()
    {
        // Ak nie je v session nastavený kľúč 'cart', nastavíme ho na prázdne pole
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    // Metóda pre pridanie produktu do košíka
    public function addProduct($product_id, $quantity)
    {
        // Ak produkt ešte nie je v košíku, nastavíme jeho množstvo na 0
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        // Pridáme požadované množstvo produktu do košíka
        $_SESSION['cart'][$product_id] += $quantity;
    }

    // Metóda pre odstránenie produktu z košíka
    public function delete($id)
    {
        // Ak je produkt v košíku, odstránime ho
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // Metóda pre získanie obsahu košíka
    public function select()
    {
        // Vrátime obsah košíka
        return $_SESSION['cart'];
    }
}
