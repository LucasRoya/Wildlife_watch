<?php

namespace LucasR\Framework;

class Response{
    public function redirect($url){
        header("Location: ".$url);
        exit(0);
    }

    public function POSTredirect($url){
        header("Location: ".$url,true,303);
        exit(0);
    }

    public function POSTredirect2($url){
        header("Location: ".$url,true,200);
        exit(0);
    }

    public function setHeader($name,$value){
        header($name.": ".$value,true);
    }

    public function sendResponse($view,$isLogged){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            echo "coucou";
        }
        else{
            $view->addPart('header',$isLogged);
            $view->render();
        }
    }
}

?>