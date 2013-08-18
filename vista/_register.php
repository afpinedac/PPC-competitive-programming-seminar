<div class="row-fluid">

    <div class="row-fluid">
        <div class="span12">
            <center><h3>Programming Practice Center</h3></center>
        </div>
    </div>

    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="span4 offset4">

                <center><p><a href='index.php' ><i class='icon icon-share-alt'></i>Volver</a></p></center>


                <div class="row-fluid">


                    <form  method="post" name="reg" action="registro.php?option=registrar">
                        <div class="span12 well">
                            <legend>Registrate (es gratis) <span class='pull-right' style='font-size: 10px;'><a href='' onclick="alert('Escribe un correo a <<afpinedac@unal.edu.co>>')">Problemas con el registro?</a></span></legend>
                            <div>
                                <label style='margin-top: 4px; font-size: 12px;' for="nombre" class='span4'><strong><a href='http://uva.onlinejudge.org/index.php?option=com_comprofiler&task=registers' target="_blank">Usuario de la UVA :</a></strong> </label><input type="text" id="nombre" class="span8" name="username" value='' placeholder="Usuario de la UVA">
                            </div>                        
                            <div>
                                <label style='margin-top: 4px;' for="nombre" class='span3'><strong>Nombre :</strong> </label><input type="text" id="nombre" class="span9" name="name" value='' placeholder="Nombre">
                            </div>
                            <div>
                                <label style='margin-top: 4px;' for="apellido" class='span3'><strong>Apellido :</strong> </label><input type="text" id="apellido" class="span9" name="lastName" value='' placeholder="Apellido">
                            </div>
                            <div>
                                <label style='margin-top: 4px;' for="email" class='span3'><strong>E-mail :</strong> </label><input type="email" id="email" class="span9" name="email" value="" placeholder="E-mail">
                            </div>
                            <div>
                                <label style='margin-top: 4px;' for="password" class='span4'><strong>Contraseña :</strong> </label><input type="password" id="password" class="span8" name="password" value='' placeholder="Contraseña">
                            </div>
                            <div>
                                <label style='margin-top: 4px; font-size: 12px;' for="confirmed_password" class='span4'><strong>Repertir contraseña:</strong> </label><input type="password" id="confirmed_password" class="span8" value='' name="password2" placeholder="Repetir contraseña">
                            </div>
                            <div>
                                <label style='margin-top: 4px;' for="apellido" class='span4'><strong>Universidad :</strong> </label><input type="text" id="apellido" class="span8" name="university" value='' placeholder="Universidad">
                            </div>
                            <div>
                                <input type="checkbox" id="profesor" name="profesor" placeholder="Email"> <strong><span style='padding-top: 3px;'>Soy profesor</span></strong>
                            </div>

                            <br>
                            <button type="submit" name="submit" class="btn btn-info btn-block" onclick="return validar();"><i class='icon icon-ok-circle icon-white'></i> REGISTRAR</button>

                        </div></form>
                </div>




            </div> 
        </div>
    </div>
    <div class="span12">





    </div>
</div>


<script>
                                function validar() {




                                    //validamos que todo tenga algo
                                    if (reg.username.value.length == 0) {
                                        alert("El nombre de usuario es obligatorio");
                                        reg.username.focus();
                                        return false;
                                    }


                                    var result = $.ajax({
                                        url: "jx_login.php?option=existUser&username=" + reg.username.value,
                                        async: false
                                    }).responseText



                                    // alert("pasa1");
                                    if (result === "false") {
                                        alert("El usuario de la UVA es inválido");
                                        reg.username.focus();
                                        return false;
                                    } else if (result === 'already_exists') {
                                        alert("Este usuario ya se encuentra registrado");
                                        reg.username.focus();
                                        return false;
                                    }


                                    if (reg.name.value.length == 0) {
                                        alert("El nombre  es obligatorio");
                                        reg.name.focus();
                                        return false;
                                    }

                                    if (reg.lastName.value.length == 0) {
                                        alert("El apellido es obligatorio");
                                        reg.lastName.focus();
                                        return false;
                                    }

                                    if (reg.email.value.length == 0) {
                                        alert("El email es obligatorio");
                                        reg.email.focus();
                                        return false;
                                    }

                                    if (reg.password.value.length == 0) {
                                        alert("La contraseña es obligatoria");
                                        reg.password.focus();
                                        return false;
                                    }



                                    if (reg.university.value.length == 0) {
                                        alert("La universidad es obligatoria");
                                        reg.university.focus();
                                        return false;
                                    }





                                    // alert("pasa2");
                                    if (reg.password.value != reg.password2.value) {
                                        $("#merror").removeClass('hide');
                                        $("#mensaje").text('Las contraseñas no coinciden');
                                        reg.password.focus();
                                        return false;

                                    }


                                    $("#fade").removeClass('overlay');
                                    $("#light").removeClass('loading');
                                    $("#fade,#light").addClass('oculto');

                                    return true;
                                }
</script>

