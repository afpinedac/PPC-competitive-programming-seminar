<div class="container">
    <div class="row-fluid">
        <div class="span10" >
            <h3>Cursos inscritos</h3>
        </div>
    </div>   
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-bordered table-hover">
                <thead>
                <td> Nombre</td>
                <td>Profesor</td>   
                <td> Ejercicios Resueltos</td>
                <td> Porcentaje</td>
                <td> Posición</td>
                <td>Inscrito desde</td>
                <td>Ingresar</td>
                <td>Eliminar de mis cursos</td>
                </thead>    
                <tbody>

                    <?php
                    
                    $pos=getPosition();
                    $c = new conector_mysql();
                    //var_dump($cursos);
                    while ($data = mysql_fetch_array($cursos)) {
                        $result = $c->getInfoCurso($data['id_course']);
                        $participant = $c->getInfoParticipant($data['id_course'], $current_user);
                        $profesor = $c->getInfoUser($c->getOneField($result, 'id_user'));
                        $done = $c->getProblemsSolvedCourse($current_user, $data['id_course']);
                        $total = $c->getNumeroProblemas($data['id_course']);

                        echo "<td>" . $c->getOneField($result, 'name') . "</td>
    <td>" . $c->getOneField($profesor, 'name') . " " . $c->getOneField($profesor, 'lastName') . "</td>  
    <td>" . $done . "/" . $total . " </td>
          <td> " . floor(($done / $total) * 100) . "% </td>
                <td> $pos </td>
      <td>" . $c->getOneField($participant, 'inscription_date') . "</td>
    <td><a href='curso.php?option=entrar&idCourse=" . $data['id_course'] . "' class='btn btn-success'>Entrar</a></td>
    <td><a href='curso.php?option=eliminar&idCurso=" . $data['id_course'] . "' class='btn btn-danger'>Eliminar</a></td>";
                    }
                    ?>

                </tbody>   


            </table>    
        </div>
    </div>
</div>

<?php
    function getPosition(){
        global $username,$c,$current_course;
        $pos=1;
        $lista=$c->getRankingCurso($current_course);
        while($data=  mysql_fetch_array($lista)){
            if($data[0]==$username){
                return $pos;
            }
            $pos++;
        }
    }

?>