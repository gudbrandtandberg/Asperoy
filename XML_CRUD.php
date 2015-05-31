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

    function __construct($xmlPath = NULL, $xmlString = NULL) {
        include_once($this->loggerPath);
        Logger::configure($this->loggerConfigPath);
        $this->logger = Logger::getLogger("main");

        if ($xmlPath) {
            $this->xmlFilePath = $xmlPath;
            $this->xmlFile = simplexml_load_file($this->xmlFilePath);
        } else if ($xmlString) {
            $this->xmlFile = simplexml_load_string($xmlString);
        }
    }

	private function reloadXMLFile() {
$this->logger->info("reloadxml!!");
		if(!$this->xmlFile) {
			$this->xmlFile = simplexml_load_file($this->xmlFilePath);
$this->logger->info("Naa er det en xml fil der vel!");
		}
	}

    private function saveXMLFile() {
        try {
            $this->xmlFile->asXML($this->xmlFilePath);
        } catch (Exception $e) {
//            $this->logger->fatal("Failure when saving xml file: \n" . $e->getMessage());
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
                    if (count($childNode) > 2) {
                        try {
                            $xPathQuery = $xPathQuery . $this->xPathAttributeCondition($childNode[1], $childNode[2]);
                        } catch (Exception $e) {
//                            $this->logger->fatal("Could not construct xpath query for childnodes and attributes: \n" . $e->getMessage());
                        }
                    }
                } catch (Exception $e) {
//                    $this->logger->fatal("Could not construct xpath query of childnodes: \n" . $e->getMessage());
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

        $returnNode = NULL;
	$this->logger->info($this->xmlFilePath);
//	$this->reloadXMLFile();
        try {
            $returnNode = $this->xmlFile->xpath($xPathQuery);
        } catch (Exception $e) {
            $this->logger->fatal("Could not return node with xpath query: \n" . $e->getMessage());
        }
$this->logger->info("Got the node!");
        return $returnNode;
    }

    // Hiding the keep alive option so development doesn't confuse the options and leave the xml file open after
    protected function getNodesOfTypeByAttributeAndSubTypes($type, $attribute, $attrVal, $subTypes) { // variable $subTypes is an array of subtypes.
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attrVal, $subTypes);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);
    }

    protected function getNodesOfType($type) {
        $xPathQuery = $this->createXPathQuery($type);
        return $this->getNodeByExecutingXPathQuery($xPathQuery);
    }

    protected function getNodeOfTypeByAttribute($type, $attribute, $attributeValue) {
$this->logger->info( "get node of type by attribute called!");
        $xPathQuery = $this->createXPathQuery($type, $attribute, $attributeValue);
        $returnNode = $this->getNodeByExecutingXPathQuery($xPathQuery);

$this->logger->info("hvis dette blir logget saa har vi faatt tak i noden!");
return $returnNode;
    }

    // Variable $childAttributesAndValues is a 2d array with format [ [$attribute, $attributeValue], ...] Closes xml file afterwards
    protected function addChildOfTypeAndContentWithAttributesToNode($newChildType, $newChildContent = NULL, $newChildAttributesAndValues = Array(), $nodeToAddTo) {
        $newChildNode = $nodeToAddTo->addChild($newChildType, $newChildContent);

        foreach ($newChildAttributesAndValues as $newChildAttrVal) {
            try {
                $newChildNode->addAttribute($newChildAttrVal[0], $newChildAttrVal[1]);
            } catch (Exception $e) {
//                $logger->fatal("Couldn't add attributes to new child node: \n" . $e->getMessage());
                return false;
            }
        }

        $this->saveXMLFile();
        return true;
    }
    
    protected function removeChildOfTypeWithAttributesFromNode($nodeType, $attribute, $attributeValue) {
        
        $query = $this->createXPathQuery($nodeType, $attribute, $attributeValue);
        $toDelete = $this->getNodeByExecutingXPathQuery($query);
        unset($toDelete[0][0]);
        $this->saveXMLFile();
    }

    protected function updateNodeAttributes($nodeType, $attribute, $attributeValue, $attributeAndNewValue = Array()) {
        $updateNode = $this->getNodeOfTypeByAttribute($nodeType, $attribute, $attributeValue)[0];
        $updateNode[$attributeAndNewValue[0]] = $attributeAndNewValue[1];
        $this->saveXMLFile();
        return true;
    }
}
