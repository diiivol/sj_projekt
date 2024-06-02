<?php
/**
 * Tento súbor sa používa na spustenie relácie a zahrnutie všetkých potrebných tried.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

// Zahrnúť header
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