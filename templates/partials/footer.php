<?php

/**
 * Základný názov aktuálneho skriptu sa získa a použije na vytvorenie nového objektu Page.
 * Nastaví sa názov stránky a na stránku sa pridajú skripty.
 */

// Získajte základný názov aktuálneho skriptu
$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');

// Vytvorte nový objekt Page
$page_object = new Page();

// Nastavte názov stránky
$page_object->set_page_name($page_name);

// Pridajte skripty na stránku a vypíšte výsledok
echo $page_object->add_scripts();

?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col text-left">&copy; 2023 Oyster</div>
            <div class="col-md-auto text-right">Vytvorila Daria Volynchikova</div>
        </div>
    </div>
</footer>

</body>

</html>