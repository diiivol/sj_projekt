<?php
ob_start();
include('partials/header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 0) {
    header('Location: 404.php');
}
?>
<main>
    <section class="container">
        <div class="row">
            <div class="col-100 text-left">
                <h1>Admin rozhranie</h1>



                <h2>Kontakty</h2>
                <?php
                $contact_object = new Contact();
                $contacts = $contact_object->select();
                if (isset($_POST['delete_contact'])) {
                    $contact_id = $_POST['delete_contact'];
                    $contact_object->delete();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
                echo '<table class="admin-table">';
                echo '<tr><th>Name</th>
                              <th>Email</th>
                              <th>Message</th>
                              
                              <th>Delete</th>
                          </tr>';
                foreach ($contacts as $c) {
                    echo '<tr>';
                    echo '<td>' . $c->name;
                    '</td>';
                    echo '<td>' . $c->email;
                    '</td>';
                    echo '<td>' . $c->message;
                    '</td>';
                    // echo '<td>'.$c->acceptance;'</td>';
                    echo '<td>
                            <form action="" method="POST">
                                <button type="submit" name="delete_contact" value="' . $c->id . '"' . '>Vymazať</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }

                echo '</table>';
                ?>



                <h2>Dishes</h2>
                <?php
                $dishes_object = new Dishes();


                $dishes = $dishes_object->select();


                if (isset($_POST['delete_dishes'])) {
                    $dishes_id = $_POST['delete_dishes'];
                    $dishes_object->delete();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }



                if (isset($_POST['update_dishes'])) {
                    $dishes_id = $_POST['update_dishes'];
                    $dishes_object->update();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
                
                echo '<table class="admin-table">';
                echo '<tr><th>Name</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Ingredients</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </tr>';
                
                foreach ($dishes as $d) {
                    echo '<tr>';
                    echo '<td class="dish-name">' . $d->name . '</td>';
                    echo '<td class="dish-description">' . $d->description . '</td>';
                    echo '<td class="dish-price">' . $d->price . '</td>';
                    echo '<td class="dish-ingredients">' . $d->ingredients . '</td>';
                    
                    echo '<td>
                            <form action="" method="POST">
                                <input type="hidden" name="new_dish_name" value="' . $d->name . '">
                                <input type="hidden" name="new_dish_description" value="' . $d->description . '">
                                <input type="hidden" name="new_dish_price" value="' . $d->price . '">
                                <input type="hidden" name="new_dish_ingredients" value="' . $d->ingredients . '">
                                <button class="edit-button" type="button">Upraviť</button>
                                <button class="save-button" type="submit" name="update_dishes" value="' . $d->id . '" style="display: none;">OK</button>
                            </form>
                          </td>';
                    echo '<td>
                            <form action="" method="POST">
                                <button type="submit" name="delete_dishes" value="' . $d->id . '">Vymazať</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                
                echo '</table>';
                
                
                

                ?>
                <h2>Orders</h2>
                <?php
                $order_object = new Order();
                $orders = $order_object->select();
                foreach ($orders as $order) {
                    $items = $order_object->select_dishes($order->id);
                    // Now $items contains the items for this order
                }

                if (isset($_POST['delete_order'])) {
                    // $order_id = $_POST['delete_order'];
                    $order_object->delete();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                foreach ($orders as $o) {
                    echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="food-item">';
                    echo '<h3>Order №' . $o->id . '</h3>';
                    echo '<p>User ID: ' . $o->user_id . '</p>';
                    echo '<p>Order Date: ' . $o->order_date . '</p>';


                    // // Get the items for this order
                    $items = $order_object->select_dishes($o->id);

                    // // Create a string with all item names, separated by commas
                    $itemNames = array();
                    foreach ($items as $item) {
                        $itemNames[] = $item->name . ' x' . $item->quantity; // replace 'name' with the actual field name in your database
                    }
                    $itemNamesString = implode(', ', $itemNames);

                    echo '<td>' . $itemNamesString . '</td>';

                    echo '<td>
                                <form action="" method="POST">
                                    <button type="submit" name="delete_order" value="' . $o->id . '"' . '>Vymazať</button>
                                </form>
                          </td>';
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