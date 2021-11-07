
// Minimal demo to request SRTM 90m elevation data

const locSnowdon = [53.06861, -4.07611];
const locLuccombeDown = [50.603611, -1.2025];

document.getElementById("btnElevations").addEventListener('click', event => {

    // Array to hold the locations to be processed
    let locations = [];
    // Add the locations to the array 
    locations.push(...locSnowdon);
    locations.push(...locLuccombeDown);

    // For demo purposes only, measure how long it takes to retrieve the elevations
    const tStart = performance.now(); 

    fetch('getSRTMElevationDemo.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            locations: locations, 
            doInfills: document.getElementById("infills").checked, 
            interpolate: false
        })
    })
    .then(response => response.json())
    .then(function (retval) {

        // Do something useful with retval here

        // The return value an array of elevations, so the first 
        // location's elevation value is accessed as: retval[0]

        // The remaining code here is just for the demo
        const tEnd = performance.now();

        let output = `${retval.length} elevations returned in ${Math.round((tEnd - tStart))}ms:<br>[${retval}]`;
        document.getElementById('results').innerHTML = output;
    })	
    .catch(error => {
        console.log('getElevations ' + error);
    });
});