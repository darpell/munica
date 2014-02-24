function mapHouseholdOverlay(map) //Larvalpositive nodes display
{	
	if (hs_length != 0)
	{alert("Household Overlay");
		var hs_length = document.getElementById("hs_length");
		var hinfo = new Array();
		var hlat = new Array();
		var hlng = new Array();
		var occupantsChild = "";
		var occupantsParent = new Array();
		
		var ctr =0;
		var currHouse=document.getElementById("hs_householdId"+ctr);
		var prevHouse=0;
		hinfo.push(""+
			document.getElementById("hs_householdName"+ctr)+" Household<br/>"+
			document.getElementById("hs_barangay"+ctr)+"<br/>"+
			document.getElementById("hs_houseNo"+ctr)+", "+
			document.getElementById("hs_street"+ctr)+"<br/><br/>"+
			+"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr)+"<br/>"+
			+"Last Visit: "+document.getElementById("hs_lastVisited"+ctr));
		hlat.push(document.getElementById("hs_lat"+ctr));
		hlng.push(document.getElementById("hs_lng"+ctr));
		
		while(ctr<hs_length)
		{
			currHouse=document.getElementById("hs_householdId"+ctr);
			if (currHouse==prevHouse || ctr==0)
			{
				occupantsChild+=document.getElementById("hs_lname"+ctr)+", "+document.getElementById("hs_fname"+ctr)+" <i>"+document.getElementById("hs_dob"+ctr)+" "+document.getElementById("hs_sex"+ctr)+"</i><br/>");
			}
			else
			{
				hinfo.push(""+
					document.getElementById("hs_householdName"+ctr)+" Household<br/>"+
					document.getElementById("hs_barangay"+ctr)+"<br/>"+
					document.getElementById("hs_houseNo"+ctr)+", "+
					document.getElementById("hs_street"+ctr)+"<br/><br/>"+
					+"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr)+"<br/>"+
					+"Last Visit: "+document.getElementById("hs_lastVisited"+ctr)+"<br/>");
				hlat.push(document.getElementById("hs_lat"+ctr));
				hlng.push(document.getElementById("hs_lng"+ctr));
				occupantsParent.push(occupantChild);
				occupantsChild = "";
				occupantsChild+=document.getElementById("hs_lname"+ctr)+", "+document.getElementById("hs_fname"+ctr)+" <i>"+document.getElementById("hs_dob"+ctr)+" "+document.getElementById("hs_sex"+ctr)+"</i><br/>");
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
	