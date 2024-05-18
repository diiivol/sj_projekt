<?php
ob_start();

include('partials/header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 1) {
    header('Location: 404.php');
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>
<main>
    <section class="container pt-3 mb-4">
        <div class="row">
            <!-- <div class="col-100 text-left"> -->
                <?php
                echo '<h1>Košík</h1>';
                $dishes_class = new Dishes();
                $order_object = new Order();
                
                $dishes =[];
                foreach ($dishes_class->select() as $dish) {
                    $dishes[$dish->id] = $dish;
                }

                $cart = new Cart();
                $cartItems = $cart->getCart();

                // $dishes = $dishes_class->select();
                $totalPrice = 0;
                $userId = $_SESSION['user_id'];


                if (!empty($cartItems)) {
                    echo '<div class="container pt-3 mb-4 items-table">';
                    echo '<table class="user-table">';
                    echo '<tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>';
                    
                    foreach ($cartItems as $id => $quantity) {
                        if (isset($dishes[$id])) {
                            $name = $dishes[$id]->name;
                            $price = $dishes[$id]->price;
                            
                        }
                        $delivery = 5;
                        $totalPrice += $price * $quantity + $delivery;
                        echo '<tr>';
                        echo '<td>' . $name . '</td>';
                        echo '<td>' . $price . '</td>';
                        echo '<td>' . $quantity . '</td>';
                        echo '<td><form method="POST">
                              <input type="hidden" name="product_id" value="' . $id . '">
                            <input type="submit" value="Remove" name="remove_from_cart" class="btn btn-danger">
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
                    echo '</div>';
                    echo '<h4>Total price: ' . $totalPrice . '€</h4>';
                    echo '<h4>Delivery: ' . $delivery . '€</h4>';
                    
                    echo '<h3><u>Total price with delivery: ' . ($totalPrice + $delivery) . '€</u></h3>';
                                        
                    echo '<form method="POST">
                        <input type="submit" value="Order" name="order" class="btn btn-primary mb-4">
                    </form>';
                    
                    if (isset($_POST['order'])) {
                        $order_object->createOrder($userId, $cartItems, $totalPrice + $delivery);
                        $order_object->clearCart();
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    }
                } else {
                    echo '<h4>Nič tu nie je. Prejsť do <a href="menu.php">menu</a>?</h4>';
                }
                ?>



                <h1>Objednávky</h1>
                <?php
                $orders = $order_object->select($userId);
                
                if (!empty($orders)) {

                echo '<div class="container pt-3 mb-4 orders">';
                echo '<div class="row">';

                foreach ($orders as $o) {
                    echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="food-item">';
                    echo '<h3>Order №' . $o->id . '</h3>';
                    // echo '<p>Order Date: ' . $o->order_date . '</p>';
                    
                    $items = $order_object->select_dishes($o->id);
                    
                    $itemNames = array();
                    foreach ($items as $item) {
                        $itemNames[] = $item->name . ' x' . $item->quantity; 
                    }
                    $itemNamesString = implode('<br>', $itemNames);
                    
                    echo '<p>' . $itemNamesString . '</p>';
                    
                    echo '<p>Order Status: ' . $o->order_status . '</p>';
                    echo '<h4>Order Price: ' . $o->total_price . '€</h4>';
                    echo '</div>'; 
                    echo '</div>'; 
                }

                echo '</div>';  }
                // echo '</div>'; 
                else {
                    echo '<h4>Nič tu nie je.</h4>';
                }
                
                ?>
            </div>
        </div>
    </section>
</main>
<?php
include('partials/footer.php');
?>