
<div class="container">
    <div class="row-fluid">
        <div  class="span12">
            <button id="subirRecurso" class="btn btn-success" data-modo="close"><i class='icon icon-cloud-upload'></i> Upload resource</button>
            <br><br>
            <div id="fsubir" class="span12 hide">                
                <form class="form-inline" action="modulo.php?option=crearRecurso" method="post" >
                    <input type="text" class="input-large" name="description" placeholder="Descripción" required>
                    <input type="text" class="input-large" name="url" placeholder="URL" required>
                    <button type="submit" class="btn btn-info"><i class='icon icon-upload'></i> Upload</button>
                </form>
            </div>   
        </div> 


        <div class="span12">
            <h3>Recursos</h3>

            <?php if ($n_recursos > 0) { ?>

                <table class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr style='background-color: #e5e5e5' id="header_ranking" class="success">
                            <th><center><h5>Resource</h5></center></th> 
                    <th><center><h5>User who has uploaded it</h5></center></th>                                
                    <th><center><h5>Delete</h5></center></th>                                
                    </tr>    
                    </thead>
                    <tbody>

                        <?php while ($rw = mysql_fetch_array($result)) { ?>
                            <tr>                                
                                <td width='40%'> <a href='<?php echo $rw['url']; ?>' target='_blank'> <?php echo $rw['description']; ?> </a></td>         
                                <td><center><?php echo $rw['username'] ?></center></td>                
                        <td>
                            <?php if ($current_user == $rw['id_user']) { ?>
                                <form method="post" action="modulo.php?option=eliminarRecurso">
                                    <center><button class='btn btn-danger'><i class='icon icon-remove icon-white'></i> Delete</button> </center>  
                                    <input type="hidden" name="id_resource" value='<?php echo $rw['id_resource'] ?>'>
                                </form>
                                <?php
                            } else {
                                ?>
                        <center><button class='btn'><i class='icon icon-lock'></i></button></center>
                            <?php
                        }
                    }
                    ?>
                    </td> 
                    </tbody>   
                </table>   
            <?php } else {
                ?>

                <div class="alert alert-error">
                    <p><center>THIS COURSE HAS NOT COURSES</center></p>
                </div>


            <?php } ?>





        </div>
    </div>
</div>

<style>
    #header_ranking{
        background: #85ADFF;
        font-size: 20px;
    }

</style>    


<script>
    $("#subirRecurso").click(function() {
        modo = $(this).data("modo");
        if (modo == "close") {
            $("#fsubir").show("normal");
            $(this).data("modo", "open");
        } else {
            $("#fsubir").hide("normal");
            $(this).data("modo", "close");
        }

    });



</script>
