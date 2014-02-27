var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
function initialize()
{
		var mapProp = {
				center: dasma,
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.HYBRID
			};
		var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

		var oms = new OverlappingMarkerSpiderfier(map);
			
		var mcOptions = {gridSize: 50, maxZoom: 15};
		var markers = [];
			
		for (var pt_ctr = 0; pt_ctr < lat.length; pt_ctr++) 
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
		}
					
		//var mc = new MarkerClusterer(map, markers, mcOptions);
}
google.maps.event.addDomListener(window, 'load', initialize);