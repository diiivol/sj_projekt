<?php

/**
 * Class Page
 *
 * This class represents a page on the website.
 */
class Page
{
    /**
     * @var string $page_name The name of the page.
     */
    private $page_name;

    /**
     * Set the name of the page.
     *
     * @param string $page_name The name of the page.
     */
    public function set_page_name(string $page_name): void
    {
        $this->page_name = $page_name;
    }

    /**
     * Add a stylesheet to the page.
     *
     * @return string The HTML for the stylesheet link.
     */
    public function add_stylesheet(): string
    {
        $result = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

        if ($this->page_name == 'index') {
            $result .= ' <link rel="stylesheet" href="../assets/css/style_main.css">';
        } else {
            $result .= ' <link rel="stylesheet" href="../assets/css/style.css">';
        }

        return $result;
    }

    /**
     * Add scripts to the page.
     *
     * @return string The HTML for the script links.
     */
    public function add_scripts(): string
    {
        $result = '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                   <script src="../assets/js/preload.js"></script>';

        switch ($this->page_name) {
            case 'menu':
                $result .= ' <script src="../assets/js/accordion.js"></script>';
                break;
            case 'about-us':
                $result .= ' <script src="../assets/js/slider.js"></script>';
                break;
            case 'contacts':
            case 'register':
                $result .= ' <script src="../assets/js/alert.js"></script>';
                break;
            case 'admin':
                $result .= ' <script src="../assets/js/edit.js"></script>';
                break;
        }

        return $result;
    }

    /**
     * Redirect to the homepage.
     */
    public function redirect_homepage(): void
    {
        header("Location: templates/index.php");
        die("Chyba! Stránka sa nedá načítať.");
    }
}