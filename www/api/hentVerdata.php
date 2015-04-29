<?php

// hent xml fra yr og spytt viktige detaljer i json objekt:
//temp
//weathertype
//winddir
//windspeed
//precipitation

header("Content-type: application/json");

include_once("../../VerDataHandler.php");
$verDataHandler = VerDataHandler::getInstance();
$verData = $verDataHandler->getCurrentForecast();

echo $verData ? $verData : NULL;

?>