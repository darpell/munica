function createMarker(map,point,image,info,bounce,isOld,isPoI,RiskOrSource)
{//General marker creation
	var centroidMarker;
	var oms = new OverlappingMarkerSpiderfier(map);
	if(image === null && !isPoI)
	{
		if(isOld===false)
		{
			centroidMarker = new google.maps.Marker({
			  position: point,
			  map: map,
			  shadow:null
			});
			oms.addMarker(centroidMarker);
			if(bounce !== null)
			{
			    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
			}
		}
		else
		{
			centroidMarker = new google.maps.Marker({
				  position: point,
				  map: map,
			      icon: new google.maps.MarkerImage('https://maps.gstatic.com/mapfiles/ms2/micons/ltblue-dot.png'),
				});
				oms.addMarker(centroidMarker);
				if(bounce !== null)
				{
				    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
				}
		}
	}
	else if (isPoI)
	{
		centroidMarker = new google.maps.Marker({  
        position: point,   
        map: map,  
        icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+RiskOrSource+'|FF0000|000000'  
    	});  
	}
	else
	{
		centroidMarker = new google.maps.Marker({
		      map: map,
		      position: point,
		      icon: image,
			});
	}
	  
	google.maps.event.addListener(centroidMarker, 'click', function() {
		infoWindow.setContent(info);
		infoWindow.open(map, this);
	});
	
		google.maps.event.addListener(centroidMarker, 'click', function() {
			loadXMLDoc(info);
	});
}



