<?php

require("include.php");




$from = $_GET['from'];
$until = $_GET['until'];


$c = new conector_mysql();

$result = $c->realizarConsulta("select id_user,username from user where id_user>=$from AND id_user<=$until");  // eliminar todos los problemas


while ($row = mysql_fetch_array($result)) {
    try {
        load($row['id_user'], $row['username']);
        echo "Listo {$row['username']}<br>";
    } catch (Exception $e) {
        echo "hubo un probleam {$row['username']}<br>";
        var_dump($e->getMessage());
    }
}

function load($id_user, $user) {

    $username = $user;
    $user = ws::getIdUser($username);
    $var = ws::getSubmissions($user);
    //var_dump(time());
    global $c;

    foreach ($var as $arr) {
        if ($arr[2] == 90) {

            // $data=ws::getInfoProblem2($arr[1], "num");            
            $data = $c->getProblemNumber($arr[1]);
            $query = "INSERT INTO solved(id_user,id_problem,date) VALUES('$id_user','$data','$arr[4]')";
            try {
                $c->realizarConsulta($query);
            } catch (Exception $e) {
                null;
            }
        }
    }
}

?>
