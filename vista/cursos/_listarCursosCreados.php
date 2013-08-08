<div class="container">
    <div class="row-fluid">
        <div class="span10" >
            <h3>Cursos Creados</h3>
        </div>
    </div>   
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-bordered table-hover">
                <thead style="background-color: #e5e5e5">
                <th> Nombre</th>
                <th> Código</th>
                <th># de estudiantes</th>
                <th># de Temas</th>   
                <th># de problemas</th>   
                <th>Fecha de creación</th>              
                <th>Editar</td>
                <th>Eliminar</td>
                    </thead>    
                <tbody>

                    <?php
                    $c = new conector_mysql();
                    //var_dump($cursos);
                    while ($data = mysql_fetch_array($cursos)) {
                        $result = $c->getInfoCurso($data['id_course']);
                        $participant = $c->getInfoParticipant($data['id_course'], $current_user);
                        $profesor = $c->getInfoUser($c->getOneField($result, 'id_user'));
                        ?>
                        <tr>
                            <td><center><em><?php echo $c->getOneField($result, 'name') ?></em></center></td>
                            <td><center><em><?php echo $c->getOneField($result, 'registration_code') ?></em></center></td>
                            <td><center><?php echo $c->getNumeroEstudiantes($data['id_course']) ?></center></td>  
                            <td><center><?php echo $c->getNumeroTemas($data['id_course']) ?></center></td>  
                            <td><center><?php echo $c->getNumeroProblemas($data['id_course']) ?></center></td>  
                            <td><center><?php echo $c->getOneField($c->getInfoCurso($data['id_course']), 'creation_date') ?></center></td>     
                            <td><center><a href='curso.php?option=editarCurso&idCurso=<?php echo $data['id_course'] ?>' class='btn btn-info btn-small'><i class='icon-edit icon-white'></i> Editar</a></center></td>
            <td><center><a  onclick="return confirm('¿Está seguro de eliminar este curso?')" href='curso.php?option=eliminarCursoCreado&idCurso=<?php echo $data['id_course'] ?>' class='btn btn-danger btn-small'><i class='icon-remove icon-white'></i> Eliminar</a></center></td></tr>

                        <?php
                    }
                    ?>

                </tbody>   


            </table>    
        </div>
    </div>
</div>