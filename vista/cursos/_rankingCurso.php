
<div class="container">
    <div class="row-fluid">

        <div class="row-fluid">
            <div class="span12">

                <div class="span8">
                    <h4 style="font-family: 'Press Start 2P', cursive; margin-top: 60px;" class='pull-left'>Ranking</h4>
                </div>

                <?php
                // var_dump($programador);
                if ($programador) {
                    ?>
                    <div class="span4">


                        <div class="row-fluid">
                            <div class="">


                                <div class="row-fluid">
                                    <div class="span12">
                                        <p style='margin-bottom: -2px; font-size: 16px;' class='lead pull-right'><em><strong><i class='icon icon-trophy'></i> Programmer's week</strong></em></p>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span6">
                                            <span class='pull-right'> <img id='programador-de-la-semana' src='./public/img/avatars/<?php echo $programador['foto'] ?>.png'></span>
                                        </div>
                                        <div class="span6">
                                            <p ><?php echo $programador['username'] ?></p>
                                            <p>(<?php echo $programador['total'] ?>) ejercicios</p>
                                        </div>
                                    </div>
                                </div>


                            </div>   

                        </div>

                        <span class='pull-right'>




                    </div>

                <?php } ?>

            </div>
        </div>



        <div class="row-fluid">


            <div class="span12">

                <table class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr id="header_ranking" class="success" >
                            <th><center><h5>Position</h5></center></th>  
                    <th><center><h5>Avatar</h5></center></th>  
                    <th><center><h5>User</h5></center></th>           
                    <th><center><h5>Solved Problems</h5></center></th> 
                    <th><center><h5>In the last week</h5></center></th> 
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
                            <tr class='ranking <?php if ($current_user == $rw['id_user']) echo 'success' ?>'>
                                <td width='10%'><h3><center><?php echo ($pos++) ?></center></h3></td>                
                                <td width='10%'><center><img class="fotoavatar-ranking" src='./public/img/avatars/<?php echo $rw['foto'] ?>.png'></center></td>                
                        <td width='45%'><center><h5 style="font-family: 'Press Start 2P', cursive;"><?php echo $rw[1] ?></h5></center></td>           
                        <td><center><h3><?php echo $rw['c'] ?></center></h3></td>  
                        <td><center><h3><?php echo $c->get_number_of_solved_in_days($rw[1], $current_course, 7) ?></center></h3></td>  

                        <?php
                    }
                    ?>

                    </tbody>   
                </table>    
            </div>
        </div>
    </div>
</div>

<style>
    #header_ranking{
        background: #e5e5e5;
        font-size: 30px;
    }

</style>    