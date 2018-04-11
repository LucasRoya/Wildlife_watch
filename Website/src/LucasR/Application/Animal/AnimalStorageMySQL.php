<?php

namespace LucasR\Application\Animal;

use LucasR\Application\Animal\AnimalStorage;
use LucasR\Application\Animal\Animal;

class AnimalStorageMySQL implements AnimalStorage{
    private $db;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function getOne($id){
        $request = "SELECT * FROM ANIMALS WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue('id',intval($id),\PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            foreach($res as $item){
                return new Animal($item['Id'],$item['typ'],$item['Latitude'],$item['Longitude'],$item['dat'],$item['UploadBy'],$item['UsersSee'],$item['HasPic'],$item['descript']);
            }
        }
        else{
            return null;
        }
    }

    public function getFiveMRA(){
        $animals = array();
        $request = "SELECT * FROM ANIMALS ORDER BY Id DESC LIMIT 5";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            foreach($res as $item){
                array_push($animals,new Animal($item['Id'],$item['typ'],$item['Latitude'],$item['Longitude'],$item['dat'],$item['UploadBy'],$item['UsersSee'],$item['HasPic'],$item['descript']));
            }
            return $animals;
        }
        else{
            return null;
        }
    }

    public function getAll(){
        $animals = array();
        $request = "SELECT * FROM ANIMALS";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            foreach($res as $item){
                array_push($animals,new Animal($item['Id'],$item['typ'],$item['Latitude'],$item['Longitude'],$item['dat'],$item['UploadBy'],$item['UsersSee'],$item['HasPic'],$item['descript']));
            }
            return $animals;
        }
        else{
            return null;
        }
    }

    public function getOneSpotRequest($id){
        $request = "SELECT * FROM ANIMALS_WAIT WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue('id',intval($id),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllSpotRequests(){
        $request = "SELECT * FROM ANIMALS_WAIT";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function willAppear(Animal $animal){
        $request = "SELECT UsersSee FROM ANIMALS WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $data = array(':id',$animal->getId());
        $stmt->execute($data);
        $res = $stmt->fetch();
        if(count($res) > 0){
            if($res[0] == 'All'){
                return True;
            }
            else{
                return False;
            }
        }
        else{
            return False;
        }
    }

    public function getAllSpecies(){
        $request = "SELECT DISTINCT(typ) FROM ANIMALS";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function getAllAnimalsGivingType($type){
        $request = "SELECT * FROM ANIMALS WHERE typ = :typ";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':typ',$type);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addSpotRequest($type,$latlng,$date,$hasPic,$user,$description){
        $request = "INSERT INTO ANIMALS_WAIT (Id,typ,Latitude,Longitude,dat,UploadBy,UsersSee,HasPic,descript) VALUES (0,:typ,:lat,:lng,:dat,:uploadby,'all',:haspic,:descript)";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':typ',$type);
        $stmt->bindValue(':lat',split(', ',$latlng)[0]);
        $stmt->bindValue(':lng',split(', ',$latlng)[1]);
        $stmt->bindValue(':dat',$date);
        $stmt->bindValue(':uploadby',$user);
        $stmt->bindValue(':haspic',$hasPic);
        $stmt->bindValue(':descript',$description);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function eraseSpotRequest($id){
        $request = "DELETE FROM ANIMALS_WAIT WHERE Id = :id";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id',$id);
        return $stmt->execute();
    }

    public function addFinalSpot($id){
        $res = $this->getOneSpotRequest($id);
        $request = "INSERT INTO ANIMALS (Id,typ,Latitude,Longitude,dat,UploadBy,UsersSee,HasPic,descript) VALUES (0,:typ,:lat,:lng,:dat,:uploadby,'all',:haspic,:descript)";
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':typ',$res[0]['typ']);
        $stmt->bindValue(':lat',$res[0]['Latitude']);
        $stmt->bindValue(':lng',$res[0]['Longitude']);
        $stmt->bindValue(':dat',$res[0]['dat']);
        $stmt->bindValue(':uploadby',$res[0]['UploadBy']);
        $stmt->bindValue(':haspic',$res[0]['HasPic']);
        $stmt->bindValue(':descript',$res[0]['descript']);
        return $stmt->execute();
    }
}

?> 