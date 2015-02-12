




<div class="row-fluid">
    <div class="span12">
        <div class="row">

            <div class="span4 offset4">
                <div class="well">
                    <legend>Create new course</legend>
                    <form method="POST" name="form2" action="curso.php?option=crearCurso" accept-charset="UTF-8">

                        <span class='x span4 pull-left'>Course name:</span>  <input class="span8 pull-right" placeholder="Nombre del curso" required type="text" required name="nombre">
                        <span class='x span4 pull-left'>Code course:</span>  <input class="span8 pull-right" placeholder="Código del curso" required type="text" required name="codigo">
                        <br>
                        <button  class="btn-info btn btn-block" type="submit">Create</button>      
                    </form>    
                </div>
            </div>
        </div>
    </div>

</div>

<style>

    .x{
        margin-top: 4px;
        margin-bottom: 5px;
     
    }
</style>