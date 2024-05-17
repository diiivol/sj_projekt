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
                <?php
                $cart = new Cart();
                $dishes_class = new Dishes();

                $cartItems = $cart->getCart();
                $dishes = $dishes_class->select();
                $totalPrice = 0;
                $userId = $_SESSION['user_id'];

                echo '<h3>Užívateľ: ' . $_SESSION['user_email'] . '</h3>';

                if (!empty($cartItems)) {
                    echo '<table>';
                    echo '<tr><th>Product</th><th>Quantity</th><th>Action</th></tr>';

                    foreach ($cartItems as $id => $quantity) {
                        $name = $dishes[$id - 1]->name;
                        $price = $dishes[$id - 1]->price;
                        $delivery = 5;
                        $totalPrice += $price * $quantity + $delivery;
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
                    echo '<h4>Total price: ' . $totalPrice . '€</h4>';
                    echo '<h4>Delivery: ' . $delivery . '€</h4>';
                    echo '<h3>Total price with delivery: ' . ($totalPrice + $delivery) . '€</h3>';
                    echo '<form method="POST">
                          <input type="submit" value="Order" name="order">
                      </form>';
                    if (isset($_POST['order'])) {
                        $order = new Order();
                        $order->createOrder($userId, $cartItems);
                        $order->clearCart();
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    }
                } else {
                    echo '<h3>Nic tu nie je</h3>';
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php
include('partials/footer.php');
?>