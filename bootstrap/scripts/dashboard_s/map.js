var center = new google.maps.LatLng(24.886436490787712, -70.2685546875);
function initialize()
{
	var mapProp = {
					  center: center,
					  zoom: 5,
					  mapTypeId:google.maps.MapTypeId.TERRAIN
				  };
	var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

	var outerCoords = [
	                      new google.maps.LatLng(25.774252, -80.190262),
	                      new google.maps.LatLng(18.466465, -66.118292),
	                      new google.maps.LatLng(32.321384, -64.75737)
	                  ];
	// Construct the polygon
    var bermudaTriangle = new google.maps.Polygon({
      paths: outerCoords,
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35
    });
    //alert(new google.maps.MVCArray.getArray(bermudaTriangle.getPaths()));
    //var test = bermudaTriangle.getPaths();
    //alert(test);
    bermudaTriangle.setMap(map);

    
    generateMarkers(bermudaTriangle,map,5,outerCoords);
}

function generateMarkers(polygon,map,ctr,boundaries)
{
	var pointInt = 0;
	var mark = new Array();
	var marker = new Array();
	var infowindow = new Array();
	var infoListener = new Array();
	while (pointInt < ctr)
	{
		mark[pointInt] = new google.maps.LatLng(getRandomInRange(boundaries[1].lat(),boundaries[2].lat(),6), getRandomInRange(boundaries[2].lng(),boundaries[0].lng(),6));
		var markerOptions = {
	    		position: mark[pointInt],
	            map: map,
	            title: 'Hello World! ' + pointInt
			};
		//generate random LatLng coordinate
		if (google.maps.geometry.poly.containsLocation(mark[pointInt], polygon))
		{
			marker[pointInt] = new google.maps.Marker(markerOptions);
			
			infowindow[pointInt] = new google.maps.InfoWindow;
			var infoContent = 'Latitude: ' + mark[pointInt].lat() + '<br/>Longitude: ' + mark[pointInt].lng();

			bindInfoW(marker[pointInt], infoContent, infowindow[pointInt], map);
			
			pointInt++;
		}
	}
}

//got from http://stackoverflow.com/questions/6878761/javascript-how-to-create-random-longitude-and-latitudes
//another note http://stackoverflow.com/questions/8611830/javascript-random-positive-or-negative-number
//another http://stackoverflow.com/questions/11400290/putting-random-latitude-and-longitude-in-google-maps-geolocation
function getRandomInRange(from, to, fixed) {
    return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
    // .toFixed() returns string, so ' * 1' is a trick to convert to number
}

// got form http://stackoverflow.com/questions/4381355/multiple-google-maps-infowindow
function bindInfoW(marker, contentString, infowindow, map)
{
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
        });
}

google.maps.event.addDomListener(window, 'load', initialize);