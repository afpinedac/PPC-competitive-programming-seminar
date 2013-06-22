<?php
$arr = array("element1","element2",array("element31","element32"));
$arr['name'] = "response";

$data=  json_encode($arr);
if ($_GET['callback']) {
    echo $_GET['callback']."($data);"; 
}else
    echo $data;

 // 09/01/12 corrected the statement
?>