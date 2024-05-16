<!-- Header -->
<?php
include_once('partials/header.php');
?>
<!-- -->

<!-- O nas -->
<div class="container o-nas pt-3 text-center">
  <h1 class="display-4 text-center mb-4">O nas</h1>
  <div class="container p-2 fs-5 col-md-8 mx-auto">
    <p>Vitajte v reštaurácii Oyster, kde sa láska k jedlu spája s umením gastronómie.
      Naša reštaurácia sa zrodila z vášne a túžby spojiť jedinečné chuťové zážitky s príjemným prostredím.
      Príbeh našej reštaurácie sa začal jedným snom a mnohými chutnými dobrotami.</p>
    <p>Naša cesta sa začala v srdci našej rodiny, kde sme spoločne zdieľali lásku k vareniu a stolovaniu.
      Každý recept, každé kuchárske tajomstvo sa starostlivo odovzdávalo z generácie na generáciu.
      Keď sme si uvedomili, že naša kulinárska vášeň má potenciál spájať ľudí a rozvíjať komunitu, rozhodli sme sa
      otvoriť Oyster.</p>
  </div>

  <!--  -->
  <!-- Slideshow (Carousel) (1b) -->
  <!--  -->
  <div class="container mb-3">
    <h3 class="text-center mb-4">Galeria</h3>
    <div class="photo-gallery row justify-content-center ">
      <!--  -->
      <!-- Obrázky (1b) -->
      <!--  -->
      <!-- používajte obrázky z bezplatných zdrojov, -->
      <!-- použite vhodné množstvo obrázkov na stránku.  -->
      <!--  -->

      <?php
      $img_folder = '../assets/img/o_nas/';
      $slider = new Slider();
      $slider->set_img_folder($img_folder);
      echo ($slider->generate_slides());
      ?>
      <!--  -->

    </div>
    <!-- <p class="text-center my-4">(click)</p> -->
  </div>
  <div class="container p-2 fs-5 col-md-8 mx-auto">
  <p>Za naše motto sme si zvolili slová: kvalita, vášeň a pohostinnosť. Každé jedlo, ktoré podávame, pripravujeme s
      láskou a starostlivosťou.
      V našej kuchyni sa stretávajú tradičné slovenské recepty s moderným šarmom a vytvárajú tak pre našich hostí
      jedinečné gastronomické zážitky.</p>
  </div>

</div>

<!--  -->
<!-- Footer (2b) -->
<!--  -->
<!-- Niekoľko stĺpcov s informáciami o stránke -->
<!-- Copyright -->
<!--  -->
<?php
include_once('partials/footer.php')
?>