//variables globales
var node_actual; 
var posx=[];
var posy=[]; 

        
///////////////
        
//carga del documento
$(document).ready(function(){  
    //cuando espicha un boton del mouse dentro del body
    $("body").mousedown(function(e){               
        if(e.button==1){    
            makeNode(e.pageX,e.pageY); // si hace click en la ruedita                             
        }
    });  
            
    //se ejecuta cuando la persona hizo click en guardar cambios dentro del modal
    $("#save_changes").click(function(){               
        var value=$("#m_numero").val();
        if(value!="" && !isNaN(value)){ 
            //alert("pasa");
            $.get("informacion.php?option=getNameProblem&id="+value+"&tema="+node_actual,function(data,status){
              alert(data);
                if(data=="no encontrado"){
                    alert("Problema no encontrado");   
                }else if(data=="ya existe"){
                    alert("El problema ya pertenece al tema");
                }else{
                    addContent(node_actual,"*"  + data + "<br/>");
                }                    
            }
            );                        
            $("#m_numero").html("");
            $("#myModal").modal("hide");                  
        }else{
            alert("Numero invalido");
        }
    });
             
});       
            