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
                <?php
                $cart = new Cart();
                $dishes_class = new Dishes();

                $cartItems = $cart->getCart();
                $dishes = $dishes_class->select();

                echo '<table>';
                echo '<tr><th>Product</th><th>Quantity</th><th>Action</th></tr>';

                foreach ($cartItems as $id => $quantity) {
                    $name = $dishes[$id-1]->name;
                    echo '<tr>';
                    echo '<td>' . $name . '</td>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td><form action="remove_from_cart.php" method="post">
                              <input type="hidden" name="product_id" value="' . $id . '">
                              <input type="submit" value="Remove">
                          </form></td>';
                    echo '</tr>';
                }

                echo '</table>';
                ?>
            </div>
        </div>
    </section> 
</main>
<?php
    include('partials/footer.php');
?>

