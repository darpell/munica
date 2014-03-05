var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
function initialize()
{
	var mapProp = {
			center: dasma,
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};

	var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
	var oms = new OverlappingMarkerSpiderfier(map);
		
	var mcOptions = {gridSize: 50, maxZoom: 15};
	var markers = [];
			
	for (var pt_ctr = 0; pt_ctr < document.getElementById("result_length").value; pt_ctr++) 
	{
		var today = new Date();
		var date = new Date();
		date.setDate(date.getDate() - 7) // 7 days from now
		
		var x = new Date();
		x.setFullYear(
					document.getElementById("pt_last_visit_year" + pt_ctr).value,
					document.getElementById("pt_last_visit_month" + pt_ctr).value - 1,
					document.getElementById("pt_last_visit_date" + pt_ctr).value
		);
		
		var image;
		
		if (x < date)
			image = document.getElementById('image_not_visited').value;
		else if (x >= date && x < today )
			image = document.getElementById('image_unvisited').value;
		else
			image = document.getElementById('image_visited').value;
		
		var marker = new google.maps.Marker({
								position:new google.maps.LatLng(
								document.getElementById("pt_lat" + pt_ctr).value,
								document.getElementById("pt_lng" + pt_ctr).value
							),
							title: document.getElementById("pt_name" + pt_ctr).value + ' located at ' 
									+ document.getElementById("pt_no" + pt_ctr).value + ' '
									+ document.getElementById("pt_street" + pt_ctr).value + ', Barangay '
									+ document.getElementById("pt_barangay" + pt_ctr).value,
							icon: image
			});
			
		var html = document.getElementById("pt_name" + pt_ctr).value + ' located at ' 
					+ document.getElementById("pt_no" + pt_ctr).value + ' '
					+ document.getElementById("pt_street" + pt_ctr).value + ', Barangay '
					+ document.getElementById("pt_barangay" + pt_ctr).value;
		
		marker.info = new google.maps.InfoWindow({
					content: html
				});
		oms.addListener('click', function(marker) {
			 marker.info.open(map, marker);
		});
					
		oms.addMarker(marker);
		markers.push(marker);
	}
					
	var mc = new MarkerClusterer(map, markers, mcOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);