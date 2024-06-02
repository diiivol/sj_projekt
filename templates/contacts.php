<?php
include_once 'partials/header.php';

// // // // CONTACT // // //
$contact_object = new Contact();


// is set? KONTAKT
if (isset($_POST['contact_submitted'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $acceptance = $_POST['acceptance'];
    try {
        $contact_object->insert($name, $email, $message, $acceptance);
        header('Location: thank.php');
    } catch (PDOException $e) {
        echo 'Chyba pri odosielaní správy: ' . $e->getMessage();
    }
}

?>
<!--  -->
<div class="container kontakt pt-3">
    <h1 class="display-4 text-center mb-4">Kontakt</h1>
    <!--  -->
    <!-- Formulár (5b) -->
    <!--  -->
    <!-- Polia: Meno, Email, Textarea, Súhlas so spracovaním osobných údajov, Odoslať -->
    <!-- Ošetrenie emailovej adresy -->
    <!-- Súhlas so spracovaním osobných údajov -->
    <!-- Redirect na thank you page -->
    <!-- Validácia  -->
    <!--  -->
    <div class="row">
        <div class="col-md-8 col-lg-6 mx-auto">
            <form id="contact" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Meno</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Zadajte svoje meno" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Zadajte svoju e-mailovú adresu" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Správa</label>
                    <textarea class="form-control" name="message" id="message" rows="5" placeholder="Napíšte svoj názor a myšlienky po návšteve našej reštaurácie alebo sa na niečo spýtajte!" required></textarea>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" name="acceptance" value="1" type="checkbox" required>
                    <label class="form-check-label">
                    Súhlas so spracovaním osobných údajov
                    </label>
                </div>
                <button type="submit" name="contact_submitted" class="btn btn-primary">Odoslať</button>
            </form>
        </div>
    </div>
    <!--  -->
    <!-- Adresa -->
    <div class="row my-4">
        <div class="col-md-8 col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Adresa</h5>
                    <p class="card-text">949 01, Nitra, Slovensko</p>
                    <!--  -->
                    <!-- Odkaz na email a telefón (mailto: , tel: ) (1b) -->
                    <!--  -->
                    <p class="card-text">
                    T. C.: <a href="tel:+123456789">+123456789</a>
                    </p>
                    <p class="card-text">
                    Email: <a href="mailto:Oyster@mail.com">Oyster@mail.com</a>
                    </p>
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
    <!-- Mapa -->
    <div class="row mb-4">
        <div class="col-md-8 col-lg-6 container text-center">
            <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5307.425477452054!2d18.086291158691395!3d48.30837599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee43b2f6763%3A0x75a567f979f5bed3!2sUniverzita%20Kon%C5%A1tant%C3%ADna%20Filozofa!5e0!3m2!1ssk!2ssk!4v1702563808753!5m2!1ssk!2ssk" width="632" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <!--  -->
    <!--  -->
    <!-- Tlačidlo s preklikom na inú stránku (1b) - <a> tag, ktorý je naštýlovaný ako button -->
    <!-- Alert (1b) -->
    <!--  -->
    <div class="row my-4">
        <div class="col-md-8 col-lg-6 social-buttons container text-center">
            <a href="https://twitter.com" class="social-button twitter" target="_blank" onclick="return confirmRedirect();">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="https://facebook.com" class="social-button facebook" target="_blank" onclick="return confirmRedirect();">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="https://instagram.com" class="social-button instagram" target="_blank" onclick="return confirmRedirect();">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="https://linkedin.com" class="social-button linkedin" target="_blank" onclick="return confirmRedirect();">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
        </div>
    </div>
  <!--  -->
</div>
<!--  -->
<!-- Footer (2b) -->
<!--  -->
<!-- Niekoľko stĺpcov s informáciami o stránke -->
<!-- Copyright -->
<!--  -->
<?php
include_once 'partials/footer.php'
?>