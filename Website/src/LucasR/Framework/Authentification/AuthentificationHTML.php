<?php

namespace LucasR\Framework\Authentification;
use LucasR\Framework\Authentication\AuthenticationManager;
use LucasR\Framework\Router;

class AuthentificationHTML{
    private $am,$router;

    public function __construct(AuthentificationManager $am,$router,$lang){
        $this->am = $am;
        $this->router = $router;
        $this->lang = $lang;
    }

    public function getPart($urlform){
        $finalLeftBar = "";
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($actual_link,"lang=") !== false){
            $actual_link = explode("lang=",$actual_link)[0];
        }
        else if(strpos($actual_link,"?") !== false){

            $actual_link .= "&";
        }
        else{
            $actual_link .= "?";
        }
        
        if($this->am->isConnected()){
            $finalLeftBar .= "<ul class='nav navbar-nav navbar-right'>";
            $finalLeftBar .=  "<ul class='nav navbar-nav navbar-right'><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='.' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            switch($this->lang){
                case "fr":
                    $finalLeftBar .= "<img border='0' alt='French' src='images/France512x512.png' width='30' height = '30'>";
                    break;
                default:
                    $finalLeftBar .= "<img border='0' alt='English' src='images/GreatBritain512x512.png' width='30' height = '30'>";
                    break;
            }
            $finalLeftBar .= "</a><ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='".$actual_link."lang=en'><img border='0' alt='English' src='images/GreatBritain512x512.png' width='30' height = '30'>English</a><a class='dropdown-item' href='".$actual_link."lang=fr'><img border='0' alt='French' src='images/France512x512.png' width='30' height = '30'>Français</a></ul></li>";
            $finalLeftBar .= "<button class='btn btn-outline-info my-2 my-sm-0' style='background-image: url(images/ouit.png)' onclick='redirectURL(\"".$this->router->getAnimalFinderUrl()."\")'>Animal finder</button>";
            $finalLeftBar .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$_SESSION['user']['username'].'</a>';        
            if($this->am->isAdmin()){
                if($this->lang == "fr"){
                    $finalLeftBar .= '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item" href="'.$this->router->getAccountInfoUrl($_SESSION['user']['username'],"fr").'">Mon compte</a><a class="dropdown-item" href="'.$this->router->getSpotRequestsUrl("fr").'">Publications d\'animaux<span class="num">'.$this->am->getAllSpotRequests().'</span></a><a class="dropdown-item" href="'.$this->router->getAccountRequestsUrl("fr").'">Comptes actifs <span class="num">'.$this->am->getAllAccountRequests().'</span></a></div>';
                }
                else{
                    $finalLeftBar .= '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item" href="'.$this->router->getAccountInfoUrl($_SESSION['user']['username']).'">My account</a><a class="dropdown-item" href="'.$this->router->getSpotRequestsUrl().'">Animal publications<span class="num">'.$this->am->getAllSpotRequests().'</span></a><a class="dropdown-item" href="'.$this->router->getAccountRequestsUrl().'">Active accounts <span class="num">'.$this->am->getAllAccountRequests().'</span></a></div>';
                }
            }
            else{
                if($this->lang == "fr"){
                    $finalLeftBar .= '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item" href="'.$this->router->getAccountInfoUrl($_SESSION['user']['username'],"fr").'">Mon compte</a><a class="dropdown-item" href="#">Mes publications</a></div>';
                }
                else{
                    $finalLeftBar .= '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item" href="'.$this->router->getAccountInfoUrl($_SESSION['user']['username']).'">My account</a><a class="dropdown-item" href="#">My publications</a></div>';
                }
            }
            $finalLeftBar .= "</li>";
            if($this->lang == "fr"){
                $finalLeftBar .= "<button class='btn btn-outline-danger my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getLogOutUrl("fr")."\")'>Déconnexion</button></ul>";
            }
            else{
                $finalLeftBar .= "<button class='btn btn-outline-danger my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getLogOutUrl()."\")'>Log Out</button></ul>";
            }
        }
        else{
            $finalLeftBar .=  "<ul class='nav navbar-nav navbar-right'><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            switch($this->lang){
                case "fr":
                    $finalLeftBar .= "<img border='0' alt='French' src='images/France512x512.png' width='30' height = '30'>";
                    $finalLeftBar .= "</a><ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='".$actual_link."lang=en'><img border='0' alt='English' src='images/GreatBritain512x512.png' width='30' height = '30'>English</a><a class='dropdown-item' href='".$actual_link."lang=fr'><img border='0' alt='French' src='images/France512x512.png' width='30' height = '30'>Français</a></ul></li><button class='btn btn-outline-primary my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getLogInUrl($this->lang)."\")'>Connexion</button><button class='btn btn-success my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getSignUpUrl($this->lang)."\")'>S'inscrire !</button></ul>";
                    break;
                default:
                    $finalLeftBar .= "<img border='0' alt='English' src='images/GreatBritain512x512.png' width='30' height = '30'>";
                    $finalLeftBar .= "</a><ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='".$actual_link."lang=en'><img border='0' alt='English' src='images/GreatBritain512x512.png' width='30' height = '30'>English</a><a class='dropdown-item' href='".$actual_link."lang=fr'><img border='0' alt='French' src='images/France512x512.png' width='30' height = '30'>Français</a></ul></li><button class='btn btn-outline-primary my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getLogInUrl($this->lang)."\")'>Log In</button><button class='btn btn-success my-2 my-sm-0' onclick='redirectURL(\"".$this->router->getSignUpUrl($this->lang)."\")'>Sign Up !</button></ul>";
                    break;
            }
            
        }
        return $finalLeftBar;
    }
}

?>