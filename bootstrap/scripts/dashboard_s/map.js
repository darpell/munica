var dasma = new google.maps.LatLng(14.2990183, 120.9589699);

var map, heatmap;
var markers = [];
for (var pt_ctr = 0; pt_ctr < lat.length; pt_ctr++) 
{
	markers[pt_ctr] = new google.maps.LatLng(lat[pt_ctr], lng[pt_ctr]);
}

var triangleCoords = [];
for (var pt_ctr2 = 0; pt_ctr2 < brgy_lat.length; pt_ctr2++) 
{
	triangleCoords[pt_ctr2] = new google.maps.LatLng(brgy_lat[pt_ctr2], brgy_lng[pt_ctr2]);
}


function initialize()
{
		var mapProp = {
				center: dasma,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.HYBRID
			};
		map = new google.maps.Map(document.getElementById('googleMap'),mapProp);

		//var oms = new OverlappingMarkerSpiderfier(map);
		//var mcOptions = {gridSize: 50, maxZoom: 15}; //for MarkerClusterer
			
		/*for (var pt_ctr = 0; pt_ctr < lat.length; pt_ctr++) 
		{
			var marker_icon = "";
			if (type[pt_ctr] == "0")
				marker_icon = img_icon[0];
			else if (type[pt_ctr] == "1")
				marker_icon = img_icon[1];
			
			var marker = new google.maps.Marker({
								position: new google.maps.LatLng(
									lat[pt_ctr],
									lng[pt_ctr]
								),
						map: map,
						icon : marker_icon
			});
			
			var html = "test" + pt_ctr;
				
			marker.info = new google.maps.InfoWindow({
						content: html
					});
			oms.addListener('click', function(marker) {
				 marker.info.open(map, marker);
					});
			
			oms.addListener('spiderfy', function(markers) {
		        for(var i = 0; i < markers.length; i ++) {
		          marker.setIcon(iconWithColor(spiderfiedColor));
		          marker.setShadow(null);
		        } 
		        marker.info.close();
		      });
					
			oms.addMarker(marker);
			markers.push(marker);
		}*/
					
		//var mc = new MarkerClusterer(map, markers, mcOptions);
		
		// Construct the polygon.
		var barangay = new google.maps.Polygon({
		    paths: triangleCoords,
		    strokeColor: '#FF0000',
		    strokeOpacity: 0.8,
		    strokeWeight: 2,
		    fillColor: '#FF0000',
		    fillOpacity: 0.35
		  });

		barangay.setMap(map);
		
		var contentString = 
			'<div>' +
			'<h4>' + barangay_name + '</h4>' +
			'<p> Having ' + barangay_cases_count + ' cases.</p>'
			'</div>'
			;

		
	  var infowindow = new google.maps.InfoWindow({
	      content: contentString
	  });
		
		google.maps.event.addListener(barangay, 'click', function() {
		    infowindow.open(map,barangay);
		  });

		heatmap = new google.maps.visualization.HeatmapLayer({
			  data: markers//pointArray
			});
		
			heatmap.setMap(map);
}

function toggleHeatmap() 
{
	heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient()
{
	var gradient = [
	    'rgba(0, 255, 255, 0)',
	    'rgba(0, 255, 255, 1)',
	    'rgba(0, 191, 255, 1)',
	    'rgba(0, 127, 255, 1)',
	    'rgba(0, 63, 255, 1)',
	    'rgba(0, 0, 255, 1)',
	    'rgba(0, 0, 223, 1)',
	    'rgba(0, 0, 191, 1)',
	    'rgba(0, 0, 159, 1)',
	    'rgba(0, 0, 127, 1)',
	    'rgba(63, 0, 91, 1)',
	    'rgba(127, 0, 63, 1)',
	    'rgba(191, 0, 31, 1)',
	    'rgba(255, 0, 0, 1)'
	  ]
	  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
}

function changeRadius()
{
	heatmap.set('radius', heatmap.get('radius') ? null : 20);
}

function changeOpacity()
{
	heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
}


google.maps.event.addDomListener(window, 'load', initialize);

