<div class="row-fluid">
    <div class="span12">


        <div class="span10 offset1">

            <div class="row-fluid">
                <div class="span12">

                    <div class="span3">


                        <ul class="nav nav-list">
                            <li class="nav-header">Curso</li>
                            <li id='info-general' class=""><a href="curso.php?option=administrar&idCurso=<?php echo $idCurso ?>">Información general</a></li>

                            <li class="nav-header">Estudiantes</li>

                            <?php while ($data = mysql_fetch_array($users)) { ?>
                                <li id='usuario-<?php echo $data['id_user'] ?>'><a class='suspensive-points'  href="curso.php?option=administrar&idCurso=<?php echo "{$data['id_course']}&idUser={$data['id_user']}" ?>"><i class='icon icon-chevron-right'></i><?php echo " ({$data['username']}) {$data['name']} {$data['lastName']}" ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>


                    </div>
                    <div class="span9">


                        <?php
                        if (isset($_data['user'])) {
                            require './vista/usuario/_perfil.php';
                        } else {
                            ?>

                            <script>
                                $(document).ready(function() {
                                    $("#info-general").addClass('active');

                                });
                            </script>

                            <?php
                            require './vista/cursos/_informacionCurso.php';
                        }
                        ?>




                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<style>
    .suspensive-points{
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 11px;
    }

</style>