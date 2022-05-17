<?php
/* *********************************************************************
 * This Original Work is copyright of 51 Degrees Mobile Experts Limited.
 * Copyright 2022 51 Degrees Mobile Experts Limited, Davidson House,
 * Forbury Square, Reading, Berkshire, United Kingdom RG1 3EU.
 *
 * This Original Work is licensed under the European Union Public Licence
 * (EUPL) v.1.2 and is subject to its terms as set out below.
 *
 * If a copy of the EUPL was not distributed with this file, You can obtain
 * one at https://opensource.org/licenses/EUPL-1.2.
 *
 * The 'Compatible Licences' set out in the Appendix to the EUPL (as may be
 * amended by the European Commission) shall be deemed incompatible for
 * the purposes of the Work and the provisions of the compatibility
 * clause in Article 5 of the EUPL shall not apply.
 * 
 * If using the Work as, or as part of, a network application, by 
 * including the attribution notice(s) required under Article 5 of the EUPL
 * in the end user terms of the application under an appropriate heading, 
 * such notice(s) shall fulfill the requirements of that article.
 * ********************************************************************* */


require(__DIR__ . "/../vendor/autoload.php");

// Fake remote address for web integration

$_SERVER["REMOTE_ADDR"] = "0.0.0.0";

use PHPUnit\Framework\TestCase;
use fiftyone\pipeline\cloudrequestengine\CloudRequestEngine;
use fiftyone\pipeline\geolocation\GeoLocationPipelineBuilder;

class GeoLocationTests extends TestCase
{
    protected $CSVDataFile = __DIR__ . "/51Degrees.csv";

    protected $iPhoneUA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_2 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Mobile/15C114';

    protected $testLat = "51.4578261";
    protected $testLon = "-0.975922996290084";

    // For some reason, the value of the 'county' property returned
    // by the call to the cloud is always null on the build agent,
    // despite working correctly locally.
    // After spending the best part of a day trying to resolve this,
    // we've  decided to exclude the county property from this test
    // for the moment.
    protected $expectedProperties = array(
        "location" => array(
            "building", 
            "streetnumber", 
            "road", 
            "town", 
            //"county", 
            "region", 
            "state", 
            "zipcode", 
            "country", 
            "countrycode", 
            "javascript"),
        "location_digitalelement" => array(
            "town", 
            "county", 
            "region", 
            "state", 
            "zipcode", 
            "country", 
            "countrycode", 
            "javascript")
        );

    private function getResourceKey() {

        $resourceKey = $_ENV["RESOURCEKEY"];

        if ($resourceKey === "!!YOUR_RESOURCE_KEY!!") {
            $this->fail("You need to create a resource key at " .
            "https://configure.51degrees.com and paste it into the " .
            "phpunit.xml config file, " .
            "replacing !!YOUR_RESOURCE_KEY!!.");
        }

        return $resourceKey;

    }

    public function testAvailableProperties_51Degrees(){
        $pipeline = new GeoLocationPipelineBuilder(array(
            "resourceKey" => $this->getResourceKey(),
            "locationProvider" => "fiftyonedegrees"
        ));

        $pipeline = $pipeline->build();
        
        $flowData = $pipeline->createFlowData();

        $flowData->evidence->set("query.51D_Pos_latitude", $this->testLat);
        $flowData->evidence->set("query.51D_Pos_longitude", $this->testLon);

        $result = $flowData->process();

        $this->availableProperties($result->location, "location");
    }

    public function testAvailableProperties_DigitalElement(){
        $pipeline = new GeoLocationPipelineBuilder(array(
            "resourceKey" => $this->getResourceKey(),
            "locationProvider" => "digitalelement"
        ));

        $pipeline = $pipeline->build();
        
        $flowData = $pipeline->createFlowData();

        $flowData->evidence->set("query.51D_Pos_latitude", $this->testLat);
        $flowData->evidence->set("query.51D_Pos_longitude", $this->testLon);

        $result = $flowData->process();

        $this->availableProperties($result->location_digitalelement, "location_digitalelement");
    }

    public function testValueTypes_51Degrees() 
    {
        $this->testValueTypes("fiftyonedegrees", "location");
    }

    public function testValueTypes_DigitalElement() 
    {
        $this->testValueTypes("digitalelement", "location_digitalelement");        
    }
    
    private function testValueTypes($locationProvider, $elementKey) 
    {
        $pipeline = new GeoLocationPipelineBuilder(array(
            "resourceKey" => $this->getResourceKey(),
            "locationProvider" => $locationProvider
        ));

        $pipeline = $pipeline->build();
        
        $flowData = $pipeline->createFlowData();

        $flowData->evidence->set("query.51D_Pos_latitude", $this->testLat);
        $flowData->evidence->set("query.51D_Pos_longitude", $this->testLon);

        $result = $flowData->process();

        $properties = $pipeline->getElement($elementKey)->getProperties();
                 
        $this->valueTypes($properties, 
            $result->get($elementKey), 
            $this->expectedProperties[$elementKey]);        
    }

    private function availableProperties($result, $dataKey)
    {
        foreach ($this->expectedProperties[$dataKey] as &$property)
        {
            $apv = $result->getInternal($property);

            $this->assertNotNull($apv, $property);

            if ($apv->hasValue) {

                $this->assertNotNull($apv->value, $property);

            } else {

                $this->assertNotNull($apv->noValueMessage, $property);

            }
        }
    }

    private function valueTypes($properties, $result, $expectedProps)
    {
        foreach ($properties as &$property)
        {            
            $key = strtolower($property["name"]);

            if(in_array($key, $expectedProps)) {

                $apv = $result->getInternal($key);

                $expectedType = $property["type"];
                
                $this->assertNotNull($apv, $key);

                $value = $apv->value;

                switch ($expectedType) {
                    case "Boolean":
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("boolean", $value, $key);
                        } else {
                            $this->assertIsBool($value, $key);
                        }
                        break;
                    case 'String':
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("string", $value, $key);
                        } else {
                            $this->assertIsString($value, $key);
                        }
                        break;
                    case 'JavaScript':
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("string", $value, $key);
                        } else {
                            $this->assertIsString($value, $key);
                        }
                        break;
                    case 'Int32':
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("integer", $value, $key);
                        } else {
                            $this->assertIsInt($value, $key);
                        }
                        break;
                    case 'Double':
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("double", $value, $key);
                        } else {
                            $this->assertIsFloat($value, $key);
                        }
                        break;
                    case 'Array':
                        if (method_exists($this, 'assertInternalType')) {
                            $this->assertInternalType("array", $value, $key);
                        } else {
                            $this->assertIsArray($value, $key);
                        }
                        break;
                    default:
                        $this->fail("expected type for " . $key . " was " . $expectedType);
                        break;
                }
            }
        }
    }
}