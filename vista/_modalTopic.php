

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
        <div class="row-fluid">
            <div class="span4">
                <br/>
                <input type="text" id="name"  style="background-color: transparent; border-width: 0px; font-size: 30px ; height: 40px; font-family: arial" />
            </div>
            <div class="span4 offset4">
                <span id="myModalLabel">Desbloquear con</span>
                <input type="text" id="ejercicio" class="input-small" name="idProblema" placeholder="ejercicios" /> 
            </div>   

        </div> 

        <div class="hide">
            hola  
        </div>         
    </div>
    <div class="modal-body">
        <h5 id="myModalLabel">Agregar ejercicio</h5>
        <center><input type="text" name="idProblema" id="idProblema" class="input-large" placeholder="Ingrese el número del problema"/>  <button class="btn btn-primary" onClick="addProblem();">Añadir</button></center>
        <hr>

        <div class="row-fluid">  
            <div class="span4">
                <select id="listaEjercicios" multiple="multiple" size="8">
                </select>
                <div><button class="btn btn-danger">Eliminar</button></div>
            </div>

            <div class="span7 offset1 alert alert-info">
                <p>Información</p>
                <p><strong>Número de Ejercicios: </strong><?php echo (isset($data)) ? $data['nejercicios'] : "-" ?></p>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-success"  aria-hidden="true" onClick="validar();">LISTO</button>

    </div>
</div>


<script>
    
    //funcion que valida toda la informacion escrita
    function validar(){
        alert("validando...");
        var ej= $("#ejercicio").val();
        var nm= $("#name").val();       
        if(nm==""){
            alert("Falta el nombre del tema");
            $("#name").focus();
            return;
        }
        if(ej==""){
            alert("Falta el numero de ejercicios para desbloquear");
            $("#ejercicio").focus();
            return;
        }
        //verificamos que el numero minimo es menor al numero de ejercicios del topic
        
        var result=$.ajax({
            url:"jx_topic.php?option=getNumberOfProblems&idTopic="+editing,
            async:false
        }        
    ).responseText 
       // alert(result+"  " +  ej);
        result=parseInt(result);
        if(result<ej){
            alert("pasa");
            alert("El número de ejercicios para desbloquear debe ser menor o igual a " + result);
            return;
        }      
        
        
        
        
        
        //llamamos a ajax para actualizar
        var result=$.ajax({
            url:"jx_graph.php?option=updateInfo&name="+nm+"&minimum="+ej+"&idTopic="+editing,
            async:false
        }        
    ).responseText  
        //actualizamos el minimum
        setInfoTopic(editing);  
        
        //ponemos la lista en la lista del div
        var div= $("#l"+editing);
        div.html("");
        $("#listaEjercicios option").each(function(e){
            addProblemDiv(editing,$(this).html());
        });
                
        
        
        //limpiamos los datos
        $("#listaEjercicios").html("");
        $("#ejercicio").html("");
        $("#name").html();      
        
        $('#myModal').modal('hide');
       
          
        
        //ponemos los datos del select en la lista del div
       
        
    }
    

    function addProblem(){          
        var value=$("#idProblema").val();
        if(value==""){
            alert('Debe ingresar un numero');
            $("#idProblema").focus();
        }else{ //obtenemos el nombre del problema
            var name=$.ajax({
                url:"jx_problem.php?option=getTitle&idProblema="+value,
                async:false
            }).responseText;           
           
            if(name=='error'){ //si no existe el problema
                alert('El problema no existe');
                $("#idProblema").val("");
            }else{ // si existe la agrego a la tabla
                
                $("#idProblema").val("");
                //insertamos el valor en la tabla
                var result=$.ajax({
                    url:'jx_problem.php?option=insert&idProblem='+value+'&idTopic='+editing+'&name='+name,
                    async: false
                }).responseText;
               
                if(result=="ya existe"){ // si ya existe el problema
                    alert("El problema '" + name + "' ya se encuentra en el tema");
                }else{                   
                    $("#listaEjercicios").append('<option value='+value+'>'+name+'</option>'); 
                    alert('Se agregó: << ' + name + ' >>');
                }             
               
            }
        }
    }
        
    
    

</script>