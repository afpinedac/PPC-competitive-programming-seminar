<?php

require("include.php");
require("./vista/templates/header.php");

if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "login") {
        require("./vista/_index.php");
        require("./vista/_login.php");
    } else if ($opt == "registrar") {
        require("./vista/_register.php");
    }
} else {


    require("./vista/_index.php");
}
require './vista/templates/footer.php';