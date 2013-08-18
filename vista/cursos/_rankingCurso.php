
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h3>Tabla de posiciones</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr id="header_ranking" class="success">
                        <th><center><h5>Posición</h5></center></th>  
                <th><center><h5>Usuario</h5></center></th>           
                <th><center><h5>Ejercicios Resueltos</h5></center></th> 
                <!--<td><h5>Porcentaje</h5></td>-->                       
                </tr>    
                </thead>
                <tbody>







                    <?php
                    $pos = 1;
                    while ($rw = mysql_fetch_array($result)) {
                        //    var_dump($rw);
                        $done = $c->getProblemsSolvedCourse($current_user, $data['id_course']);
                        $total = $c->getNumeroProblemas($data['id_course']);
                        ?>
                        <tr class='<?php if ($current_user == $rw['id_user']) echo 'success' ?>'>
                            <td width='10%'><center><?php echo ($pos++) ?></center></td>                
                    <td width='45%'><center><?php echo $rw[1] ?></center></td>           
                    <td><center><?php echo $rw['c'] ?></center></td>  

                    <?php
                }
                ?>

                </tbody>   
            </table>    
        </div>
    </div>
</div>

<style>
    #header_ranking{
        background: #e5e5e5;
        font-size: 30px;
    }

</style>    