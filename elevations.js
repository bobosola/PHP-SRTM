
// jQuery in 2020! I should be ashamed of myself.

$(document).ready(function(){

    $('#btnGetElevation').click(function() {

        $('#nag').hide();
        $('#googleMaps').hide();

        var lat = $('#userLat').val();
        var lon = $('#userLon').val();

        if(!lat || !lon) {
            $('#nag').show(); 
            return;
        }

        $.ajax({
            type: "POST",                          
            url: "getSRTMElevationDemo.php",         
            data: {lat:lat, lon:lon},
            success: function(elevation){
                $('#el').html(elevation);
            }           
        });  
        
        var googleMapsURL = "https://maps.google.com/?q=" 
        + lat + "," + lon + "&ll="
        + lat + "," + lon + "&z=5";
        $('#googleLink').attr("href", googleMapsURL);
        $('#googleMaps').show();        
    });                               
});