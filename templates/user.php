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
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $order_object->insert($userId, $cartItems, $totalPrice + $delivery, $name, $street, $city, $postcode);
    $order_object->clearCart();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!-- Obsah -->
<div class="container user pt-3 mb-4">
    
    <h1>Košík</h1>
    <div class="row">
        <?php if (!empty($cartItems)) : ?>
            <div class="container pt-3 mb-4 items-table">
                <div class="row">
                <div class="col-lg-4">
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
                                                <button type="submit" value="Remove" name="remove_from_cart" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <h4>Cena: <?php echo $totalPrice; ?>€</h4>
                            <h4>Doručenie: <?php echo $delivery; ?>€</h4>
                            <h3><u>Spolu cena: <?php echo $totalPrice + $delivery; ?>€</u></h3>
                        </div>
                        <img class="image-bottom" src="../assets/img/bill/image2.png" alt="Bottom image">
                    </div>
                    <div class="col-lg-8">
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">Meno Priezvisko</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="street">Ulica</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="form-group">
                                <label for="city">Mesto</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="postcode">PSČ</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" required>
                            </div>
                            <input type="submit" value="Order" name="order" class="btn btn-primary mt-4">
                        </form>
                    </div>
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

        <h1>Objednávky</h1>
        <?php if (!empty($orders)): ?>
            <div class="container pt-3 mb-4 orders">
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