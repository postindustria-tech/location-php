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



namespace fiftyone\pipeline\geolocation;

require(__DIR__ . "/vendor/autoload.php");

use fiftyone\pipeline\core\pipelineBuilder;
use fiftyone\pipeline\core\pipeline;
use fiftyone\pipeline\cloudrequestengine\cloudRequestEngine;
use fiftyone\pipeline\geolocation\geolocation;
use fiftyone\pipeline\javascriptbundler\javaScriptBundlerElement;

class geolocationPipelineBuilder extends pipelineBuilder {

    public $restrictedProperties;
    public $cache;
    public $resourceKey;
    public $licenseKey;

    public function __construct($settings){

        // Add cloudrequestEngine

        $cloud = new cloudRequestEngine();

        $cloud->setLicenseKey($settings["licenseKey"]);

        $cloud->setResourceKey($settings["resourceKey"]);

        $flowElements = [];

        $flowElements[] = $cloud;

        // Add JavaScript bundler

        $javascriptBundler = new javaScriptBundlerElement();

        $flowElements[] = $javascriptBundler;

        $geolocation = new geolocation($settings["type"]);

        $flowElements[] = $geolocation;

        // Add any extra flowElements
        
        $flowElements = array_merge($flowElements, $this->flowElements);
        
        $flowElements[] = $javascriptBundler;
        
        $this->flowElements = $flowElements;

    }

};