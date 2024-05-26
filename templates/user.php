<?php

/**
 * Start output buffering.
 * This means that any output that the script generates after this point is stored in internal memory instead of being
 * immediately sent to the client. This can be useful if you want to modify HTTP headers after some output has already been generated.
 */
ob_start();

/**
 * This file is used to start a session and include all necessary classes.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

/**
 * Include the header file.
 */
include 'partials/header.php';

/**
 * Check if the user is logged in and has the correct role.
 */
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 1) {
    header('Location: 404.php');
    exit();
}

/**
 * Initialize the cart if it's not already set.
 */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

/**
 * Create a new Dishes object and get all dishes.
 *
 * @var Dishes
 */
$dishes_object = new Dishes();
$dishes = [];
foreach ($dishes_object->select() as $dish) {
    $dishes[$dish->id] = $dish;
}

/**
 * Create a new Cart object and calculate the total price of the items in the cart.
 *
 * @var Cart
 */
$cart = new Cart();
$totalPrice = 0;
$delivery = 5;
$cartItems = $cart->select();
foreach ($cartItems as $id => $quantity) {
    if (isset($dishes[$id])) {
        $price = $dishes[$id]->price;
    }
    $totalPrice += $price * $quantity;
}

/**
 * If the remove from cart form is submitted, remove the item from the cart and refresh the page.
 */
if (isset($_POST['remove_from_cart'])) {
    $id = $_POST['product_id'];
    $cart->delete($id);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

/**
 * Create a new Order object.
 *
 * @var Order
 */
$order_object = new Order();
$userId = $_SESSION['user_id'];

/**
 * If the order form is submitted, create a new order, clear the cart, and refresh the page.
 */
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

<div class="container user pt-3 mb-4">    
    <div class="row">
        
        <h1>Košík</h1>
        
        <?php if (!empty($cartItems)) : ?>
        <div class="container pt-3 mb-4 items-table">
            <div class="row d-flex justify-content-between">
                <!-- Zobrazenie košíka -->
                <div class="col-lg-4">
                    <img class="image-top" src="../assets/img/bill/image1.png" alt="Top image">
                    <div class="bill p-3">
                        <table class="user-table mb-3">
                            <tr>
                                <th>Názov</th>
                                <th>Cena</th>
                                <th>ks</th>
                                <th></th>
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
                                            <button type="submit" class="remove_btn" value="Remove" name="remove_from_cart" >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <h4>Medzisučet: <?php echo $totalPrice; ?>€</h4>
                        <h5>Doručenie: <?php echo $delivery; ?>€</h5>
                        <h3><u>Spolu cena: <?php echo $totalPrice + $delivery; ?>€</u></h3>
                    </div>
                    <img class="image-bottom" src="../assets/img/bill/image2.png" alt="Bottom image">
                </div>
                <!-- Formulár pre vytvorenie objednávky -->
                <div class="col-lg-6 mx-5">
                    <div class="card p-3">
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Meno prijímateľa</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="street" class="form-label">Ulica</label>
                                    <input type="text" class="form-control" id="street" name="street" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Mesto</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                                <div class="mb-3">
                                    <label for="postcode" class="form-label">PSČ</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" required>
                                </div>
                                <div class="d-flex">
                                    <input type="submit" value="Order" name="order" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else : ?>
        <h4>Nič tu nie je.</h4>
        <h4>Prejsť do <a href="menu.php">menu</a>?</h4>
        <?php endif; ?>
        
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
            <h4>Ešte ste nevykonali žiadne objednávky.</h4>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php
include 'partials/footer.php';
?>