<?php


echo "esto es un test";
exit;

require("include.php");
require("./vista/templates/header.php");

$c = new conector_mysql();

if (isset($_GET['option'])) {
    $opt = $_GET['option'];
    if ($opt == "login") {
        require("./vista/_index.php");
        require("./vista/_login.php");
    } else if ($opt == "registrar") {
        require("./vista/_register.php");
    } else if ($opt == "reestablecer-password") {
        require('./vista/_reestablecer_password.php');
    } else if ($opt == "reestablecer_password") {
        $email = $_POST['email'];
        if (is_register($email)) {
            $usuario = $c->getInfoUserByCorreo($email);
            $user['nombre'] = $c->getOneField($usuario, 'name') . " " . $c->getOneField($usuario, 'lastName');
            $user['email'] = $c->getOneField($usuario, 'email');
            $user['link'] = create_link($user['email'], $c->getOneField($usuario, 'password'));

            require_once('./lib/smtp/class.phpmailer.php');
            require './lib/smtp/servidor/servidor_smtp.php';
            echo "<script>alert('A link to reset your password has been sended to ' + '$email')</script>";
            echo "<script>location.href='index.php'</script>";
            //var_dump($user);
        } else {
            echo "<script>alert('This e-mail is not registered')</script>";
            echo "<script>location.href='index.php'</script>";
        }
    } else if ($opt == "reestablecer") {

        $token = explode("@", $_GET['token']);
        $data['email'] = base64_decode(base64_decode($token[0]));
        $data['_email'] = $token[0];

        if (valid_token($data['email'], base64_decode(base64_decode($token[1])))) {
            require './vista/_cambiar_password.php';
        } else {
            echo "<script>alert('This link is invalid')</script>";
            echo "<script>location.href='index.php'</script>";
        }
    } else if ($opt == "cambiar_password") {

        $data['password'] = $_POST['new'];
        $data['email'] = base64_decode(base64_decode($_POST['_email']));
        $c->cambiar_password($data);
        echo "<script>alert('Password changed correctly')</script>";
        echo "<script>location.href='index.php'</script>";
    }
} else {


    require("./vista/_index.php");
}
require './vista/templates/footer.php';

function is_register($email) {
    global $c;
    return $c->correo_exists($email) ? true : false;
}

function create_link($email, $old_password) {
    $separator = "@";
    $token = base64_encode(base64_encode($email)) . $separator . base64_encode(base64_encode($old_password));
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?option=reestablecer&token=$token";
    return $url;
}

function valid_token($email, $pass) {
    global $c;

    $pass1 = $c->getOneField($c->getInfoUserByCorreo($email), 'password');
    return $pass1 == $pass ? true : false;
}