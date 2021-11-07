<?php

require_once('SRTMGeoTIFFReader.php');

// Receive the data from a JSON string request as:
// {locations: [lat1, lon1 .. latn, lonn], doInfills: bool, interpolate: bool}
$request = json_decode(file_get_contents("php://input"));

// Set up the data reader with the path to the directory containg SRTM data files
$dataReader = new SRTMGeoTIFFReader("GeoData"); // SRTM data file path

$elevations = $dataReader->getMultipleElevations(
   $request->locations, 
   $request->doInfills, 
   $request->interpolate 
);

header('Content-type: application/json');
echo json_encode($elevations);