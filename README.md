# SRTM Elevation Data in PHP
This repo contains PHP code (with a usage demo) to obtain worldwide elevation data from the freely-available 5°x5° 90m v4.1 [SRTM GeoTIFF](https://www2.jpl.nasa.gov/srtm/) data. It was written around 2010.

The core code is in  **SRTMGeoTIFFReader.php**. The other files are just for the demo, which can also be [seen here](https://www.osola.org.uk/PHP-SRTM). My home site uses this code along with [JpGraph](https://jpgraph.net/) to make [profile graphs](https://www.osola.org.uk/elevations/) of the elevations between two user-chosen locations.

The code determines which data file to read for a given location then uses file pointer arithmetic to read the elevation data from standard GEOTIFF data offsets. It is therefore orders of magnitude faster than ASCII file parsing or reading from a database. For example, my (2020) webserver returns 3378 elevations in around 30ms for the straight line between the two locations of London and Liverpool. This line is around 176 miles in length and the code calculates each elevation for every 90m (approx.) along the line.


## Getting the data files
The full set of SRTM elevation data files is downloadable from either 
[CGIAR-CSI](http://srtm.csi.cgiar.org) or Derek Watkins' [SRTM Tile Grabber](http://dwtkns.com/srtm/).
I recommend the latter as it's much more responsive and easier to use.

## Code features
The code can:

* return the single elevation in metres closest to the location **lat, lon**
* return an array of elevations for the array **(lat1, lon1, ... latN, lonN)**
* optionally include elevations for calculated intermediate locations every 
  90m along the straight line between successive pairs of locations
* optionally return a bilinear interpolation of the four elevation data points which surround each location
* return the total linear distance, ascent and descent between two or more locations

The bilinear interpolation option tends to flatten out peaks and troughs. It can make elevation graphs appear smoother over shorter distances (e.g. for hikes or cycle rides) but is arguably less accurate depending on the profile of the terrain.


## Running the demo
You will need to:
* unzip the file **GeoData/srtm_36_02.zip** into the same directory (the zip can then be discarded)
* copy all the files to a webserver running any version of PHP
* browse to index.htm


## Code usage
The basic usage is as follows:
```php
<?php 
require_once 'SRTMGeoTIFFReader.php';

$reader = new SRTMGeoTIFFReader("path/to/SRTMdatafiles");

// get the closest single elevation for a given $lat and $lon
$elevation = $reader->getElevation($lat, $lon, $interpolate = false);

// get an array of elevations for every 90m between multiple waypoints
// given an array of lats & lons as (lat1, lon1, ... latN, lonN)
$elevations = $reader->getMultipleElevations(
   $latLons, 
   $addIntermediatelatLons = true, 
   $interpolate = false
);
?>
```

Usage is described in more detail in the class itself with worked examples in the demo code files. 

Be aware that empty data (e.g. over sea areas) is stored as 0x800 and returned as -32678, so such values must be handled accordingly in your code. More details in the [SRTM FAQ](http://srtm.csi.cgiar.org/faq/). 
