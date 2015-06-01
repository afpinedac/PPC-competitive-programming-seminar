<!--Grafo para el creador de un curso-->

<div class="container">
    <div class="row-fluid">
        <div  id="graph" class="span20">


        </div>
    </div>
    <div>   




        <script>
            var endpoint = {
                endpoint: "Dot",
                isSource: true,
                maxConnections: 10,
                isTarget: true
                        //dropOptions:{ tolerance:"touch" , hoverClass:"dropHover" }
            };

            var parent = [];
            var child = [];


            //JSPLUMB   
            jsPlumb.bind("ready", function() {
              //  console.log('estoy listo JSPLUMB');
                jsPlumb.setRenderMode(jsPlumb.SVG);
                jsPlumb.bind("click", function(w) {
                    if (confirm("Desea eliminar la conexion?")) {
                        //eliminamos en la base de datos
                        result = $.ajax({
                            url: "jx_topic.php?option=deleteConnection&parent=" + getIdTopic(w.sourceId) + "&child=" + getIdTopic(w.targetId),
                            async: false
                        }).responseText;
                        // console.log(result);
                        if (result == "ok") {
                            jsPlumb.detach(w);
                        } else {
                            alert("A problem has ocurred, please contact to the administrator: andr3s2@gmail.com");
                        }
                    }
                });
                jsPlumb.Defaults.Anchors = ["TopCenter", "TopCenter"];

                jsPlumb.Defaults.DragOptions = {cursor: 'wait', zIndex: 20};
                jsPlumb.Defaults.Connector = ["Straight"];
                jsPlumb.Defaults.Overlays = ["Arrow"]
                jsPlumb.Defaults.Endpoints = [["Dot", 1], ["Dot", 2]]
                jsPlumb.Defaults.PaintStyle = {
                    lineWidth: 5,
                    strokeStyle: 'rgba(200,0,0,100)'
                };


                loadConnections();
            });


            function loadConnections() {
                for (i = 0; i < parent.length; i++) {
                    conectar(crearIdTopic(parent[i]), crearIdTopic(child[i]));
                }
            }

            function setEdge(div1, div2) {
                //  console.log("--" + div1);
                //insertemos en la base de datos
                if (isValidConnection(div1, div2)) {
                    conectar(div1, div2);

                } else {
                    alert("Invalid link");
                }
            }

            function conectar(div1, div2) {
                //  console.log(endpoint);
                // console.log(div1 + " --- " + div2);
                var e1 = jsPlumb.addEndpoint(div1, endpoint);
                // console.log("termino1");
                var e2 = jsPlumb.addEndpoint(div2, endpoint);
                //  console.log("termino2");
                jsPlumb.connect({source: e1, target: e2, paintStyle: {strokeStyle: "gray", lineWidth: 2}, overlays: [
                        ["Arrow", {foldback: 0.9}]
                    ]});
                // console.log("termino3");
            }


            function isValidConnection(div1, div2) {
                var result = $.ajax({
                    url: "jx_topic.php?option=connect&parent=" + getIdTopic(div1) + "&child=" + getIdTopic(div2),
                    async: false
                }).responseText;

                if (result == "ok")
                    return true;
                return false;
            }




            //VARIALBES GLOBALES
            var selectedDiv = null;
            var onDiv = false;
            var editing = null;
            var source = null;
            var target = null;

            //FUNCIONES DEL GRAFO
            //funcion que se encarga de crear un nuevo topic
            function crearTopic(id, x, y) {
                //      alert("id: "+  id + " x: " + x + " y: " + y);
                // console.log(x + " " + y);
                var x = Math.round(x);
                var y = Math.round(y);
                //console.log(x + " " + y);
                //alert();
                var div = $(crearDivTopic(id));
                div.css({"top": y, "left": x});
                $("#graph").append(div);


                //FUNCIONES
                div.click(function() {
                    $("div").removeClass("selected");
                    $(this).addClass("selected");
                    $("#save").addClass("unsave");
                    selectedDiv = $(this).attr('id');
                });

                div.dblclick(function(e) {
                    //  e.preventDefault();                  
                    onDiv = true;
                    editing = getIdTopic($(this).attr('id'));
                    loadInfoTopicModal(getInfoTopic(editing, 1));

                    $('#myModal').modal()
                });

                //click derecho
                div.bind('contextmenu', function(e) {
                    return false;
                }).mousedown(function(e) {
                    if (e.button == 2) {
                        source = $(this).attr('id');
                        //  console.log("abajo: " + $(this).attr('id'));
                    }
                });

                div.mouseup(function(e) {
                    if (e.button == 2) {
                        target = $(this).attr('id');
                        //  console.log("arriba: " + $(this).attr('id'));
                        if (source != null & target != null && source != target) {
                            setEdge(source, target);
                        }
                        source = target = null;
                    }
                });





                jsPlumb.draggable(crearIdTopic(id));
                //jsPlumb.draggable(div2);

                //  div.draggable({handle:'div.topicName'});
            }


            function getInfoTopic(id, tipo) {
                //we load the info of the selected div 
                var info_topic = null;
                if (tipo == 1) {
                    $.ajax({
                        dataType: 'json',
                        url: 'jx_topic.php?option=getNameMinimum&idTopic=' + id,
                        async: false,
                        success: function(data) {
                            info_topic = data;
                        }
                    });
                    // window.console.log(info_topic);
                    return info_topic;
                } else if (tipo == 2) {
                    var result = $.ajax({
                        url: 'jx_topic.php?option=getListProblems&idTopic=' + id,
                        async: false
                    }).responseText;
                    return result;
                }
            }

            function setInfoTopic(id) {
                var result = getInfoTopic(id, 1);
                //var value = result.split(",");
                //  window.console.log(result);
                $("#" + crearIdTopic(id) + " .topicName").html(result.name + " (" + result.number_of_problems + "/" + result.minimum_solved + ")");
            }


            function loadInfoTopicModal(result) {
                //  window.console.log(result);
                //ponemos los valores en las cajas de texto del Modal Topic
                // var value = result.split(",");
                $("#name").attr('value', result.name);
                $("#ejercicio").attr('value', result.minimum_solved);
                $("#listaEjercicios").append(getInfoTopic(editing, 2));

                //  $("#"+crearIdTopic(editing) + " .topicName").html(value[0]);
            }




            function crearIdTopic(id) {
                return "d" + id;
            }
            function crearIdListaTopic(id) {
                return "l" + id;
            }


            function getIdTopic(div) {
                return div.substring(1);
            }


            function crearDivTopic(id) {
                var div = "<div id='" + crearIdTopic(id) + "' class='topic'>"
                        + "<div class='topicName' >"
                        + "</div>"
                        + "<div class='problems'>"
                        + "<div id='" + crearIdListaTopic(id) + "'>"
                        + "</div>"
                        + "</div>"
                        + "</div>";
                return div;
            }

            $(document).ready(function() {
             //   console.log("console.log('estoy listo Jquery');");
                $(document).dblclick(function(e) {
                    if (e.pageY > $("#navbar1").height()) {
                       // console.log("estoy en dblclick");
                        if (!onDiv) {
                            var result = $.ajax({
                                url: "jx_graph.php?option=generateIdTopic&posx=" + e.pageX + "&posy=" + e.pageY,
                                async: false
                            }).responseText
                            //     alert("id: " + result + " x: " + e.pageX + " y: " + e.pageY);
                            crearTopic(result, e.pageX, e.pageY);
                        } else
                            onDiv = false;
                    }
                });

                $(document).keydown(function(e) { //cuando espicha supr
                    if (e.which == 46) {
                        //   alert("suor");
                        if (selectedDiv != null && confirm("¿Esta seguro que desea eliminar el tema?")) {
                            idTopic = getIdTopic($("#" + selectedDiv).attr("id"));
                            $("#" + selectedDiv).remove();
                            selectedDiv = null;
                            $.ajax({
                                url: 'jx_graph.php?option=delete&id=' + idTopic,
                                async: false
                            });
                            save(0);
                            location.href = "graph.php";
                        }
                    }
                });


            });

            //agregar nuevo problema al div
            function addProblemDiv(id, problem) {
                var l = "* " + problem + "<br/>";
                $("#l" + id).append(l);

            }

            //funcion que guarda el estado de la matriz
            function save(modo) {
                $(".topic").each(function(e) {
                    var x = (parseInt($(this).css("left")));
                    var y = (parseInt($(this).css("top")));
                    var div = $(this).attr("id");
                    var result = $.ajax({
                        url: "jx_graph.php?option=editPosition&x=" + x + "&y=" + y + "&idTopic=" + getIdTopic(div),
                        async: false
                    }).responseText;
                    //   alert(result);                    
                });
                if (modo == 1)
                    alert("Information saved correctly");
                $("#save").removeClass("unsave");
                $("div").removeClass("selected");
                selectedDiv = null;
                onDiv = false;
            }

        </script>   



        <style>

            ._jsPlumb_overlay { z-index:51; }
            ._jsPlumb_endpoint { z-index:50; cursor:move; }
            ._jsPlumb_connector { z-index:0;  }

            .topicName{
                min-width: 100px;
                height: 20px;
                border: 1px solid black;  
            }

            .problems{
                min-width: 100px;               
                height: 100px;
                border: 1px solid black; 
                overflow: auto ;
                font-size: 10px;
                line-height: 10px;
            }

            .topic{
                position: absolute;
                height: auto;
                min-height: 90px;
                min-width: 100px;
                border: 1px solid black; 
                box-shadow: 2px 2px 19px #aaa;
                -o-box-shadow: 2px 2px 19px #aaa;
                -webkit-box-shadow: 2px 2px 19px #aaa;
                -moz-box-shadow: 2px 2px 19px #aaa;
                -moz-border-radius:0.5em;
                border-radius:0.5em;
                opacity:0.8;
                filter:alpha(opacity=80);
                z-index:5;                
                font-family:helvetica;
                z-index: 1;

            }

            .topic:hover{
                box-shadow: 2px 2px 19px #444;
                -o-box-shadow: 2px 2px 19px #444;
                -webkit-box-shadow: 2px 2px 19px #444;
                -moz-box-shadow: 2px 2px 19px #444;
                opacity:0.6;
                filter:alpha(opacity=60);
            }

            .selected{
                background-color: #D5FFC1;                
            }

            .unsave{
                background-color: #FFDED6;
            }

        </style>    




        <?php
        #cargamos todos los topics
        // $c = new conector_mysql();
        // sleep(3);
        while ($rw = mysqli_fetch_array($topics)) {
            $position = $c->getInfoPosition($rw['id_topic'], $current_course);

            $idTopic = $c->getOneField($position, 'id_topic');
            $x = $c->getOneField($position, 'x');
            $y = $c->getOneField($position, 'y');
            echo "<script>
                        crearTopic($idTopic,$x,$y);                                               
                        setInfoTopic($idTopic);
                         </script>";
            $problema = $c->getAllProblemas($current_course, $idTopic);
            while ($r = mysqli_fetch_array($problema)) {
                $val = $r['name'];
                echo "<script>
                    addProblemDiv($idTopic,'$val');
                    </script>";
            }
        }

//cargamos las conexiones 
        while ($data = mysqli_fetch_array($connections)) {
            echo "<script>
                parent.push(" . $data['parent'] . ");
                child.push(" . $data['child'] . ");
               </script>";
        }
        ?>
            






