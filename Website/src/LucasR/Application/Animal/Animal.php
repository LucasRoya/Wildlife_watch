<?php

namespace LucasR\Application\Animal;

class Animal{
    private $id,$type,$latitude,$longitude,$date,$uploadBy,$usersSee,$hasPic,$description;

    public function __construct($id, $type, $latitude, $longitude, $date, $uploadBy, $usersSee, $hasPic,$description){
        $this->id = $id;
        $this->type = $type;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->date = $date;
        $this->uploadBy = $uploadBy;
        $this->usersSee = $usersSee;
        $this->hasPic = $hasPic;
        $this->description = $description;
    }

    public function getType(){
        return $this->type;
    }

    public function getId(){
        return $this->id;
    }

    public function getLatitude(){
        return $this->latitude;
    }

    public function getLongitude(){
        return $this->longitude;
    }

    public function getDDMMYYYY(){
        return split(' ',$this->date)[0];
    }

    public function getDate($lang){
        $finalDate = "";
        $numToMonthEN = array(
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );
        $numToMonthFR = array(
            '1' => 'Janvier',
            '2' => 'Février',
            '3' => 'Mars',
            '4' => 'Avril',
            '5' => 'Mai',
            '6' => 'Juin',
            '7' => 'Juillet',
            '8' => 'Août',
            '9' => 'Septembre',
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septebre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        );
        $globalDateArray = split(' ',$this->date);
        
        $monthDayArray = split('-',$globalDateArray[0]);

        switch($lang){
            case "fr":
                $finalDate .= "Rencontré : ".$monthDayArray[2];
                switch(intval($monthDayArray[2])){
                    case 1:
                        $finalDate .= "er";
                        break;
                    default:
                        $finalDate .= "";
                        break;
                }
                $finalDate .= " ".$numToMonthFR[$monthDayArray[1]]." ".$monthDayArray[0];
                break;
            default:
                $finalDate .= "Spotted : ".$monthDayArray[2];
                switch(intval($monthDayArray[2])){
                    case 1:
                        $finalDate .= "st";
                        break;
                    case 2:
                        $finalDate .= "nd";
                        break;
                    default:
                        $finalDate .= "th";
                        break;
                }
                $finalDate .= " ".$numToMonthEN[$monthDayArray[1]]." ".$monthDayArray[0];
                break;
        }
        
        
        return $finalDate;
    }

    public function getUploadedBy(){
        return $this->uploadBy;
    }

    public function getUsersSee(){
        return $this->usersSee;
    }

    public function getHasPic(){
        return $this->hasPic;
    }

    public function getDescription(){
        return $this->description;
    }

}

?> 