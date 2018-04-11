<?php
namespace LucasR\Framework;

use LucasR\Framework\Router;
use LucasR\Framework\Response;
use LucasR\Framework\Request;
use LucasR\Framework\View;
use LucasR\Framework\ViewFr;
use LucasR\Framework\Authentification\AuthentificationManager;
use LucasR\Framework\Authentification\AuthentificationHTML;
use LucasR\Framework\Access\AccessManager;
use LucasR\Application\Def\Controller;
use LucasR\Application\Animal\AnimalController;
use LucasR\Application\Animal\AnimalStorageMySQL;
use LucasR\Application\Account\AccountController;
use LucasR\Application\Account\AccountStorageMySQL;

class FrontController{
    protected $request,$response,$database;

    public function __construct(Request $request, Response $response,\PDO $database){
        $this->response = $response;
        $this->request = $request;
        $this->database = $database;
    }

    public function execute(){

        $router = new Router($this->request);
        $router->main();

        $controllerClass = $router->getControllerClass();
        $databaseRequester = $router->getDatabaseRequester();
        $action = $router->getAction();
        $id = $router->getId();

        $lang = $this->request->getParamGet('lang');
        switch($lang){
            case "fr":
                $view = new ViewFr($router);
                break;
            default:
                $view = new View($router);
                break;
        }

        $authManager = new AuthentificationManager($this->database,$this->request);
        $authHTML = new AuthentificationHTML($authManager,$router,$lang);

        $database = new $databaseRequester($this->database);

        $controller = new $controllerClass($this->request,$this->response,$view,$database,$authManager);
        $controller->execute($action,$id);
        $isLogged = $authHTML->getPart($this->request->getCurrentRequestURI());
        $this->response->sendResponse($view,$isLogged);
    }
}

?>