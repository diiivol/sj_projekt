<?php


class Menu
{

    private $pages;

    /**
     * Konštruktor triedy
     *
     * $pages - Stránky menu
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * generovanie menu
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