# 51Degrees Geo-Location Engines

![51Degrees](https://51degrees.com/DesktopModules/FiftyOne/Distributor/Logo.ashx?utm_source=github&utm_medium=repository&utm_content=readme_main&utm_campaign=php-open-source "Data rewards the curious") **Pipeline API**

[Developer Documentation](https://docs.51degrees.com?utm_source=github&utm_medium=repository&utm_content=documentation&utm_campaign=php-open-source "developer documentation")

## Introduction

This repository contains the geo-location engines for the PHP implementation of the Pipeline API.

## Pre-requesites

The Pipeline engines are written in PHP and target 5 and 7.

## Packages
- **geoLocation** - A Node.js engine which retrieves geo-location results by consuming data from the 51Degrees cloud service.
- **geoLocationPipelineBuilder** - Contains the geo-location engine builders.

## Installation

You can either reference the projects in this repository or you can reference the [Composer][composer] packages in your project:

```
"require": {
    "51degrees/fiftyone.geolocation": "@dev",
    ...
```

Make sure to select the latest version from [Composer.][composer]

#### Configuration Options

 - String ``type`` - The name of the type of geolocation service to use.
 - String ``resourceKey`` - Resource Key is evidence used within the Cloud service for monitoring usage. [Obtain a resource key](https://configure.51degrees.com).
 - Array ``restrictedProperties`` - The properties to populate values for in the result (all are populated by default).

## Examples

Examples can be found in the `FiftyOne.Pipeline.GeoLocation/` folder. See below for a list of examples.

|Example|Description|Implemtation|
|-------|-----------|------------|
|gettingStarted.php|This example uses geo-location to determine the country from a longitude and latidude.|Cloud|
|configureFromFile.php|This examples creates a pipeline from a configuration file to set up geo-location.|Cloud|
|combiningServices.php|This example uses geo-location alongside device detection to determine the country and device.|Cloud|

## Project documentation

For complete documentation on the Pipeline API and associated engines, see the [51Degrees documentation site][Documentation].

[Documentation]: https://docs.51degrees.com
[composer]: https://packagist.org/packages/51degrees/fiftyone.geolocation