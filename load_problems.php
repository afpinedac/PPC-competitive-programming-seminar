<?php

require("include.php");


$data = ws::getText("http://uhunt.felix-halim.net/api/p");

$data = json_decode($data);


$c = new conector_mysql();

$c->realizarConsulta("DELETE FROM uva_problems");  // eliminar todos los problemas

foreach ($data as $row) {




    try {
        $c->realizarConsulta("insert into uva_problems(n_problem,id_problem,level,title) values($row[1],$row[0],$row[3],'" . mysql_real_escape_string($row[2]) . "')");
        //  var_dump("insert into uva_problems(n_problem,id_problem,level,title) values($row[1],$row[0],$row[3],'" . mysql_real_escape_string($row[2]) . "')");
        echo "pasa";
    } catch (Exception $e) {
        //null;
        var_dump($e->getMessage());
    }
}
?>
