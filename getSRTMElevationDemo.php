<?php 
 
/*
This is the simplest use case: one location returning one elevation
It uses POST because GET strings can be cached and cause problems.
*/

require_once 'SRTMGeoTIFFReader.php';

$lat = $_POST['lat'];
$lon = $_POST['lon'];
$dataReader = new SRTMGeoTIFFReader("GeoData"); // SRTM file path

/*
Get the elevation for the single data point nearest to the location.
*/
echo $dataReader->getElevation($lat, $lon, $interpolate = false);

/*
For multiples of locations & elevations, use something like:

$elevations = $dataReader->getMultipleElevations(
   $latLons, 
   $addIntermediatelatLons = true, 
   $interpolate = true
)

$latLons is an array of pairs of lats & lons as {lat 1, lon 1, ... lat n, lon n}
to represent {location 1 ... location n}
   
`$addIntermediatelatLons` optionally calculates the elevations for every
90m (approx) along a straight line between each successive pair locations.
Use it for getting the all the elevations between two or more waypoints
or to produce an elevation graph data source for multiple locations.
    
`$interpolate` optionally bilinearly interpolates the 4 nearest data points
surrounding each location. This can be useful for smoothing graphs but it
requires 4x the data reads and is arguably no more (and possibly less)
accurate than using the nearest single elevation. It will round down peaks
so the accuracy of results will vary with the shape of the terrain.

An array of elevations is returned in all cases.
*/
?> 