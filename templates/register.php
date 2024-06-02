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

/**
 * Skontrolujte, či je užívateľ už prihlásený
 * Ak áno, presmerujte ich na stránku 404
 */
if ($_SESSION['logged_in'] == true) {
    header('Location: 404.php');
}

/**
 * Vytvorte nový objekt User
 */
$user_object = new User();

// Inicializácia chybových hlásení
$passwordError = '';
$registerError = '';

/**
 * Skontrolujte, či bola odoslaná registračná forma
 */
if (isset($_POST['user_register'])) {
    /**
     * Získajte odoslaný email, heslo a potvrdenie hesla
     */
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    /**
     * Skontrolujte, či sa heslo a potvrdenie hesla zhodujú
     */
    if ($password === $confirm_password) {
        /**
         * Pokúste sa zaregistrovať užívateľa
         * Ak je úspešný, zobrazte správu o úspechu
         * Ak nie je úspešný, zobrazte chybovú správu
         */
        if ($user_object->register($email, $password)) {
            // Prihlásiť užívateľa
            $user_object->login($email, $password);
            // Presmerovanie na dashboard užívateľa alebo domovskú stránku
            header('Location: user.php');
            exit();
        } else {
            $registerError = "Užívateľ s týmto e-mailom už existuje";
        }
    } else {
        /**
         * Ak sa heslo a potvrdenie hesla nezhodujú, zobrazte chybovú správu
         */
        $passwordError = "Heslá sa nezhodujú";
    }
}
?>

<!-- Registračný formulár -->
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
                    <p class='text-center'><?php echo $passwordError; ?></p>
                </div>
                <div class="d-flex">
                    <button type="submit" name="user_register" class="btn btn-primary">Registrovať sa</button>
                    <a href="login.php" class="btn btn-link">Prihlásiť sa</a>
                </div>
                <div class='mt-3'><?php echo $registerError; ?></div>
            </form>
      </div>
    </div>
</div>

<?php
/**
 * Zahrnutie footeru
 */
include_once 'partials/footer.php';
?>