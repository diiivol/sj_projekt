<?php

/**
 * Trieda Page
 *
 * Táto trieda reprezentuje stránku na webovej stránke.
 */
class Page
{
    /**
     * @var string $page_name Názov stránky.
     */
    private $page_name;

    /**
     * Nastavte názov stránky.
     *
     * @param string $page_name Názov stránky.
     */
    public function set_page_name(string $page_name): void
    {
        $this->page_name = $page_name;
    }

    /**
     * Pridajte štýl do stránky.
     *
     * @return string HTML pre odkaz na štýl.
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
     * Pridajte skripty na stránku.
     *
     * @return string HTML pre odkazy na skripty.
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
     * Presmerujte na domovskú stránku.
     */
    public function redirect_homepage(): void
    {
        header("Location: templates/index.php");
        die("Chyba! Stránka sa nedá načítať.");
    }
}