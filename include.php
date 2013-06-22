<?php

require("modelo/conexion.php");
require("clases/webService.php");
require("clases/GLOBALS.php");
require("clases/util.php");

util::escapar($_GET);
util::escapar($_POST);
echo "test";
?>
