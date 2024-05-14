<?php
    include('partials/header.php');
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header('Location: admin.php');
    }
?>
<main>
     <section class="container">
        <div class="row">
            <div class="col-100 text-left">
                <h1>Prihlásenie</h1>
                <form action="" method="POST">
                    <input type="email" name="email" placeholder="Vaše meno">
                    <br>
                    <input type="text" name="password" placeholder="Vaše heslo">
                    <br>
                    <input type="submit" value="Odoslať" name="user_login">
                </form>

                <?php
            
                    if(isset($_POST['user_login'])){
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $user = new User();
                        //tu bude vzdy true alebo false
                        $login_success = $user->login($email,$password);
                        if($login_success == true){
                            
                            
                            if($_SESSION['user_role'] == 1){
                                header('Location: admin.php');
                            } else {
                                $_SESSION['cart'] = array();
                                header('Location: user.php');
                            }
                            exit;
                        } else {
                            echo 'Nesprávne meno alebo heslo';
                        }
                    }
                
                ?>

            </div>
        </div>
    </section> 
</main>
<?php
    include('partials/footer.php');
?>
