<?php

class Slider
{
    private $img_folder = ''; // Premenná pre uchovanie cesty k priečinku s obrázkami

    // Metóda pre nastavenie cesty k priečinku s obrázkami
    public function set_img_folder(string $img_folder)
    {
        $this->img_folder = $img_folder; // Priradenie hodnoty parametra do premennej $img_folder
    }

    // Metóda pre generovanie snímkov pre slider
    public function generate_slides()
    {
        // Začiatok vytvárania HTML kódu pre slider
        $result = '<div class="col-lg-6 text-center d-flex justify-content-center">';
        // Získanie všetkých súborov s obrázkami vo formáte .jpg v priečinku
        $img_files = glob($this->img_folder . '*.jpg');
        // Prechádzame všetky obrázky a pridávame ich do HTML kódu pre slider
        for ($i = 0; $i < count($img_files); $i++) {
            $result .= '<img class="mySlides m-0" src="' . $img_files[$i] . '" alt="Náš tím" onclick="plusSlides(1)">';
        }
        // Koniec vytvárania HTML kódu pre slider
        $result .= '</div>';
        // Vrátime výsledný HTML kód pre slider
        return $result;
    }
}
