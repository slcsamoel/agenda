<?php

    session_start();
    //header('Content-Type: application/json; charset=UTF-8');
    require_once '../vendor/autoload.php';
    use App\Request;

    ///var_dump($_REQUEST);

    if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {

        $rest = new Request($_SERVER['REQUEST_URI']);
        echo $rest->run();

	}

       
        
      
    
    