<?php
/* *********************************************************************
 * This Original Work is copyright of 51 Degrees Mobile Experts Limited.
 * Copyright 2019 51 Degrees Mobile Experts Limited, 5 Charlotte Close,
 * Caversham, Reading, Berkshire, United Kingdom RG4 7BY.
 *
 * This Original Work is licensed under the European Union Public Licence (EUPL) 
 * v.1.2 and is subject to its terms as set out below.
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

/**
 * @example cloud/gettingstarted.php
 *
 * Example of using the 51Degrees geo-location Cloud to determine the country and device for a given longitude and latitude.
 * 
 * This example is available in full on [GitHub](https://github.com/51Degrees/location-php/blob/release/v4.1.0/examples/cloud/gettingstarted.js). 
 * (During the beta period, this repository will be private. 
 * [Contact us](mailto:support.51degrees.com) to request access) 
 *
 * To run this example, you will need to create a **resource key**. 
 * The resource key is used as short-hand to store the particular set of 
 * properties you are interested in as well as any associated license keys 
 * that entitle you to increased request limits and/or paid-for properties.
 *
 * You can create a resource key using the 51Degrees [Configurator](https://configure.51degrees.com).
 *
 * The example shows how to:
 *
 * 1. Build a new Pipeline to use cloud geolocation engine.
 * ```
 * $builder = new geoLocationPipelineBuilder(array(
 *     // Obtain a resource key from https://configure.51degrees.com
 *     "resourceKey" => "",
 *     "type" => "location",
 *     "restrictedProperties" => array() // All properties by default
 * ));
 * $pipeline = $builder->build();
 * ```
 *
 * 2. Create a new flow data instance ready to be populated with evidence for the
 * Pipeline.
 * ```
 * $flowData = pipeline->createFlowData();
 * ```
 *
 * 3. Process an HTTP request to retrieve the values associated
 * with the request for the selected properties.
 * ```
 * $flowData->evidence->setFromWebRequest();
 * $result = $flowData->process();
 * ```
 *
 * 4. Extract the value of a property as a string from the results.
 * ```
 * echo "Country: " . $result->get("location")->get("country");
 * ```
 *
 * 5. Add the JavaScript required to get extra information from the device. This is
 * needed to get the longitude and latitude.
 * ```
 * echo "<script>";
 * echo $result->get("javascriptbundler")->get("javascript");
 * echo "</script>";
 * ```
 */

require(__DIR__ . "/../../vendor/autoload.php");

use fiftyone\pipeline\geolocation\geoLocationPipelineBuilder;

// Create a simple pipeline to access the engine with.
$builder = new geoLocationPipelineBuilder(array(
    // Obtain a resource key from https://configure.51degrees.com
    "resourceKey" => "",
    "locationProvider" => "fiftyonedegrees",
    "restrictedProperties" => array() // All properties by default
));
$pipeline = $builder->build();

$flowData = $pipeline->createFlowData();

$flowData->evidence->setFromWebRequest();

$result = $flowData->process();

echo "<script>";
echo $result->get("javascriptbundler")->get("javascript");
echo "</script>";

echo "Country: " . $result->get("location")->get("country")->value;