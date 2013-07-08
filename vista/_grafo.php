

<div class="container">
    <div class="row-fluid">
        <div  id="graph" class="span20">


        </div>
    </div>
    <div>   




        <script>      
            var endpoint = {       
                endpoint:"Dot",            
                isSource:true,
                maxConnections:10,          
                isTarget:true
                //dropOptions:{ tolerance:"touch" , hoverClass:"dropHover" }
            };
            
            var parent=[];
            var child=[];
                
            
            //JSPLUMB   
            jsPlumb.bind("ready",function(){
               // console.log('estoy listo JSPLUMB');
                jsPlumb.setRenderMode(jsPlumb.SVG);
//                jsPlumb.bind("click",function(w){
//                    if(confirm("Desea eliminar la conexion?")){
//                        //eliminamos en la base de datos
//                        result=$.ajax({
//                            url:"jx_topic.php?option=deleteConnection&parent="+getIdTopic(w.sourceId)+"&child="+getIdTopic(w.targetId),
//                            async:false
//                        }).responseText;
//                        console.log(result);
//                        if(result=="ok"){
//                            jsPlumb.detach(w);
//                        }else{
//                            alert("Ha ocurrido un error");
//                        }
//                    }
//                });
                jsPlumb.Defaults.Anchors = ["TopCenter", "TopCenter"];
                
                jsPlumb.Defaults.DragOptions = { cursor: 'wait', zIndex:20 };
                jsPlumb.Defaults.Connector = [ "Straight" ];     
                jsPlumb.Defaults.Overlays =  [ "Arrow"  ] 
                jsPlumb.Defaults.Endpoints = [ [ "Dot", 1 ], [ "Dot", 2 ] ]
                jsPlumb.Defaults.PaintStyle = {
                    lineWidth:5,
                    strokeStyle: 'rgba(200,0,0,100)'
                };
                
                
                loadConnections();
            });
            
            
            function loadConnections(){
                for(i=0;i<parent.length;i++){
                    conectar(crearIdTopic(parent[i]),crearIdTopic(child[i]));
                }
            }
                      
            function setEdge(div1,div2){   
               // console.log("--"  + div1);
                //insertemos en la base de datos
                if(isValidConnection(div1,div2)){
                    conectar(div1,div2);
                    
                }else{
                    alert("La conexíon no es válida");
                }               
            }
            
            function conectar(div1,div2){     
                //console.log(endpoint);
                //console.log(div1  + " --- " + div2);                
                var e1 = jsPlumb.addEndpoint(div1, endpoint);
                //console.log("termino1");                  
                var e2 = jsPlumb.addEndpoint(div2, endpoint);   
                //console.log("termino2");
                jsPlumb.connect({ source:e1, target:e2, paintStyle:{strokeStyle:"gray", lineWidth:2} , overlays: [
                        [ "Arrow", { foldback:0.9 } ]    
                    ]}); 
             //   console.log("termino3");
            }
            
           
            function isValidConnection(div1,div2){
                var result=$.ajax({
                    url:"jx_topic.php?option=connect&parent="+getIdTopic(div1)+"&child="+getIdTopic(div2),
                    async:false
                }).responseText;
                
                if(result=="ok")return true;
                return false;   
            }
            
                      
            
           
           
            //FUNCIONES DEL GRAFO
            //funcion que se encarga de crear un nuevo topic
            function crearTopic(id,x,y){
                //      alert("id: "+  id + " x: " + x + " y: " + y);
                console.log(x + " " + y);
                var x=Math.round(x);
                var y=Math.round(y);
                console.log(x + " " + y);
                //alert();
                var div=$(crearDivTopic(id));
                div.css({"top":y,"left":x});
                if(isBloqueado(id)){
                    div.addClass('bloqueado');
                }
                $("#graph").append(div);
                
             //    jsPlumb.draggable(crearIdTopic(id));
                            
            } 
            
            //funcion que dice si un topic esta bloqueado o no
            function isBloqueado(id){
                var result=$.ajax({
                    url:"jx_topic.php?option=isLocked&idTopic="+id,
                    async:false
                }).responseText;
                //   alert(result);
               
                if(result=="true"){
                    return true;  
                }
            }
            
            
            function getInfoTopic(id,tipo){
               
                //we load the info of the selected div 
                if(tipo==1){
                    var result=$.ajax({
                        url:'jx_topic.php?option=getNameMinimum&idTopic='+id ,
                        async:false                       
                    }).responseText;
                    
                    return result;
                }else if(tipo==2){                    
                    var result=$.ajax({
                        url:'jx_topic.php?option=getListProblems&idTopic='+id ,
                        async:false                       
                    }).responseText;                  
                    return result;
                }
            }
            
            function setInfoTopic(id){
                var result=getInfoTopic(id,1);
                var value=result.split(",");  
                // alert(value);
                $("#"+crearIdTopic(id) + " .topicName").html("<u style='font-size:20px;'>"+value[0] +"</u> <br> ("+ value[1] + "");      
            }
            
            
            function loadInfoTopicModal(result){            
                //ponemos los valores en las cajas de texto del Modal Topic
                var value=result.split(",");
                $("#name").attr('value',value[0]);
                $("#ejercicio").attr('value',value[1]);   
               
                $("#listaEjercicios").append(getInfoTopic(editing,2));
                
                //  $("#"+crearIdTopic(editing) + " .topicName").html(value[0]);
            }
            
     
            
            
            function crearIdTopic(id){
                return "d"+id;
            }
            function crearIdListaTopic(id){
                return "l"+id;
            }
           
            
            function getIdTopic(div){
                return div.substring(1);
            }
            
            
            function crearDivTopic(id){                
                var div ="<div id='" + crearIdTopic(id) + "' class='topic'>"
                    + "<div class='topicName' >"                      
                    +"</div>"
                    +"<div class='problems'>"  
                    +"<div id='"+ crearIdListaTopic(id) +"'>"
                    +"</div>"
                    +"</div>"
                    + "</div>";                
                return div ;  
            }    
            
            $(document).ready(function(){
                $(document).dblclick(function(e){                   
                    if(e.pageY>$("#navbar1").height()){                        
                        if(!onDiv){
                            var result = $.ajax({
                                url : "jx_graph.php?option=generateIdTopic&posx="+e.pageX+"&posy="+e.pageY,
                                async: false
                            }).responseText                               
                            //     alert("id: " + result + " x: " + e.pageX + " y: " + e.pageY);
                            crearTopic(result,e.pageX,e.pageY);
                        } else
                            onDiv=false;
                    }
                });             
            });
            
            //agregar nuevo problema al div
            function addProblemDiv(id,code,problem){
                var div=$("#"+crearIdTopic(id));
                 if(div.hasClass('bloqueado')){
                     //alert("esta bloqueado" + div.attr('id'));
                 }else{
                //   alert(code);
                //lo ponemos verde si ya esta solucionado
                var result=$.ajax({
                    url:"jx_problem.php?option=isSolved&idProblem="+code,
                    async:false
                }).responseText

                if(result=="false"){
                  //alert("no");
                    var l="*"+problem+" ("+code+")<br>";
                    $("#l"+id).append(l);
                }else{
                    //  alert("si");
                    var l="<li style='background-color:#19AC19'>"+problem+" ("+code+")</li>";
                    $("#l"+id).append(l);  
                }
               
            }
                
                
                             
            }          
        
        </script>
        <style>

            ._jsPlumb_overlay { z-index:51; }
            ._jsPlumb_endpoint { z-index:50; cursor:move; }
            ._jsPlumb_connector { z-index:0;  }

            .topicName{
                min-width: 100px;
                height: 40px;
                border: 1px solid black;  
            }

            .problems{
                min-width: 100px;               
                height: 100px;
                border: 1px solid black; 
                overflow: auto ;
                background-position: center center;
                font-size: 10px;
                line-height: 12px;

                background-size: 100%;

            }

            .bloqueado{
                background-image: url("images/candado.gif");
            }



            .topic{
                position: fixed;
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
        while ($rw = mysql_fetch_array($topics)) {
            $position = $c->getInfoPosition($rw['id_topic'], $current_course);

            $idTopic = $c->getOneField($position, 'id_topic');
            $x = $c->getOneField($position, 'x');
            $y = $c->getOneField($position, 'y');
            echo "<script>
                        crearTopic($idTopic,$x,$y);                                               
                       setInfoTopic($idTopic);
                         </script>";
            $problema = $c->getAllProblemas($current_course, $idTopic);
            while ($r = mysql_fetch_array($problema)) {
                $code = $r['id_problem'];
                $name = $r['name'];
                echo "<script>
              
                    addProblemDiv($idTopic,$code,'$name');
                    </script>";
            }
        }

//cargamos las conexiones 
        while ($data = mysql_fetch_array($connections)) {
            echo "<script>
                parent.push(" . $data['parent'] . ");
                child.push(" . $data['child'] . ");
               </script>";
        }
        ?>
            







