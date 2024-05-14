<?php
require('../_inc/config.php');

$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');
$page_object = new Page();
$page_object->set_page_name($page_name);
?>

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
  <?php echo $page_object->add_stylesheet(); ?>
  <link rel="icon" href="../assets/img/logo_white.svg" type="image/x-icon">
</head>
<body>
    <!-- Preload (kreatívny bod?) -->
        <div id="preloader">
            <img src="../assets/img/preloader.gif" alt="Loading...">
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
        <a class="navbar-brand d-none d-lg-block" href="../index.php">
            <img src="../assets/img/logo_white.svg" alt="Logo" width="30" height="30" class="img-fluid">
            Oyster
        </a>
        <a class="navbar-brand d-lg-none" href="../index.php">
            <img src="../assets/img/logo_white.svg" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <?php 
                $pages = array(
                    'Menu' => 'menu.php',
                    'Kontakt' => 'contacts.php',
                    'O nas' => 'about-us.php'
                );
                
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                    if($_SESSION['user_role'] == 1){
                        // Если пользователь - админ, добавить ссылку на страницу управления
                        $pages['Admin'] = 'admin.php';
                    } else {
                        // Если пользователь - не админ, добавить ссылку на корзину
                        $pages['Kosik'] = 'user.php';
                    }
                    $pages['Odhlásiť sa'] = 'logout.php';
                } else {
                    $pages['Prihlásiť sa'] = 'login.php';
                }
                $menu_object = new Menu($pages);
                echo $menu_object->generate_menu();
            ?>
            </ul>
        </div>
        </div>
    </nav>