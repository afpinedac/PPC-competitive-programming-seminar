
<div id="fade" class="oculto"></div>
<div id="light" class="oculto">
    <img src=".public/img/cargando.gif"></img>
</div>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">LOGIN</h3>
    </div>
    <div class="modal-body">
        <div id="merror" class="alert alert-error hide">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <center><p>Usuario o contraseña incorrectos</p></center>
        </div> 
        <form id="form1" class="form-horizontal" onsubmit="return login();">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Usuario:</label>
                <div class="controls">
                    <input type="text" id="inputEmail" name="username" placeholder="Usuario UVA">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">Contraseña:</label>
                <div class="controls">
                    <input type="password" id="inputPassword" name="pass" placeholder="Password">
                </div>
            </div>


            <div class="control-group">
                <div class="controls">
                    <!-- <label class="checkbox">
                         <input type="checkbox"> Remember me
                     </label>  -->
                    <button type="submit" class="btn btn-primary" onClick="">Entrar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
</div>

<script>
            $(document).ready(function() {
                $("#myModal").modal('show');
            });

            function login() {
                $("#fade,#light").removeClass('oculto');
                $("#fade").addClass('overlay');
                $("#light").addClass('loading');

                var result = $.ajax({
                    url: "jx_login.php?option=login&username=" + form1.username.value + "&pass=" + form1.pass.value,
                    async: false
                }).responseText


                if (result == "false") {
                    $("#merror").removeClass('hide');
                    $("#fade").removeClass('overlay');
                    $("#light").removeClass('loading');
                    $("#fade,#light").addClass('oculto');
                    form1.pass.value = "";
                    return false;
                }
                else {
                    //alert("redireccionando");
                    location.href = "curso.php";
                    return false;
                }






            }


</script>   