<?php

namespace LucasR\Framework\Authentification;
use LucasR\Framework\Request;

class AuthentificationManager{
    protected $database,$request,$auth,$isConnected;

    public function __construct(\PDO $database,Request $request){
        $this->request = $request;
        $this->auth = array();
        $this->database = $database;
    }

    public function putNewAccountRequest($username,$password,$firstname,$name,$age,$job,$address){
        $request = "INSERT INTO ACCOUNTS_WAIT (username,passwd,firstname,lastname,job,age,typ,addres) VALUES (:username,:psswrd,:firstname,:lastname,:job,:age,'standard',:addrss)";
        $stmt = $this->database->prepare($request);
        $stmt->bindValue(':username',$username);
        $stmt->bindValue(':psswrd',$password);
        $stmt->bindValue(':firstname',$firstname);
        $stmt->bindValue(':lastname',$name);
        $stmt->bindValue(':age',$age);
        $stmt->bindValue(':job',$job);
        $stmt->bindValue(':addrss',$address);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function getAllAccountRequests(){
        $request = "SELECT * FROM ACCOUNTS_WAIT";
        $stmt = $this->database->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return count($res);
    }

    public function getAllSpotRequests(){
        $request = "SELECT * FROM ANIMALS_WAIT";
        $stmt = $this->database->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return count($res);
    }

    public function checkAuth($login,$pwd){
        $request = "SELECT * FROM ACCOUNTS WHERE username = :login";
        $stmt = $this->database->prepare($request);
        $stmt->bindValue(':login',$login);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            foreach($res as $item){
                if(password_verify($pwd,$item['passwd'])){
                    $this->auth['user'] = $item;
                    $this->auth['user']['isConnected'] = true;
                    $this->request->synchronizeSession($this->auth);
                    $_POST = array();
                    return true;   
                }
            }
            return false;    
        }
        else{
            return false;
        }
    }

    public function isConnected(){
        if(key_exists('user',$_SESSION)){
            return (key_exists('isConnected',$_SESSION['user'])) ? $_SESSION['user']['isConnected'] : false;
        }
        return false;
    }

    public function isAdmin(){
        if(key_exists('user',$_SESSION) and key_exists('typ',$_SESSION['user'])){
            return $_SESSION['user']['typ'] == "admin" ;
        }
        return false;
    }
}

?>