<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Reštaurácia">
  <meta name="keywords" content="Jedlo, smotana, syr">
  <meta name="author" content="Daria Volynchikova">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>O nas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="img/logo_white.svg" type="image/x-icon">
</head>

<body>

  <!-- Preload (kreatívny bod?) -->
  <div id="preloader">
    <img src="img/preloader.gif" alt="Loading...">
  </div>
  <!--  -->

  <!--  -->
  <!-- Navigácia (4b) -->
  <!--  -->
    <!-- Navigácia s minimálne 3 stránkami (Napr. Domov, O nás, Blog, Galéria, Kontakt,..) -->
    <!-- Na mobiloch hamburger navigácia -->
    <!-- Logo v navigácii -->
    <!-- Navigácia viditeľná počas scrollovania   -->
  <!--  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand d-none d-lg-block" href="index.html">
        <img src="img/logo_white.svg" alt="Logo" width="30" height="30" class="img-fluid">
        Oyster
      </a>
      <a class="navbar-brand d-lg-none" href="index.html">
        <img src="img/logo_white.svg" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="menu.html">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contacts.html">Kontakt</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about-us.html">O nas</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
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
        Keď sme si uvedomili, že naša kulinárska vášeň má potenciál spájať ľudí a rozvíjať komunitu, rozhodli sme sa otvoriť Oyster.</p>
      <p>Za naše motto sme si zvolili slová: kvalita, vášeň a pohostinnosť. Každé jedlo, ktoré podávame, pripravujeme s láskou a starostlivosťou.
        V našej kuchyni sa stretávajú tradičné slovenské recepty s moderným šarmom a vytvárajú tak pre našich hostí jedinečné gastronomické zážitky.</p>
      <p>Tešíme sa na stretnutie s vami v "Ustrici" a na spoločné objavovanie radosti z gastronómie!</p>
    </div>

    <!--  -->
    <!-- Slideshow (Carousel) (1b) -->
    <!--  -->
    <div class="container">
      <h3 class="text-center mb-4">Galeria</h3>
      <div class="photo-gallery row justify-content-center ">
        <!--  -->
        <!-- Obrázky (1b) -->
        <!--  -->
          <!-- používajte obrázky z bezplatných zdrojov, -->
          <!-- použite vhodné množstvo obrázkov na stránku.  -->
        <!--  -->

        <!-- Upozornenie: všetky obrázky boli prevzaté zo freepik.com okrem jedného - Živánska (na stránke menu), -
          pretože som ju nemohla nikde nájsť, okrem bigstockphoto.com, takže som použila obrázok odtiaľ. -->
        <!--  -->

        <div class="col-lg-6 text-center d-flex justify-content-center">
          <img class="mySlides m-0" src="img/o-nas1.jpg" alt="Náš tím" onclick="plusSlides(1)">
          <img class="mySlides m-0" src="img/o-nas2.jpg" alt="Náš tím" onclick="plusSlides(1)">
          <img class="mySlides m-0" src="img/o-nas3.jpg" alt="Náš tím" onclick="plusSlides(1)">
        </div>
        <!--  -->

      </div>
      <p class="text-center my-4">(click)</p>
    </div>
  </div>

  <!--  -->
  <!-- Footer (2b) -->
  <!--  -->
    <!-- Niekoľko stĺpcov s informáciami o stránke -->
    <!-- Copyright -->
  <!--  -->
  <footer>
    <div class="container">
      <div class="footer-text">&copy; 2023 Oyster.</div>
      <div class="footer-text">Vytvorila Daria Volynchikova.</div>
    </div>
  </footer>
  <!--  -->

  <!-- Odkazy na scripty -->
  <script src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!--  -->

</body>
</html>
