<?php

session_start();

require("include.php");
extract($_GET);
extract($_POST);
$c = new conector_mysql();
$current_course = $_SESSION['course']['idCurso'];
$current_user = $_SESSION['user']['idUser'];


if (isset($_GET['option'])) {
    if ($option == "getName") {
        $problem = $c->getInfoProblema($idProblema, $idTopic, $current_course);
        echo $c->getOneField($problem, 'name');
    } else if ($option == "getTitle") {
        $name = ws::getInfoProblem($idProblema, 'title');
        if ($name == "" || $name == NULL) {
            echo "error";
        } else {
            echo "$name";
        }
    } else if ($option == "insert") {
        try {
            $c->insertarProblema($idProblem, $idTopic, $current_course, $name);
        } catch (Exception $e) {
            echo "ya existe";
        }
    } else if ($option == "isSolved") {
        if ($c->isSolved($current_user, $idProblem)) {
            echo "true";
        } else {
            echo "false";
        }
    }
} else {
    
}
?>
