<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 3/8/15
 * Time: 11:17 PM
 */

include_once('XML_CRUD.php');

class VerDataHandler extends XML_CRUD {

    public static function getInstance() {

        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    function __construct() {
        parent::__construct("http://www.yr.no/sted/Norge/Aust-Agder/Lillesand/Just%C3%B8y~2960/varsel.xml");
    }

    public function getCurrentForecast(){
        date_default_timezone_set("Europe/Oslo");
        $times = $this->getNodesOfTypeByAttributeAndSubTypes("tabular", NULL, NULL, [["time"]]);
        $currentForecast = $times[0];

        $temperatureAttr = $currentForecast->temperature->attributes(); //value
        $precipitationAttr = $currentForecast->precipitation->attributes(); //value
        $windDirectionAttr = $currentForecast->windDirection->attributes(); //deg
        $windSpeedAttr = $currentForecast->windSpeed->attributes(); //mps

        $symbolAttr = $currentForecast->symbol->attributes(); //name
        $verType = $symbolAttr["name"];
        $weatherType = "PARTLY_CLOUDY_DAY";
        if ($verType == "Skyet") {
            $weatherType = "CLOUDY";
        } else if ($verType == "Delvis skyet") {
            if (date("H") > 21){
                $weatherType = "PARTLY_CLOUDY_NIGHT";
            }
            else{
                $weatherType = "PARTLY_CLOUDY_DAY";
            }
        } else if ($verType == "Regn") {
            $weatherType = "RAIN";
        } else if ($verType == "Lettskyet") {
            if (date("H") > 21){
                $weatherType = "PARTLY_CLOUDY_NIGHT";
            }
            else{
                $weatherType = "PARTLY_CLOUDY_DAY";
            }
        } else if ($verType == "Lett regn") {
            $weatherType = "SLEET";
        } else if ($verType == "Kraftig regn") {
            $weatherType = "RAIN";
        } else if ($verType == "Regnbyger") {
            $weatherType = "RAIN";
        } else if ($verType == "Lette regnbyger") {
            $weatherType = "SLEET";
        } else if ($verType == "Klarvær") {
            if (date("H") > 21){
                $weatherType = "CLEAR_NIGHT";
            }
            else{
                $weatherType = "CLEAR_DAY";
            }
        }

        if ((int)$windSpeedAttr["mps"] > 15) {
            $weatherType = "WINDY";
        }

        return json_encode(Array("temp" => (string)$temperatureAttr["value"], "weathertype" => $weatherType, "precipitation" => (string)$precipitationAttr["value"], "winddir" => (string)$windDirectionAttr["deg"], "windspeed" => (string)$windSpeedAttr["mps"]));
    }
}