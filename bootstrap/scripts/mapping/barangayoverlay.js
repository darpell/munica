function mapBarangayOverlay(map)
{
	var bb_length = document.getElementById('bb_length').value.toString();
	if (bb_length != 0)
	{
		var pinfo = new Array();
		var plat = new Array();
		var plng = new Array();
		var polygonChild = new Array();
		var color="FF0000";
		var bermudaTriangle;
	
		var ctr =0;
		var currPoly=document.getElementById("bb_polyID"+ctr);
		var prevPoly=0;
		//*
		while(ctr<bb_length)
		{//alert(parseFloat(document.getElementById("bb_polyLat"+ctr).value.toString()));
			currPoly=document.getElementById("bb_polyID"+ctr).value.toString();
			if (currPoly==prevPoly || ctr==0)
			{//alert("IF "+ctr);
				polygonChild.push(new google.maps.LatLng(parseFloat(document.getElementById("bb_polyLat"+ctr).value.toString()),
						parseFloat(document.getElementById("bb_polyLng"+ctr).value.toString())));
			}
			else
			{
				bermudaTriangle = new google.maps.Polygon(
						{
							paths: polygonChild,
							fillColor: "#FF0000",
							fillOpacity:0.3,
							clickable:false
						});
				bermudaTriangle.setMap(map);
				polygonChild = [];
				polygonChild.push(new google.maps.LatLng(parseFloat(document.getElementById("bb_polyLat"+ctr).value.toString()),
						parseFloat(document.getElementById("bb_polyLng"+ctr).value.toString())));
				prevPoly=currPoly;
			}
			if(ctr==0)
				{
					prevPoly=currPoly;
				}
			ctr++;
		}
		bermudaTriangle = new google.maps.Polygon(
				{
					paths: polygonChild,
					fillColor: "#FF0000",
					fillOpacity:0.3,
					clickable:false
				});
		bermudaTriangle.setMap(map);
		polygonChild = [];
	}
}