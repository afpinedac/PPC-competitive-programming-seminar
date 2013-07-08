//funcion que crea un nodo
function makeNode(posx,posy){        
    var x=$("<div id='"+ generateID(posx,posy) +"' class='node'></div>").css({
        "top" : posy , 
        "left" : posx
    });
            
    //funciones que se le agreagan al nuevo nodo
    x.on("mousedown", function(e){  // ELIMINAR si espicha boton derecho sobre el nodo                
        if(e.button==2){
            if(confirm("Esta seguro de eliminar el nodo"))
                x.remove();
        } 
    });            
    x.on("dblclick",function(){ // agregarle nuevas caracteriticas                
        //var x=prompt("ingrese un numero");
        //alert(x.attr("id"));
        node_actual=x.attr("id");
        $("#m_numero").attr("value","");
        $("#myModal").modal();
     
     
    // alert($(this).height());
        
        
    });
            
            
            
    $("body").append(x);            
    $(".node").draggable({
        scroll:true
    });  
    $(".node").selectable();
}

//funcion que agrega contenido a un nodo

function addContent(div,value){ 
   // alert(value);
    $("#"+div).append(value);
}

//funcion que genera el id de un nodo dado sus posiciones
function generateID(posx,posy){   
    posx=Math.round(posx);
    posy=Math.round(posy);
    return "x_"+posx+"_y_"+ posy;
}