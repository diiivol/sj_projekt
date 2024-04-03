<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Reštaurácia">
  <meta name="keywords" content="Jedlo, smotana, syr">
  <meta name="author" content="Daria Volynchikova">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontakt</title>
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
  <!--  -->

  <div class="container kontakt pt-3">
    <h1 class="display-4 text-center mb-4">Kontakt</h1>

    <!--  -->
    <!-- Formulár (5b) -->
    <!--  -->
      <!-- Polia: Meno, Email, Textarea, Súhlas so spracovaním osobných údajov, Odoslať -->
      <!-- Ošetrenie emailovej adresy -->
      <!-- Súhlas so spracovaním osobných údajov -->
      <!-- Redirect na thank you page -->
      <!-- Validácia  -->
    <!--  -->
    <div class="row">
      <div class="col-md-8 col-lg-6 mx-auto">
        <form onsubmit="event.preventDefault(); window.location.href='thank.html'">
          <div class="mb-3">
            <label for="name" class="form-label">Meno</label>
            <input type="text" class="form-control" id="name" placeholder="Zadajte svoje meno" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" placeholder="Zadajte svoju e-mailovú adresu" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Správa</label>
            <textarea class="form-control" id="message" rows="5" placeholder="Napíšte svoj názor a myšlienky po návšteve našej reštaurácie alebo sa na niečo spýtajte!" required></textarea>
          </div>
          <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" required>
            <label class="form-check-label">
              Súhlas so spracovaním osobných údajov
            </label>
          </div>
          <button type="submit" class="btn btn-primary">Odoslať</button>
        </form>
      </div>
    </div>
    <!--  -->

    <!-- Adresa -->
    <div class="row my-4">
      <div class="col-md-8 col-lg-6 mx-auto">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Adresa</h5>
            <p class="card-text">949 01, Nitra, Slovensko</p>

            <!--  -->
            <!-- Odkaz na email a telefón (mailto: , tel: ) (1b) -->
            <!--  -->
            <p class="card-text">
              T. C.: <a href="tel:+123456789">+123456789</a>
            </p>
            <p class="card-text">
              Email: <a href="mailto:Oyster@mail.com">Oyster@mail.com</a>
            </p>
            <!--  -->

          </div>
        </div>
      </div>
    </div>

    <!-- Mapa -->
    <div class="row mb-4">
      <div class="col-md-8 col-lg-6 container text-center">
        <div class="map-responsive">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5307.425477452054!2d18.086291158691395!3d48.30837599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee43b2f6763%3A0x75a567f979f5bed3!2sUniverzita%20Kon%C5%A1tant%C3%ADna%20Filozofa!5e0!3m2!1ssk!2ssk!4v1702563808753!5m2!1ssk!2ssk" width="632" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
    <!--  -->

    <!--  -->
    <!-- Tlačidlo s preklikom na inú stránku (1b) - <a> tag, ktorý je naštýlovaný ako button -->
    <!-- Alert (1b) -->
    <!--  -->
    <div class="row my-4">
      <div class="col-md-8 col-lg-6 social-buttons container text-center">
          <a href="https://twitter.com" class="social-button twitter" target="_blank" onclick="return confirmRedirect();">
            <i class="fab fa-twitter"></i> Twitter
          </a>
          <a href="https://facebook.com" class="social-button facebook" target="_blank" onclick="return confirmRedirect();">
            <i class="fab fa-facebook-f"></i> Facebook
          </a>
          <a href="https://instagram.com" class="social-button instagram" target="_blank" onclick="return confirmRedirect();">
            <i class="fab fa-instagram"></i> Instagram
          </a>
          <a href="https://linkedin.com" class="social-button linkedin" target="_blank" onclick="return confirmRedirect();">
            <i class="fab fa-linkedin-in"></i> LinkedIn
          </a>
      </div>
    </div>
    <!--  -->

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
