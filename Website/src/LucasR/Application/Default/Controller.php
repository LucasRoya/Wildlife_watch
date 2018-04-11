<?php

namespace LucasR\Application\Def;

use LucasR\Framework\View;

class Controller{
    protected $request,$response,$view;
    
        function __construct($request,$response,View $view){
            $this->request = $request;
            $this->response = $response;
            $this->view = $view;
        }
    
        public function showHomePage(){
            $this->view->makeHomePage();
        }

        public function execute($action,$id){
            switch($action){
                case "":
                    $this->showHomePage();
                    break;
                default:
                    $this->showHomePage();
                    break;
            }
        }
}

?>