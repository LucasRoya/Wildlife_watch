<?php

namespace LucasR\Framework;

use LucasR\Application\Def\Controller;
use LucasR\Framework\Request;

class Router{
    private $request,$object,$action,$id,$controllerClass,$databaseRequester;

    public function __construct($request){
        $this->request = $request;
    }

    public function main(){
		$this->action = $this->request->getParamGet("a");
		$this->object = $this->request->getParamGet("o");
        $this->id = $this->request->getParamGet("id");

        switch($this->object){
            case "animal":
                $this->controllerClass = "LucasR\Application\Animal\AnimalController";
                $this->databaseRequester = "LucasR\Application\Animal\AnimalStorageMySQL";
                break;
            case "account":
                $this->controllerClass = "LucasR\Application\Account\AccountController";
                $this->databaseRequester = "LucasR\Application\Account\AccountStorageMySQL";
                break;
            default:
                $this->controllerClass = "LucasR\Application\Def\Controller";
                $this->databaseRequester = "LucasR\Application\Animal\AnimalStorageMySQL";
                break;
        }
    }
    
    public function getAction(){
		return $this->action;
	}

    public function getId(){
        return $this->id;
    }

	public function getControllerClass(){
		return $this->controllerClass;
    }
    
    public function getDatabaseRequester(){
        return $this->databaseRequester;
    }

	/* URL de la page d'accueil */
	public function getHomeURL(){
		return ".";
    }

    public function getSignUpUrl($lang = null){
        switch($lang){
            case "fr":
                return "?a=signUp&lang=".$lang;
                break;
            default:
                return "?a=signUp";
                break;
        }
        
    }

    public function getLogInUrl($lang = null){
        switch($lang){
            case "fr":
                return "?a=logIn&lang=".$lang;
                break;
            default :
                return "?a=logIn";
                break;
        }
    }

    public function getLogOutUrl($lang = null){
        switch($lang){
            case "fr":
                return "?a=logOut&lang=".$lang;
                break;
            default:
                return "?a=logOut";
                break;
        }
    }

    public function getSpotUrl($lang = null){
        switch($lang){
            case "fr":
                return "?a=spot&lang=".$lang;
                break;
            default:
                return "?a=spot";
                break;
        }
    }

    public function getAccountInfoUrl($username,$lang=null){
        switch($lang){
            case "fr":
                return "?o=account&a=show&id=".$username."&lang=fr";
                break;
            default:
                return "?o=account&a=show&id=".$username."";
                break;
        }
    }

    public function getSpotRequestsUrl($lang=null){
        switch($lang){
            case "fr":
                return "?o=animal&a=spotRequests&lang=fr";
                break;
            default:
                return "?o=animal&a=spotRequests";
                break;
        }
    }

    public function getSpotRequestUrl($id,$lang=null){
        switch($lang){
            case "fr":
                return "?o=animal&a=spotRequest&id=".$id."&lang=fr";
                break;
            default:
                return "?o=animal&a=spotRequest&id=".$id;
                break;
        }
    }

    public function getAccountRequestsUrl($lang=null){
        switch($lang){
            case "fr":
                return "?o=account&a=accountRequests&lang=fr";
                break;
            default:
                return "?o=account&a=accountRequests";
                break;
        }
    }

    public function getAnimalFinderUrl($lang=null){
        switch($lang){
            case "fr":
                return "?o=animal&a=finder&lang=fr";
                break;
            default:
                return "?o=animal&a=finder";
                break;
        }
    }

    public function getAccountRequestUrl($id,$lang=null){
        switch($lang){
            case "fr":
                return "?o=account&a=accountRequest&id=".$id."lang=fr";
                break;
            default:
                return "?o=account&a=accountRequest&id=".$id;
                break;
        }
    }
}
?>