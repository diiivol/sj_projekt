<?php

/**
 * This file is used to start a session and include all necessary classes.
 */
if (!file_exists('partials/header.php')) {
  die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

/**
* Include the header file.
*/
include 'partials/header.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  // If not, redirect back to the form
  header('Location: 404.php');
  exit;
}

// Create a new Contact object and insert it into the database
$contact_object = new Contact();
$contact_object->insert();

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

// Include the footer
include_once 'partials/footer.php';

?>