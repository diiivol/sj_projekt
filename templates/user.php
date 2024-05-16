<?php
include('partials/header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 1) {
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
                $totalPrice = 0;
                echo '<table>';
                echo '<tr><th>Product</th><th>Quantity</th><th>Action</th></tr>';

                foreach ($cartItems as $id => $quantity) {
                    $name = $dishes[$id - 1]->name;
                    $price = $dishes[$id - 1]->price;
                    $totalPrice += $price * $quantity;
                    echo '<tr>';
                    echo '<td>' . $name . '</td>';
                    echo '<td>' . $price . '</td>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td><form method="POST">
                              <input type="hidden" name="product_id" value="' . $id . '">
                              <input type="submit" value="Remove" name="remove_from_cart">
                          </form></td>';
                    echo '</tr>';
                }
                if (isset($_POST['remove_from_cart'])) {
                    $product_id = $_POST['product_id'];
                    $cart->removeProduct($product_id);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
                echo '</table>';
                echo '<h3>Total price: ' . $totalPrice . '€</h3>';
                ?>
            </div>
        </div>
    </section>
</main>
<?php
include('partials/footer.php');
?>