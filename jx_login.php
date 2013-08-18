<?php

session_start();

require("include.php");
extract($_GET);
extract($_POST);
$c = new conector_mysql();
if (isset($_GET['option'])) {
    if ($option == "login") {
        // echo "= " . $c->checkLogin($username, $pass);
        if ($id = $c->checkLogin($username, $pass)) {
            $user = $c->getInfoUser($id);
            //establecemos las varialbes de session
            // $_SESSON['user']['rol']=$c->getRol($id);
            $_SESSION['user']['idUser'] = $c->getOneField($user, 'id_user');
            $_SESSION['user']['username'] = $c->getOneField($user, 'username');
            $_SESSION['user']['name'] = ucfirst($c->getOneField($user, 'name')) . " " . ucfirst($c->getOneField($user, 'lastName'));
            $_SESSION['user']['rol'] = $c->getOneField($user, 'rol');
            // var_dump($_SESSION);            
            echo "true";
            //header("Location:curso.php");
        } else {
            echo "false";
        }
    } elseif ($option == "existUser") {
        $username = $_GET['username'];
        $result = trim(ws::getIdUser($username));
        if ($result == "0") {
            echo "false";
        } else {
            $data = $c->getOneData($c->realizarConsulta("SELECT count(*) FROM user WHERE username='$username'"));
            // echo "N: $data";
            if ($data >= 1) {
                echo "already_exists";
            } else {
                echo "true";
            }
        }
    }
}
?>
