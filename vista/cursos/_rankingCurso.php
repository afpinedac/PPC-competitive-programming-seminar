
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
                        $done = $c->getProblemsSolvedCourse($current_user, $data['id_course']);
                        $total = $c->getNumeroProblemas($data['id_course']);


                        echo "<tr>
            <td width='10%'><center>" . ($pos++) . "</center></td>                
            <td width='45%'><center>" . $rw[0] . "</center></td>           
            <td><center>" . $rw[1] . "</center></td>  
                 
            ";
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