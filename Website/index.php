<?php

namespace LucasR;
use LucasR\Framework\FrontController;
use LucasR\Framework\Request;
use LucasR\Framework\Response;

spl_autoload_register(function ($className){
    $className = str_replace("\\",DIRECTORY_SEPARATOR,$className);
    $file = ("src/".$className.".php");
    include $file;
});


$database = new \PDO('mysql:host=mysql.info.unicaen.fr;dbname=21400116_bd;port=3306;charset=utf8mb4','21400116','Osei2mie3AGhaequ');

ini_set("allow_url_fopen",1);

session_start();

$frontController = new FrontController(new Request($_GET,$_POST,$_FILES,$_SERVER),new Response(),$database);
$frontController->execute();
?>