

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
        <span id="myModalLabel">Unlock with</span>
        <input type="text" id="ejercicio" class="input-small" name="idProblema" placeholder="ejercicios" /> 
      </div>   

    </div> 


  </div>
  <div class="modal-body">
    <h5 id="myModalLabel">Add problem</h5>
    <center><input type="text" name="idProblema" id="idProblema" class="input-large" placeholder="Add the problem number in UVA JudgeOnline"/>  <button class="btn btn-primary" onClick="addProblem();">Add</button></center>
    <hr>

    <div class="row-fluid">  
      <div class="span4">
        <select id="listaEjercicios" multiple="multiple" size="8">
        </select>
        <div><button class="btn btn-danger" onclick="modal.eliminar_ejercicio()">Delete</button></div>
      </div>

      <div class="span7 offset1 alert alert-info">
        <p>Information</p>
        <p><strong>Number of problems: </strong><?php echo (isset($data['nejercicios'])) ? $data['nejercicios'] : "-" ?></p>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <button class="btn btn-success"  aria-hidden="true" onClick="validar();">Save</button>

  </div>
</div>


<script>


  modal = {
    eliminar_ejercicio: function () {
      ejercicio = $("#listaEjercicios option:selected").attr('id');
      if (ejercicio != undefined) {

        $.ajax({
          dataType: "",
          type: 'post',
          url: "jx_topic.php?option=eliminarEjercicio",
          data: {
            id_problem: ejercicio,
            id_topic: editing
          },
          success: function (data) {
            if (data == 1) {
              $("#listaEjercicios option:selected").remove();
            } else {
              alert('A problem has occured while you were removing the problem');
            }
          }
        });



      }

    }
  }





  //funcion que valida toda la informacion escrita
  function validar() {
    alert("validating...");
    var ej = $("#ejercicio").val();
    var nm = $("#name").val();
    if (nm == "") {
      alert("Topic's name is required");
      $("#name").focus();
      return;
    }
    if (ej == "") {
      alert("Mimimum number of problem is required");
      $("#ejercicio").focus();
      return;
    }
    //verificamos que el numero minimo es menor al numero de ejercicios del topic

    var result = $.ajax({
      url: "jx_topic.php?option=getNumberOfProblems&idTopic=" + editing,
      async: false
    }
    ).responseText
    // alert(result+"  " +  ej);
    result = parseInt(result);
    if (result < ej) {
      // alert("pasa");
      alert("The number of problems for unlock this node must be lower or equal to " + result);
      return;
    }





    //llamamos a ajax para actualizar
    var result = $.ajax({
      url: "jx_graph.php?option=updateInfo&name=" + nm + "&minimum=" + ej + "&idTopic=" + editing,
      async: false
    }
    ).responseText
    //actualizamos el minimum
    setInfoTopic(editing);

    //ponemos la lista en la lista del div
    var div = $("#l" + editing);
    div.html("");
    $("#listaEjercicios option").each(function (e) {
      addProblemDiv(editing, $(this).html());
    });



    //limpiamos los datos
    $("#listaEjercicios").html("");
    $("#ejercicio").html("");
    $("#name").html();

    $('#myModal').modal('hide');



    //ponemos los datos del select en la lista del div


  }


  function addProblem() {
    var value = $("#idProblema").val();
    if (value == "") {
      alert('You must set a number');
      $("#idProblema").focus();
    } else { //obtenemos el nombre del problema
      var name = $.ajax({
        url: "jx_problem.php?option=getTitle&idProblema=" + value,
        async: false
      }).responseText;

      if (name == 'error') { //si no existe el problema
        alert('The problem do not exists');
        $("#idProblema").val("");
      } else { // si existe la agrego a la tabla

        $("#idProblema").val("");
        //insertamos el valor en la tabla
        var result = $.ajax({
          url: 'jx_problem.php?option=insert&idProblem=' + value + '&idTopic=' + editing + '&name=' + name,
          async: false
        }).responseText;

        if (result == "ya existe") { // si ya existe el problema
          alert("The problem '" + name + "' is already in the topic");
        } else {
          $("#listaEjercicios").append('<option value=' + value + '>' + name + '</option>');
          alert('Added: << ' + name + ' >>');
        }

      }
    }
  }




</script>