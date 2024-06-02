<?php

class Cart
{
    /**
     * Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
     */
    public function __construct()
    {
        // Ak kľúč 'cart' nie je nastavený v relácii, nastavíme ho na prázdne pole
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    /**
     * Metóda na pridanie produktu do košíka
     *
     * @param int $product_id ID produktu
     * @param int $quantity Množstvo produktu
     */
    public function insert(int $product_id, int $quantity): void
    {
        // Ak produkt ešte nie je v košíku, nastavíme jeho množstvo na 0
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        // Pridáme požadované množstvo produktu do košíka
        $_SESSION['cart'][$product_id] += $quantity;
    }

    /**
     * Metóda na odstránenie produktu z košíka
     *
     * @param int $id ID produktu na odstránenie
     */
    public function delete(int $id): void
    {
        // Ak je produkt v košíku, odstránime ho
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    /**
     * Metóda na získanie obsahu košíka
     *
     * @return array
     */
    public function select(): array
    {
        // Vrátime obsah košíka
        return $_SESSION['cart'];
    }
}