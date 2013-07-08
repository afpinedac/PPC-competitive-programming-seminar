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
        } else if ($option == "validarCodigo") {
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
            $c->eliminarCursoCreado($idCurso);
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
            echo "<script>alert('La información fue actualizada correctamente')</script>";
            echo "<script>location.href='curso.php?option=editarInformacion'</script>";
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
    if ($cursos = $c->getMyCursos($current_user)) {
        require("./vista/cursos/_listaCursos.php");
    } else {
        $data['tipo'] = "error";
        $data['message'] = "Actualmente no tiene cursos inscritos";
        require("./vista/templates/_message.php");
        $data['tipo'] = "error";
        $data['message'] = "Si desea puede inscribirse al curso del semillero de Programación de UNALMED, código: semillero@13";
        require("./vista/templates/_message.php");
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

?>