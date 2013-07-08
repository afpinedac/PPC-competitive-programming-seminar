<div class="container-fluid">


    <br>


    <div class="row-fluid">
        <div class="span6 offset3 well">

            <legend><h2>Registro</h2></legend>
            <!--<h6 > <a href="http://uva.onlinejudge.org/index.php?option=com_comprofiler&task=registers" target="_blank">¿No tienes usuario de la UVA? </a></h6>-->


            <div id="fade" class="oculto"></div>
            <div id="light" class="oculto">
                <img src="./images/cargando.gif"></img>
            </div>


            <br>

            <div id="merror" class="alert alert-error hide">
                <center><p id="mensaje"></p></center>
            </div> 

            <div class="container-fluid">
                <div class="row-fluid " >   
                    <div class="pull-left">
                        <form class="form-horizontal pull-left" method="post" name="reg" action="registro.php?option=registrar">

                            <div class="span1 offset3">
                                <div class="control-group">
                                    <label class="control-label" or="username">Usuario de la UVA</label>
                                    <div class="controls">
                                        <input type="text" id="nombre" name="username" placeholder="Usuario"> 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="nombre">Nombre</label>
                                    <div class="controls">
                                        <input type="text" id="nombre" name="name" placeholder="Nombre">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="apellido">Apellido</label>
                                    <div class="controls">
                                        <input type="text" id="nombre" name="lastName" placeholder="Apellido">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Email</label>
                                    <div class="controls">
                                        <input type="email" id="inputEmail" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Contraseña</label>
                                    <div class="controls">
                                        <input type="password" id="inputPassword" name="password" placeholder="Contraseña">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Repetir Contraseña</label>
                                    <div class="controls">
                                        <input type="password" id="inputPassword" name="password2" placeholder="nuevamente la contraseña">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="universidad">Universidad</label>
                                    <div class="controls">
                                        <input type="text" id="inputPassword" name="university" placeholder="Universidad">
                                    </div>
                                </div> 


                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Soy profesor</label>
                                    <div class="controls">
                                        <input type="checkbox" id="profesor" name="profesor" placeholder="Email">
                                    </div>
                                </div> 


                                <div class="control-group">
                                    <div class="controls">               
                                        <button type="submit"  onClick=" return validar();" class="btn btn-info">Registrarme</button>
                                    </div>
                                </div>

                            </div>





                        </form>
                    </div>
                </div> 
            </div>
        </div>

    </div>

</div>


<style>
    .control-group{
        margin-bottom: 5px;
    }

</style>



<script>
                                            function validar() {
                                                $("#fade,#light").removeClass('oculto');
                                                $("#fade").addClass('overlay');
                                                $("#light").addClass('loading');


                                                //validamos que todo tenga algo
                                                if (reg.username.value.length == 0) {
                                                    alert("El nombre de usuario es obligatorio");
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




                                                var result = $.ajax({
                                                    url: "jx_login.php?option=existUser&username=" + reg.username.value,
                                                    async: false
                                                }).responseText

                                                //  alert(result);

                                                // alert("pasa1");
                                                if (result == "false") {
                                                    //   alert("pasa1.1");
                                                    $("#merror").removeClass('hide');
                                                    $("#mensaje").text('El nombre de usuario no es valido');
                                                    reg.username.focus();
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

