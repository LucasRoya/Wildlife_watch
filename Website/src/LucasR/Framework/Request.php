<?php

namespace LucasR\Framework;

class Request{
    protected $get,$post,$files,$server;

    public function __construct($get,$post,$files,$server){
        $this->get = $get;
        $this->post = $post;
        $this->files = $files;
        $this->server = $server;
    }

    public function getParamGet($name){
        return key_exists($name,$this->get) ? $this->get[$name] : "";
    }

    public function getParamPost($name){
        return key_exists($name,$this->post) ? htmlspecialchars($this->post[$name]) : "";
    }

    public function getParamFiles($name){
        return key_exists($name,$this->files) ? $this->files[$name] : "";
    }

    public function getSessionInfo($name){
        return key_exists($name,$this->session) ? $this->session[$name] : "";
    }

    public function putSessionInfo($name,$value){
        $this->session[$name] = $value;
    }

    public function getCurrentRequestURI(){
        return $this->server['REQUEST_URI'];
    }

    public function synchronizeSession($array){
        $_SESSION = $array;
    }

    public function unsetSession(){
        unset($_SESSION['user']);
    }

    public function isAjaxRequest(){
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}

?>