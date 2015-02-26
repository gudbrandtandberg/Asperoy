<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/26/15
 * Time: 11:33 PM
 */

include("JSON_CRUD.php");

class KalenderController extends JSON_CRUD {

    private $eventsJsonPath = "model/events.json";

    public static function getInstance() {

        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }



}