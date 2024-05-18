<footer>
  <div class="container">
    <div class="row">
      <div class="col text-left">&copy; 2023 Oyster</div>
      <div class="col-md-auto text-right">Vytvorila Daria Volynchikova</div>
    </div>
  </div>
</footer>
<?php
$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');
$page_object = new Page();
$page_object->set_page_name($page_name);
echo ($page_object->add_scripts());
?>
</body>

</html>