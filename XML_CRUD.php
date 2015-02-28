<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/24/15
 * Time: 12:14 AM
 */

class XML_CRUD {

    private $loggerPath = 'external/logger/Logger.php';
    private $loggerConfigPath = '../../ServerLoggerConfig.xml';
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

    private function getNodeByExecutingXPathQuery($xPathQuery, $keepXMLOpen = NULL) {
        $this->logger->info("Getting nodes with xPath query: \n" . $xPathQuery);

        $this->openXMLFileForEditing();
        $returnNode = NULL;
        try {
            $returnNode = $this->xmlFile->xpath($xPathQuery);
        } catch (Exception $e) {
            $this->logger->fatal("Could not return node with xpath query: \n" . $e->getMessage());
        }

        if (!$keepXMLOpen) {
            $this->closeXMLFile();
        }
        return $returnNode;
    }

    // Hiding the keep alive option so development doesn't confuse the options and leave the xml file open after
    private function getNodesOfTypeByAttributeAndSubTypesWithKeepAliveOption($type, $attribute, $attrVal, $subTypes, $keepXMLOpen) { // variable $subTypes is an array of subtypes.
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attrVal, $subTypes);
        return $this->getNodeByExecutingXPathQuery($xPathQuery, $keepXMLOpen);
    }

    protected function getNodesForFurtherInteraction($type, $attribute, $attrVal, $subTypes) {
        return $this->getNodesOfTypeByAttributeAndSubTypesWithKeepAliveOption($type, $attribute, $attrVal, $subTypes, true);
    }

    protected function getNodesOfTypeByAttributeAndSubTypes($type, $attribute, $attrVal, $subTypes) {
        return $this->getNodesOfTypeByAttributeAndSubTypesWithKeepAliveOption($type, $attribute, $attrVal, $subTypes, false);
    }

    private function getNodesOfTypeWithKeepAliveOption($type, $keepXMLOpen) {
        $xPathQuery = $this->createXPathQuery($type);
        return $this->getNodeByExecutingXPathQuery($xPathQuery, $keepXMLOpen);
    }

    protected function getNodesOfType($type) {
        return $this->getNodesOfTypeWithKeepAliveOption($type, false);
    }

    protected function getNodesOfTypeForFurtherInteraction($type) {
        return $this->getNodesOfTypeWithKeepAliveOption($type, true);
    }

    protected function getNodeOfTypeByAttribute($type, $attribute, $attributeValue) {
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attributeValue);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);
    }

    // Variable $childAttributesAndValues is a 2d array with format [ [$attribute, $attributeValue], ...] Closes xml file afterwards
    protected function addChildOfTypeAndContentWithAttributesToNode($newChildType, $newChildContent = NULL, $newChildAttributesAndValues = Array(), $nodeToAddTo) {
        $newChildNode = $nodeToAddTo->addChild($newChildType, $newChildContent);

        foreach ($newChildAttributesAndValues as $newChildAttrVal) {
            try {
                $newChildNode->addAttribute($newChildAttrVal[0], $newChildAttrVal[1]);
            } catch (Exception $e) {
                $logger->fatal("Couldn't add attributes to new child node: \n" . $e->getMessage());
                $this->closeXMLFile();
                return false;
            }
        }

        $this->closeXMLFile();
        return true;
    }



}