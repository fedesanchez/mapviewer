<?php
    include("../classes/maps.class.php");
 
    $id=$_GET['id'];


    $map="maps.php/$id";
    include("../templates/composer.tpl.php");
?>