<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Reštaurácia">
  <meta name="keywords" content="Jedlo, smotana, syr">
  <meta name="author" content="Daria Volynchikova">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oyster</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style_main.css">
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

  <!-- Content -->
  <div class="main-content text-center">
    <div class="container">

      <!--  -->
      <!-- Rôzne nadpisy (1b) -->
      <!-- Formátovanie (1b) -->
      <!--  -->
      <h1 class="main-heading">Vitajte v našej reštaurácii</h1>
      <h2 class="sub-heading">Chutné jedlá podávané <strong>s láskou!</strong></h2>
      <!--  -->

    </div>

    <div class="hodiny p-4">

      <!--  -->
      <!-- Tabuľka (1b)  -->
      <!--  -->
      <table>
        <thead>
          <tr>
            <th>DEŇ</th>
            <th>OD</th>
            <th>DO</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>PO-ST</td>
            <td>10:30</td>
            <td>20:00</td>
          </tr>
          <tr>
            <td>ŠT</td>
            <td>10:00</td>
            <td>21:00</td>
          </tr>
          <tr>
            <td>SO</td>
            <td>11:30</td>
            <td>20:00</td>
          </tr>
          <tr>
            <td>NE</td>
            <td>11:00</td>
            <td>21:00</td>
          </tr>
        </tbody>
      </table>
      <!--  -->

    </div>
  </div>

  <!-- (nie je tu Footer, pretože nezapadá do štýlu hlavnej stránky,
  nie preto, že by som ho zabudla zahrnúť alebo nevedela, ako to urobiť) -->

  <!-- Odkazy na scripty -->
  <script src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!--  -->

</body>
</html>
