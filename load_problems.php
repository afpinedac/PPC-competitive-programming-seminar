<?php

require("include.php");


$data = ws::getText("http://uhunt.felix-halim.net/api/p");
$data = substr($data, 2, sizeof($data) - 3);


$arr = explode("],[", $data);
$c = new conector_mysql();
foreach ($arr as $r) {
    $row = explode(",", $r);
    try {
        $c->realizarConsulta("insert into uva_problems values($row[1],$row[0])");
        echo "pasa";
    } catch (Exception $e) {
        null;
    }
}
?>
