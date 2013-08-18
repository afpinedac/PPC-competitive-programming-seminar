<div class="row-fluid">
    <div class="span12">


        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Nombre:</span><span class=''> <?php echo " {$_data['user']['nombre']} {$_data['user']['apellido']}" ?></span></p>

        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Usuario:</span><span class=''> <?php echo " {$_data['user']['username']}" ?></span></p>



        <p class='text-big'><i class='icon icon-ok-circle'></i> Ejercicios resueltos</p>


        <table class="table table-striped table-bordered">
            <thead>
            <th>Tema</th>
            <th># de ejercicios resueltos</th>
            <th>Mínimo</th>
            </thead>
            <tbody>
                <?php
                while ($data = mysql_fetch_array($_data['user']['topics'])) {
                    $solved = $c->getNumberOfProblemsSolved($idUser, $idCurso, $data['id_topic']);
                    $total = $c->getNumberOfProblems($idCurso, $data['id_topic']);
                    $minimum = $c->getOneField($c->getInfoTopic($data['id_topic'], $idCurso), 'minimum_solved');
                    $class = "";
                    if ($solved >= $minimum) {
                        $class = 'info';
                    }
                    if ($solved == $total) {
                        $class = 'success';
                    }
                    ?>
                    <tr class="<?php echo $class ?>">
                        <td><?php echo $data['name'] ?></td>
                        <td><?php echo $solved . "/" . $total ?></td>
                        <td><?php echo $minimum ?></td>
                    </tr>
                    <?php
                }
                ?>



            </tbody>    
        </table>   

        <p class='text-big'><i class='icon icon-ok-circle'></i>Envios</p>

        <table class="table table-striped table-bordered">
            <thead>
            <th>Ejercicio</th>
<!--            <th>Tema</th>-->
            <th>Fecha</th>
            <th>Resultado</th>
            </thead>
            <tbody>

                <?php foreach ($_data['user']['subs'] as $value) {
                    ?>
                    <tr class='<?php if ($value['resultado'] == 'Accepted') echo "success" ?>'>
                        <td><?php echo $value['problem'] ?></td>
                       <!-- <td><?php echo $value['topic'] ?></td>-->
                        <td><?php echo $value['fecha'] ?></td>                     

                        <td><?php echo $value['resultado'] ?></td>
                    </tr>

                <?php } ?>
            </tbody>    
        </table>    



    </div>
</div>


<style>

    .text-big{
        font-size: 20px;
    }
</style>


<script>
     USER = '<?php echo $idUser ?>'
    $(document).ready(function(){
        
         
         $("#usuario-" + USER).addClass('active');
    
});
   

    
</script>