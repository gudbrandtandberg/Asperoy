<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/26/15
 * Time: 11:46 PM
 */

// subclassing av Exception gjor at vi kan identifisere dem lenger oppe i hierarkiet

class CRUD_Exception extends Exception {
    function __construct($message){
        parent::__construct($message);
    }
};

class AuthException extends Exception {
    function __construct($message){
        parent::__construct($message);
    }
};

class JSON_CRUD {

    private $loggerPath = 'external/logger/Logger.php';
    private $loggerConfigPath = '../../ServerLoggerConfig.xml';
    protected $logger;

    private $jsonFilePath;

    function __construct($jsonPath) {
        include($this->loggerPath);
        Logger::configure($this->loggerConfigPath);
        $this->logger = Logger::getLogger("main");

        $this->jsonFilePath = $jsonPath;
    }

    private function decodeJsonFileToArray($jsonPath) {
        return json_decode(file_get_contents($jsonPath));
    }

    // For aa generere nye ider
    private function getId() {
        $newId = uniqid();
        return $newId;
    }

    private function getObjectIndex($id) {
        $objIndex = 0;
        $objArray = $this->getAllAsArray();
        for ($i = 0; $i < count($objArray); $i++) {
            $obj = (object) $objArray[$i];
            if ($obj->id === $id) {
                $objIndex = $i;
                return $objIndex;
            }
        }
        throw new CRUD_Exception("Object not found. Invalid id: " . $id);
    }

    protected function getAllAsArray() {
        return $this->decodeJsonFileToArray($this->jsonFilePath);
    }


    // Throws CRUD_Exception
    protected function getObjectById($id) {
        $arrayOfAllObj = $this->getAllAsArray();

        foreach ($arrayOfAllObj as $obj) {
            if ($obj->id === $id) {
                return $obj;
            }
        }
        // hvis vi ikke finner objektet med den iden, saa er den ikke her og vi kaster en exception for aa forhindre at vi fortsetter herfra med daarlig data
        throw new CRUD_Exception("Object not found. Invalid id: " . $id);
    }

    protected function replaceObject($object) {
        $objIndex = $this->getObjectIndex($object->id);
        $objArray = $this->getAllAsArray();
        $objArray[$objIndex] = $object;
        file_put_contents($this->jsonFilePath, json_encode($objArray));
        return json_encode($object);
    }

    protected function addObject($object) {
        $newId = $this->getId();
        $object->id = $newId;

        $arrayOfAllObj = $this->getAllAsArray();
        $arrayOfAllObj[count($arrayOfAllObj)] = $object;
        file_put_contents($this->jsonFilePath, json_encode($arrayOfAllObj));
        return json_encode($object);
    }

    protected function getAllAsJson() {
        $filecontent = file_get_contents($this->jsonFilePath);
        if (count($filecontent) == 0) { // Just in case we have an empty text file instead of any json string content
            $filecontent = "{}";
        }
        return $filecontent;
    }

    protected function deleteObjectById($id) {
        $objIndex = $this->getObjectIndex($id);
        $objArray = $this->getAllAsArray();
        array_splice($objArray, $objIndex, 1);
        file_put_contents($this->jsonFilePath, json_encode($objArray));
        return $id;
    }
}
