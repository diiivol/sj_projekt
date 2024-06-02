<?php

class Cart
{

    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    /**
     * Pridanie produktu do košíka
     *
     * $product_id - ID PRODUCTU
     * $quantity - MNOZSTVO PRODUKTU
     */
    public function insert(int $product_id, int $quantity): void
    {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id] += $quantity;
    }

    /**
     * Odstránenie produktu z košíka
     *
     * $id - ID PRODUKTU NA ODSTRANENIE
     */
    public function delete(int $id): void
    {
        // Ak je produkt v košíku, odstránime ho
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    /**
     * VSETKY PRODUKTY Z KOSIKA
     */
    public function select(): array
    {
        return $_SESSION['cart'];
    }
}