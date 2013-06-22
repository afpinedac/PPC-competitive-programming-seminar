<?php

session_start();

if (isset($_SESSION['course']['idCurso']) && $_SESSION['user']['rol'] == 1) {
    require("include.php");
    extract($_GET);
    extract($_POST);
    $c = new conector_mysql();
    $current_user = $_SESSION['user']['idUser'];
    $current_course = $_SESSION['course']['idCurso'];
    $COURSE_NAME = $c->getOneField($c->getInfoCurso($current_course), 'name');;

    require("./vista/header.php");
    require("./vista/_graphHeader.php");


    if (isset($option)) {
        if ($option == "addInfoTopic") {
            require('./vista/_graph.php');
        }
    } else {
        mostrarGrafo();
    }

    require('./vista/footer.php');
} else {
    echo 'no tiene permiso para ver esta pagina';
}

function mostrarGrafo() {
    global $c, $current_user, $current_course;
    $topics = $c->getAllTopics($current_course);
    $connections = $c->getAllSucesor($current_course);
    // var_dump($topics);

    require('./vista/_graph.php');
    require('./vista/_modalTopic.php');
}

?>
