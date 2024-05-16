<?php
include_once('partials/header.php');
if ($_SESSION['logged_in'] == true) {
  header('Location: 404.php');
}

$user_object = new User();


if (isset($_POST['user_register'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];


  if ($password === $confirm_password) {

    if ($user_object->register($email, $password)) {
      echo "<p>Registrácia bola úspešná</p>";
    } else {
      echo "<p>Registrácia zlyhala</p>";
    }
  } else {
    echo "<p>Heslá sa nezhodujú</p>";
  }
}
?>

<main>
  <section class="container">
    <div class="row">
      <div class="col-100">
        <h1>Registrácia</h1>
        <form action="" method="POST">
          <label for="email">E-mail:</label>
          <br>
          <input type="email" id="email" name="email" required>
          <br>
          <label for="password">Heslo:</label>
          <br>
          <input type="password" id="password" name="password" required>
          <br>
          <label for="confirm_password">Zopakovať heslo:</label>
          <br>
          <input type="password" id="confirm_password" name="confirm_password" required>
          <br>
          <button type="submit" name="user_register">Registrovať sa</button>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
include_once('partials/footer.php');
?>