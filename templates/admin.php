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
 * Check if the user is logged in and has the correct role
 */
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 0) {
    header('Location: 404.php');
    exit();
}

/**
 * Create a new Dishes object
 * 
 * @var Dishes
 */
$dishes_object = new Dishes();

/**
 * Check if the form for updating dishes was submitted
 */
if (isset($_POST['update_dishes'])) {
    /**
     * Get the ID and new details of the dish from the form
     *
     * @var int
     * @var string
     */
    $id = $_POST['update_dishes'];
    $new_name = $_POST['new_dish_name'];
    $new_description = $_POST['new_dish_description'];
    $new_price = $_POST['new_dish_price'];
    $new_ingredients = $_POST['new_dish_ingredients'];

    /**
     * Try to update the dish and redirect to the same page
     * If an error occurs, catch the exception and display the error message
     */
    try {
        $dishes_object->update($id, $new_name, $new_description, $new_price, $new_ingredients);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Error updating dish: ' . $e->getMessage();
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Check if the form for deleting dishes was submitted
 */
if (isset($_POST['delete_dishes'])) {
    /**
     * Get the ID of the dish from the form
     *
     * @var int
     */
    $id = $_POST['delete_dishes'];

    /**
     * Check if the ID is a number
     */
    if (is_numeric($id)) {
        /**
         * Try to delete the dish and redirect to the same page
         * If an error occurs, catch the exception and display the error message
         */
        try {
            $dishes_object->delete($id);
            header('Location: ' . $_SERVER['PHP_SELF']);
        } catch (Exception $e) {
            echo 'Chyba pri mazaní jedla: ' . $e->getMessage();
        }
    } else {
        echo "Chyba: ID jedla musí byť číslo.";
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Check if the form for adding a new dish was submitted
 */
if (isset($_POST['add_dish'])) {
    /**
     * Get the data of the new dish from the form
     */
    $name = $_POST['new_dish_name'];
    $description = $_POST['new_dish_description'];
    $price = $_POST['new_dish_price'];
    $ingredients = $_POST['new_dish_ingredients'];

    /**
     * Try to add the new dish and redirect to the same page
     * If an error occurs, catch the exception and display the error message
     */
    try {
        $dishes_object->insert($name, $description, $price, $ingredients);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri pridávaní jedla: ' . $e->getMessage();
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Get all dishes
 *
 * @var array
 */
$dishes = $dishes_object->select();

/**
 * Create a new Order object
 *
 * @var Order
 */
$order_object = new Order();

/**
 * Check if the form for deleting an order was submitted
 */
if (isset($_POST['delete_order'])) {
    /**
     * Get the ID of the order from the form
     *
     * @var int
     */
    $id = $_POST['delete_order'];

    /**
     * Try to delete the order and redirect to the same page
     * If an error occurs, catch the exception and display the error message
     */
    try {
        $order_object->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri mazaní objednávky: ' . $e->getMessage();
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Check if the form for updating an order was submitted
 */
if (isset($_POST['update_order'])) {
    /**
     * Get the ID and new status of the order from the form
     *
     * @var int
     * @var string
     */
    $id = $_POST['update_order'];
    $new_status = $_POST['order_status'];

    /**
     * Try to update the order and redirect to the same page
     * If an error occurs, catch the exception and display the error message
     */
    try {
        $order_object->update($id, $new_status);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri aktualizácii objednávky: ' . $e->getMessage();
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Get all orders
 *
 * @var array
 */
$orders = $order_object->select();

/**
 * Create a new Contact object
 *
 * @var Contact
 */
$contact_object = new Contact();

/**
 * Check if the form for deleting a contact was submitted
 */
if (isset($_POST['delete_contact'])) {
    /**
     * Get the ID of the contact from the form
     *
     * @var int
     */
    $id = $_POST['delete_contact'];

    /**
     * Try to delete the contact and redirect to the same page
     * If an error occurs, catch the exception and display the error message
     */
    try {
        $contact_object->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri mazaní kontaktu: ' . $e->getMessage();
    }

    /**
     * Terminate script execution
     */
    exit();
}

/**
 * Get all contacts
 *
 * @var array
 */
$contacts = $contact_object->select();

?>

<div class="container admin pt-3 mb-4">
    <div class="row">
        
        <h1>Kontakty</h1>
        
        <?php
        /**
         * Check if the $contacts array is not empty
         */
        if (!empty($contacts)): ?>
        <div class="container pt-3 mb-4 contacts-table">
            <table class="admin-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($contacts as $c): ?>
                <tr>
                    <td class="contact-name"><?= $c->name ?></td>
                    <td class="contact-email"><?= $c->email ?></td>
                    <td class="contact-message"><?= $c->message ?></td>
                    <td>
                        <form action="" method="POST">
                            <button type="submit" name="delete_contact" class="btn btn-danger" value="<?= $c->id ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php else: ?>
        <h4>Žiadne kontakty</h4>
        <?php endif; ?>
        
        <h1>Jedlá</h1>
        
        <?php
        /**
         * Check if the $dishes array is not empty
         */
        if (!empty($dishes)): ?>
        <div class="container pt-3 mb-4 dishes-table">
            <table class="admin-table">
                <tr>
                    <!-- Table headers -->
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price <i class="fa fa-eur"></i></th>
                    <th>Ingredients</th>
                    <th>Upraviť</th>
                    <th>Vymazať</th>
                </tr>
                <!-- Loop through each dish in the $dishes array -->
                <?php foreach ($dishes as $d): ?>
                <tr>
                    <!-- Display dish details -->
                    <td class="dish-name"><?= $d->name ?></td>
                    <td class="dish-description"><?= $d->description ?></td>
                    <td class="dish-price"><?= $d->price ?></td>
                    <td class="dish-ingredients"><?= $d->ingredients ?></td>
                    <td>
                        <form action="" method="POST">
                            <!-- Hidden inputs to hold the dish details -->
                            <input type="hidden" name="new_dish_name" value="<?= $d->name ?>" required>
                            <input type="hidden" name="new_dish_description" value="<?= $d->description ?>" required>
                            <input type="hidden" name="new_dish_price" value="<?= $d->price ?>" required>
                            <input type="hidden" name="new_dish_ingredients" value="<?= $d->ingredients ?>" required>
                            <!-- Edit and save buttons -->
                            <button class="btn btn-warning edit-button" type="button">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-success save-button" type="submit" name="update_dishes" value="<?= $d->id ?>" style="display: none;">OK</button>
                        </form>
                    </td>
                    <td>
                        <form action="" method="POST">
                            <!-- Delete button -->
                            <button type="submit" name="delete_dishes" class="btn btn-danger" value="<?= $d->id ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <form method="POST">
                        <!-- Inputs for adding a new dish -->
                        <td><input type="text" id="new_dish_name" name="new_dish_name" placeholder="Názov jedla" required style="width: 100%;"></td>
                        <td><textarea id="new_dish_description" name="new_dish_description" placeholder="Popis jedla" required rows="4" style="width: 100%;"></textarea></td>
                        <td><input type="number" value="0" min="0" step="0.50" id="new_dish_price" name="new_dish_price" placeholder="Cena jedla" required style="width: 100%;"></td>
                        <td><textarea id="new_dish_ingredients" name="new_dish_ingredients" placeholder="Ingrediencie jedla" required rows="4" style="width: 100%;"></textarea></td>
                        <td colspan="2"><input type="submit" value="Pridať jedlo" name="add_dish" class="btn btn-primary" required></td>
                    </form>
                </tr>
            </table>
        </div>
        <?php else: ?>
        <h4>Žiadne jedlá</h4>
        <?php endif; ?>
        
        <h1>Objednávky</h1>
        
        <?php
        if (!empty($orders)): ?>
        <div class="container pt-3 mb-4 orders">
            <div class="row">
                <!-- Loop through each order in the orders array -->
                <?php foreach ($orders as $o):
                // Get the dishes for the current order
                $items = $order_object->select_dishes($o->id); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="food-item">
                        <h3>Objednávka №<?= $o->id ?></h3>
                        <form action="" method="POST" class="order-update-form">
                            <div class="col-6">
                                <select name="order_status" class="form-select mb-2" onchange="this.form.submit()">
                                    <option value="prijatá"<?= $o->order_status == 'prijatá' ? ' selected' : '' ?>>prijatá</option>
                                    <option value="pripravuje sa"<?= $o->order_status == 'pripravuje sa' ? ' selected' : '' ?>>pripravuje sa</option>
                                    <option value="hotová"<?= $o->order_status == 'hotová' ? ' selected' : '' ?>>hotová</option>
                                </select>
                            </div>
                            <input type="hidden" name="update_order" value="<?= $o->id ?>">
                        </form>
                        <p>User ID: <?= $o->user_id ?></p>
                        <p>Dátum objednávky: <?= $o->order_date ?></p>
                        <p>Meno: <?= $o->name ?></p>
                        <p>Adresa: <?= $o->street ?>, <?= $o->city ?>, <?= $o->postcode ?></p>
                        <p>------------------------------------</p>
                        <?php
                        // Create an array to store the names of the items in the order
                        $itemNames = array();
                        // Loop through each item in the items array
                        foreach ($items as $item) {
                            // Add the name and quantity of the item to the itemNames array
                            $itemNames[] = $item->name . ' x' . $item->quantity;
                        }
                        // Convert the itemNames array to a string
                        $itemNamesString = implode('<br>', $itemNames);
                        ?>
                        <p><?= $itemNamesString ?></p>
                        <h4>Cena: <?= $o->total_price ?>€</h4>
                        <form action="" method="POST">
                            <button type="submit" name="delete_order" value="<?= $o->id ?>" class="btn btn-danger mt-2">Vymazať</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <h4>Žiadne objednávky</h4>
        <?php endif; ?>
    </div>
</div>

<?php
// Include the footer
include 'partials/footer.php';
?>