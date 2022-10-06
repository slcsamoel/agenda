<?php

    //var_dump($_SERVER);

    //header('Content-Type: application/json; charset=UTF-8');
    require_once '../vendor/autoload.php';
    use App\Request;

    var_dump($_REQUEST);

    if (isset($_REQUEST) && !empty($_REQUEST)) {

        $rest = new Request($_REQUEST);
        echo $rest->run();

	}

       
        
      
    
    