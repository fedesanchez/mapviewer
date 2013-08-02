<?php
    include("../classes/maps.class.php");
    if(isset($_GET['id'])){
    	$id=$_GET['id'];
    	$map="maps.php/$id";
    }
    	   
    include("../templates/view.tpl.php");
?>
