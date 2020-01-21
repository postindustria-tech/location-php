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
 * @example cloud/configurefromfile.php
 *
 * Configure from file example of using 51Degrees geolocation.
 *
 * The example shows how to:
 *
 * 1. Create a Pipeline configuration from an JSON file.
 * ```
 * $builder = new pipelineBuilder();
 * $pipeline = $builder->buildFromConfig("./pipeline.json");
 * ```
 *
 * 2. Create a new flow data instance ready to be populated with evidence for the
 * Pipeline.
 * ```
 * $flowData = $pipeline.createFlowData();
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

use fiftyone\pipeline\geolocation\geolocationPipelineBuilder;

// Create a simple pipeline to access the engine with.
$builder = new pipelineBuilder();
$pipeline = $builder->buildFromConfig("./pipeline.json");

$flowData = $pipeline->createFlowData();

$flowData->evidence->setFromWebRequest();

$result = $flowData->process();

echo "<script>";
echo $result->get("javascriptbundler")->get("javascript");
echo "</script>";

echo "Country: " . $result->get("location")->get("country");