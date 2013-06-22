<div class="container">
    <div class="row-fluid">
        <div class="span10" >
            <h3>Cursos Creados</h3>
        </div>
    </div>   
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-bordered table-hover">
                <thead>
                <td> Nombre</td>
                <td># de estudiantes</td>
                <td># de Temas</td>   
                <td># de problemas</td>   
                <td>Fecha de creación</td>              
                <td>Editar</td>
                <td>Eliminar</td>
                </thead>    
                <tbody>

                    <?php
                    $c = new conector_mysql();
                    //var_dump($cursos);
                    while ($data = mysql_fetch_array($cursos)) {
                        $result = $c->getInfoCurso($data['id_course']);
                        $participant = $c->getInfoParticipant($data['id_course'], $current_user);
                        $profesor = $c->getInfoUser($c->getOneField($result, 'id_user'));
                        echo "<tr><td>" . $c->getOneField($result, 'name') . "</td>
    <td>" . $c->getNumeroEstudiantes($data['id_course']) . "</td>  
        <td>" . $c->getNumeroTemas($data['id_course']) . "</td>  
        <td>" . $c->getNumeroProblemas($data['id_course']) . "</td>  
    <td>" . $c->getOneField($c->getInfoCurso($data['id_course']), 'creation_date') . "</td>     
    <td><a href='curso.php?option=editarCurso&idCurso=" . $data['id_course'] . "' class='btn btn-info'>Editar</a></td>
    <td><a href='curso.php?option=eliminarCursoCreado&idCurso=" . $data['id_course'] . "' class='btn btn-danger'>Eliminar</a></td></tr>";
                    }
                    ?>

                </tbody>   


            </table>    
        </div>
    </div>
</div>