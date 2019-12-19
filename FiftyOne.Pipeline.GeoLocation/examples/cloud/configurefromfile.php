<?php
/* ********************************************************************
 * Copyright (C) 2019  51Degrees Mobile Experts Limited.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 * ******************************************************************** */

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