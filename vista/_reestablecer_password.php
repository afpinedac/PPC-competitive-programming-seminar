
<br>
<br>
<br>


<center><a href='index.php'><i class='icon icon-share-alt'>Back</i></a></center>

<div class="row-fluid">
    <div class="span12">
        <div class="row">
            <div class="span4 offset4">
                <div class="well">
                    <legend>Reset password</legend>
                    <form method="POST" name="form2" action="index.php?option=reestablecer_password" accept-charset="UTF-8">
                        <div id="error" class="alert alert-error hide">
<!--                            <a class="close" data-dismiss="alert" href="#">x</a><center> -->
                            <center><p id="mensaje-error"></p></center>
                        </div>      
                        <span class='x span2 pull-left'>E-mail:</span>  <input class="span10 pull-right" required placeholder="Correo donde se le enviara link de reestablecimiento"  type="email" value='' name="email">


                        <br>
                        <button onclick="return validar();" class="btn-info btn btn-block" type="submit">Send link</button>      
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>