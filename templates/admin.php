<?php

// Spustenie vyrovnávacej pamäte výstupu. To znamená, že akýkoľvek výstup,
// ktorý skript generuje po tomto bode, sa ukladá do internej pamäte namiesto
// toho, aby bol okamžite odoslaný klientovi. To môže byť užitočné, ak chcete
// upraviť HTTP hlavičky po tom, ako už bol vygenerovaný nejaký výstup.
ob_start();

// Header
include 'partials/header.php';

// Kontrola prihlásenia a role užívateľa
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 0) {
    header('Location: 404.php');
}

// Vytvorenie nového objektu jedál
$dishes_object = new Dishes();


// Ak bol odoslaný formulár pre aktualizáciu jedla
    if (isset($_POST['update_dishes'])) {
        $id = $_POST['update_dishes'];
        $new_name = $_POST['new_dish_name'];
        $new_description = $_POST['new_dish_description'];
        $new_price = $_POST['new_dish_price'];
        $new_ingredients = $_POST['new_dish_ingredients'];
        try {
            $dishes_object->update($id, $new_name, $new_description, $new_price, $new_ingredients);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            echo 'Chyba pri aktualizácii jedla: ' . $e->getMessage();
        }
        exit();
    }

// Ak bol odoslaný formulár pre vymazanie jedla
    if (isset($_POST['delete_dishes'])) {
        $id = $_POST['delete_dishes'];
        if (is_numeric($id)) {
            try {
                $dishes_object->delete($id);
                header('Location: ' . $_SERVER['PHP_SELF']);
            } catch (Exception $e) {
                echo 'Chyba pri mazaní jedla: ' . $e->getMessage();
            }
        } else {
            echo "Chyba pri mazaní jedla: ID musí byť číslo";
        }
        exit();
    }

// Ak bol odoslaný formulár pre pridanie nového jedla
    if (isset($_POST['add_dish'])) {
        $new_dish = $_POST['add_dish']; // предполагается, что 'add_dish' содержит данные нового блюда
        try {
            $dishes_object->insert($new_dish);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            echo 'Chyba pri pridaní jedla: ' . $e->getMessage();
        }
        exit();
    }

// Získanie všetkých jedál
$dishes = $dishes_object->select();

// Vytvorenie nového objektu objednávky
$order_object = new Order();


// Ak bol odoslaný formulár pre vymazanie objednávky
    if (isset($_POST['delete_order'])) {
        $id = $_POST['delete_order'];
        try {
            // Vymažeme objednávku
            $order_object->delete($id);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            // Ak nastane chyba, vypíšeme ju
            echo "Chyba pri mazaní objednávky: " . $e->getMessage();
        }
        exit();
    }

// Ak bol odoslaný formulár pre aktualizáciu objednávky
    if (isset($_POST['update_order'])) {
        // Aktualizujeme objednávku
        $id = $_POST['update_order'];
        $new_status = $_POST['order_status'];
        try {
            $order_object->update($id, $new_status);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            // Ak nastane chyba, vypíšeme ju
            echo "Chyba pri aktualizácii objednávky: " . $e->getMessage();
        }
        exit();
    }

// Získanie všetkých objednávok
$orders = $order_object->select();


// Vytvorenie nového objektu kontaktu
$contact_object = new Contact();

// Ak bol odoslaný formulár pre vymazanie kontaktu
    if (isset($_POST['delete_contact'])) {
        $id = $_POST['delete_contact'];
        try {
            $contact_object->delete($id);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            echo "Chyba pri odstránení kontaktu: " . $e->getMessage();
        }
        exit();
    }

// Získanie všetkých kontaktov
$contacts = $contact_object->select();

?>
    <div class="container admin pt-3 mb-4">
        <div class="row">
                <h1>Kontakty</h1>
                <?php
                
                if (empty($contacts)) {
                    echo '<h4>Žiadne kontakty</h4>';
                } else {

                    echo '<div class="container pt-3 mb-4 contacts-table">';
                    echo '<table class="admin-table">';
                    echo '<tr>';
                    echo   '<th>Name</th>
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
                        echo '<td>
                                <form action="" method="POST">
                                    <button type="submit" name="delete_contact" class="btn btn-danger" value="' . $c->id . '"' . '>Vymazať</button>
                                </form>
                            </td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
                }
                ?>

<h1>Jedlá</h1>

<?php
if (empty($dishes)) {
    echo '<h4">Žiadne jedlá</h4>';
} else {

    echo '<div class="container pt-3 mb-4 dishes-table">';
    echo '<table class="admin-table">';
    echo '<tr>';
    echo   '<th>Name</th>
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
                    <button class="btn btn-warning edit-button" type="button">Upraviť</button>
                    <button class="btn btn-success save-button" type="submit" name="update_dishes" value="' . $d->id . '" style="display: none;">OK</button>
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
                <td><input type="text" id="new_dish_name" name="new_dish_name" placeholder="Názov jedla" required style="width: 100%;"></td>
                <td><textarea id="new_dish_description" name="new_dish_description" placeholder="Popis jedla" required rows="4" style="width: 100%;"></textarea></td>
                <td><input type="number" value="0" min="0" step="0.50" id="new_dish_price" name="new_dish_price" placeholder="Cena jedla" required style="width: 100%;"></td>
                <td><textarea id="new_dish_ingredients" name="new_dish_ingredients" placeholder="Ingrediencie jedla" required rows="4" style="width: 100%;"></textarea></td>
                <td colspan="2"><input type="submit" value="Pridať jedlo" name="add_dish" class="btn btn-primary" required></td>
            </form>
         </tr>';
    echo '</table>';
    echo '</div>';
}
?>

<h1>Objednávky</h1>

<?php
// Ak nie sú žiadne objednávky, vypíšeme správu
if (empty($orders)) {
    echo '<h4">Žiadne objednávky</h4>';
} else {
    echo '<div class="container pt-3 mb-4 orders">';
    echo '<div class="row">';
    // Pre každú objednávku vypíšeme informácie
    foreach ($orders as $o) {
        // Získanie jedál z objednávky
        $items = $order_object->select_dishes($o->id);
        echo '<div class="col-md-6 col-lg-4">';
        echo '<div class="food-item">';
        echo '<h3>Objednávka №' . $o->id . '</h3>';
        echo '<form action="" method="POST" class="order-update-form">';
        echo '<div class="col-6">';
        echo '<select name="order_status" class="form-select mb-2" onchange="this.form.submit()">';
        echo '<option value="prijatá"' . ($o->order_status == 'prijatá' ? ' selected' : '') . '>prijatá</option>';
        echo '<option value="pripravuje sa"' . ($o->order_status == 'pripravuje sa' ? ' selected' : '') . '>pripravuje sa</option>';
        echo '<option value="hotová"' . ($o->order_status == 'hotová' ? ' selected' : '') . '>hotová</option>';
        echo '</select>';
        echo '</div>';
        echo '<input type="hidden" name="update_order" value="' . $o->id . '">';
        echo '</form>';
        echo '<p>User ID: ' . $o->user_id . '</p>';
        echo '<p>Dátum objednávky: ' . $o->order_date . '</p>';
        $itemNames = array();
        foreach ($items as $item) {
            $itemNames[] = $item->name . ' x' . $item->quantity;
        }
        $itemNamesString = implode('<br>', $itemNames);
        echo '<p>' . $itemNamesString . '</p>';
        echo '<form action="" method="POST">';
        echo '<button type="submit" name="delete_order" value="' . $o->id . '" class="btn btn-danger">Vymazať</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
?>
            </div>
        </div>
    </div>

<!-- Footer -->
<?php
include 'partials/footer.php';
?>