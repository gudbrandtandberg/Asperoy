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
        $objectAdded = $this->addObject($newEvent);
        return $objectAdded;
    }

    public function getFirstEvent() {
        $eventTest = new Event();
        $eventTest->title = "TEST EVENT";
        $eventTest->creator = "me";
        $eventTest->start = "2015-05-17";
        $eventTest->end = "2015-05-18";
        $arrayEventTest = Array($eventTest);
        file_put_contents($this->eventsJsonPath, json_encode($arrayEventTest));

//        $testArr = json_decode(file_get_contents($this->eventsJsonPath));

//        $this->logger->info($testArr["title"]);
//        foreach ($testArr as $event) {
//            $this->logger->info($event->title);
//        }
//
        return '{"testId":{"title": "testEvent","start": "2015-05-17","end": "2015-05-18"}}';
//        $allEvents = $this->getAll();
//        return $allEvents["testId"];
    }

}