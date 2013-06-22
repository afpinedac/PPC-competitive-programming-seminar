
<div class="well">
    <h3>Editar Información</h3>
</div>    


<br>

<div class="container-fluid" >
    <div class="row-fluid offset4" >   

        <form class="form-horizontal" method="post" action="curso.php?option=editarInfo" id="form2">
            <div class="span1">
                <div class="control-group">
                    <label class="control-label" or="username">Usuario de la UVA</label>
                    <div class="controls">
                        <input type="text" id="nombre" name="username" readonly="readonly" value="<?php echo $data['username'] ?>" placeholder="Usuario">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"  for="nombre">Nombre</label>
                    <div class="controls">
                        <input type="text" id="nombre" name="name" value="<?php echo $data['nombre'] ?>" name="name" placeholder="Nombre">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="apellido">Apellido</label>
                    <div class="controls">
                        <input type="text" id="nombre" name="lastName" value="<?php echo $data['apellido'] ?>" placeholder="Apellido">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="text" id="inputEmail" name="email" value="<?php echo $data['email'] ?>" placeholder="Email">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Password</label>
                    <div class="controls">
                        <input type="password" id="inputPassword" name="password" value="<?php echo $data['password'] ?>" placeholder="Contraseña">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="universidad">Universidad</label>
                    <div class="controls">
                        <input type="text" id="inputPassword" name="university" value="<?php echo $data['universidad'] ?>" placeholder="Universidad">
                    </div>
                </div>
                
                <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>" />






                <div class="control-group">
                    <div class="controls">               
                        <button type="submit" onClick="return validar();"  class="btn btn-primary">Actualizar</button>
                    </div>
                </div>


            </div>





        </form>

    </div> 
</div>




</div>    

<script>
    function validar(){
        if(form2.username.value==""){
            alert("Todos los campos son obligatorios");
            form2.username.focus();
            return false;
        }else if(form2.name.value==""){
            alert("Todos los campos son obligatorios");
            form2.name.focus();
            return false;
        }else if(form2.lastName.value==""){
            alert("Todos los campos son obligatorios");
            form2.lastName.focus();
            return false;
        }else if(form2.password.value==""){
            alert("Todos los campos son obligatorios");
            form2.password.focus();return false;
        }else if(form2.university.value==""){
            alert("Todos los campos son obligatorios");
            form2.university.focus();return false;
        }
        
        return true;
    }
</script>    
