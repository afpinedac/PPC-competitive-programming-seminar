

<?php

//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded






$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP


try {

    $user_erudito = array(
        'email' => "programming.practice.center@gmail.com",
        'password' => "programming_practice_center"
    );


    //  $mail->Encoding = "quoted­printable";
    $mail->CharSet = "UTF-8";
    $mail->Host = "mail.yourdomain.com"; // SMTP server
    $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing) <-- set '2' to do debug
    $mail->SMTPAuth = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username = $user_erudito['email'];  // GMAIL username
    $mail->Password = $user_erudito['password'];            // GMAIL password
    $mail->AddAddress($user['email'], $user['nombre']);  // para quien va el mensaje y como se llama el usuario
    $mail->SetFrom('programming_practice_center@gmail.com', 'Programming Practice Center');  // El nombre del remitente
    //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
    $mail->Subject = '[PPC] Reestablecimiento de contraseña';
    $mail->AltBody = 'Solicitud de reestablecimiento de contraseña'; // optional - MsgHTML will create an alternate automatically
    $old = array('{nombre}', '{link}');
    $new = array($user['nombre'], $user['link']);
    $content = str_replace($old, $new, file_get_contents('./lib/smtp/servidor/contents.php'));
    $mail->MsgHTML($content);
    // $mail->AddAttachment('./lib/smtp/servidor/images/phpmailer.gif');      // attachment
    // $mail->AddAttachment('./lib/smtp/servidor/images/phpmailer_mini.gif'); // attachment
    $mail->Send();

    $data = array(
        'tipo' => 'success',
        'mensaje' => "Se ha enviado un correo con el link de reestablecimiento a: <strong>$email</strong>"
    );

    //  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
    $data = array(
        'tipo' => 'error',
        'mensaje' => "Se ha generado un error enviando el correo de reestablecimiento:  {$e->getMessage()}"
    );
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    $data = array(
        'tipo' => 'error',
        'mensaje' => "Se ha generado un error enviando el correo de reestablecimiento:  {$e->getMessage()}"
    );
    echo $e->errorMessage();
}
?>

