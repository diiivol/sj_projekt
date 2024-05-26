<?php
/**
 * This file is used to start a session and include all necessary classes.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

// Include the header
include 'partials/header.php';

/**
 * Check if the user is already logged in
 * If they are, redirect them to the 404 page
 */
if ($_SESSION['logged_in'] == true) {
    header('Location: 404.php');
}

/**
 * Create a new User object
 */
$user_object = new User();

/**
 * Check if the registration form has been submitted
 */
if (isset($_POST['user_register'])) {
    /**
     * Get the submitted email, password, and confirm password
     */
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    /**
     * Check if the password and confirm password match
     */
    if ($password === $confirm_password) {
        /**
         * Attempt to register the user
         * If successful, display a success message
         * If not successful, display an error message
         */
        if ($user_object->register($email, $password)) {
            echo "<p>Registrácia bola úspešná</p>";
        } else {
            echo "<p>Registrácia zlyhala alebo užívateľ s týmto e-mailom už existuje</p>";
        }
    } else {
        /**
         * If the password and confirm password do not match, display an error message
         */
        echo "<p>Heslá sa nezhodujú</p>";
    }
}
?>

<!-- Registration form -->
<div class="container register d-flex align-items-center justify-content-center">
    <div class = "card p-3">
      <div class="card-body">
            <h1 class="display-4 text-center mb-4">Registrácia</h1>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Vaš e-mail" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Vaše heslo" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Zopakovať heslo:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Zopakovať heslo" required>
                </div>
                <div class="d-flex">
                    <button type="submit" name="user_register" class="btn btn-primary">Registrovať sa</button>
                    <a href="login.php" class="btn btn-link">Prihlásiť sa</a>
                </div>
            </form>
      </div>
    </div>
</div>

<?php
/**
 * Include the footer partial
 */
include_once 'partials/footer.php';
?>