<?php
class Menu
{
    private $pages; // Premenná pre uchovanie stránok menu

    // Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
    public function __construct($pages)
    {
        // Priradenie hodnoty parametra konštruktora do premennej $pages
        $this->pages = $pages;
    }

    // Metóda pre generovanie menu
    public function generate_menu(): string
    {
        $menu = ''; // Premenná pre uchovanie HTML kódu menu
        // Prechádzame všetky stránky
        foreach ($this->pages as $name => $url) {
            // Pridáme do menu položku s názvom a URL stránky
            $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '">' . $name . '</a></li>';
        }
        // Vrátime HTML kód menu
        return $menu;
    }
}