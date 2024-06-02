<?php

/**
 * Spustenie výstupného bufferovania.
 * To znamená, že akýkoľvek výstup, ktorý skript generuje po tomto bode, sa ukladá do internej pamäte namiesto toho,
 * aby bol okamžite odoslaný klientovi. To môže byť užitočné, ak chcete upraviť HTTP hlavičky po tom, ako už bol vygenerovaný nejaký výstup.
 */
ob_start();

/**
 * Tento súbor sa používa na spustenie relácie a zahrnutie všetkých potrebných tried.
 */
if (!file_exists('partials/header.php')) {
    die('Chyba: chýba súbor s hlavičkou stránky. Prosím, kontaktujte administrátora.');
}

/**
 * Zahrnutie headeru
 */
include 'partials/header.php';

/**
 * Skontrolujte, či je používateľ prihlásený a má správnu rolu
 */
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] == 0) {
    header('Location: 404.php');
    exit();
}

/**
 * Vytvorenie nového objektu Dishes
 * 
 * @var Dishes
 */
$dishes_object = new Dishes();

/**
 * Skontrolujte, či bol odoslaný formulár na aktualizáciu jedál
 */
if (isset($_POST['update_dishes'])) {
    /**
     * Získajte ID a nové detaily jedla z formulára
     *
     * @var int
     * @var string
     */
    $id = $_POST['update_dishes'];
    $new_image = $_POST['new_dish_image'];
    $new_name = $_POST['new_dish_name'];
    $new_description = $_POST['new_dish_description'];
    $new_price = $_POST['new_dish_price'];
    $new_ingredients = $_POST['new_dish_ingredients'];

    /**
     * Skúste aktualizovať jedlo a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $dishes_object->update($id, $new_image, $new_name, $new_description, $new_price, $new_ingredients);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri aktualizácii jedla: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Skontrolujte, či bol odoslaný formulár na odstránenie jedál
 */
if (isset($_POST['delete_dishes'])) {
    /**
     * Získajte ID jedla z formulára
     *
     * @var int
     */
    $id = $_POST['delete_dishes'];

    /**
     * Skúste odstrániť jedlo a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $dishes_object->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri mazaní jedla: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Skontrolujte, či bol odoslaný formulár na pridanie nového jedla
 */
if (isset($_POST['add_dish'])) {
    /**
     * Získajte údaje o novom jedle z formulára
     */
    $image = $_POST['dish_image'];
    $name = $_POST['dish_name'];
    $description = $_POST['dish_description'];
    $price = $_POST['dish_price'];
    $ingredients = $_POST['dish_ingredients'];

    /**
     * Skúste pridať nové jedlo a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $dishes_object->insert($image, $name, $description, $price, $ingredients);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri pridávaní jedla: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Získajte všetky jedlá
 */
$dishes = $dishes_object->select();

/**
 * Vytvorte nový objekt Objednávka
 */
$order_object = new Order();

/**
 * Skontrolujte, či bol odoslaný formulár na odstránenie objednávky
 */
if (isset($_POST['delete_order'])) {
    /**
     * Získajte ID objednávky z formulára
     */
    $id = $_POST['delete_order'];

    /**
     * Skúste odstrániť objednávku a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $order_object->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri mazaní objednávky: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Skontrolujte, či bol odoslaný formulár na aktualizáciu objednávky
 */
if (isset($_POST['update_order'])) {
    /**
     * Získajte ID a nový stav objednávky z formulára
     */
    $id = $_POST['update_order'];
    $new_status = $_POST['order_status'];

    /**
     * Skúste aktualizovať objednávku a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $order_object->update($id, $new_status);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri aktualizácii objednávky: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Získajte všetky objednávky
 */
$orders = $order_object->select();

/**
 * Vytvorte nový objekt Kontakt
 */
$contact_object = new Contact();

/**
 * Skontrolujte, či bol odoslaný formulár na odstránenie kontaktu
 */
if (isset($_POST['delete_contact'])) {
    /**
     * Získajte ID kontaktu z formulára
     */
    $id = $_POST['delete_contact'];

    /**
     * Skúste odstrániť kontakt a presmerujte na rovnakú stránku
     * Ak sa vyskytne chyba, zachytí výnimku a zobrazí chybovú správu
     */
    try {
        $contact_object->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Exception $e) {
        echo 'Chyba pri mazaní kontaktu: ' . $e->getMessage();
    }

    /**
     * Ukončenie vykonávania skriptu
     */
    exit();
}

/**
 * Získajte všetky kontakty
 */
$contacts = $contact_object->select();

?>

<div class="container admin pt-3 mb-4">
    <div class="row">
        
        <h1>Kontakty</h1>
        
        <?php
        /**
         * Skontrolujte, či pole $contacts nie je prázdne
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
         * Skontrolujte, či pole $dishes nie je prázdne
         */
        if (!empty($dishes)): ?>
        <div class="container pt-3 mb-4 dishes-table">
            <table class="admin-table">
                <tr>
                    <!-- Table headers -->
                    <th>IMG</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price <i class="fa fa-eur"></i></th>
                    <th>Ingredients</th>
                    <th>Upraviť</th>
                    <th>Vymazať</th>
                </tr>
                <!-- Prejdite cez každé jedlo v poli $dishes -->
                <?php foreach ($dishes as $d): ?>
                <tr>
                    <!-- Zobraziť podrobnosti o jedle -->
                    <td class="dish-image">
                        <?php
                        /**
                         * Získajte obrázok jedla
                         */
                        $imagePath = "../assets/img/dishes/" . $d->image;
                        $image = (!empty($d->image) && file_exists($imagePath)) ? $d->image : 'default.png';
                        ?>
                        <img src="../assets/img/dishes/<?= $image ?>" alt="<?= $d->name ?>" class="img-fluid">
                    </td>
                    <td class="dish-name"><?= $d->name ?></td>
                    <td class="dish-description"><?= $d->description ?></td>
                    <td class="dish-price"><?= $d->price ?></td>
                    <td class="dish-ingredients"><?= $d->ingredients ?></td>
                    <td>
                        <form action="" method="POST">

                            <!-- Výber obrázka -->
                            <select style="display: none;" name="new_dish_image">
                                <?php
                                $dir = '../assets/img/dishes';
                                $files = scandir($dir);
                                foreach ($files as $file) {
                                    if ($file !== '.' && $file !== '..') {
                                        $selected = ($file == $d->image) ? 'selected' : '';
                                        echo "<option value='$file' $selected>$file</option>";
                                    }
                                }
                                ?>
                            </select>
                            <!-- Skryté vstupy na uchovanie podrobností o jedle -->
                            <input type="hidden" name="new_dish_name" value="<?= $d->name ?>" required>
                            <input type="hidden" name="new_dish_description" value="<?= $d->description ?>" required>
                            <input type="hidden" name="new_dish_price" value="<?= $d->price ?>" required>
                            <input type="hidden" name="new_dish_ingredients" value="<?= $d->ingredients ?>" required>
                            <!-- Tlačidlá Upraviť a Uložiť -->
                            <button class="btn btn-warning edit-button" type="button">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-success save-button" type="submit" name="update_dishes" value="<?= $d->id ?>" style="display: none;">OK</button>
                        </form>
                    </td>
                    <td>
                        <form action="" method="POST">
                            <!-- Tlačidlo Odstrániť -->
                            <button type="submit" name="delete_dishes" class="btn btn-danger" value="<?= $d->id ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <form method="POST">
                        <!-- Vstupy pre pridanie nového jedla -->
                        <td>
                        <select name="dish_image">
                            <?php
                            $dir = '../assets/img/dishes';
                            $files = scandir($dir);
                            foreach ($files as $file) {
                                if ($file !== '.' && $file !== '..') {
                                    $selected = ($file == 'default.png') ? 'selected' : '';
                                    echo "<option value='$file' $selected>$file</option>";
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <td><input type="text" id="dish_name" name="dish_name" placeholder="Názov jedla" required style="width: 100%;"></td>
                        <td><textarea id="dish_description" name="dish_description" placeholder="Popis jedla" required rows="4" style="width: 100%;"></textarea></td>
                        <td><input type="number" value="0" min="0" step="0.50" id="dish_price" name="dish_price" placeholder="Cena jedla" required style="width: 100%;"></td>
                        <td><textarea id="dish_ingredients" name="dish_ingredients" placeholder="Ingrediencie jedla" required rows="4" style="width: 100%;"></textarea></td>
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
                <!-- Prejdite cez každú objednávku v poli $orders -->
                <?php foreach ($orders as $o):
                // Získajte jedlá v objednávke
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
                        // Vytvorte pole na uloženie názvov položiek v objednávke
                        $itemNames = array();
                        // Prejdite každú položku v poli položiek
                        foreach ($items as $item) {
                            // Pridajte názov a množstvo položky do poľa itemNames
                            $itemNames[] = $item->name . ' x' . $item->quantity;
                        }
                        // Konvertujte pole itemNames na reťazec
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
// Zahrnutie footeru
include 'partials/footer.php';
?>