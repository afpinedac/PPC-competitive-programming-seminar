<?php

session_start();

require("include.php");
extract($_GET);
extract($_POST);
$c = new conector_mysql();
$current_course = $_SESSION['course']['idCurso'];
$current_user = $_SESSION['user']['idUser'];

if (isset($_GET['option'])) {
    if ($option == "getNameMinimum") {
        $topic = $c->getInfoTopic($idTopic, $current_course);
        $data['rol'] = $_SESSION['user']['rol'];
        $data['name'] = $c->getOneField($topic, 'name');
        $data['number_solved_problems'] = $c->getNumberOfProblemsSolved($current_user, $current_course, $idTopic);
        $data['number_of_problems'] = $c->getNumberOfProblems($current_course, $idTopic);
        $data['minimum_solved'] = $c->getOneField($topic, 'minimum_solved');
        echo json_encode($data);
    } else if ($option == "getListProblems") {
        $problems = $c->getAllProblemas($current_course, $idTopic);
        $str = "";
        while ($data = mysql_fetch_array($problems)) {
            $str.="<option id='{$data['id_problem']}'>" . $data['name'] . "</option>"; //aqui pongo los colores
        }
        echo $str;
    } else if ($option == "connect") {
        if ($parent == $child)
            echo "error";
        else if ($c->existeConexionTopic($child, $parent, $current_course))
            echo "error";
        else {
            $c->conectarTopic($parent, $child, $current_course);
            echo "ok";
        }
    } else if ($option == "deleteConnection") {
        $c->eliminarSucesor($parent, $child, $current_course);
        echo "ok";
    } else if ($option == "getNumberOfProblems") {
        echo $c->getNumberOfProblems($current_course, $idTopic);
    } else if ($option == "isLocked") {
        $parent = $c->getTopicParents($current_course, $idTopic);
        $free = true;
        while ($p = mysql_fetch_array($parent)) {
            $topic4 = $c->getInfoTopic($p['parent'], $current_course);
            $minimum = $c->getOneField($topic4, 'minimum_solved');
            $sol = $c->getNumberOfProblemsSolved($current_user, $current_course, $p['parent']);
            if ($sol < $minimum) {
                $free = false;
                break;
            }
        }
        echo $free ? "false" : "true";
    } else if ($option == "eliminarEjercicio") {
        $data = array(
            'id_topic' => $id_topic,
            'id_problem' => $id_problem,
            'id_course' => $current_course
        );
        $c->eliminar_problema_de_topic($data);
        echo "1";
    }
} else {
    
}
?>
