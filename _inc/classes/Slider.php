<?php
class Slider
{
    private $img_folder = '';
    public function set_img_folder(string $img_folder)
    {
        $this->img_folder = $img_folder;
    }
    public function generate_slides()
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
