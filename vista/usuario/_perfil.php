<div class="row-fluid">
    <div class="span12">


        <div class="row-fluid">
            <div class="span12">
                <div class="span1">
                    <img src='./public/img/avatars/<?php echo $_data['user']['foto'] ?>.png'>
                </div>
                <div class="span11">
                    <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Name:</span><span class=''> <?php echo " {$_data['user']['nombre']} {$_data['user']['apellido']}" ?></span></p>

                    <p><i class='icon icon-ok-circle'></i> <span class='text-big'>User:</span><span class=''> <?php echo " {$_data['user']['username']}" ?></span></p>

                </div>
            </div>
        </div>




        <p class='text-big'><i class='icon icon-ok-circle'></i> Solved problems</p>


        <table class="table table-striped table-bordered">
            <thead>
            <th>Topic</th>
            <th># of solved problems</th>
            <th>Minimum</th>
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

        <?php
         if(isset($option) && $option=="administrar"){
        ?>        
        <p class='text-big'><i class='icon icon-ok-circle'></i>Submissions</p>

        <table class="table table-striped table-bordered">
            <thead>
            <th>Problem</th>
<!--            <th>Tema</th>-->
            <th>Date</th>
            <th>Result</th>
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

            <?php }  ?>

    </div>
</div>


<style>

    .text-big{
        font-size: 20px;
    }
</style>


<script>
    USER = '<?php echo $idUser ?>'
    $(document).ready(function() {


        $("#usuario-" + USER).addClass('active');

    });



</script>