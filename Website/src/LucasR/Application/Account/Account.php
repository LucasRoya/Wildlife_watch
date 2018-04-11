<?php

namespace LucasR\Application\Account;

class Account{
    private $username,$password,$firstname,$name,$job,$address,$age,$type;

    public function __construct($username,$password,$firstname,$name,$job,$address,$age,$type){
        $this->username = $username;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->name = $name;
        $this->job = $job;
        $this->address = $address;
        $this->age = $age;
        $this->type = $type;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function getName(){
        return $this->name;
    }

    public function getJob(){
        return $this->job;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getAge(){
        return $this->age;
    }

    public function getType(){
        return $this->type;
    }
}
?>