<?php
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
 * Vytvorenie nového objektu Cart
 *
 * @var Cart
 */
$cart = new Cart();

/**
 * Skontroluje, či je užívateľ prihlásený a má správnu rolu
 */
if (isset($_POST['add_to_cart'])) {
    /**
     * Získa množstvo a ID produktu
     */
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    /**
     * Vloží produkt do košíka
     */
    $cart->insert($product_id, $quantity);

    /**
     * Presmeruje na menu
     */
    header('Location: menu.php');
    exit();
}

/**
 * Získa všetky položky v košíku
 */
$cartItems = $cart->select();

/**
 * Vytvorenie nového objektu Dishes
 *
 * @var Dishes
 */
$dishes_object = new Dishes();
// Získa všetky jedlá
$dishes = $dishes_object->select();
?>

<div class="container menu pt-3 mb-4">
    <h1 class="display-4 text-center mb-4">Menu</h1>
    <div class="row">
        <?php if (!empty($dishes)): ?>
        <?php foreach ($dishes as $dish): ?>
        <div class="col-md-6 col-lg-4">
            <div class="food-item">
                <?php
                /**
                 * Získa cestu k obrázku
                 */
                $imagePath = "../assets/img/dishes/" . $dish->image;
                $image = (!empty($dish->image) && file_exists($imagePath)) ? $dish->image : 'default.png';
                ?>
                <img src="../assets/img/dishes/<?= $image ?>" alt="<?= $dish->name ?>" class="img-fluid mb-3" onclick="toggleText('<?= $dish->name ?>')">
                <?php if (isset($cartItems[$dish->id])): ?>
                <div class="in_cart"><a href="user.php">Už do košíka: <?= $cartItems[$dish->id] ?></a></div>
                <?php endif; ?>
                <h3><?= $dish->name ?></h3>
                <p class="description"><?= $dish->description ?></p>
                <p class="cena">Cena: <?= $dish->price ?>€</p>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                <?php if ($_SESSION['user_role'] == 0): ?>
                <form method="POST" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="form-group">
                        <input type="number" name="quantity" value="1" min="1" max="50" class="form-control" style="width: 100px;">
                        <input type="hidden" name="product_id" value="<?= $dish->id ?>">
                    </div>
                    <button type="submit" name="add_to_cart" class="btn btn-dark">Pridať do košíka</button>
                </form>
                <?php endif; ?>
                <?php else: ?>
                <form style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="form-group"></div>
                    <a href="login.php" class="btn btn-dark">Pridať do košíka</a>
                </form>
                <?php endif; ?>
                <div id="<?= $dish->name ?>" style="display: none;">
                    <br>
                    <p>Ingredients:</p>
                    <ul>
                        <?php $ingredients = explode(',', $dish->ingredients); ?>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li><?= trim($ingredient) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <h2 class="text-center w-100">Žiadne jedlá</h2>
        <?php endif; ?>
    </div>
</div>

<?php
/**
 * Zahrnutie footeru
 */
include_once 'partials/footer.php';
?>