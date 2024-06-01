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
<main>
    <section class="container">
        <div class="row">
            <div class="col-100 text-left">
                <?php
                // Unset all session variables
                $_SESSION = array();

                unset($_SESSION['logged_in']);
                unset($_SESSION['cart']);

                // Destroy the session
                session_destroy();

                // Redirect to the login page
                header('Location: login.php');
                ?>
            </div>
        </div>
    </section>
</main>
<?php
include 'partials/footer.php';
?>