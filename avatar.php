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
        $option = $_GET['option'];
        if ($option == "actualizar" && isset($avatar)) {

            $data = array(
                'foto' => $avatar,
                'id_user' => $current_user
            );

            $c->actualizar_avatar($data);
            echo "<script>location.href='curso.php'</script>";
        }
    }


    require("./vista/_avatar.php");


    require("./vista/templates/footer.php");
} else {
    echo "ud no tiene permiso";
}