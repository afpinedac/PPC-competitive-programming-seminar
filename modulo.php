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

    require("./vista/templates/header.php");
    require("./vista/_modulo.php");

    if (isset($option)) {
        if ($option == "logout") {
            session_destroy();
            echo "<script>location.href='index.php'</script>";
        } else if ($option == "verRanking") {
            $result = $c->getRankingCurso($current_course);
            $programador = $c->get_programador_semana($current_course);
            require('./vista/cursos/_rankingCurso.php');
        } else if ($option == "verRecursos") {
            $result = $c->getRecursos($current_course);
            $n_recursos = $c->numFilas($result);
            require('./vista/cursos/_recursos.php');
        } else if ($option == "crearRecurso") {
            $data = $_POST;
            $data['id_user'] = $current_user;
            $c->crearRecurso($current_course, $data);
            echo "<script>location.href='modulo.php?option=verRecursos'</script>";
        } else if ($option == "eliminarRecurso" && isset($_POST['id_resource'])) {
            $data = $_POST;
            $data['id_user'] = $current_user;
            $c->eliminarRecurso($data);
            echo "<script>location.href='modulo.php?option=verRecursos'</script>";
        } else if ($option == "estadisticas") {


            //get all participants
            // $users = $c->get_all_participants($idCurso);

            $data = array();

            $user = $c->getInfoUser($current_user);
            $_data['user']['nombre'] = $c->getOneField($user, 'name');
            $_data['user']['foto'] = $c->getOneField($user, 'foto');
            $_data['user']['apellido'] = $c->getOneField($user, 'lastName');
            $_data['user']['username'] = $c->getOneField($user, 'username');
            $_data['user']['topics'] = $c->getAllTopics($current_course); //$c->get_number_of_exercises_solved_by_topic($idUser, $idCurso);
            $_data['user']['subs'] = get_submissions($current_user, $current_course, $_data['user']['username']);

            $idUser = $current_user;
            $idCurso = $current_course;



         
            require './vista/usuario/_estadisticas.php';
        }
    } else {
        cargarProblemasSolucionados();
        mostrarGrafo();
    }
    require('./vista/templates/footer.php');
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
    //var_dump(time());
    global $c, $current_user;

    foreach ($var as $arr) {
        if ($arr[2] == 90) {

            // $data=ws::getInfoProblem2($arr[1], "num");            
            $data = $c->getProblemNumber($arr[1]);
            $query = "INSERT INTO solved(id_user,id_problem,date) VALUES('$current_user','$data','$arr[4]')";
            try {
                $c->realizarConsulta($query);
            } catch (Exception $e) {
                null;
            }
        }
    }
}

//FUNCIONES UTILES

function get_submissions($user, $course, $username) {
    global $c;

    $subs = ws::getSubmissions(ws::getIdUser($username));
    //var_dump($subs);

    $solve = $c->get_problems_to_solve($user, $course);

    $arr_solve = array();

    while ($row = mysql_fetch_array($solve)) {
        $arr_solve[] = $row['id_problem'];
    }

    $arr_solve = mapear_problemas($arr_solve);

    $response = array();


    foreach ($arr_solve as $solve) {
        foreach ($subs as $sub) {
            if ($sub[1] == $solve) {
                $response[] = $sub;
            }
        }
    }

    $data2 = array();
    $i = 0;

    foreach ($response as $sub) {

        $data['problem'] = $c->getOneData($c->getInfoUVAProblem($sub[1]), 'title');
        $data['topic'] = 'topic1';
        $data['fecha'] = date('d-m-Y H:i:s', $sub[4]);
        $data['resultado'] = ws::getVerdictID($sub[2]);
        $data2[$i++] = $data;
    }
    return $data2;
}

function mapear_problemas($to_solve) {
    global $c;
    $lista = "";
    foreach ($to_solve as $value) {
        $lista.= ",$value";
    }
    //echo "$lista";
    $lista = "(" . substr($lista, 1) . ")";

    $query = "SELECT id_problem from uva_problems WHERE n_problem in $lista";
    $result = $c->realizarConsulta($query);

    $values = array();

    while ($row = mysql_fetch_array($result)) {
        $values[] = $row['id_problem'];
    }
    return $values;
}

?>