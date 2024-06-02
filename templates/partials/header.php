<?php

/**
 * Tento súbor je hlavičkou webovej stránky.
 * Nastavuje objekt stránky a zahrňuje potrebné štýly a skripty.
 */

require('../_inc/config.php');

/**
 * Základný názov aktuálneho skriptu sa získa a použije na vytvorenie nového objektu Page.
 * Nastaví sa názov stránky.
 */
$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');
$page_object = new Page();
$page_object->set_page_name($page_name);

/**
 * Vytvorí sa pole bežných stránok a použije sa na generovanie ponuky.
 */
$commonPages = array(
    'Menu' => 'menu.php',
    'Kontakt' => 'contacts.php',
    'O nas' => 'about-us.php'
);

// Vytvorte nový objekt Menu a generujte menu
$menu_object = new Menu($commonPages);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <?php echo $page_object->add_stylesheet(); ?>
    <link rel="icon" href="../assets/img/icon.svg" type="image/x-icon">
</head>

<body>

<!-- Preload (kreatívny bod) -->
<div id="preloader">
    <img src="../assets/img/loading.gif" width="50" height = "50" alt="Loading...">
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
            <img src="../assets/img/icon.svg" alt="Logo" width="35" height="35" class="img-fluid">
            yster
        </a>
        <a class="navbar-brand d-lg-none" href="../index.php">
            <img src="../assets/img/icon.svg" alt="Logo" width="35" height="35" class="d-inline-block align-text-top me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?= $menu_object->generate_menu(); ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php
                /**
                 * Vytvorí sa pole stránok používateľa na základe stavu prihlásenia používateľa a jeho role.
                 * Toto pole sa používa na generovanie menu.
                 */
                $userPages = array();
                    
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    if ($_SESSION['user_role'] == 1) {
                        $userPages['<i class="fas fa-user"></i> ' . $_SESSION['user_email']] = 'admin.php';
                    } else {
                        $userPages['<i class="fas fa-user"></i> ' . $_SESSION['user_email']] = 'user.php';
                    }
                    $userPages['Odhlásiť sa'] = 'logout.php';
                } else {
                    $userPages['Prihlásiť sa'] = 'login.php';
                }
                $menu_object = new Menu($userPages);
                echo $menu_object->generate_menu();
                ?>
            </ul>
        </div>
    </div>
</nav>