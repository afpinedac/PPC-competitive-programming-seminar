//funcion que guarda el grafo
function save(){ 
    var div=[];
    var problem=[];
    var ndiv=-1;
    
    $(".node").each(function(e){
        var pos=$(this).position();
        //alert("x: " + pos.left + " y: " + pos.top);
        var nx=Math.round(pos.left);
        var ny=Math.round(pos.top);
        ndiv++;
        posx.push(nx); //agregamos las posiciones de los divs
        posy.push(ny);
        //alert($(this).text());
        var problems=$(this).text().split("*");
        for(i=0;i<problems.length;i++){
            if(problems[i]!="" && problems[i]!=null){
                div.push(ndiv);
                problem.push(problems[i]);
            }
        }
    });
            
    location.href="curso.php?option=save&posx="+posx+"&posy="+posy+"&indices="+div+"&problem="+problem;
}