<div class="container">


    <div class="row-fluid">
        <div class="span12">
            <div class="span2">
              
                <a href='avatar.php'><img id="fotoavatar" src='./public/img/avatars/<?php echo $data['user']['foto'] ?>.png'></a>
                  <center><h6><em>(<?php echo $data['user']['username'] ?>)</em></h6></center>
                <center><h6 style='margin-top: -10px'><i class='icon icon-caret-right'></i> <?php echo $data['user']['full_name'] ?></h6></center>
                <center><h6 style='margin-top: -10px;'><i class='icon icon-caret-right'></i> <?php echo $data['user']['university'] ?></h6></center>

            </div>
            <div class="span10">



                <div class="row-fluid">
                    <div class="span10" >
                        <h4 style="font-family: 'Press Start 2P', cursive;">Enrolled courses</h4>
                    </div>
                </div>   
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead style="background-color: #e5e5e5">
                            <th valign='middle'><center>Name</center></th>
                            <th>Teacher</th>   
                            <th> Solved problems</th>
                            <th> Percentage</th>
                            <th> Position</th>
                            <th>Register since</th>
                            <th>Enter</th>
                            <th>Delete</th>
                            </thead>    
                            <tbody>

                                <?php
                                $c = new conector_mysql();

                                //var_dump($cursos);
                                $current_course = null;
                                while ($data = mysql_fetch_array($cursos)) {
                                    // var_dump($data);
                                    // $current_course = $data['id_course'];
                                    $result = $c->getInfoCurso($data['id_course']);
                                    $participant = $c->getInfoParticipant($data['id_course'], $current_user);
                                    $profesor = $c->getInfoUser($c->getOneField($result, 'id_user'));
                                    $done = $c->getProblemsSolvedCourse($current_user, $data['id_course']);
                                    $total = $c->getNumeroProblemas($data['id_course']);
                                    $pos = getPosition($data['id_course']);
                                    ?>
                                    <tr>
                                        <td><center><em><?php echo $c->getOneField($result, 'name') ?></em></center></td>
                                <td><center><?php echo $c->getOneField($profesor, 'name') . " " . $c->getOneField($profesor, 'lastName') ?></center></td>  
                                <td valign='middle'><center>
                                    <?php echo $done . "/" . $total ?></center></td>
                                <td> <div class="progress progress-striped active">
                                        <div class="bar" style='width: <?php echo $total == 0 ? "0" : floor(($done / $total) * 100) ?>%'></div>
                                    </div> </td>
                                <td><center><span class='badge badge-info'><?php echo $pos ?></span></center></td>
                                <td><small style="font-size:10px"><center><?php echo date("d-m-Y", strtotime($c->getOneField($participant, 'inscription_date'))) ?></center></small></td>
                                <td><center></i><a href='curso.php?option=entrar&idCourse=<?php echo $data['id_course'] ?>' class='btn btn-success btn-small'><i class='icon-hand-right icon-white'></i> Enter</a></center></td>
                                <td><center><a onclick="return confirm('¿Está seguro de eliminar este curso?')" href='curso.php?option=eliminar&idCurso=<?php echo $data['id_course'] ?>' class='btn btn-danger btn-small'><i class='icon-remove icon-white'></i> Delete</a></center></td>
                                </tr>
                                <?php
                            }
                            ?>

                            </tbody>   


                        </table>    
                    </div>
                </div>



            </div>

        </div>
    </div>



</div>





<?php

function getPosition($course) {
    global $username, $c;
    $pos = 0;
    $lista = $c->getRankingCurso($course);
    //var_dump($course);
    while ($data = mysql_fetch_array($lista)) {

        if ($data['username'] == $username) {
            return++$pos;
        }
        $pos++;
    }
    return $pos;
}
?>