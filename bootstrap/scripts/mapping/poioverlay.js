function mapPointsOfInterest(map)
{//alert("POI");
	var poi_length = document.getElementById("poi_length").value.toString();
	var poiinfo="";
	var point;
	var img;
	
	if (poi_length != 0)
	{
		img=document.getElementById("poi_iconS").value.toString();
		var ctr =0;//*
		while(ctr < poi_length)
		{//*
			poiinfo = "<b>"+document.getElementById("poi_name"+ctr).value.toString()+"</b><br/>";
			if(parseInt(document.getElementById("poi_type"+ctr).value.toString()) === 1)
				{
					img=document.getElementById("poi_iconR").value.toString();//poiinfo +="SOURCE AREA<br/><br/>"poi_iconS;
				}
				//poiinfo +="RISK AREA<br/><br/>";//*/
			poiinfo +=document.getElementById("poi_barangay"+ctr).value.toString()+"<br/>";
			poiinfo +=document.getElementById("poi_notes"+ctr).value.toString()+"<br/>";
			
			//alert(ctr);
			point = new google.maps.LatLng(document.getElementById("poi_lat"+ctr).value.toString(),document.getElementById("poi_lng"+ctr).value.toString());
			createMarker(map,point,img,poiinfo,null,false,false,false);//*/
			ctr++;
			poiinfo="";
		}
	}
}