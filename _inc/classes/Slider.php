<?php

/**
 * Trieda Slider
 *
 * Táto trieda sa používa na generovanie HTML kódu pre posuvník.
 */
class Slider
{
    /**
     * @var string Cesta k priečinku s obrázkami.
     */
    private $img_folder = '';

    /**
     * Nastaví cestu k priečinku s obrázkami.
     *
     * @param string $img_folder Cesta k priečinku s obrázkami.
     */
    public function set_img_folder(string $img_folder): void
    {
        $this->img_folder = $img_folder;
    }

    /**
     * Generuje snímky pre posuvník.
     *
     * @return string HTML kód pre posuvník.
     */
    public function generate_slides(): string
    {
        $result = '<div class="col-lg-6 text-center d-flex justify-content-center">';
        $img_files = glob($this->img_folder . '*.jpg');
        for ($i = 0; $i < count($img_files); $i++) {
            $result .= '<img class="mySlides m-0" src="' . $img_files[$i] . '" alt="Náš tím" onclick="plusSlides(1)">';
        }
        $result .= '</div>';
        return $result;
    }
}