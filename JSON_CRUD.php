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

//    private function encodeJsonStringToJsonFile

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
        $arrayOfAllObj = $this->getAllAsArray();
        $arrayOfAllObj[count($arrayOfAllObj)] = $object;
        file_put_contents($this->jsonFilePath, json_encode($arrayOfAllObj));
        return $object;
    }

    protected function getAllAsJson() {
        return file_get_contents($this->jsonFilePath);
    }
}
