<?php
class Slider
{

    private $img_folder = '';

    // Setter for image folder
    public function set_img_folder(string $img_folder)
    {
        $this->img_folder = $img_folder;
    }

    // Method to generate slides
    public function generate_slides()
    {
        $result = '<div class="col-lg-6 text-center d-flex justify-content-center">';
        // Získanie zoznamu súborov obrázkov v adresári
        $img_files = glob($this->img_folder . '*.jpg');


        // Prechádza cez každý obrázok
        for ($i = 0; $i < count($img_files); $i++) {
            // Začiatok divu pre snímku
            $result .= '<img class="mySlides m-0" src="' . $img_files[$i] . '" alt="Náš tím" onclick="plusSlides(1)">';
        }
        $result .= '</div>';
        return $result;
    }
}
