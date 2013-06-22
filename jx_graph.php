<?php

session_start();

require("include.php");
extract($_GET);
extract($_POST);
$c = new conector_mysql();
$current_course = $_SESSION['course']['idCurso'];


if (isset($_GET['option'])) {
    if ($option == "generateIdTopic") {
        $id = $c->generateIdTopic($current_course, $posx, $posy);
        echo $id;
    } else if ($option == "delete") {
        $c->eliminarTopic($id, $current_course);
    } else if ($option == "editPosition") {
        $c->editarPosition($idTopic, $current_course, $x, $y);
    } else if ($option == "updateInfo") {
        echo "res";
        $c->editarTopic($idTopic, $current_course, $name, $minimum);        
    }
} else {
    
}
?>
