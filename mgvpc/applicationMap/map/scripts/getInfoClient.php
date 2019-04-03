<?php
    header("Content-Type: text/plain");
    function __autoload($class_name){
        require('../../classes/' . $class_name . '.class.php'); 
    }

    $res="";
    if(isset($_POST['num']) && !empty($_POST['num']))   {
        $manager = new clientManager(database::getDB());
        $client = $manager->get($_POST['num']);
    }
    if ($client!=false) {
        $res = $client->getNom()." ".$client->getPrenom();
    }
    echo $res;