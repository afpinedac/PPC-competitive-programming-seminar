
<div class="row-fluid">
    <div class="span12">
        <div class="row">
            <div class="span4 offset4">
                <div class="well">
                    <legend>Update information</legend>
                    <form method="POST" name="form2" action="curso.php?option=editarInfo" accept-charset="UTF-8">
                        <div id="error" class="alert alert-error hide">
<!--                            <a class="close" data-dismiss="alert" href="#">x</a><center> -->
                            <center><p id="mensaje-error"></p></center>
                        </div>      
                        <span class='x span3 pull-left'>User:</span>  <input class="span9 pull-right" placeholder="usuario" readonly="readonly" type="text" value='<?php echo $data['username'] ?>' name="username">
                        <span class='x span3 pull-left'>Name:</span>  <input class="span9 pull-right" placeholder="nombre" type="text"  value='<?php echo $data['nombre'] ?>' name="name">
                        <span class='x span3 pull-left'>Last Name:</span>  <input class="span9 pull-right" placeholder="apellido" type="text" value='<?php echo $data['apellido'] ?>' name="lastName">
                        <span class='x span3 pull-left'>E-mail:</span>  <input class="span9 pull-right" placeholder="e-mail" type="email"  value='<?php echo $data['email'] ?>' name="email">
                        <span class='x span3 pull-left'>Password:</span>  <input class="span9 pull-right" placeholder="password"  type="password" value='<?php echo $data['password'] ?>' name="password">
                        <span class='x span3 pull-left'>University:</span>  <input class="span9 pull-right" placeholder="universidad" type="text"  value='<?php echo $data['universidad'] ?>' name="university">

                        <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>" />
                        <br>
                        <button onclick="return validar();" class="btn-info btn btn-block" type="submit">Update</button>      
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .x{
        margin-bottom: 10px;
    }
</style>




<script>
                            function validar() {
                                var errores = "";

                                var valid = true;

                                if (form2.username.value == "") {
                                    errores += "<p>El Usuario es obligatorio<p>";
                                    form2.username.focus();
                                    valid = false;
                                }
                                if (form2.name.value == "") {
                                    errores += "<p>El nombre es obligatorio</p>";
                                    form2.name.focus();
                                    valid = false;
                                }
                                if (form2.lastName.value == "") {
                                    errores += "<p>El apellido es obligatorio</p>";
                                    form2.lastName.focus();
                                    valid = false;

                                }

                                if (form2.email.value == "") {
                                    errores += "<p>El e-mail es obligatorio</p>";
                                    form2.email.focus();
                                    valid = false;
                                }

                                if (form2.password.value == "") {
                                    errores += "<p>La contraseña es obligatoria</p>"
                                    form2.password.focus();
                                    valid = false;
                                }
                                if (form2.university.value == "") {
                                    errores += "<p>La universidad es obligatoria</p>"
                                    form2.university.focus();
                                    valid = false;
                                }
                                if (valid) {
                                    return true;
                                } else {
                                    $("#mensaje-error").html(errores);
                                    $("#error").show();
                                    return false;

                                }
                            }
</script>    
