<?php 
require_once 'SRTMGeoTIFFReader.php';

$start = microtime(true); // speed timer

$London = array(51.5287718,-0.2420236);
$Liverpool = array(53.4122997,-3.0564834);

$dataReader = new SRTMGeoTIFFReader("GeoData");
$elevations = $dataReader->getMultipleElevations(
    array_merge($London, $Liverpool), 
    $addIntermediatelatLons = true, 
    $interpolate = false
);

const KM_TO_MILES = 1.60934;
$distanceKm = number_format($dataReader->getTotalDistance(), 1);
$miles = number_format($distanceKm/KM_TO_MILES);

$hills = $dataReader->getAscentDescent();
$ascent = number_format($hills["ascent"]);
$descent = number_format($hills["descent"]);

$elevationsCount = number_format($dataReader->getNumElevations());

$elapsed = number_format(microtime(true) - $start, 4);
?>
<html>
<head>
    <title>SRTM Elevation Data in PHP Speed Test</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="Skeleton-2.0.4/css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="main.css"> 
</head>
<body>
    <div class="container" id="container">
        <main>
            <h1>SRTM Elevation Data in PHP Speed Test</h1>
			<p>NB: 2nd and subsequent runs will be much fast due to cacheing.</p>
			<p>The straight line distance between London and Liverpool is approximately 
            <b><?php echo $distanceKm;?></b> kilometres (<b><?php echo $miles;?></b> miles).
            The line has <b><?php echo $ascent;?></b> metres of ascent and <b><?php echo $descent;?></b> metres of descent.         
            The code produced <b><?php echo $elevationsCount ;?></b> elevations every 90m (approx) along the line
            and took <b><?php echo $elapsed;?></b> seconds to run.</p>
            
            <p>The elevations returned are as follows:</p>
<pre>
<?php print_r($elevations);?>
</pre>
        </main>
    </div>  
</body>