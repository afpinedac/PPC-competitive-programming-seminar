
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h3>Tabla de posiciones</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr id="header_ranking" class="success">
                        <td><h5>Posición</h5></td>  
                        <td><h5>Username</h5></td>           
                        <td><h5>Ejercicios Resueltos</h5></td> 
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
            <td>" . ($pos++) . "</td>                
            <td>" . $rw[0] . "</td>           
            <td>" . $rw[1] . "</td>  
                 
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
        background: #85ADFF;
        font-size: 30px;
    }
    
</style>    