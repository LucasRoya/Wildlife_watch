<?php

namespace LucasR\Application\Account;

use LucasR\Application\Account\AccountStorage;
use LucasR\Application\Account\Account;

class AccountStorageMySQL implements AccountStorage{
    private $db;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function getPDO(){
        return $this->db;
    }

    public function getAccountInfo($username){
        $request = "SELECT * FROM ACCOUNTS WHERE username = :username";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':username',$username);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            return $res;
        }
        else{
            return "none";
        }
    }

    

    public function getOneAccountRequest($id){
        $request = "SELECT * FROM ACCOUNTS_WAIT WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id',intval($id),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllAccountRequests(){
        $request = "SELECT * FROM ACCOUNTS_WAIT";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function eraseAccountRequest($id){
        $request = "DELETE FROM ACCOUNTS_WAIT WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function addFinalAccount($id){
        $res = $this->getOneAccountRequest($id);
        var_dump($res);
        $request = "INSERT INTO ACCOUNTS (username,passwd,firstname,lastname,job,addres,age,typ) VALUES (:username,:psswrd,:firstname,:lastname,:job,:addrss,:age,'standard')";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':username',$res[0]['username']);
        $stmt->bindValue(':psswrd',password_hash($res[0]['passwd'],PASSWORD_DEFAULT));
        $stmt->bindValue(':firstname',$res[0]['firstname']);
        $stmt->bindValue(':lastname',$res[0]['lastname']);
        $stmt->bindValue(':job',$res[0]['job']);
        $stmt->bindValue(':addrss',$res[0]['addres']);
        $stmt->bindValue(':age',$res[0]['age']);
        if($stmt->execute()){
            var_dump('ça marche');
            $this->eraseAccountRequest($id);
            return true;
        }
        else{
            var_dump($this->db->errorInfo());
            var_dump("non");
            return false;
        }
    }

    public function addAccountRequest(Account $account){
        $request = "INSERT INTO ACCOUNTS_WAIT (username,passwd,firstname,lastname,job,age,typ,addres) VALUES (:username,:psswrd,:firstname,:lastname,:job,:age,'standard',:addrss)";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':username',$account->getUsername());
        $stmt->bindValue(':psswrd',$account->getPassword());
        $stmt->bindValue(':firstname',$account->getFirstname());
        $stmt->bindValue(':lastname',$account->getName());
        $stmt->bindValue(':age',$account->getAge());
        $stmt->bindValue(':job',$account->getJob());
        $stmt->bindValue(':addrss',$account->getAddress());
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function deleteAccount($username){

    }

    public function deleteAccountRequest($username){

    }

    public function modifyAccount(Account $account){
        
    }
}

?>