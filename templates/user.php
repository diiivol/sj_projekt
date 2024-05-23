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
$delivery = 5;

// Získanie obsahu košíka
$cartItems = $cart->select();

foreach ($cartItems as $id => $quantity) {
    if (isset($dishes[$id])) {
        $price = $dishes[$id]->price;
    }
    $totalPrice += $price * $quantity;
}

// Odstránenie položky z košíka
if (isset($_POST['remove_from_cart'])) {
    $id = $_POST['product_id'];
    $cart->delete($id);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Vytvorenie nového objektu objednávky
$order_object = new Order();

$userId = $_SESSION['user_id'];

// Vytvorenie objednávky
if (isset($_POST['order'])) {
    $order_object->insert($userId, $cartItems, $totalPrice + $delivery);
    $order_object->clearCart();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!-- Obsah -->
<div class="container user pt-3 mb-4">
    <div class="row">
        <?php if (!empty($cartItems)) : ?>
            <div class="container pt-3 mb-4 items-table">
                <div class="col-md-6 col-lg-4">
                    <img class="image-top" src="../assets/img/bill/image1.png" alt="Top image">
                    <div class="bill p-3">
                        <table class="user-table">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($cartItems as $id => $quantity) : ?>
                                <?php if (isset($dishes[$id])) :
                                    $name = $dishes[$id]->name;
                                    $price = $dishes[$id]->price;
                                endif; ?>
                                <tr>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                            <input type="submit" value="Remove" name="remove_from_cart" class="btn btn-danger">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <h4>Total price: <?php echo $totalPrice; ?>€</h4>
                        <h4>Delivery: <?php echo $delivery; ?>€</h4>
                        <h3><u>Total price with delivery: <?php echo $totalPrice + $delivery; ?>€</u></h3>
                        <form method="POST">
                            <input type="submit" value="Order" name="order" class="btn btn-primary mb-4">
                        </form>
                    </div>
                    <img class="image-bottom" src="../assets/img/bill/image2.png" alt="Bottom image">
                </div>
            </div>
        <?php else : ?>
            <h4>Nič tu nie je.</h4>
            <h4>Prejsť do <a href="menu.php">menu</a>?</h4>
        <?php endif; ?>

        <!-- Zobrazenie objednávok -->
        <?php
        // Získanie objednávok podľa ID užívateľa
        $orders = $order_object->select($userId);
        ?>

        <?php if (!empty($orders)): ?>
            <div class="container pt-3 mb-4 orders">
            <h1>Objednávky</h1>
                <div class="row">
                    <?php foreach ($orders as $o): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="food-item">
                                <?php
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
                                ?>
                                <div class="in_cart <?= $statusClass ?>">
                                    <?= $o->order_status ?>
                                </div>
                                <h3>Objednávka №<?= $o->id ?></h3>
                                <?php
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
                                ?>
                                <p><?= $itemNamesString ?></p>
                                <h4>Order Price: <?= $o->total_price ?>€</h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <h4>Nič tu nie je.</h4>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php
include 'partials/footer.php';
?>