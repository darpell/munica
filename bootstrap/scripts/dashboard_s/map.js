var dasma = new google.maps.LatLng(14.2990183, 120.9589699);

var map, heatmap;
var markers = [];
for (var pt_ctr = 0; pt_ctr < lat.length; pt_ctr++) 
{
	markers[pt_ctr] = new google.maps.LatLng(lat[pt_ctr], lng[pt_ctr]);
}

var san_agustin_iii_coords = [];
for (var brgy_ctr = 0; brgy_ctr < san_agustin_iii_lat.length; brgy_ctr++) 
{
	san_agustin_iii_coords[brgy_ctr] = new google.maps.LatLng(san_agustin_iii_lat[brgy_ctr], san_agustin_iii_lng[brgy_ctr]);
}

var langkaan_ii_coords = [];
for (var brgy_ctr = 0; brgy_ctr < langkaan_ii_lat.length; brgy_ctr++) 
{
	langkaan_ii_coords[brgy_ctr] = new google.maps.LatLng(langkaan_ii_lat[brgy_ctr], langkaan_ii_lng[brgy_ctr]);
}

var sampaloc_i_coords = [];
for (var brgy_ctr = 0; brgy_ctr < sampaloc_i_lat.length; brgy_ctr++) 
{
	sampaloc_i_coords[brgy_ctr] = new google.maps.LatLng(sampaloc_i_lat[brgy_ctr], sampaloc_i_lng[brgy_ctr]);
}

var san_agustin_i_coords = [];
for (var brgy_ctr = 0; brgy_ctr < san_agustin_i_lat.length; brgy_ctr++) 
{
	san_agustin_i_coords[brgy_ctr] = new google.maps.LatLng(san_agustin_i_lat[brgy_ctr], san_agustin_i_lng[brgy_ctr]);
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
		var san_agustin_iii_polygon = new google.maps.Polygon({
		    paths: san_agustin_iii_coords,
		    strokeColor: '#FF0000',
		    strokeOpacity: 0.8,
		    strokeWeight: 2,
		    fillColor: '#FF0000',
		    fillOpacity: 0.35
		  });

		san_agustin_iii_polygon.setMap(map);
		
		var contentString = 
			'<div>' +
			'<h4>' + san_agustin_iii + '</h4>' +
			'<p> Having ' + san_agustin_iii_cases_count + ' cases.</p>'
			'</div>'
			;

		
	  var infowindow = new google.maps.InfoWindow({
	      content: contentString
	  });
		
		google.maps.event.addListener(san_agustin_iii_polygon, 'click', function() {
		    infowindow.open(map,san_agustin_iii_polygon);
		  });
		
		// langkaan ii
		var langkaan_ii_polygon = new google.maps.Polygon({
		    paths: langkaan_ii_coords,
		    strokeColor: '#FF0000',
		    strokeOpacity: 0.8,
		    strokeWeight: 2,
		    fillColor: '#FF0000',
		    fillOpacity: 0.35
		  });

		langkaan_ii_polygon.setMap(map);
		
		var langkaan_ii_string = 
			'<div>' +
			'<h4>' + langkaan_ii + '</h4>' +
			'<p> Having ' + langkaan_ii_cases_count + ' cases.</p>' // to be changed
			'</div>'
			;

		
	  var langkaan_ii_infowindow = new google.maps.InfoWindow({
	      content: langkaan_ii_string
	  });
		
		google.maps.event.addListener(langkaan_ii_polygon, 'click', function() {
			langkaan_ii_infowindow.open(map,langkaan_ii_polygon);
		  });
		
		// sampaloc i
		var sampaloc_i_polygon = new google.maps.Polygon({
		    paths: sampaloc_i_coords,
		    strokeColor: '#FF0000',
		    strokeOpacity: 0.8,
		    strokeWeight: 2,
		    fillColor: '#FF0000',
		    fillOpacity: 0.35
		  });

		sampaloc_i_polygon.setMap(map);
		
		var sampaloc_i_string = 
			'<div>' +
			'<h4>' + sampaloc_i + '</h4>' +
			'<p> Having ' + sampaloc_i_cases_count + ' cases.</p>' // to be changed
			'</div>'
			;

		
	  var sampaloc_i_infowindow = new google.maps.InfoWindow({
	      content: sampaloc_i_string
	  });
		
		google.maps.event.addListener(sampaloc_i_polygon, 'click', function() {
			sampaloc_i_infowindow.open(map,sampaloc_i_polygon);
		  });
		
		// san agustin I
		var san_agustin_i_polygon = new google.maps.Polygon({
		    paths: san_agustin_i_coords,
		    strokeColor: '#FF0000',
		    strokeOpacity: 0.8,
		    strokeWeight: 2,
		    fillColor: '#FF0000',
		    fillOpacity: 0.35
		  });

		san_agustin_i_polygon.setMap(map);
		
		var san_agustin_i_string = 
			'<div>' +
			'<h4>' + san_agustin_i + '</h4>' +
			'<p> Having ' + san_agustin_i_cases_count + ' cases.</p>' // to be changed
			'</div>'
			;

		
	  var san_agustin_i_infowindow = new google.maps.InfoWindow({
	      content: san_agustin_i_string
	  });
		
		google.maps.event.addListener(san_agustin_i_polygon, 'click', function() {
			san_agustin_i_infowindow.open(map,san_agustin_i_polygon);
		  });
		
		// end of polygons

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

