<?php

namespace LucasR\Framework;

class ViewFr{
    protected $router,$parts;

    public function __construct(Router $router){
        $this->router = $router;
        $parts = array();
    }

    public function addPart($name,$value){
        array_push($this->parts[$name],$value);
    }

    public function getLang(){
        return "fr";
    }

    public function render(){
        if (!key_exists('title',$this->parts) || !key_exists('content',$this->parts)) {
			$this->makeProblemPage();
        }
        include(__DIR__.DIRECTORY_SEPARATOR."template.php");
    }

    public function debug($msg) {
        $msg = str_replace('"', '\\"', $msg); // Escaping double quotes 
        echo "<script>console.log(\"Le lien donné : $msg\")</script>";
    }


    public function makeAfterPostPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>A propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Merci d'avoir posté";
        $this->parts['content'] = array(
            "<p class='lead'>Merci pour votre coopération ! Notre administrateur va analyser les informations que vous venez de donner aussi rapidement que possible !</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAccountInfoPage($tab){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>A propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - ".$tab[0]["username"];
        $this->parts['content'] = array(
            "<div>",
            "<p class='lead'>Un résumé de vos informations :</p>",
            "<ul>",
            "<li><p>Votre pseudo : ".$tab[0]["username"]."</p></li>",
            "<li><p>Votre nom : ".$tab[0]["firstname"]." ".$tab[0]["lastname"]."</p></li>",
            "<li><p>Votre travail : ".$tab[0]["job"]."</p></li>",
            "<li><p>Votre ville : ".$tab[0]['addres']." </p></li>",
            "<li><p>Votre âge : ".$tab[0]['age']."</p></li>",
            "<li><p>Vous êtes un membre ".$tab[0]['typ']." </p></li>",
            "</ul></div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeSpotRequestsPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>A propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Ajouts d'animaux";
        $this->parts['content'] = array(
            "<div><p class='lead'>Voici tous les animaux que nos utilisateurs ont (auraient) rencontré :</p>",
            "<ul>"
        );
        foreach($res as $item){
            array_push($this->parts['content'],"<li><p><a href='".$this->router->getSpotRequestUrl($item['Id'],"fr")."'>".$item['typ']." (".split(' ',$item['dat'])[0]."), par  ".$item['UploadBy']."</a></p></li>");
        }
        array_push($this->parts['content'],"</ul></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeSpotRequestPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>A propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Demande d'ajout d'animal";
        $this->parts['content'] = array("<div><p class='lead'>".$res[0]["UploadBy"]." aurait rencontré cet animal :</p>",
        "<ul>",
        "<li><p>Espèce : ".$res[0]['typ']."</p></li>",
        "<li><p>Coordonnées : ".$res[0]['Latitude'].",".$res[0]["Longitude"]."</p></li>",
        "<li><p>Date : ".$res[0]['dat']."</p></li>",
        "<li><p>Photos : ".$res[0]['HasPic']."</p></li>",
        "<li><p>Description : ".$res[0]['descript']."</p></li>",
        "</ul><form action='?o=animal&a=addFinalSpot&lang=fr' method='post'>",
        "<p><label for='decision'>Que décidez-vous de faire ?</label><select name='decision' required><option value='' selected disabled hidden>Choisissez ici</option><option value='yes'>C'est bon !</option><option value='no'>Je pose mon véto</option></select></p>",
        "<p><label for='id'>Id de la demande : </label><input name='id' id='id' type='text' value='".$res[0]['Id']."' readonly></p>",
        "<p><input type='submit' value='Ma sentence est irrévocable'></p>",
        "</form></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAccountRequestPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Demande d'inscription";
        $this->parts['content'] = array("<div><p class='lead'>".$res[0]["firstname"]." ".$res[0]["lastname"]." veut nous rejoindre :</p>",
        "<ul>",
        "<li><p>Pseudo : ".$res[0]['username']."</p></li>",
        "<li><p>Mot de passe : ".$res[0]['passwd']."</p></li>",
        "<li><p>Travail : ".$res[0]['job']."</p></li>",
        "<li><p>Âge : ".$res[0]['age']."</p></li>",
        "<li><p>Type d'utilisateur : ".$res[0]['typ']."</p></li>",
        "<li><p>Ville (ou lieu-dit) : ".$res[0]['addres']."</p></li>",
        "</ul><form action='?o=account&a=addFinalAccount&lang=fr' method='post'>",
        "<p><label for='decision'>Que décidez-vous de faire ?</label><select name='decision' required><option value='' selected disabled hidden>Choisissez-ici</option><option value='yes'>C'est bon !</option><option value='no'>Je pose mon véto</option></select></p>",
        "<p><label for='id'>Id de la demande : </label><input name='id' id='id' type='text' value='".$res[0]['Id']."' readonly></p>",
        "<p><input type='submit' value='Ma sentence est irrévocable'></p>",
        "</form></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAccountRequestsPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>A propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Demandes d'inscription";
        if(count($res) > 0){
            foreach($res as $item){
                $this->parts['content'] = array(
                    "<div><p class='lead'>Voici toutes les demandes d'inscription :</p>",
                    "<ul>"
                );
                array_push($this->parts['content'],"<li><p><a href='".$this->router->getAccountRequestUrl($item['Id'],"fr")."'>".$item['firstname']." ".$item['lastname'].", qui sera ".$item['username']."</a></p></li>");
            }
            array_push($this->parts['content'],"</ul></div>");
        }
        else{
            $this->parts['content'] = array('<div><p class="lead">Il n\'y a plus de demandes ! Beau travail !</p></div>');
        }
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAboutPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>À propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - À propos";
        $this->parts['content'] = array(
            "<p class='lead'>Ce site fait partie du sujet intitulé <em>Wildlife Watch</em>, réalisé par Lucas Royackkers (21400116), Master 1 Informatique à l'Unicaen (2017-2018)</p>",
            "<p>Son but principal est de montrer une représentation de la vie sauvage animale, ainsi que de donner des informations relatives quand à ces derniers, en accédant à une base de données externe, ici DBpedia.</p>",
            "<p>Ce site est basée sur sa communauté, en leur demandant où les utilisateurs ont récemment vu un animal sauvage (l'utilisateur doit être un membre enregistré pour ajouter un animal rencontré).</p>",
            "<p>Notre politique est de permettre un accès à une vue globale quand aux dangers que représentent parfois la vie sauvage quand aux professionels et particuliers, mais aussi de protéger des vies animales innocentes.</p>",
            "<p>C'est pourquoi chaque informations mises dans ce site seront vérifées par un membre de notre équipe d'administrateur.</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makePermissionNotGrantedPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>À propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "De grands pouvoirs impliquent ...";
        $this->parts['content'] = array(
            "<p class='lead'>... de grandes responsabilités, mais il paraît que vous n'êtes pas autorisé d'accéder à ce contenu. Désolé :/</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeProblemPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about&lang=fr'>À propos<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Il y a un problème ...";
        $this->parts['content'] = array(
            "<p class='lead'>Malheureusement, un problème nous a empêché de vous faire accéder au contenu demandé. :(</p>",
            "<p>Essayez à nouveau dans quelques minutes, ou contactez-nous si le problème persiste</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";

    }

    public function makeHomePage($list) {
        // <img id='logo' src='images/logo.png' alt='Logo'/>
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch<span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Accueil";
        $this->parts['content'] = array(
            "<div id='map'><p class='lead'>Tous les animaux récemment rencontrés par nos utilisateurs !</p></div>",
            "<div id='allAnimals'>"
        );
        foreach($list as $item){
            array_push($this->parts['content'],'<p class="animalInfos" id="'.$item->getLatitude().' '.$item->getLongitude().'" ><a href="?o=animal&a=show&id='.$item->getId().'&lang=fr">'.$item->getType().'</a><span id="master_'.$item->getLatitude().''.$item->getLongitude().'">...<button onclick="showMore(\'master_'.$item->getLatitude().''.$item->getLongitude().'\')">Plus</button/></span><span id="last_'.$item->getLatitude().''.$item->getLongitude().'" style="display:none">'.$item->getDate("fr").'<button onclick="showLess(\'last_'.$item->getLatitude().''.$item->getLongitude().'\')">Moins</button/></span></p>');
        }
        array_push($this->parts['content'],"</div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeSpotFormPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch<span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Rencontre sauvage !";
        $this->parts['content'] = array(
            "<div><p class='lead'>Où est-ce que ça s'est passé ?</p>",
            "<form action='?o=animal&a=addSpotRequest&lang=fr' method='post'>",
            "<p><label for='type'>Quel animal était-ce ? </label><input type='text' name='type' id='type' placeholder=\"Indiquez l'espèce supposée de l'animal\" required></p>",
            "<p><label for='pictures'>Vous avez des photos de cet évènement ?</label><input type='text' name='pictures' id='pictures' placeholder='Oui ou non' required></p>",
            "<p><label for='date'>La date de cette rencontre *: </label><input type='date' name='date' id='date'></p>",
            "<p><label for='time'>L'heure précise de cette rencontre *: </label><input type='time' name='time' id='time'></p>",
            "<div id='map'><p class='lead'>Mettez votre lieu de rencontre !</p></div>",
            "<p><label for='marker'>Placez un point sur la carte, notre site fera le reste !</label><input type='text' name='marker' id='marker' placeholder='Cliquez sur la carte !' required></p>",
            "<p><label for='description'>Description supplémentaire :</label><input type='text' name='description' id='description' placeholder='Description supplémentaire ...'></p>",
            "<p><input type='submit' value=\"Oui, c'était ça !\"></p>",
            "</form></div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>C'est parti, racontez-nous ! *Si votre rencontre était il y a plus d'une heure, indiquez-le</p></div>";
    }

    public function makeLogInPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Se connecter";
        $this->parts['content'] = array("<form action='?a=logInVerif&lang=fr' method='post'>","<p> <label for='login'> Login : </label><input type='text' name='login' id='login' placeholder='Login' required></p>","<p><label for='pwd'> Mot de passe : </label><input type='password' name='pwd' id='pwd' placeholder='Mot de passe' required></p>","<br>","<p><input type='submit' value='Connexion !'></p>","</form>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl('fr')."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeSignUpPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - S'inscrire";
        $this->parts['content'] = array(
            
            "<form action='.?o=account&a=addAccountRequest&lang=fr' method='post'>",
            "<p class='lead'>Dîtes-nous en plus sur vous !</p>",
            "<p><label for='username'>Pseudo : </label><input type='text' name='username' id='username' placeholder='Votre pseudo' required></p>",
            "<p><label for='password'>Mot de passe : </label><input type='password' name='password' id ='password' placeholder='Votre mot de passe' required></p>",
            "<p><label for='firstname'>Prénom: </label><input type='text' name='firstname' id='firstname' placeholder='Votre prénom' required></p>",
            "<p><label for='name'>Nom : </label><input type='text' name='name' id='name' placeholder='Votre nom' required></p>",
            "<p><label for='job'>Job : </label><input type='text' name='job' id='job' placeholder='Votre travail' required></p>",
            "<p><label for='address'>Ville (ou lieu-dit) : </label><input type='text' name='address' id='address' placeholder='Où vivez-vous ?' required></p>",
            "<p><label for='age'>Âge : </label><input type='number' id='age' name='age' min='18' required></p>",
            "<p><input type='submit' value=\"M'inscrire !\"></p>",
            "</form>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAnimalSummaryPage($list){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item active'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux<span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Sommaire animalier";
        $this->parts['content'] = array(
            "<ul id='animalsList'>"
        );
        foreach($list as $item){
            array_push($this->parts['content'],'<li><p>'.$item->getDDMMYYYY().' : Regarde, un <a href="?o=animal&a=show&id='.$item->getId().'&lang=fr">'.$item->getType().'</a> !</p></li>');
        }
        array_push($this->parts['content'],"<p>");
        array_push($this->parts['content'],"</ul>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAnimalHeatmapPage($species,$isPost,$animals){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Animal finder";
        $this->parts['content'] = array(
            "<form action='#' method='post'>",
            "<label for='animals'>Choisissez un animal : </label>",
            "<select name='animals' id='animals'>",
        );
        foreach($species as $type){
            array_push($this->parts['content'],"<option value='".$type['typ']."'>".$type['typ']."</option>");
        }
        array_push($this->parts['content'],"</select><p><input type='submit' value=\"Voyons ce qu'il se passe !\"></p></form>");
        if($isPost){
            array_push($this->parts['content'],"<div id='map'><p class='lead'>Une carte représentant la chance de rencontrer des animaux d'une espèce spécifique</p></div>");
        }
        foreach($animals as $animal){
            array_push($this->parts['content'],"<p class='animalsHeatmap' style='display : none;'>".$animal['Latitude'].",".$animal['Longitude']."</p>");
        }
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

    public function makeAnimalPage($animal,$queryResult){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.?lang=fr'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl("fr")."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary&lang=fr'>Animaux</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about&lang=fr'>À propos</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - ".$animal->getType().' aperçu : '.$animal->getDDMMYYYY();
        $dbpediaURL = split('/',$queryResult[0]->{"animal"}->{"value"});
        $wikipediaURL = split('\?',$queryResult[0]->{"wikiLink"}->{"value"});
        $this->parts['content'] = array(
            "<div class='row content'>",
            "<div class='col-sm-2 sidenav'>",
            "<p><img src='".$queryResult[0]->{"image"}->{"value"}."' alt='".$queryResult[0]->{"caption"}->{"value"}."'></p>",
            "<p>".str_replace("_"," ",$dbpediaURL[count($dbpediaURL)-1])."</p>",
            "<p>".$queryResult[0]->{"description"}->{"value"}."</p>",
            "<p><a href='".$wikipediaURL[0]."'>Plus</a></p>",
            "</div>",
            "<div class='col-sm-8 text-left'>",
            "<div id='map'><p class='lead'>Carte représentant l'animal</p></div>",
            "<div id='oneAnimal'>",
            "<ul class='animalInfos'>",
            "<li><p>Espèce : ".$animal->getType()." </p></li>",
            // Maybe put town here, rather than coords
            "<li style='display : none;'><p>Coordonnées : <span class='animalCoords'>".$animal->getLatitude().", ".$animal->getLongitude()."</span></p></li>",
            "<li><p>Date : ".$animal->getDDMMYYYY()." </p></li>",
            "<li><p>Mis en ligne par : ".$animal->getUploadedBy()." </p></li>",
            "</ul></div>",
            "</div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Vous avez vu un animal récemment ? <a href='".$this->router->getSpotUrl("fr")."'> Dîtes-nous en plus !</a></p></div>";
    }

}
?>