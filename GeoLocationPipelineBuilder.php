/* *********************************************************************
 * This Original Work is copyright of 51 Degrees Mobile Experts Limited.
 * Copyright 2023 51 Degrees Mobile Experts Limited, Davidson House,
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

namespace fiftyone\pipeline\geolocation;

use fiftyone\pipeline\core\PipelineBuilder;
use fiftyone\pipeline\cloudrequestengine\CloudRequestEngine;
use fiftyone\pipeline\geolocation\GeoLocationCloud;

/**
* Extension of pipelineBuilder class that allows for the quick generation
* of a geolocation pipeline.
*/
class GeoLocationPipelineBuilder extends PipelineBuilder
{
    public $restrictedProperties;
    public $cache;
    public $resourceKey;
    public $licenseKey;

    /**
     * @param {Array} settings
     * @param {String} settings.resourceKey
     * @param {String} settings.cloudEndPoint custom endpoint for the cloud service
     * @param {Array} settings.restrictedProperties (list of properties to restrict the results to)
     * @param {String} options.cloudRequestOrigin value to use for the 
     * Origin header when sending requests to cloud.
    **/
    public function __construct($settings)
    {
        parent::__construct($settings);

        // Translate the cloud options with different names
        if(array_key_exists("cloudEndPoint", $settings)) {
            $settings["baseURL"] = $settings["cloudEndPoint"];
        }
                
        // Add cloudrequestEngine
        $cloud = new CloudRequestEngine($settings);

        $flowElements = [];

        $flowElements[] = $cloud;

        $geolocation = new GeoLocationCloud($settings);

        $flowElements[] = $geolocation;

        // Add any extra flowElements

        $flowElements = array_merge($flowElements, $this->flowElements);

        $this->flowElements = $flowElements;
    }
};
