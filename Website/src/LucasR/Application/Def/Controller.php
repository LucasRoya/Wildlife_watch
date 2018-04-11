<?php

namespace LucasR\Application\Def;

use LucasR\Framework\View;
use LucasR\Framework\Authentification\AuthentificationManager;
use LucasR\Application\Animal\AnimalStorageMySQL;

class Controller{
    protected $request,$response,$view,$db;
    
        function __construct($request,$response,$view,AnimalStorageMySQL $db,AuthentificationManager $authManager){
            $this->request = $request;
            $this->response = $response;
            $this->view = $view;
            $this->db = $db;
            $this->authManager = $authManager;
        }
    
        public function showHomePage(){
            $animalsList = $this->db->getFiveMRA();
            usort($animalsList,function ($a,$b){
                return strtotime($b->getDDMMYYYY()) - strtotime($a->getDDMMYYYY());
            });
            $this->view->makeHomePage($animalsList);
        }

        public function showLogInPage(){
            if($this->authManager->isConnected()){
                $this->showHomePage();
            }
            else{
                $this->view->makeLogInPage();
            }
        }

        public function showAboutPage(){
            $this->view->makeAboutPage();
        }

        public function logOut(){
            if($this->authManager->isConnected()){
                session_destroy();
                $this->request->synchronizeSession(array());
                $this->showHomePage();
            }
            else{
                $this->showHomePage();
            }
            
        }

        public function showSignUpPage(){
            if($this->authManager->isConnected()){
                $this->showHomePage();
            }
            else{
                $this->view->makeSignUpPage();
            }
        }

        public function setLogIn(){
            $login = $this->request->getParamPost('login');
            $passwd = $this->request->getParamPost('pwd');
            $test = $this->authManager->checkAuth($login,$passwd);
            $isConnected = $this->authManager->isConnected();
            if($isConnected){
                $this->showHomePage();
            }
            else{
                $this->showLogInPage();
            }
        }

        public function showSpotFormPage(){
            if($this->authManager->isConnected()){
                // DO SOMETHING
                $this->view->makeSpotFormPage();
            }
            else{
                $this->showLogInPage();
            }
        }

        public function execute($action,$id){
            switch($action){
                case "about":
                    $this->showAboutPage();
                    break;
                case "logIn":
                    $this->showLogInPage();
                    break;
                case "logOut":
                    $this->logOut();
                    break;
                case "signUp":
                    $this->showSignUpPage();
                    break;
                case "spot":
                    $this->showSpotFormPage();
                    break;
                case "logInVerif":
                    $this->setLogIn();
                    break;
                default:
                    $this->showHomePage();
                    break;
            }
        }
}

?>