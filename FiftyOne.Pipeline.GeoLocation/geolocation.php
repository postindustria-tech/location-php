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

use fiftyone\pipeline\engines\aspectDataDictionary;
use fiftyone\pipeline\engines\engine;

class geolocation extends engine {

    // Type - location or osm_location
    public function __construct($type){

        $this->dataKey = $type;

    }

    public function processInternal($flowData) {

        if(count($this->properties) === 0){

            $cloudProperties = $flowData->get("cloud")->get("properties");

            if(isset($cloudProperties["Products"][$this->dataKey])){

                $cloudProperties = $cloudProperties["Products"][$this->dataKey]["Properties"];

                foreach ($cloudProperties as $property){

                    $propertyName = strtolower($property["Name"]);
    
                    $this->properties[$propertyName] = $property;
    
                }
    
                $this->updatePropertyList();

            }

        }

        $cloudData = $flowData->get("cloud")->get("cloud");

        if($cloudData){

            $cloudData = \json_decode($cloudData, true);

            $deviceData = $cloudData[$this->dataKey];

            $data = new aspectDataDictionary($this, $deviceData);
            
            $flowData->setElementData($data);

        }

        return;

    }

}

