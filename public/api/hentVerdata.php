<?php

// hent xml fra yr og spytt viktige detaljer i json objekt:
//temp
//weathertype
//winddir
//windspeed
//precipitation


header("Content-type: application/json");

$xml_handle = simplexml_load_file("http://www.yr.no/sted/Norge/Aust-Agder/Lillesand/Just%C3%B8y~2960/varsel.xml");
if ($xml_handle !== FALSE){
    
    //hent ut interresant data fra $xml_handle med XML_CRUD
    
    $liksomData = Array("temp" => 20, "weathertype" => "PARTLY_CLOUDY_DAY", "precipitation" => 2, "winddir" => 180, "windspeed" => 20);
    echo json_encode($liksomData);
}

?>