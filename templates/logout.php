<?php

include_once 'partials/header.php';

?>
<main>
    <section class="container">
        <div class="row">
            <div class="col-100 text-left">
                <?php

                $_SESSION = array();

                session_destroy();

                header('Location: login.php');
                ?>
            </div>
        </div>
    </section>
</main>
<?php
include 'partials/footer.php';
?>