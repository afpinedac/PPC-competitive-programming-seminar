<?php

include('include.php');

$c = new conector_mysql();

if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "getNameProblem") {
        $idProblem = $_GET['id'];
        $tema = $_GET['tema'];
      //  echo "$tema";
        //verificamos si ese problema ya existe en el tema
        $temas = $c->getAllTemas();
        while ($data = mysql_fetch_array($temas)) {
            if ($tema == util::generateID($data[1], $data[2])) { //encontramos el tema
                    echo "tema encontrado";
                if ($c->existeProblemaEnTema($data[0], ws::getNameProblem($idProblem))) {
                   echo GLOBALS::PROBLEM_ALREADY_EXISTS;
                } else {
                    $val = ws::getNameProblem($idProblem);
                    if ($val == "")
                        echo GLOBALS::PROBLEM_NOT_FOUND;
                    else
                        echo $val;
                }
                break;
            }
        }
    }
}
?>
