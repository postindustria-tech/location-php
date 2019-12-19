![51Degrees](https://51degrees.com/DesktopModules/FiftyOne/Distributor/Logo.ashx?utm_source=github&utm_medium=repository&utm_content=readme_main&utm_campaign=php-open-source "Data rewards the curious") **Location Service for PHP Pipeline**

[Developer Documentation](https://docs.51degrees.com?utm_source=github&utm_medium=repository&utm_content=documentation&utm_campaign=php-open-source "developer documentation")

## Introduction

A Geo location solution, backed by several different vendors, is available via the 51Degrees cloud service. 
Regardless of vendor, this currently requires longitude and latitude information from the client device, which is retrieved seamlessly by the pipeline.

#### Building

To build a pipeline containing everything required to start using geolocation, simply [obtain a resource key](https://configure.51degrees.com) and use it with the ``geolocationPipelineBuilder`` to construct a pipeline.

#### Configuration Options

 - String ``type`` - The name of the type of geolocation service to use.
 - String ``resourceKey`` - Resource Key is evidence used within the Cloud service for monitoring usage. [Obtain a resource key](https://configure.51degrees.com).
 - String ``licenceKeys`` - The license key supplied with your available product.
 - Array ``restrictedProperties`` - The properties to populate values for in the result (all are populated by default).

### Examples

Usage examples are available in ``FiftyOne.Pipeline.GeoLocation``
