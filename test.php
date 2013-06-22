<?php
include('./vista/header.php');

?>

<script>
 $.ajax({
     url:"http://espineda.com/things/test1.php?callback=?",
     dataType: 'jsonp', // Notice! JSONP <-- P (lowercase)
     success:function(json){
        console.log(json);  
         // do stuff with json (in this case an array)
         alert("Success");
     },
     error:function(){
         alert("Error");
     }
});
</script>    
