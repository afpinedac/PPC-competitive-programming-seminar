<?php

session_start();

if (isset($_SESSION['user']['username'])) {
    require("include.php");
    extract($_GET);
    extract($_POST);

    // var_dump($_SESSION);
    $c = new conector_mysql();
    $current_user = $_SESSION['user']['idUser'];
    $current_user_rol = $_SESSION['user']['rol'];
    $username = $_SESSION['user']['username'];
    //  $current_course = $_SESSION['course']['idCurso'];
    $info['uva_id'] = ws::getIdUser($username);
    // var_dump($info);
    //$data=ws::getIdUser($c->getOneField($c->getInfoUser($current_user), 'username'));
//CABECERAS

    require("./vista/templates/header.php");
    require("./vista/cursos/_curso.php");

    if (isset($option)) {
        if ($option == "logout") {
            session_destroy();
            echo "<script>location.href='index.php'</script>";
            // header("Location:index.php");
        } else if ($option == "validarCodigo" && isset($_POST['codigo'])) {
            if ($idCurso = $c->validarCodigo($codigo, $current_user)) {
                $c->registrarParticipante($current_user, $idCurso);
                mostrarCursos();
            } else {
                $data['tipo'] = 'error';
                $data['message'] = "El codigo es inválido";
                require("./vista/templates/_message.php");
                require("./vista/cursos/_inscribirCurso.php");
            }
        } else if ($option == "inscribir") {
            require("./vista/cursos/_inscribirCurso.php");
        } else if ($option == "crearNuevo" && $current_user_rol == 1) {
            require("./vista/cursos/_crearCurso.php");
        } else if ($option == "eliminar") {
            $c->eliminarParticipante($current_user, $idCurso);
            mostrarCursos();
        } else if ($option == "entrar") {
            $_SESSION['course']['idCurso'] = $idCourse;
            echo "<script>location.href='modulo.php'</script>";
        } else if ($option == "crearCurso" && $current_user_rol == 1) {
            if ($c->registrarCurso($current_user, $nombre, $codigo)) {
                $data['tipo'] = "success";
                $data['message'] = "Curso creado correctamente";
                require("./vista/templates/_message.php");
                mostrarCursos();
            } else {
                $data['tipo'] = "error";
                $data['message'] = "El código del curso ya esta en uso";
                require("./vista/templates/_message.php");
                require("./vista/cursos/_crearCurso.php");
            }
        } else if ($option == "eliminarCursoCreado" && $current_user_rol == 1) {
            $c->eliminarCursoCreado($idCurso, $current_user);
            mostrarCursos();
        } else if ($option == "editarCursoCreado" && $current_user_rol == 1) {
            //  var_dump($_GET);
            $c->editarCurso($idCurso, $nombre, $codigo);
            mostrarCursos();
        } else if ($option == "editarCurso" && $current_user_rol == 1) {
            $_SESSION['course']['idCurso'] = $idCurso;
            $data['id_course'] = $idCurso;
            //$data['code'] = $c->getOneField($c->getInfoCurso($idCurso), 'registration_code');
            //$data['name'] = $c->getOneField($c->getInfoCurso($idCurso), 'name');
            //var_dump($_SESSION); 

            echo "<script>location.href='graph.php'</script>";
            //require("./vista/_editCurso.php");
        } else if ($option == "editarInformacion") {
            $user = $c->getInfoUser($current_user);
            $data['id_user'] = $current_user;
            $data['username'] = $c->getOneField($user, 'username');
            $data['nombre'] = $c->getOneField($user, 'name');
            $data['apellido'] = $c->getOneField($user, 'lastName');
            $data['password'] = $c->getOneField($user, 'password');
            $data['email'] = $c->getOneField($user, 'email');
            $data['universidad'] = $c->getOneField($user, 'university');
            require("./vista/usuario/_editarInformacion.php");
        } else if ($option == "editarInfo") {
            $query = "UPDATE user SET name='$name', lastName='$lastName', password='$password',username='$username',email='$email', university='$university' WHERE id_user='$id_user'";
            $c->realizarConsulta($query);
            echo "<script>alert('Information has updated correctly')</script>";
            echo "<script>location.href='curso.php?option=editarInformacion'</script>";
        } else if ($option == "administrar" && isset($_GET['idCurso'])) {

            if (is_owner($_SESSION['user']['idUser'], $idCurso)) {


                //get all participants
                $users = $c->get_all_participants($idCurso);

                $data = array();
                if (isset($idUser)) {
                    $user = $c->getInfoUser($idUser);
                    $_data['user']['nombre'] = $c->getOneField($user, 'name');
                    $_data['user']['foto'] = $c->getOneField($user, 'foto');
                    $_data['user']['apellido'] = $c->getOneField($user, 'lastName');
                    $_data['user']['username'] = $c->getOneField($user, 'username');
                    $_data['user']['topics'] = $c->getAllTopics($idCurso); //$c->get_number_of_exercises_solved_by_topic($idUser, $idCurso);
                    $_data['user']['subs'] = get_submissions($idUser, $idCurso, $_data['user']['username']);

                    // var_dump($_data['user']['subs']);
                } else {

                    $course = $c->getInfoCurso($idCurso);
                    $_data['curso']['nombre'] = $c->getOneField($course, 'name');
                    $_data['curso']['codigo'] = $c->getOneField($course, 'registration_code');
                    $_data['curso']['fecha_creacion'] = $c->getOneField($course, 'creation_date');
                    $_data['curso']['numero_estudiantes'] = $c->getNumeroEstudiantes($idCurso);
                    $_data['curso']['numero_temas'] = $c->getNumeroTemas($idCurso);
                    $_data['curso']['numero_ejercicios'] = 0;
                }


                require './vista/cursos/_administrarCurso.php';
            } else {
                echo "<script>location.href='curso.php'</script>";
            }
        } else {
            echo "<script>location.href='curso.php'</script>";
        }
    } else {
        mostrarCursos();
    }
    require("./vista/templates/footer.php");
} else {
    echo "ud no tiene permiso";
}

//FUNCIONES UTILES

function mostrarCursos() {
    global $c, $current_user, $current_user_rol;
    $user = $c->getInfoUser($current_user);
    $data['user']['username'] = $_SESSION['user']['username'];
    $data['user']['full_name'] = $c->getOneField($user, 'name') . " " . $c->getOneField($user, 'lastName');
    $data['user']['university'] = $c->getOneField($user, 'university');
    $data['user']['foto'] = $c->getOneField($user, 'foto');
    if ($cursos = $c->getMyCursos($current_user)) {
        require("./vista/cursos/_listaCursos.php");
    } else {
        $data['tipo'] = "error";
        $data['message'] = "<em>Right now, you don't have any course registered!!</em>";
        require("./vista/templates/_message.php");
        $data['tipo'] = "error";
        $data['message'] = "If you want you can register the National University of Colombia programming course </p>code: <em>semillero@13</em> <a href='curso.php?option=inscribir&code=semillero@13'>[here]</a></p>";
        require("./vista/templates/_message.php");
        if ($_SESSION['user']['rol'] == 1) {
            $data['message'] = "If you're a teacher you can create your own  <a href='curso.php?option=crearNuevo'>[here]</a>";
            require("./vista/templates/_message.php");
        }
    }

    if ($current_user_rol == 1) {
        if ($cursos = $c->getMyCursosCreados($current_user)) {



            require("./vista/cursos/_listarCursosCreados.php");
        } else {
            $data['tipo'] = "error";
            $data['message'] = "Actualmente no tiene cursos creados";
            require("./vista/templates/_message.php");
        }
    }
}

//checks if a user is owner of a course
function is_owner($user, $course) {
    global $c;
    $count = $c->get_is_owner($user, $course);
    return $count == 1 ? true : false;
}

function get_submissions($user, $course, $username) {
    global $c;

    $subs = ws::getSubmissions(ws::getIdUser($username));
    //var_dump($subs);

    $solve = $c->get_problems_to_solve($user, $course);

    $arr_solve = array();

    while ($row = mysqli_fetch_array($solve)) {
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

    while ($row = mysqli_fetch_array($result)) {
        $values[] = $row['id_problem'];
    }
    return $values;
}

?>