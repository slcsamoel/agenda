<?php

namespace App\Controllers;

use App\Helpers\RenderHTML;


class AgendaController{

    public $view;

    function __construct()
    {

        $this->view = new RenderHTML();
        
    }

}