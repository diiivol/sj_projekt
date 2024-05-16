<?php
class Page
{
    private $page_name;

    public function set_page_name($page_name)
    {
        $this->page_name = $page_name;
    }

    function add_stylesheet()
    {
        $result = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

        if ($this->page_name == 'index') {
            $result .= '<link rel="stylesheet" href="../assets/css/style_main.css">';
        } else {
            $result .= '<link rel="stylesheet" href="../assets/css/style.css">';
        }

        return $result;
    }

    function add_scripts()
    {
        $result = '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                       <script src="../assets/js/preload.js"></script>';
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
        }
        return $result;
    }

    function redirect_homepage()
    {
        header("Location: templates/index.php");
        die("Nepodarilo sa nájsť Domovskú stránku");
    }
}
