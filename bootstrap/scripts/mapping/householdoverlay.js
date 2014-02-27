function mapHouseholdOverlay(map) //Larvalpositive nodes display
{	
	if (hs_length != 0)
	{//alert("Household Overlay");
		var hs_length = document.getElementById("hs_length").value.toString();
		var hinfo = new Array();
		var hlat = new Array();
		var hlng = new Array();
		var occupantsChild = "";
		var occupantsParent = new Array();
		
		var ctr =0;
		var currHouse=document.getElementById("hs_householdId"+ctr).value.toString();
		var prevHouse=0;
		hinfo.push(""+
			document.getElementById("hs_householdName"+ctr).value.toString()+" Household<br/>"+
			document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
			document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
			document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
			+"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr).value.toString()+"<br/>"+
			+"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString());
		hlat.push(document.getElementById("hs_lat"+ctr).value.toString());
		hlng.push(document.getElementById("hs_lng"+ctr).value.toString());
		
		while(ctr<hs_length)
		{
			currHouse=document.getElementById("hs_householdId"+ctr).value.toString();
			if (currHouse==prevHouse || ctr==0)
			{
				occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>");
			}
			else
			{
				hinfo.push(""+
					document.getElementById("hs_householdName"+ctr).value.toString()+" Household<br/>"+
					document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
					document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
					document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
					+"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr).value.toString()+"<br/>"+
					+"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/>");
				hlat.push(document.getElementById("hs_lat"+ctr).value.toString());
				hlng.push(document.getElementById("hs_lng"+ctr).value.toString());
				occupantsParent.push(occupantChild);
				occupantsChild = "";
				occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>");
				prevHouse=currHouse;
			}
			ctr++;
		}
		occupantsParent.push(occupantsChild);
		occupantsChild = "";
		var lengthinvariant = hinfo.length;
		for (var i=0; i<lengthinvariant; i++)
		{
			point = new google.maps.LatLng(hlat[i],hlng[i]);
			createMarker(map,point,null,hinfo[i],false,false,false,false);
		}
	}
}
	