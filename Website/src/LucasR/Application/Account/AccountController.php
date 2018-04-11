<?php

namespace LucasR\Application\Account;

use LucasR\Framework\View;
use LucasR\Framework\Authentification\AuthentificationManager;
use LucasR\Application\Account\AccountStorageMySQL;
use LucasR\Application\Account\Account;

class AccountController{
    private $request,$response,$view,$db;

    public function __construct($request,$response,$view,AccountStorageMySQL $db, AuthentificationManager $authManager){
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->db = $db;
        $this->authManager = $authManager;
    }

    public function showAccountPage($id){
        if($this->authManager->isConnected()){
            $res = $this->db->getAccountInfo($id);
            $this->view->makeAccountInfoPage($res);
        }
        else{
            $this->view->makePermissionNotGrantedPage();
        }
    }

    public function showAccountRequestPage($id){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            $res = $this->db->getOneAccountRequest($id);
            $this->view->makeAccountRequestPage($res);
        }
        else{
            $this->view->makePermissionNotGrantedPage();
        }
    }

    public function showAccountRequestsPage(){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            $res = $this->db->getAllAccountRequests();
            $this->view->makeAccountRequestsPage($res);
        }
        else{
            $this->view->makePermissionNotGrantedPage();
        }
    }

    public function addFinalAccount(){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            
            $id = $this->request->getParamPost('id');
            $decision  = $this->request->getParamPost('decision');
            if($decision == "yes"){
                $res = $this->db->addFinalAccount($id);
                if($res){
                    $this->showAccountRequestsPage();
                }
                else{
                    $this->view->makeProblemPage();
                }
            }
            else{
                $res = $this->db->eraseAccountRequest($id);
                if($res){
                    $this->showAccountRequestsPage();
                }
                else{
                    $this->view->makeProblemPage();
                }
                $this->showAccountRequestsPage();
            }
        }
        else{
            $this->view->makePermissionNotGrantedPage();
        }
    }

    public function addAccountRequest(){
        if($this->authManager->isConnected()){
            $this->view->makeProblemPage();
        }
        else{
            $account = new Account($this->request->getParamPost("username"),$this->request->getParamPost("password"),$this->request->getParamPost("firstname"),$this->request->getParamPost("name"),$this->request->getParamPost("job"),$this->request->getParamPost("address"),$this->request->getParamPost("age"),'standard');
            $res = $this->db->addAccountRequest($account);
            $this->view->makeAfterPostPage();
        }
    }

    public function showHomePage(){
        $this->view->makeAboutPage();
    }

    public function execute($action,$id){
        switch($action){
            case "show":
                $this->showAccountPage($id);
                break;
            case "accountRequests":
                $this->showAccountRequestsPage();
                break;
            case "accountRequest":
                $this->showAccountRequestPage($id);
                break;
            case "addAccountRequest":
                $this->addAccountRequest();
                break;
            case "addFinalAccount":
                $this->addFinalAccount();
                break;
            default:
                $this->showHomePage();
                break;
        }
    }
}

?>