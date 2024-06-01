<?php
/**
 * This file is used to start a session and include all necessary classes.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

// Include the header
include 'partials/header.php';
?>

<!-- Obsah -->
<div class="container error d-flex flex-column align-items-center justify-content-center">
    <h1>404</h1>
    <p class="text-center">Prepáčte, stránka, ktorú hľadáte, neexistuje.</p>
</div>

<?php
// <!-- Footer -->
include_once 'partials/footer.php'
?>