
<div class="row-fluid">
    <div class="span12">
        <div class="row">
            <div class="span4 offset4">
                <div class="well">
                    <legend>Actualizar información</legend>
                    <form method="POST" action="curso.php?option=editarInfo" accept-charset="UTF-8">
                        <div class="alert alert-error">
                            <a class="close" data-dismiss="alert" href="#">x</a>Incorrect Username or Password!
                        </div>      
                        <span class='x span3 pull-left'>Usuario:</span>  <input class="span9 pull-right" placeholder="usuario" readonly="readonly" type="text" value='<?php echo $data['username'] ?>' name="username">
                        <span class='x span3 pull-left'>Nombre:</span>  <input class="span9 pull-right" placeholder="nombre" type="text"  value='<?php echo $data['nombre'] ?>' name="name">
                        <span class='x span3 pull-left'>Apellido:</span>  <input class="span9 pull-right" placeholder="apellido" type="text" value='<?php echo $data['apellido'] ?>' name="lastName">
                        <span class='x span3 pull-left'>E-mail:</span>  <input class="span9 pull-right" placeholder="e-mail" type="text"  value='<?php echo $data['email'] ?>' name="email">
                        <span class='x span3 pull-left'>Contraseña:</span>  <input class="span9 pull-right" placeholder="password"  type="password" value='<?php echo $data['password'] ?>' name="password">
                        <span class='x span3 pull-left'>Universidad:</span>  <input class="span9 pull-right" placeholder="universidad" type="text"  value='<?php echo $data['universidad'] ?>' name="university">

                        <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>" />
                        <button onclick="return validar();" class="btn-info btn btn-block" type="submit">Actualizar</button>      
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
                                if (form2.username.value == "") {
                                    alert("Todos los campos son obligatorios");
                                    form2.username.focus();
                                    return false;
                                } else if (form2.name.value == "") {
                                    alert("Todos los campos son obligatorios");
                                    form2.name.focus();
                                    return false;
                                } else if (form2.lastName.value == "") {
                                    alert("Todos los campos son obligatorios");
                                    form2.lastName.focus();
                                    return false;
                                } else if (form2.password.value == "") {
                                    alert("Todos los campos son obligatorios");
                                    form2.password.focus();
                                    return false;
                                } else if (form2.university.value == "") {
                                    alert("Todos los campos son obligatorios");
                                    form2.university.focus();
                                    return false;
                                }

                                return true;
                            }
</script>    
