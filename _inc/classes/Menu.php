<?php

/**
 * Trieda Menu
 *
 * Táto trieda reprezentuje menu na webovej stránke.
 */
class Menu
{
    /**
     * @var array $pages Stránky menu.
     */
    private $pages;

    /**
     * Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy.
     *
     * @param array $pages Stránky menu.
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Metóda na generovanie menu.
     *
     * @return string HTML kód menu.
     */
    public function generate_menu(): string
    {
        $menu = '';

        foreach ($this->pages as $name => $url) {
            $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '">' . $name . '</a></li>';
        }

        return $menu;
    }
}