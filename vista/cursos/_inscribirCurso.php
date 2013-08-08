
<div class="row-fluid">
    <div class="span12">
        <div class="row">

            <div class="span4 offset4">
                <div class="well">
                    <legend>Inscribir curso</legend>
                    <form method="POST" name="form2" action="curso.php?option=validarCodigo" accept-charset="UTF-8">
                        <div id="error" class="alert alert-error hide">
<!--                            <a class="close" data-dismiss="alert" href="#">x</a><center> -->
                            <center><p id="mensaje-error"></p></center>
                        </div> <br>     
                        <span class='x span4 pull-left'>Código del curso:</span>  <input class="span8 pull-right" placeholder="código del curso"  type="text" required name="codigo">

                        <button  class="btn-info btn btn-block" type="submit">Inscribir</button>      
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>