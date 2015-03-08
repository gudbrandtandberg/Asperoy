<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/26/15
 * Time: 11:33 PM
 */

include("JSON_CRUD.php");
include("model/Event.php");

class KalenderController extends JSON_CRUD {

    private $eventsJsonPath = "../../model/events.json";

    public static function getInstance() {

        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    function __construct() {
        parent::__construct("../../model/events.json");
    }

    public function getAllEventsAsJson() {
        return $this->getAllAsJson();
    }

    public function addEvent($title, $start, $end, $creator, $details = NULL) {
        $newEvent = new Event($title, $start, $end, $creator, $details);
        $id = $this->addObject($newEvent);
        return $id;
    }

    public function deleteEventById($id, $deleter) {
        $event = (object) $this->getObjectById($id);
        if ($deleter === $event->creator) {
            $this->deleteObjectById($id);
            return $id;
        }
        return null;
    }

}