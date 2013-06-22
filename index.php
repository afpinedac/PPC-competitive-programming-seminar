<?php

require("include.php");
require("./vista/header.php");

if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "login") {
        require("./vista/_index.php");
        require("./vista/_login.php");
    } else if ($opt == "registrar") {
        require("./vista/_register.php");
    }
} else {
   // echo ws::getSubmissions(ws::getIdUser("andr3s2"));
    
    require("./vista/_index.php"); 
}

?>