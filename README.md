# SRTM Elevation Data in PHP

[**October 2024 update** - It appears that the SRTM 3 arc second (90m) data files are now almost impossible to obtain, so I cannot recommend anyone use this (now very old) code. I will leave it up here in case anyone manages to find a source of such files or wants to use it as a base to get ideas for reading other elevation data formats]

[**November 2021 update** - *the demo site has been updated to use more current JS & PHP techniques and therefore no longer supports Internet Explorer. The main SRTM PHP reader class has also had a minor bugfix.*]

This repo contains PHP code with a usage demo to obtain worldwide elevation data from the freely-available 5°x5° 90m v4.1 [SRTM GeoTIFF](https://www2.jpl.nasa.gov/srtm/) data. It was written around 2010 so may require some updating for modern PHP practices.

For Great Britain only, the GitHub repo [OSTerrain50-PHP](https://github.com/bobosola/OSTerrain50-PHP) contains similar functionality but instead uses the OS Terrain 50 data set. This is a better option for those interested in obtaining elevation data for Great Britain - see the [author's OS Terrain 50](https://osola.org.uk/osterrain50) page for more details.

The PHP core code in this repo is in  **SRTMGeoTIFFReader.php**. The other files are just for the demo, which can also be seen live on the author's [demo site](https://www.osola.org.uk/PHP-SRTM). Another demo on the author's site uses this code along with [JpGraph](https://jpgraph.net/) to make [elevation profile graphs](https://www.osola.org.uk/srtm/) between two user-chosen locations.

The code determines which SRTM data file to read for a given location then uses file pointer arithmetic to read the elevation data from standard GEOTIFF data offsets. It is therefore orders of magnitude faster than ASCII file parsing or reading from a database.


## Getting the data files
**Oct 2024: these sources are now dead - see update note at page top** ~~The full set of SRTM elevation data files is downloadable from either [CGIAR-CSI](http://srtm.csi.cgiar.org) or Derek Watkins' [SRTM Tile Grabber](http://dwtkns.com/srtm/). I recommend the latter as it's much more responsive and easier to use.~~

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
* unzip the file **GeoData/srtm_36_02.zip** into the same directory (GeoData) - the zip can then be discarded
* copy all the files to a webserver running PHP
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
// given an array of lats & lons as [lat1, lon1, ... latN, lonN]
$elevations = $reader->getMultipleElevations(
   $latLons, 
   $addIntermediatelatLons = true, 
   $interpolate = false
);
?>
```

Usage is described in more detail in the class code. 

Be aware that areas of no data (e.g. over sea areas) are stored as 0x800 and returned as -32678, so such values must be handled accordingly in your code. More details in the [SRTM FAQ](http://srtm.csi.cgiar.org/faq/). 
