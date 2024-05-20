<?php
class Page
{
    private $page_name; // Premenná pre uchovanie názvu stránky

    // Metóda pre nastavenie názvu stránky
    public function set_page_name($page_name)
    {
        $this->page_name = $page_name; // Priradenie hodnoty parametra do premennej $page_name
    }

    // Metóda pre pridanie štýlov
    public function add_stylesheet()
    {
        // Vytvorenie základného reťazca pre štýly
        $result = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
        // Ak je názov stránky 'index', pridáme špecifický štýl pre túto stránku
        if ($this->page_name == 'index') {
            $result .= '<link rel="stylesheet" href="../assets/css/style_main.css">';
        } else {
            // Inak pridáme všeobecný štýl
            $result .= '<link rel="stylesheet" href="../assets/css/style.css">';
        }
        // Vrátime výsledný reťazec so štýlmi
        return $result;
    }

    // Metóda pre pridanie skriptov
    public function add_scripts()
    {
        // Vytvorenie základného reťazca pre skripty
        $result = '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                       <script src="../assets/js/preload.js"></script>';
        // Na základe názvu stránky pridáme špecifické skripty
        switch ($this->page_name) {
            case 'menu':
                $result .= '<script src="../assets/js/accordion.js"></script>';
                break;
            case 'about-us':
                $result .= '<script src="../assets/js/slider.js"></script>';
                break;
            case 'contacts':
                $result .= '<script src="../assets/js/alert.js"></script>';
                break;
            case 'admin':
                $result .= '<script src="../assets/js/edit.js"></script>';
                break;
        }
        // Vrátime výsledný reťazec so skriptmi
        return $result;
    }

    // Metóda pre presmerovanie na domovskú stránku
    public function redirect_homepage()
    {
        // Presmerovanie na domovskú stránku
        header("Location: templates/index.php");
        // Ak sa nepodarí nájsť domovskú stránku, ukončíme skript a vypíšeme chybovú správu
        die("Nepodarilo sa nájsť Domovskú stránku");
    }
}