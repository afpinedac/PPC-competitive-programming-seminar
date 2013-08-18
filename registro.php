<?php

require("include.php");
require("./vista/templates/header.php");
if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "registrar") {
      //  var_dump($_POST);
        $c = new conector_mysql();
        $c->registrarUser($_POST);
        echo "<script>alert('usuario registrado correctamente...')</script>";
        echo "<script>location.href='index.php'</script>";
    }
} else {

    require("./vista/_register.php");
}
require('./vista/templates/footer.php');
?>
