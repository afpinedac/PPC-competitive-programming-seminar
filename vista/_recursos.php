
<div class="container">
    <div class="row-fluid">
        <div  class="span12">
            <button id="subirRecurso" class="btn btn-success" data-modo="close">Subir recurso</button>
            <br><br>
            <div id="fsubir" class="span12 hide">                
                <form class="form-inline" action="modulo.php?option=crearRecurso" method="post" >
                    <input type="text" class="input-large" name="description" placeholder="Descripción" required>
                    <input type="text" class="input-large" name="url" placeholder="URL" required>
                    <button type="submit" class="btn">Subir</button>
                </form>
            </div>   
        </div> 


        <div class="span12">
            <h3>Recursos</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr id="header_ranking" class="success">
                        <td><h5>Código</h5></td> 
                        <td><h5>Descripción</h5></td>                                
                    </tr>    
                </thead>
                <tbody>

                    <?php
                    
                    while ($rw = mysql_fetch_array($result)) {
                        echo "<tr>
            <td>" . $rw['id_resource'] . "</td>                
            <td> <a href='{$rw['url']}' target='_blank'>" . $rw['description'] . "</a></td>                  
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
        font-size: 20px;
    }

</style>    


<script>
    $("#subirRecurso").click(function(){
        modo=$(this).data("modo");
        if(modo=="close"){
            $("#fsubir").show("normal");
            $(this).data("modo","open");
        }else{
            $("#fsubir").hide("normal");
            $(this).data("modo","close");
        }       
        
    });
        
    

</script>
