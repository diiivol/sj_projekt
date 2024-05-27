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

// Create a new Contact object and insert it into the database
$contact_object = new Contact();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert the new contact into the database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $acceptance = $_POST['acceptance'];
    $contact_object->insert($name, $email, $message, $acceptance);
} else {
    // Redirect to the homepage if the form was not submitted
    header('Location: 404.php');
    exit;
}

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