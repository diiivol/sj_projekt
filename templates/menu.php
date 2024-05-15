<!-- Header -->
<?php
  include_once('partials/header.php');
?>

  <!-- Menu -->
  <div class="container menu pt-3 mb-4">
    <h1 class="display-4 text-center mb-4">Menu</h1>
    <div class="row">
      <?php
        $dishes_class = new Dishes();
        $dishes = $dishes_class->select();

        $cart = new Cart();
        $cartItems = $cart->getCart();

        for ($i=0;$i<count($dishes);$i++) {
          echo '<div class="col-md-6 col-lg-4">';
          echo '<div class="food-item">';
          echo '<img src="../assets/img/'.$dishes[$i]->image.'" alt="'.$dishes[$i]->name.'" class="img-fluid mb-3" onclick="toggleText(\''.$dishes[$i]->name.'\')">';
          echo '<h3>'.$dishes[$i]->name.'</h3>';
          echo '<p>'.$dishes[$i]->description.'</p>';
          // echo '<p>'.$dishes[$i]->id.'</p>';
          echo '<p class="m-0">Cena: '.$dishes[$i]->price.'€</p>';
          
          if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_role'] != 1){
            echo '<form method="POST">';
            echo '<input type="number" name="quantity" value="1" min="1" max="10">';
            echo '<input type="hidden" name="product_id" value="' . $dishes[$i]->id . '">';
            echo '<input type="submit" value="Pridať do košíka" name="add_to_cart">';
            echo '</form>';
            
            if (isset($cartItems[$dishes[$i]->id])) {
              echo '<p>Already in cart: ' . $cartItems[$dishes[$i]->id] . '</p>';
            }
          }
          
          echo '<div id="'.$dishes[$i]->name.'" style="display: none;">';
          echo '<br>';
          echo '<p>Ingredients:</p>';
          echo '<ul>';
          $ingredients = explode(',', $dishes[$i]->ingredients);
          foreach ($ingredients as $ingredient) {
            echo '<li>'.trim($ingredient).'</li>';
          }
          echo '</ul>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        if(isset($_POST['add_to_cart'])){
          $cart = new Cart();
          $quantity = $_POST['quantity'];
          $product_id = $_POST['product_id'];
          $cart->addProduct($product_id, $quantity);
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
    include_once('partials/footer.php')
  ?>