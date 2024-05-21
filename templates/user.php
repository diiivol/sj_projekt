<?php

// Spustenie vyrovnávacej pamäte výstupu. To znamená, že akýkoľvek výstup,
// ktorý skript generuje po tomto bode, sa ukladá do internej pamäte namiesto
// toho, aby bol okamžite odoslaný klientovi. To môže byť užitočné, ak chcete
// upraviť HTTP hlavičky po tom, ako už bol vygenerovaný nejaký výstup.
ob_start();

// Header
include 'partials/header.php';

// Kontrola prihlásenia a role užívateľa
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 1) {
    header('Location: 404.php');
}

// Inicializácia košíka
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Vykonanie nového objektu jedál
$dishes_object = new Dishes();

    $dishes = [];

    // Prechádzanie jedál a pridanie ich do poľa
    foreach ($dishes_object->select() as $dish) {
        $dishes[$dish->id] = $dish;
    }

// Vytvorenie nového objektu košíka
$cart = new Cart();

    $totalPrice = 0;

    if (isset($_POST['remove_from_cart'])) {
        $id = $_POST['product_id'];
        $cart->removeProduct($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Získanie obsahu košíka
    $cartItems = $cart->getCart();

// Vytvorenie nového objektu objednávky
$order_object = new Order();

    $userId = $_SESSION['user_id'];

    // Vytvorenie objednávky
    if (isset($_POST['order'])) {
        $order_object->createOrder($userId, $cartItems, $totalPrice + $delivery);
        $order_object->clearCart();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

?>

<!-- Obsah -->
    <div class="container user pt-3 mb-4">
        <div class="row">

            <!-- Zobrazenie košíka -->
            <h1>Košík</h1>
            
            <?php

            // Zobrazenie položiek v košíku
            if (!empty($cartItems)) {
                echo '<div class="container pt-3 mb-4 items-table">';
                echo '<div class="col-md-6 col-lg-4">';
                echo '<img class="image-top" src="../assets/img/bill/image1.png" alt="Top image">';
                echo '<div class="bill p-3">';
                echo '<table class="user-table">';
                echo '<tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>';

                // Prechádzanie položiek v košíku
                foreach ($cartItems as $id => $quantity) {
                    
                    if (isset($dishes[$id])) {
                        // Získanie názvu jedla z poľa jedál podľa ID
                        $name = $dishes[$id]->name;
                        // Získanie ceny jedla z poľa jedál podľa ID
                        $price = $dishes[$id]->price;
                    }

                    // Nastavenie ceny doručenia
                    $delivery = 5;
                    // Výpočet celkovej ceny objednávky (cena jedla * množstvo + cena doručenia)
                    $totalPrice += $price * $quantity + $delivery;

                    echo '<tr>';
                    echo '<td>' . $name . '</td>';
                    echo '<td>' . $price . '</td>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td>';
                    echo '<form method="POST">
                            <input type="hidden" name="product_id" value="' . $id . '">
                            <input type="submit" value="Remove" name="remove_from_cart" class="btn btn-danger">
                          </form></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<h4>Total price: ' . $totalPrice . '€</h4>';
                echo '<h4>Delivery: ' . $delivery . '€</h4>';
                echo '<h3><u>Total price with delivery: ' . ($totalPrice + $delivery) . '€</u></h3>';
                echo '<form method="POST">
                <input type="submit" value="Order" name="order" class="btn btn-primary mb-4">
                </form>';

                echo '</div>';
                echo '<img class="image-bottom" src="../assets/img/bill/image2.png" alt="Bottom image">';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<h4>Nič tu nie je.</h4>
                    <h4>Prejsť do <a href="menu.php">menu</a>?</h4>';
            }
            ?>

            <!-- Zobrazenie objednávok -->
            <h1>Objednávky</h1>

            <?php
            // Získanie objednávok podľa ID užívateľa
            $orders = $order_object->select($userId);
            if (!empty($orders)) {
                echo '<div class="container pt-3 mb-4 orders">';
                echo '<div class="row">';
                foreach ($orders as $o) {
                    echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="food-item">';
                    $statusClass = '';
                    // Nastavenie triedy podľa stavu objednávky
                    switch ($o->order_status) {
                        case 'prijatá':
                            $statusClass = 'status-pending';
                            break;
                        case 'pripravuje sa':
                            $statusClass = 'status-processing';
                            break;
                        case 'hotová':
                            $statusClass = 'status-completed';
                            break;
                    }
                    echo '<div class="in_cart ' . $statusClass .'">' . $o->order_status . '</div>';
                    echo '<h3>Objednávka №' . $o->id . '</h3>';

                    // Získanie jedál z objednávky
                    $items = $order_object->select_dishes($o->id);
                    // Vytvorenie zoznamu jedál
                    $itemNames = array();
                    // Prechádzanie jedál
                    foreach ($items as $item) {
                        $itemNames[] = $item->name . ' x' . $item->quantity;
                    }
                    // Spojenie názvov jedál do reťazca
                    $itemNamesString = implode('<br>', $itemNames);
                    echo '<p>' . $itemNamesString . '</p>';
                    echo '<h4>Order Price: ' . $o->total_price . '€</h4>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<h4>Nič tu nie je.</h4>';
            }
            echo '</div>';
            ?>
        </div>
    </div>

<!-- Footer -->
<?php
include 'partials/footer.php';
?>