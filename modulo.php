<?php

session_start();

if (isset($_SESSION['course']['idCurso'])) {
    require("include.php");
    extract($_GET);
    extract($_POST);
    $c = new conector_mysql();
    $current_user = $_SESSION['user']['idUser'];
    $current_user_rol = $_SESSION['user']['rol'];
    $current_course = $_SESSION['course']['idCurso'];
    $data["id_course"] = $current_course;
    $username = $_SESSION['user']['username'];
    $info['uva_id'] = ws::getIdUser($username);
    // echo "->" .$info['uva_id'];

    $COURSE_NAME = $c->getOneField($c->getInfoCurso($current_course), 'name');

    //   echo $current_user;
//CABECERAS

    require("./vista/header.php");
    require("./vista/_modulo.php");

    if (isset($option)) {
        if ($option == "logout") {
            session_destroy();
            echo "<script>location.href='index.php'</script>";
        } else if ($option == "verRanking") {
            $result = $c->getRankingCurso($current_course);
            require('./vista/_rankingCurso.php');
        } else if ($option == "verRecursos") {
            $result = $c->getRecursos($current_course);
            require('./vista/_recursos.php');
        } else if ($option == "crearRecurso") {
            $data = $_POST;
            $c->crearRecurso($current_course, $data);
            echo "<script>location.href='modulo.php?option=verRecursos'</script>";
        }
    } else {
        cargarProblemasSolucionados();
        mostrarGrafo();
    }
    require("./vista/footer.php");
} else {
    echo "ud no tiene permiso para ver el modulo";
}

function mostrarGrafo() {
    global $c, $current_course;
    $topics = $c->getAllTopics($current_course);
    $connections = $c->getAllSucesor($current_course);
    // var_dump($topics);

    require('./vista/_grafo.php');
    require('./vista/_modalTopic.php');
}

function cargarProblemasSolucionados() {
    $username = $_SESSION['user']['username'];
    $user = ws::getIdUser($username);
    $var = ws::getSubmissions($user);
    global $c, $current_user;
    foreach ($var as $arr) {
        if ($arr[2] == 90) {
            // $data=ws::getInfoProblem2($arr[1], "num");            
            $data = $c->getProblemNumber($arr[1]);
            $query = "INSERT INTO solved(id_user,id_problem) VALUES('$current_user','$data')";
            try {
                $c->realizarConsulta($query);
            } catch (Exception $e) {
                null;
            }
        }
    }
}

//FUNCIONES UTILES
?>