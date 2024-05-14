<?php
include('partials/header.php');

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true){
    header('Location: 404.php');
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>
<main>
    <section class="container">
        <div class="row">
            <div class="col-100 text-left">
                
                <h1>Kosik</h1>
                <h2>Objednávka</h2>
                <h2>Dishes</h2>
                <?php
                    
                ?>
            </div>
        </div>
    </section> 
</main>
<?php
    include('partials/footer.php');
?>

