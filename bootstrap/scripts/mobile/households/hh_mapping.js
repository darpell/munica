var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
function initialize()
{
	var mapProp = {
			center: dasma,
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};

	var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
	var oms = new OverlappingMarkerSpiderfier(map);
		
	var mcOptions = {gridSize: 50, maxZoom: 15};
	var markers = [];

	// Arrays for distance formula
	/*var tracking_no = [];
	var refNumber = [];
	var household = [];
	var container = [];

			
			var amount_200 = [];
			var percent_200 = [];
			var amount_50 = [];
			var percent_50 = [];
			*/
				
	for (var ctr = 0; ctr < document.getElementById("result_length").value; ctr++)
	{
		// distance formula necessities
		/*tracking_no[ctr] = document.getElementById("pt_tracking_no" + ctr).value;
  		refNumber[ctr] = document.getElementById("pt_ref_no" + ctr).value;
  		household[ctr] = document.getElementById("pt_household" + ctr).value;
  		container[ctr] = document.getElementById("pt_container" + ctr).value;
  		amount_200[ctr] = document.getElementById("amount_200_" + ctr).value;
		percent_200[ctr] = document.getElementById("percentage_200_" + ctr).value;
  		amount_50[ctr] = document.getElementById("amount_50_" + ctr).value;
		percent_50[ctr] = document.getElementById("percentage_50_" + ctr).value;*/
		  			
		// end distance formula necessities
	}
			
	for (var pt_ctr = 0; pt_ctr < document.getElementById("result_length").value; pt_ctr++) 
	{
		var date = new Date();
		date.setDate(date.getDate() - 7) // 7 days from now
		
		var x = new Date();
		x.setFullYear(
					document.getElementById("pt_last_visit_year" + pt_ctr).value,
					document.getElementById("pt_last_visit_month" + pt_ctr).value,
					document.getElementById("pt_last_visit_date" + pt_ctr).value
		);
		
		var image;
		
		if (x < date)
			image = 'images/house not visited.PNG';
		else if (x >= date || false )
			;
		
		var marker = new google.maps.Marker({
								position:new google.maps.LatLng(
								document.getElementById("pt_lat" + pt_ctr).value,
								document.getElementById("pt_lng" + pt_ctr).value
							),
							title: 'test'
			});

		/*
		var householdcount = 0;
		var containercount = 0;
		for (var __i = 0; __i < household.length; __i++)
        {
	       	if (household[pt_ctr] === household[__i])
	       		householdcount++;
	       	if (container[pt_ctr] === container[__i])
	       		containercount++;
		}
		var householdpercent = householdcount / household.length * 100;
		var containerpercent = containercount / container.length * 100;
					
		// infowindow content
		var html = "<b>Larval Survey Report #: </b>" + refNumber[pt_ctr]
				+ " <br/>" + "<b>Tracking #: </b>" + tracking_no[pt_ctr]
				+ " <br/>" + "<b>Larval positives (LP) within: </b>"
		    	+ " <br/>" + "<b>200m:</b>" + amount_200[pt_ctr] +" ("+ percent_200[pt_ctr] +"% of displayed LP)"
		    	+ " <br/>" + "<b>50m:</b>" + amount_50[pt_ctr] +" ("+ percent_50[pt_ctr] +"% of displayed LP)" 
		    	+ "<br/><br/>" + "<b>Household: </b>" + household[pt_ctr] +" ("+ householdcount +" of "+ household.length +" total occurrences, "+ householdpercent.toFixed(2) + "%)"
		    	+ " <br/>" + "<b>Container: </b>" + container[pt_ctr] +" ("+ containercount +" of "+ container.length +" total occurances, "+ containerpercent.toFixed(2) + "%)";*/
		// end infowindow content
			
		marker.info = new google.maps.InfoWindow({
					content: 'test'
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