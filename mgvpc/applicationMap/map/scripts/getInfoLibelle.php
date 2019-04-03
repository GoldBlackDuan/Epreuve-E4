<?php
    header("Content-Type: text/plain");
    function __autoload($class_name){
        require('../../classes/' . $class_name . '.class.php'); 
    }

    $res="";
    if(isset($_POST['reference']) && !empty($_POST['reference']))   {
        $manager = new produitManager(database::getDB());
        $prod = $manager->get($_POST['reference']);
    }
    if ($prod!=false) {
        $res = $prod->getLib();
    }
    echo $res;