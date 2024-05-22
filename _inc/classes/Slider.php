<?php

/**
 * Class Slider
 *
 * This class is used to generate HTML code for a slider.
 */
class Slider
{
    /**
     * @var string The path to the image folder.
     */
    private $img_folder = '';

    /**
     * Sets the path to the image folder.
     *
     * @param string $img_folder The path to the image folder.
     */
    public function set_img_folder(string $img_folder): void
    {
        $this->img_folder = $img_folder;
    }

    /**
     * Generates the slides for the slider.
     *
     * @return string The HTML code for the slider.
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