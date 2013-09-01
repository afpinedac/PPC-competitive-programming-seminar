<br>
<br>
<br>
<br>
<div class="row-fluid">
    <div class="span12">
        <div class="row">
            <div class="span6 offset3">
                <div class="well">
                    <legend>Update password</legend>
                    <form id="cambiar_password" method="POST" name="form2" action="index.php?option=cambiar_password" accept-charset="UTF-8">
                        <div id="error" class="alert alert-error hide">
<!--                            <a class="close" data-dismiss="alert" href="#">x</a><center> -->
                            <center><p id="mensaje-error"></p></center>
                        </div>      
                        <span class='x span3 pull-left'>Email:</span>  <input class="span9 pull-right" placeholder="usuario" readonly="readonly" type="text" value='<?php echo $data['email'] ?>' name="username">
                        <span class='x span3 pull-left'>New password:</span>  <input id="new" class="span9 pull-right" placeholder="nueva contraseña" type="password"  value='' required name="new">
                        <span class='x span3 pull-left'>Repeat new password:</span>  <input id="old" class="span9 pull-right" placeholder="repetir nueva contraseña" type="password" required value='' name="new2">
                        <input type="hidden" name="_email" value="<?php echo $data['_email']?>">
                        <br>
                        <button onclick="return validar();" class="btn-info btn btn-block" type="submit">Actualizar</button>      
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#cambiar_password").submit(function(){
        if($("#new").val()==$("#old").val()){            
           return true;
        }else{
           alert('The Passwords don\'t match');
           $("#new").focus();
           return false;
        }
    });
});
</script>