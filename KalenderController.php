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

    private function isCreator($eventId, $bruker) {
        $event = (object) $this->getObjectById($eventId);
        return $event->creator === $bruker;
    }

    public function getAllEventsAsJson() {
        return $this->getAllAsJson();
    }

    // Skaffer deg alle eventer som json streng sortert etter start dato
    public function getAllEventsAsJsonSorted() {
        date_default_timezone_set('UTC');
        $eventArray = $this->getAllAsArray();

        usort($eventArray, function($a, $b) {
            return strtotime($a->start) - strtotime($b->start);
        });
        return json_encode($eventArray);
    }

    // lager et event php objekt av parameterne og legger det til i json listen med andre eventer.
    public function addEvent($title, $start, $end, $creator, $details = NULL) {
        $newEvent = new Event($title, $start, $end, $creator, $details);
        $obj = $this->addObject($newEvent);
        return $obj; //svarer med en json av eventen naar lagring gaar bra
    }

    // sletter eventer med id
    public function deleteEventById($id, $bruker) {
        if (!$this->isCreator($id, $bruker))
            throw new AuthException("User " . $bruker . " does not have creator privileges.");

        $this->deleteObjectById($id);
        return $id; //svarer med iden til den slettede eventen hvis alt gaar bra
    }

    // oppdater en event med en hel jsonstreng
    public function updateEvent($eventJSON, $bruker) {
        $event = (object) json_decode($eventJSON);
        $id = $event->id;
        if (!$this->isCreator($id, $bruker))
            throw new AuthException("User " . $bruker . " does not have creator privileges.");
        return $this->replaceObject($event);
    }
}