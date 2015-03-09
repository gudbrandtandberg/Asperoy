<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/26/15
 * Time: 11:46 PM
 */

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

    private function getId() {
        $newId = uniqid();
        while ($this->getObjectById($newId)) {
            $newId = uniqid();
        }
        return $newId;
    }

    protected function getAllAsArray() {
        return $this->decodeJsonFileToArray($this->jsonFilePath);
    }

    protected function getObjectById($id) {
        $arrayOfAllObj = $this->getAllAsArray();

        foreach ($arrayOfAllObj as $obj) {
            if ($obj->id === $id) {
                return $obj;
            }
        }
        return null;
    }

    protected function addObject($object) {
        $newId = $this->getId();
        $object->id = $newId;

        $arrayOfAllObj = $this->getAllAsArray();
        $arrayOfAllObj[count($arrayOfAllObj)] = $object;
        file_put_contents($this->jsonFilePath, json_encode($arrayOfAllObj));
        return $newId;
    }

    protected function getAllAsJson() {
        $filecontent = file_get_contents($this->jsonFilePath);
        if (count($filecontent) == 0) {
            $filecontent = "{}";
        }
        return $filecontent;
    }

    protected function deleteObjectById($id) {
        // sjekker for god id
        if (!$this->getObjectById($id)) {
            return null;
        }

        $objIndex = 0;
        $objArray = $this->getAllAsArray();
        for ($i = 0; $i < count($objArray); $i++) {
            $obj = (object) $objArray[$i];
            if ($obj->id === $id) {
                $objIndex = $i;
                break; // object index found, get out of loop
            }
        }
        array_splice($objArray, $objIndex, 1);
        file_put_contents($this->jsonFilePath, json_encode($objArray));
        return $id;
    }
}
