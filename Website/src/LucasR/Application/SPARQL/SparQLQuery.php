<?php

namespace LucasR\Application\SPARQL;

class SparQLQuery{
    private $format,$baseSite,$baseURL,$query,$params,$queryPart,$lang;

    public function __construct($lang){
        $this->baseSite = "http://dbpedia.org";
        $this->baseURL = "https://dbpedia.org/sparql";
        $this->format = "application/sparql-results+json";
        $this->queryPart = "?";
        $this->lang = $lang;
    }

    public function execute($animalType){
        switch($animalType){
            case "Boar":
                $animalType = "Wild boar";
                break;
            case "Stork":
                $this->lang = "en";
                break;
            default:
                break;
        } 

        $sparqlURL = $this->baseURL;

        $queryURL = $this->queryPart;

        $this->query = "PREFIX dbo: <http://dbpedia.org/ontology/> PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> select ?animal ?image ?caption ?description ?wikiLink where {?animal rdfs:label \"".$animalType."\"@en. ?animal rdfs:comment ?description. ?animal dbo:thumbnail ?image. ?animal dbp:imageCaption ?caption. ?animal prov:wasDerivedFrom ?wikiLink. FILTER(LANG(?description) = \"\" || LANGMATCHES(LANG(?description), \"".$this->lang."\")).}";

        $this->params=array(
            "default-graph-uri" =>  $this->baseSite,
            "query" =>  $this->query,
            "format" =>  $this->format,
            "CXML_redir_for_subjs" => "121",
            "CXML_redir_for_hrefs" => "",
            "timeout" => "30000",
            "debug" => "on",
            "run" => "+Run+Query+"
        );
        foreach($this->params as $name => $value){
            if($name == 'run'){
                $queryURL .= $name."=".urlencode($value);
            }
            else{
                $queryURL .= $name."=".urlencode($value)."&";
            }
            
        }
        $sparqlURL .= $queryURL;

        $proxy = "http://proxy.unicaen.fr:3128";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_PROXY, $proxy);
        curl_setopt($curl, CURLOPT_URL, $sparqlURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $dataJson = json_decode($data);
        $dataJsonResults = $dataJson->{"results"}->{"bindings"};
        
        return $dataJsonResults;
    }
}

?> 