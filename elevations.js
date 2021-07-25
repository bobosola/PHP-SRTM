
window.onload = (e) => {
	document.getElementById('btnGetElevation').addEventListener('click', function(e) {
		
		let lat = document.getElementById('userLat').value
		let lon = document.getElementById('userLon').value

		if(!lat || !lon) {
			alert('Both lat and long values are required.');
			return;
		}
		
		const data = "lat=" + lat + "&lon=" + lon;
		return fetch('getSRTMElevationDemo.php', {
			method: 'POST',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			body: data
		})
		.then (response => response.text())
		.then (function(text) {
			let googleMapsURL = "https://maps.google.com/?q=" 
			+ lat + "," + lon 
			+ "&ll=" + lat + "," + lon 
			+ "&z=5";
			
			document.getElementById('el').innerHTML = text;
			document.getElementById('googleLink').setAttribute('href', googleMapsURL); 
			document.getElementById('googleMaps').style.display = 'block'		
		});
	});
}
