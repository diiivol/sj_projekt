<?php

require_once 'partials/header.php';


if ($_SESSION['logged_in'] == true) {
    header('Location: 404.php');
}


$user_object = new User();

// chybové hlášky
$passwordError = '';
$registerError = '';

// is set? REGISTRACIA
if (isset($_POST['user_register'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // či sa heslo a potvrdenie hesla zhodujú?
    if ($password === $confirm_password) {

        if ($user_object->register($email, $password)) {
            $user_object->login($email, $password);
            header('Location: user.php');
            exit();
        } else {
            $registerError = "Užívateľ s týmto e-mailom už existuje";
        }
    } else {
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
require_once 'partials/footer.php';
?>