<?php

require("include.php");
 require("./vista/header.php");
if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "registrar") {
        $c = new conector_mysql();
        $c->registrarUser($_POST);
        echo "<script>location.href='index.php'</script>";        
    }
} else {
    
    require("./vista/_register.php");
}
require("./vista/footer.php");
?>
