<!-- Header -->
<?php
include_once 'partials/header.php';
?>
<!-- Menu -->
<div class="container menu pt-3 mb-4">
  <h1 class="display-4 text-center mb-4">Menu</h1>
  <div class="row">
    <?php
$cart = new Cart();
if (isset($_POST['add_to_cart'])) {
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];
    $cart->addProduct($product_id, $quantity);
    header('Location: menu.php');
    exit();
}
$dishes_object = new Dishes();
$dishes = $dishes_object->select();
$cartItems = $cart->getCart();
if (empty($dishes)) {
    echo '<h2 class="text-center w-100">Žiadne jedlá</h2>';
} else {
    for ($i = 0; $i < count($dishes); $i++) {
        echo '<div class="col-md-6 col-lg-4">';
        echo '<div class="food-item">';
        $imagePath = "../assets/img/dishes/" . $dishes[$i]->image;
        $image = (!empty($dishes[$i]->image) && file_exists($imagePath)) ? $dishes[$i]->image : 'default.png';
        echo '<img src="../assets/img/dishes/' . $image . '" alt="' . $dishes[$i]->name . '" class="img-fluid mb-3" onclick="toggleText(\'' . $dishes[$i]->name . '\')">';
        if (isset($cartItems[$dishes[$i]->id])) {
            echo '<div class="in_cart"><a href="user.php">Už do košíka: ' . $cartItems[$dishes[$i]->id] . '</a></div>';
        }
        echo '<h3>' . $dishes[$i]->name . '</h3>';
        echo '<p class="description">' . $dishes[$i]->description . '</p>';
        echo '<p class="cena">Cena: ' . $dishes[$i]->price . '€</p>';
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            if ($_SESSION['user_role'] == 0) {
                echo '<form method="POST" style="display: flex; justify-content: space-between; align-items: center;">';
                echo '<div class="form-group">';
                echo '<input type="number" name="quantity" value="1" min="1" max="50" class="form-control" style="width: 100px;">';
                echo '<input type="hidden" name="product_id" value="' . $dishes[$i]->id . '">';
                echo '</div>';
                echo '<button type="submit" name="add_to_cart" class="btn btn-dark">Pridať do košíka</button>';
                echo '</form>';
            }
        } else {
            echo '<form style="display: flex; justify-content: space-between; align-items: center;">';
            echo '<div class="form-group">';
            echo '</div>';
            echo '<a href="login.php" class="btn btn-dark">Pridať do košíka</a>';
            echo '</form>';
        }
        echo '<div id="' . $dishes[$i]->name . '" style="display: none;">';
        echo '<br>';
        echo '<p>Ingredients:</p>';
        echo '<ul>';
        $ingredients = explode(',', $dishes[$i]->ingredients);
        foreach ($ingredients as $ingredient) {
            echo '<li>' . trim($ingredient) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
  </div>
</div>
<!--  -->
<!-- Footer (2b) -->
<!--  -->
<!-- Niekoľko stĺpcov s informáciami o stránke -->
<!-- Copyright -->
<!--  -->
<?php
include_once 'partials/footer.php'
?>