<div class="container">
    <div class="row-fluid">
        <div class="span9">

            <form class="form-horizontal" method="post" action="curso.php?option=editarCursoCreado&idCurso=<?php echo $data['id_course'] ?>">
                <div class="control-group">
                    <label class="control-label" for="nombre">Nombre</label>
                    <div class="controls">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre del curso" value="<?php echo $data['name'] ?>" >
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="codigo">Codigo</label>
                    <div class="controls">
                        <input type="text" id="codigo" name="codigo" placeholder="Ingrese un codigo" value="<?php echo $data['code'] ?>">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">                       
                        <button type="submit" class="btn btn-success">Editar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>    

</div>
