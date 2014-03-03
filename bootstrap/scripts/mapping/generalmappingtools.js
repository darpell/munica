var infoWindow = new google.maps.InfoWindow();
infoWindow.setOptions({maxWidth:400});

var centroidMarker;
function createMarker(map,point,image,info,bounce,isOld,isPoI,hasCircle)
{//General marker creation
	//var oms = new OverlappingMarkerSpiderfier(map);
	if(image === null && !isPoI)
	{
		if(isOld===false)
		{
			centroidMarker = new google.maps.Marker({
			  position: point,
			  map: map,
			  shadow:null
			});
			//oms.addMarker(centroidMarker);
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
				//oms.addMarker(centroidMarker);
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
	//oms.addMarker(centroidMarker);
		/*
		var oms = new OverlappingMarkerSpiderfier(map);
		//var mcOptions = {gridSize: 50, maxZoom: 15}; //for MarkerClusterer

		oms.addListener('click', function(marker) {
		    iw.setContent(marker.desc);
		    iw.open(map, marker);
		  });
		  oms.addListener('spiderfy', function(markers) {
		    for(var i = 0; i < markers.length; i ++) {
		      markers[i].setIcon(iconWithColor(spiderfiedColor));
		      markers[i].setShadow(null);
		    } 
		    iw.close();
		  });
		  oms.addListener('unspiderfy', function(markers) {
		    for(var i = 0; i < markers.length; i ++) {
		      markers[i].setIcon(iconWithColor(usualColor));
		      markers[i].setShadow(shadow);
		    }
		  });//*/
}



