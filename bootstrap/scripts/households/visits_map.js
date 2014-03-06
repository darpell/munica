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
	
	//alert(hh_img[0]);
	
	for (var ctr = 0; ctr < households.length; ctr++)
	{
		// date comparison
		var today = new Date();
		var date = new Date();
		date.setDate(date.getDate() - 7) // 7 days from now
		
		var x = new Date(last_visits[ctr].visit_date);
		
		var image;
		
		if (x < date)
			image = hh_img[1];
		else //if (x >= date && x < today )
			image = hh_img[0];
		
		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(
				households[ctr].household_lat,
				households[ctr].household_lng
			),
			icon: image,
			map: map
		});
		
		
		// infowindow content
		var html =
			'<div>'
			+ '<table cellpadding="5">'
			+ '<tr> <th>'
			+ 'Household Name: </th>'
			+ '<td>' + households[ctr].household_name + '</td>'
			+ '</tr>'
			+ '<tr> <th>'
			+ 'Address: </th>'
			+ '<td>' + households[ctr].house_no + ' at ' + households[ctr].street + '</td>'
			+ '</tr>'
			+ '<tr> <th>'
			+ 'Barangay: </th>'
			+ '<td>' + households[ctr].barangay + '</td>'
			+ '</tr>'
			+ '</div>'
			+ '<tr> <th>'
			+ 'Last Visit: </th>'
			+ '<td>' + last_visits[ctr].visit_date + '</td>'
			+ '</tr>'
			+ '</table> <br/>'
			+ '<form action="add_to_visit_list/' + households[ctr].household_id + '" method="post">'
			+ '<input type="hidden" name="household_id" value="' + households[ctr].household_id + '" />'
			+ '<div class="form-group"><center><input type="submit" value="Add to list" class="btn btn-primary btn-xs" /></center></div>'
			+ '</form>';
		
		marker.info = new google.maps.InfoWindow({
			content: html
		});
		oms.addListener('click', function(marker) {
			 marker.info.open(map, marker);
		});
		
		oms.addMarker(marker);
	}
}

google.maps.event.addDomListener(window, 'load', initialize);