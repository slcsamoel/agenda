<?php
    namespace App\Helpers;

    
  class RenderHTML{


        public function renderHtml($template , $dados){

                extract($dados);
                ob_start();
                require __DIR__.'/../Views/'.$template;        
                $html =  ob_get_contents();
                ob_clean();
                return $html;

        }



  }
