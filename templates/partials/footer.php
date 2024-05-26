<?php

/**
 * The basename of the current script is retrieved and used to create a new Page object.
 * The page name is set and scripts are added to the page.
 */

// Get the base name of the current script
$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');

// Create a new Page object
$page_object = new Page();

// Set the page name
$page_object->set_page_name($page_name);

// Add scripts to the page and echo the result
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