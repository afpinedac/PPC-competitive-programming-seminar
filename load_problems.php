<?php

require("include.php");


$data = ws::getText("http://uhunt.felix-halim.net/api/p");
$data = substr($data, 2, sizeof($data) - 3);

//var_dump($data);


$arr = explode("],[", $data);
$c = new conector_mysql();

$c->realizarConsulta("DELETE FROM uva_problems");  // eliminar todos los problemas

foreach ($arr as $r) {
  //  var_dump($r);
    $row = explode(",", $r);
    try {
        $c->realizarConsulta("insert into uva_problems values($row[1],$row[0],$row[3])");
        echo "pasa";
    } catch (Exception $e) {
        null;
        echo "hubo error";
    }
}
?>
