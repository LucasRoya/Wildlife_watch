<?php

namespace LucasR\Framework;

class View{
    protected $router,$parts;

    public function __construct(Router $router){
        $this->router = $router;
        $parts = array();
    }

    public function addPart($name,$value){
        array_push($this->parts[$name],$value);
    }

    public function getLang(){
        return "en";
    }

    public function render(){
        if (!key_exists('title',$this->parts) || !key_exists('content',$this->parts)) {
			$this->makeProblemPage();
        }
        include(__DIR__.DIRECTORY_SEPARATOR."template.php");
    }
    
    public function makeAfterPostPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - After post";
        $this->parts['content'] = array(
            "<p class='lead'>Thanks for your submit ! Our administrator will analyse your demand asap !</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAccountInfoPage($tab){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - ".$tab[0]["username"];
        $this->parts['content'] = array(
            "<div>",
            "<p class='lead'>Here is a small recap of your informations :</p>",
            "<ul>",
            "<li><p>Your username : ".$tab[0]["username"]."</p></li>",
            "<li><p>Your name : ".$tab[0]["firstname"]." ".$tab[0]["lastname"]."</p></li>",
            "<li><p>Your job : ".$tab[0]["job"]."</p></li>",
            "<li><p>Your town : ".$tab[0]['addres']." </p></li>",
            "<li><p>Your age : ".$tab[0]['age']."</p></li>",
            "<li><p>You are a(n) ".$tab[0]['typ']." user </p></li>",
            "</ul></div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeSpotRequestsPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Spot requests";
        $this->parts['content'] = array(
            "<div><p class='lead'>Here are all the spot requests that you might accept or not</p>",
            "<ul>"
        );
        foreach($res as $item){
            array_push($this->parts['content'],"<li><p><a href='".$this->router->getSpotRequestUrl($item['Id'])."'>".$item['typ']." (".split(' ',$item['dat'])[0]."), by  ".$item['UploadBy']."</a></p></li>");
        }
        array_push($this->parts['content'],"</ul></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeSpotRequestPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Spot request";
        $this->parts['content'] = array("<div><p class='lead'>".$res[0]["UploadBy"]." has spotted something :</p>",
        "<ul>",
        "<li><p>Type of the animal : ".$res[0]['typ']."</p></li>",
        "<li><p>Coords : ".$res[0]['Latitude'].",".$res[0]["Longitude"]."</p></li>",
        "<li><p>Date : ".$res[0]['dat']."</p></li>",
        "<li><p>Pictures of it : ".$res[0]['HasPic']."</p></li>",
        "<li><p>Description : ".$res[0]['descript']."</p></li>",
        "</ul><form action='?o=animal&a=addFinalSpot' method='post'>",
        "<p><label for='decision'>What do you decide to do with this ?</label><select name='decision' required><option value='' selected disabled hidden>Choose here</option><option value='yes'>It's ok !</option><option value='no'>This is a no for me</option></select></p>",
        "<p><label for='id'>Request's id : </label><input name='id' id='id' type='text' value='".$res[0]['Id']."' readonly></p>",
        "<p><input type='submit' value='I took my decision !'></p>",
        "</form></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAccountRequestPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Account request";
        $this->parts['content'] = array("<div><p class='lead'>".$res[0]["firstname"]." ".$res[0]["lastname"]." want to join us :</p>",
        "<ul>",
        "<li><p>Username : ".$res[0]['username']."</p></li>",
        "<li><p>Password : ".$res[0]['passwd']."</p></li>",
        "<li><p>Job : ".$res[0]['job']."</p></li>",
        "<li><p>Age : ".$res[0]['age']."</p></li>",
        "<li><p>User type : ".$res[0]['typ']."</p></li>",
        "<li><p>Hometown (or location) : ".$res[0]['addres']."</p></li>",
        "</ul><form action='?o=account&a=addFinalAccount' method='post'>",
        "<p><label for='decision'>What do you decide to do with this ?</label><select name='decision' required><option value='' selected disabled hidden>Choose here</option><option value='yes'>It's ok !</option><option value='no'>This is a no for me</option></select></p>",
        "<p><label for='id'>Request's id : </label><input name='id' id='id' type='text' value='".$res[0]['Id']."' readonly></p>",
        "<p><input type='submit' value='I took my decision !'></p>",
        "</form></div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAccountRequestsPage($res){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - Account requests";
        if(count($res) > 0){
            foreach($res as $item){
                $this->parts['content'] = array(
                    "<div><p class='lead'>Here are all the account requests that you might accept or not</p>",
                    "<ul>"
                );
                array_push($this->parts['content'],"<li><p><a href='".$this->router->getAccountRequestUrl($item['Id'])."'>".$item['firstname']." ".$item['lastname'].", as ".$item['username']."</a></p></li>");
            }
            array_push($this->parts['content'],"</ul></div>");
        }
        else{
            $this->parts['content'] = array('<div><p class="lead">There are no more requests ! Your job here is done !</p></div>');
        }
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAboutPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - About";
        $this->parts['content'] = array(
            "<p class='lead'>This website is part of the subject <em>Wildlife Watch</em>, realized by Lucas Royackkers (21400116), Master 1 Informatique at Unicaen (2017-2018)</p>",
            "<p>Its main goal is to display a visualization about wildlife, and to show informations related to them, with access to an external database, DBpedia here.</p>",
            "<p>This website fully relies on its users, and ask them to tell us where did they spot a wildlife apperance recently (the user needs to be logged in before adding a new spot).</p>",
            "<p>Our politic is to permit an access of an overall view of where are the dangers that represents wildlife for farmers or inhabitants, and also to protect the animals lives.</p>",
            "<p>This is why every account and every spot will be verify by our own services.</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makePermissionNotGrantedPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "With great power comes ...";
        $this->parts['content'] = array(
            "<p class='lead'>... great responsabilities, but it seems that you are'nt able to access that content. Sorry :/</p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeProblemPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item active'><a class='nav-link' href='?a=about'>About<span class='sr-only'>(current)</span></a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Oops, there is a problem ...";
        $this->parts['content'] = array(
            "<p class='lead'>Unfotunately, a problem lead us to show you this page :( ...</p>",
            "<p>Try again in some minutes, or tell us about your problem if it doesn't solve itself ! </p>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";

    }

    public function makeHomePage($list) {
        // <img id='logo' src='images/logo.png' alt='Logo'/>
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch<span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Home";
        $this->parts['content'] = array(
            "<div id='map'><p class='lead'>All animals spotted recently by our users !</p></div>",
            "<div id='allAnimals'>"
        );
        foreach($list as $item){
            array_push($this->parts['content'],'<p class="animalInfos" id="'.$item->getLatitude().' '.$item->getLongitude().'" ><a href="?o=animal&a=show&id='.$item->getId().'">'.$item->getType().'</a><span id="master_'.$item->getLatitude().''.$item->getLongitude().'">...<button onclick="showMore(\'master_'.$item->getLatitude().''.$item->getLongitude().'\')">More</button/></span><span id="last_'.$item->getLatitude().''.$item->getLongitude().'" style="display:none">'.$item->getDate("en").'<button onclick="showLess(\'last_'.$item->getLatitude().''.$item->getLongitude().'\')">Less</button/></span></p>');
        }
        array_push($this->parts['content'],"</div>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeSpotFormPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch<span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Spot !";
        $this->parts['content'] = array(
            "<div><p class='lead'>Where and what did you spot ?</p>",
            "<form action='?o=animal&a=addSpotRequest' method='post'>",
            "<p><label for='type'>Which animal it was ? </label><input type='text' name='type' id='type' placeholder='Type an animal kind here' required></p>",
            "<p><label for='pictures'>Do you have pictures of it ? </label><input type='text' name='pictures' id='pictures' placeholder='Yes or no' required></p>",
            "<p><label for='date'>The date of your animal spot *: </label><input type='date' name='date' id='date'></p>",
            "<p><label for='time'>The time of your animal spot *: </label><input type='time' name='time' id='time'></p>",
            "<div id='map'><p class='lead'>All animals spotted recently by our users !</p></div>",
            "<p><label for='marker'>Set a marker on the map, our site will do the rest !</label><input type='text' name='marker' id='marker' placeholder='Set a marker on the map, or copy/paste your spot location' required></p>",
            "<p><label for='description'>If you want to add some infos about it, it's here :</label><input type='text' name='description' id='description' placeholder='A bit more infos'></p>",
            "<p><input type='submit' value='Yes, I spotted that !'></p>",
            "</form></div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Go ahead, tell us more ! *If your spot was one hour more than right now, please specify it</p></div>";
    }

    public function makeLogInPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Log in";
        $this->parts['content'] = array("<form action='?a=logInVerif' method='post'>","<p> <label for='login'> Login : </label><input type='text' name='login' id='login' placeholder='Login' required></p>","<p><label for='pwd'> Password : </label><input type='password' name='pwd' id='pwd' placeholder='Your password' required></p>","<br>","<p><input type='submit' value='Log in !'></p>","</form>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeSignUpPage(){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Sign up";
        $this->parts['content'] = array(
            
            "<form action='.?o=account&a=addAccountRequest' method='post'>",
            "<p class='lead'>Tell us more about yourself !</p>",
            "<p><label for='username'>Username : </label><input type='text' name='username' id='username' placeholder='Your username' required></p>",
            "<p><label for='password'>Password : </label><input type='password' name='password' id ='password' placeholder='Your password' required></p>",
            "<p><label for='firstname'>Firstname : </label><input type='text' name='firstname' id='firstname' placeholder='Your firstname' required></p>",
            "<p><label for='name'>Name : </label><input type='text' name='name' id='name' placeholder='Your name' required></p>",
            "<p><label for='job'>Job : </label><input type='text' name='job' id='job' placeholder='What you do for a living' required></p>",
            "<p><label for='address'>City (or location) : </label><input type='text' name='address' id='address' placeholder='Where do you live' required></p>",
            "<p><label for='age'>Age : </label><input type='number' id='age' name='age' min='18' required></p>",
            "<p><input type='submit' value='Log in !'></p>",
            "</form>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAnimalSummaryPage($list){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item active'><a class='nav-link' href='?o=animal&a=summary'>Animals <span class='sr-only'>(current)</span></a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Summary";
        $this->parts['content'] = array(
            "<ul id='animalsList'>"
        );
        foreach($list as $item){
            array_push($this->parts['content'],'<li><p>'.$item->getDDMMYYYY().' : Look, a <a href="?o=animal&a=show&id='.$item->getId().'">'.$item->getType().'</a> !</p></li>');
        }
        array_push($this->parts['content'],"<p>");
        array_push($this->parts['content'],"</ul>");
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAnimalHeatmapPage($species,$isPost,$animals){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife watch - Animal finder";
        $this->parts['content'] = array(
            "<form action='' method='post'>",
            "<label for='animals'>Select an animal : </label>",
            "<select name='animals' id='animals'>",
        );
        foreach($species as $type){
            array_push($this->parts['content'],"<option value='".$type['typ']."'>".$type['typ']."</option>");
        }
        array_push($this->parts['content'],"</select><p><input type='submit' value=\"Let's check !\"></p></form>");
        if($isPost){
            array_push($this->parts['content'],"<div id='map'><p class='lead'>A heatmap of the spotted animals</p></div>");
        }
        foreach($animals as $animal){
            array_push($this->parts['content'],"<p class='animalsHeatmap' style='display : none;'>".$animal['Latitude'].",".$animal['Longitude']."</p>");
        }
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function makeAnimalPage($animal,$queryResult){
        $this->parts['header'] = array(
            "<ul class='nav navbar-nav'>",
            "<li class='nav-item'><a class='navbar-brand' href='.'>Wildlife Watch</a></li>",
            "<li class='nav-item'><button class='btn btn-outline-danger my-2 my-sm-0' style='background-image: url(images/paw.png)' onclick='redirectURL(\"".$this->router->getSpotUrl()."\")'>Spot !</button></li>",
            "<li class='nav-item'><a class='nav-link' href='?o=animal&a=summary'>Animals</a></li>",
            "<li class='nav-item'><a class='nav-link' href='?a=about'>About</a></li>",
            "</ul>"
        );
        $this->parts['title'] = "Wildlife Watch - ".$animal->getType().' spotted : '.$animal->getDDMMYYYY();
        $dbpediaURL = split('/',$queryResult[0]->{"animal"}->{"value"});
        $wikipediaURL = split('\?',$queryResult[0]->{"wikiLink"}->{"value"});
        $this->parts['content'] = array(
            "<div class='row content'>",
            "<div class='col-sm-2 sidenav'>",
            "<p><img src='".$queryResult[0]->{"image"}->{"value"}."' alt='".$queryResult[0]->{"caption"}->{"value"}."'></p>",
            "<p>".str_replace("_"," ",$dbpediaURL[count($dbpediaURL)-1])."</p>",
            "<p>".$queryResult[0]->{"description"}->{"value"}."</p>",
            "<p><a href='".$wikipediaURL[0]."'>More</a></p>",
            "</div>",
            "<div class='col-sm-8 text-left'>",
            "<div id='map'><p class='lead'>All animals spotted recently by our users !</p></div>",
            "<div id='oneAnimal'>",
            "<ul class='animalInfos'>",
            "<li><p>Type : ".$animal->getType()." </p></li>",
            // Maybe put town here, rather than coords
            "<li style='display : none;'><p>Coords : <span class='animalCoords'>".$animal->getLatitude().", ".$animal->getLongitude()."</span></p></li>",
            "<li><p>Date : ".$animal->getDDMMYYYY()." </p></li>",
            "<li><p>Uploaded by : ".$animal->getUploadedBy()." </p></li>",
            "</ul></div>",
            "</div>"
        );
        $this->parts['footer'] = "<div class='container'><p class='lead'>Did you see an animal lately ? <a href='".$this->router->getSpotUrl()."'> Tell us more !</a></p></div>";
    }

    public function debug($msg) {
        $msg = str_replace('"', '\\"', $msg); // Escaping double quotes 
        echo "<script>console.log(\"Le lien donné : $msg\")</script>";
    }

}

?>