<?php

/**
 * Tento súbor sa používa na spustenie relácie a zahrnutie všetkých potrebných tried.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

/**
 * Zahrnutie headeru
 */
include 'partials/header.php';

?>

<!-- Display a thank you message -->
<div class="container thank pt-3 d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h1 class="display-4 mb-4">Ďakujem!</h1>
        <p>Vaša správa bola odoslaná.</p>
        <a href="index.php" class="btn btn-primary mt-4">Späť na hlavnú stránku</a>
    </div>
</div>

<?php

// Zahrnutie footeru
include_once 'partials/footer.php';

?>