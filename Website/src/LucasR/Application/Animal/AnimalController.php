<?php

namespace LucasR\Application\Animal;

use LucasR\Framework\View;
use LucasR\Framework\Authentification\AuthentificationManager;
use LucasR\Application\Animal\AnimalStorageMySQL;
use LucasR\Application\SPARQL\SparQLQuery;

class AnimalController{
    private $request,$response,$view,$db;

    public function __construct($request,$response, $view,AnimalStorageMySQL $db,AuthentificationManager $authManager){
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->db = $db;
        $this->authManager = $authManager;
    }

    public function showHomePage(){
        $animalsList = $this->db->getFiveMRA();
        $this->view->makeHomePage($animalsList);
    }

    public function showAnimalSummary(){
        $animalsList = $this->db->getAll();
        usort($animalsList,function ($a,$b){
            return strtotime($b->getDDMMYYYY()) - strtotime($a->getDDMMYYYY());
        });

        $this->view->makeAnimalSummaryPage($animalsList);
    }

    public function showAnimalPage($id){
        $animal = $this->db->getOne($id);

        $query = new SparQLQuery($this->view->getLang());
        $queryResult = $query->execute($animal->getType());

        $this->view->makeAnimalPage($animal,$queryResult);
    }

    public function showSpotRequests(){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            $spotsList = $this->db->getAllSpotRequests();

            $this->view->makeSpotRequestsPage($spotsList);
        }
        else{
            $this->showHomePage();
        }
    }

    public function showSpotRequest($id){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            $spotInfo = $this->db->getOneSpotRequest($id);
            
            $this->view->makeSpotRequestPage($spotInfo);
        }
        else{
            $this->showHomePage();
        }
    }

    public function showAllAnimalsByType(){
        if($this->authManager->isConnected()){
            $isPost = !($this->request->getParamPost('animals') == '');
            if($isPost){
                $animals = $this->db->getAllAnimalsGivingType($this->request->getParamPost('animals'));
            }
            else{
                $animals = array();
            }
            $animalsSpecies = $this->db->getAllSpecies();
            $this->view->makeAnimalHeatmapPage($animalsSpecies,$isPost,$animals);
        }
        else{
            $this->showHomePage();
        }
    }

    public function addFinalSpot(){
        if($this->authManager->isConnected() && $this->authManager->isAdmin()){
            $id = $this->request->getParamPost('id');
            $decision = $this->request->getParamPost('decision');
            if($decision == 'yes'){
                $res = $this->db->addFinalSpot($id);
                if($res){
                    $this->db->eraseSpotRequest($id);
                    $this->showSpotRequests();
                }
                else{
                    $this->view->makeProblemPage();
                }
            }
            else{
                $res = $this->db->eraseSpotRequest($id);
                if($res){
                    $this->showSpotRequests();
                }
                else{
                    $this->view->makeProblemPage();
                }
            }
        }
        else{
            $this->view->makePermissionNotGrantedPage();
        }
    }

    public function addSpotRequest(){
        if($this->authManager->isConnected()){
            $phpDate = getdate();
            $truMonth = $phpDate['mon'] < 10 ? "0"+$phpDate['mon'] : $phpDate['mon'];
            $date = $this->request->getParamPost('date') != "" ? $this->request->getParamPost('date') : $phpDate['year']."-".$truMonth."-".$phpDate['mday']." ".$phpDate['hours'].":".$phpDate['minutes'].":".$phpDate['seconds'];
            $res = $this->db->addSpotRequest($this->request->getParamPost('type'),$this->request->getParamPost('marker'),$date,$this->request->getParamPost('pictures'),$_SESSION['user']['username'],$this->request->getParamPost('description'));
            $this->view->makeAfterPostPage();
        }
        else{
            $this->showHomePage();
        }
    }


    public function execute($action,$id){
        switch($action){
            case "summary":
                $this->showAnimalSummary();
                break;
            case "show":
                $this->showAnimalPage($id);
                break;
            case "spotRequests":
                $this->showSpotRequests();
                break;
            case "spotRequest":
                $this->showSpotRequest($id);
                break;
            case "addSpotRequest":
                $this->addSpotRequest();
                break;
            case "addFinalSpot":
                $this->addFinalSpot();
                break;
            case "finder":
                $this->showAllAnimalsByType();
                break;
            default:
                $this->showHomePage();
                break;
        }
    }
}

?> 