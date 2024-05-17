<?php
include('partials/header.php');
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: admin.php');
}
?>
<main>
    <section class="container login pt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <h1 class="display-4 text-center mb-4">Prihlásenie</h1>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Vaš e-mail">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Vaše heslo">
                    </div>
                    <div class="d-flex">
                        <button type="submit" name="user_login" class="btn btn-primary">Odoslať</button>
                        <a href="register.php" class="btn btn-link">Registrovať sa</a>
                    </div>
                </form>

                <?php

                if (isset($_POST['user_login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $user = new User();
                    //tu bude vzdy true alebo false
                    $login_success = $user->login($email, $password);
                    if ($login_success == true) {


                        if ($_SESSION['user_role'] == 1) {
                            header('Location: admin.php');
                        } else {
                            $_SESSION['cart'] = array();
                            header('Location: user.php');
                        }
                        exit;
                    } else {
                        echo 'Nesprávne meno alebo heslo';
                    }
                }

                ?>

            </div>
        </div>
    </section>
</main>
<?php
include('partials/footer.php');
?>