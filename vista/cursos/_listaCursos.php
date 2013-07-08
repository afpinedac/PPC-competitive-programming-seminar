<div class="container">
    <div class="row-fluid">
        <div class="span10" >
            <h3>Cursos inscritos</h3>
        </div>
    </div>   
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-bordered table-hover">
                <thead style="background-color: #e5e5e5">
                <th> Nombre</th>
                <th>Profesor</th>   
                <th> Ejercicios Resueltos</th>
                <th> Porcentaje</th>
                <th> Posición</th>
                <th>Inscrito desde</th>
                <th>Ingresar</th>
                <th>Eliminar</th>
                </thead>    
                <tbody>

                    <?php
                    $pos = getPosition();
                    $c = new conector_mysql();
                    //var_dump($cursos);
                    while ($data = mysql_fetch_array($cursos)) {
                        $result = $c->getInfoCurso($data['id_course']);
                        $participant = $c->getInfoParticipant($data['id_course'], $current_user);
                        $profesor = $c->getInfoUser($c->getOneField($result, 'id_user'));
                        $done = $c->getProblemsSolvedCourse($current_user, $data['id_course']);
                        $total = $c->getNumeroProblemas($data['id_course']);
                        ?>
                        <tr>
                            <td><center><em><?php echo $c->getOneField($result, 'name') ?></em></center></td>
                    <td><center><?php echo $c->getOneField($profesor, 'name') . " " . $c->getOneField($profesor, 'lastName') ?></center></td>  
                    <td><center>
                        <?php echo $done . "/" . $total ?></center></td>
                    <td> <div class="progress progress-striped active">
                            <div class="bar" style='width: <?php echo $total == 0 ? "0" : floor(($done / $total) * 100) ?>%'></div>
                        </div> </td>
                    <td><center><span class='badge badge-info'><?php echo $pos ?></span></center></td>
                    <td><?php echo $c->getOneField($participant, 'inscription_date') ?></td>
                    <td><center></i><a href='curso.php?option=entrar&idCourse=<?php echo $data['id_course'] ?>' class='btn btn-success btn-small'><i class='icon-hand-right icon-white'></i> Entrar</a></center></td>
                    <td><center><a href='curso.php?option=eliminar&idCurso=<?php echo $data['id_course'] ?>' class='btn btn-danger btn-small'><i class='icon-remove icon-white'></i> Eliminar</a></center></td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>   


            </table>    
        </div>
    </div>
</div>

<?php

function getPosition() {
    global $username, $c, $current_course;
    $pos = 1;
    $lista = $c->getRankingCurso($current_course);
    while ($data = mysql_fetch_array($lista)) {
        if ($data[0] == $username) {
            return $pos;
        }
        $pos++;
    }
}
?>