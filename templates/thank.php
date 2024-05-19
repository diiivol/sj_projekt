<!-- Header -->
<?php
include_once 'partials/header.php';
?>
<!--  -->
<div class="container thank pt-3 d-flex justify-content-center align-items-center">
  <div class="text-center">
    <h1 class="display-4 mb-4">Ďakujem!</h1>
    <p>Vaša správa bola odoslaná.</p>
    <a href="index.php" class="btn btn-primary mt-4">Späť na hlavnú stránku</a>
    <?php
$contact_object = new Contact();
$contact_object->insert();
?>
  </div>
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