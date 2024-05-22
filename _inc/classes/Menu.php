<?php

/**
 * Class Menu
 *
 * This class represents a menu on the website.
 */
class Menu
{
    /**
     * @var array $pages The pages of the menu.
     */
    private $pages;

    /**
     * Constructor of the class, which is automatically called when an object of this class is created.
     *
     * @param array $pages The pages of the menu.
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Method for generating the menu.
     *
     * @return string The HTML code of the menu.
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