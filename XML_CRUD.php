<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/24/15
 * Time: 12:14 AM
 */

class XML_CRUD {

    private $loggerPath = 'external/logger/Logger.php';
    private $loggerConfigPath = '../../xmlCrudLoggerConfig.xml';
    protected $logger;

    private $xmlFile;
    private $xmlFilePath;


    function __construct($xmlPath) {
        include($this->loggerPath);
        Logger::configure($this->loggerConfigPath);
        $this->logger = Logger::getLogger("main");

        $this->xmlFilePath = $xmlPath;
    }

    private function openXMLFileForEditing() {
        try {
            $this->xmlFile = simplexml_load_file($this->xmlFilePath);
        } catch (Exception $e) {
            $this->logger->fatal("Failure when opening xml file: \n" . $e->getMessage());
        }
    }

    private function closeXMLFile() {
        try {
            $this->xmlFile->asXML($this->xmlFilePath);
        } catch (Exception $e) {
            $this->logger->fatal("Failure when saving xml file: \n" . $e->getMessage());
        }
    }

//    Methods related to XPath query creation
    private function createXPathQuery($type, $attribute = NULL, $attributeValue = NULL, $childNodes = Array()){ // format of the array childNodes: [ [$type1, $attribute1, $attributeValue1], [$type2...] ]
        $xPathQuery = $this->xPathAnywhereNodeType($type);

        if ($attribute && $attributeValue) {
            $xPathQuery = $xPathQuery . $this->xPathAttributeCondition($attribute, $attributeValue);
        }

        if (count($childNodes) > 0) {
            foreach ($childNodes as &$childNode) {
                try {
                    $xPathQuery = $xPathQuery . $this->xPathChildOfNodeType($childNode[0]);

                    if ($childNode[1] && $childNode[2]) {
                        try {
                            $xPathQuery = $xPathQuery . $this->xPathAttributeCondition($childNode[1], $childNode[2]);
                        } catch (Exception $e) {
                            $this->logger->fatal("Could not construct xpath query for childnodes and attributes: \n" . $e->getMessage());
                        }
                    }
                } catch (Exception $e) {
                    $this->logger->fatal("Could not construct xpath query of childnodes: \n" . $e->getMessage());
                }
            }
            unset($childNode);
        }

        return $xPathQuery;
    }

    private function xPathAttributeCondition($attribute, $attributeValue) {
        return "[@{$attribute}='{$attributeValue}']";
    }

    private function xPathAnywhereNodeType($nodeType) {
        return "//{$nodeType}";
    }

    private function xPathChildOfNodeType($nodeType) {
        return "/{$nodeType}";
    }
//    END Methods related to XPath query creation

    private function getNodeByExecutingXPathQuery($xPathQuery) {
        $this->logger->info("Getting nodes with xPath query: \n" . $xPathQuery);

        $this->openXMLFileForEditing();
        $returnNode = NULL;
        try {
            $returnNode = $this->xmlFile->xpath($xPathQuery);
        } catch (Exception $e) {
            $this->logger->fatal("Could not return node with xpath query: \n" . $e->getMessage());
        }

        $this->closeXMLFile();
        return $returnNode;
    }

    protected function getNodesOfType($type) {
        $xPathQuery = $this->createXPathQuery($type);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);
    }

    protected function getNodesOfTypeByAttributeAndSubTypes($type, $attribute, $attrVal, $subTypes) { // variable $subTypes is an array of subtypes.
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attrVal, $subTypes);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);
    }

    protected function getNodeOfTypeByAttribute($type, $attribute, $attributeValue) {
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attributeValue);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);

    }



}