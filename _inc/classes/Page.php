<?php
class Page {
    private $page_name;

    public function set_page_name($page_name) {
        $this->page_name = $page_name;
    }

    function add_stylesheet() {
        $result = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

        if ($this->page_name == 'index') {
            $result .= '<link rel="stylesheet" href="../assets/css/style_main.css">';
        } else {
            $result .= '<link rel="stylesheet" href="../assets/css/style.css">';
        }

        return $result;
    }
}
?>