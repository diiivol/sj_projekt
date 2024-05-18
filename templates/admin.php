<?php
ob_start();
include('partials/header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 0) {
    header('Location: 404.php');
}
?>
<main>
    <section class="container pt-3 mb-4">
        <div class="row">
            <!-- <div class="col-100"> -->
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
                echo '<div class="container pt-3 mb-4 contacts-table">';
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
                                <button type="submit" name="delete_contact" class="btn btn-danger" value="' . $c->id . '"' . '>Vymazať</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '</div>';
                ?>



                <h2>Jedlá</h2>
                <?php
                $dishes_object = new Dishes();


                $dishes = $dishes_object->select();


                if (isset($_POST['delete_dishes'])) {
                    // $dishes_id = $_POST['delete_dishes'];
                    $dishes_object->delete();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
                if (isset($_POST['update_dishes'])) {
                    // $dishes_id = $_POST['update_dishes'];
                    $dishes_object->update();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                if (isset($_POST['add_dish'])) {
                    $dishes_object->insert();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                
                echo '<div class="container pt-3 mb-4 dishes-table">';
                echo '<table class="admin-table">';
                echo '<tr><th>Name</th>
                          <th>Description</th>
                          <th>Price <i class="fa fa-eur" ></th>
                          <th>Ingredients</th>
                          <th><i class="fa fa-pencil" ></th>
                          <th><i class="fa fa-trash"></th>
                      </tr>';
                
                foreach ($dishes as $d) {
                    echo '<tr>';
                    echo '<td class="dish-name">' . $d->name . '</td>';
                    echo '<td class="dish-description">' . $d->description . '</td>';
                    echo '<td class="dish-price">' . $d->price . '</td>';
                    echo '<td class="dish-ingredients">' . $d->ingredients . '</td>';
                    
                    echo '<td>
                            <form action="" method="POST">
                                <input type="hidden" name="new_dish_name" value="' . $d->name . '" required>
                                <input type="hidden" name="new_dish_description" value="' . $d->description . '" required>
                                <input type="hidden" name="new_dish_price" value="' . $d->price . '" required>
                                <input type="hidden" name="new_dish_ingredients" value="' . $d->ingredients . '" required>
                                <button class="edit-button" type="button">Upraviť</button>
                                <button class="save-button" type="submit" name="update_dishes" value="' . $d->id . '" style="display: none;">OK</button>
                            </form>
                          </td>';
                    echo '<td>
                            <form action="" method="POST">
                                <button type="submit" name="delete_dishes" class="btn btn-danger" value="' . $d->id . '">Vymazať</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                echo '<tr>
                    <form method="POST">
                        <td><input type="text" id="new_dish_name" name="new_dish_name" required style="width: 100%;"></td>
                        <td><textarea id="new_dish_description" name="new_dish_description" required rows="4" style="width: 100%;"></textarea></td>
                        <td><input type="number" value="0" min="0" step="0.50" id="new_dish_price" name="new_dish_price" required style="width: 100%;"></td>
                        <td><textarea id="new_dish_ingredients" name="new_dish_ingredients" required rows="4" style="width: 100%;"></textarea></td>
                        <td colspan="2"><input type="submit" value="Add Dish" name="add_dish" required></td>
                    </form>
                </tr>';
                
                echo '</table>';


                echo '</div>';
            

                ?>
                <h2>Objednávky</h2>
                <?php
                $order_object = new Order();
                $orders = $order_object->select();
                foreach ($orders as $order) {
                    $items = $order_object->select_dishes($order->id);
                }

                if (isset($_POST['delete_order'])) {
                    // $order_id = $_POST['delete_order'];
                    $order_object->delete();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                if (isset($_POST['update_order'])) {

                    $order_object->update();
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                
                echo '<div class="container pt-3 mb-4 orders">';
                echo '<div class="row">';
                
                foreach ($orders as $o) {
                    echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="food-item">';
                    echo '<h3>Objednávka №' . $o->id . '</h3>';
                    echo '<p>User ID: ' . $o->user_id . '</p>';
                    echo '<p>Dátum objednávky: ' . $o->order_date . '</p>';

                    $items = $order_object->select_dishes($o->id);

                    $itemNames = array();
                    foreach ($items as $item) {
                        $itemNames[] = $item->name . ' x' . $item->quantity; 
                    }
                    $itemNamesString = implode(', ', $itemNames);

                    echo '<p>' . $itemNamesString . '</p>';

                    echo '<p>Objednávka je</p>'; 
                    
                    echo '<form action="" method="POST" class="order-update-form">';
                    echo '<select name="order_status" class="form-select" onchange="this.form.submit()">';
                    echo '<option value="accepted"' . ($o->order_status == 'accepted' ? ' selected' : '') . '>prijatá</option>';
                    echo '<option value="preparing"' . ($o->order_status == 'preparing' ? ' selected' : '') . '>pripravená</option>';
                    echo '<option value="ready"' . ($o->order_status == 'ready' ? ' selected' : '') . '>pripravená</option>';
                    echo '</select>';
                    echo '<input type="hidden" name="update_order" value="' . $o->id . '">';
                    echo '</form>';
                    

                    
                    echo '<form action="" method="POST">';
                    echo '<button type="submit" name="delete_order" value="' . $o->id . '" class="btn btn-danger mt-3">Delete</button>';
                    echo '</form>';
                    

                    echo '</div>'; 
                    echo '</div>'; 
                }
                

                echo '</div>'; 
                // echo '</div>'; 
                

                ?>
            </div>
        </div>
    </section>
</main>
<?php
include('partials/footer.php');
?>