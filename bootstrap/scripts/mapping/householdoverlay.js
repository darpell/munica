function mapHouseholdOverlay(map) //Larvalpositive nodes display
{	//*
	var hs_length = document.getElementById("hs_length").value.toString();alert(hs_length);
	if (hs_length != 0)
	{//alert("HS");
		var hs_length = document.getElementById("hs_length").value.toString();alert(hs_length);
		var hinfo = "";
		var occupantsChild = "";
		
		var ctr = 0;
		var currHouse = document.getElementById("hs_householdId0").value.toString();
		var prevHouse = 0;
		hinfo=""+
			document.getElementById("hs_householdName"+ctr).value.toString()+" Household<br/>"+
			document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
			document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
			document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
			"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr).value.toString()+"<br/>"+
			"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/>";
		
		var point = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
		occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
		//alert(hs_length);
		/*
		while(ctr < hs_length)
		{
			//*
			currHouse=document.getElementById("hs_householdId"+ctr).value.toString();alert(currHouse);
			if (currHouse==prevHouse || ctr==0)
			{
				occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
			}
			else
			{//*
				hinfo=""+
				document.getElementById("hs_householdName"+ctr).value.toString()+" Household<br/>"+
				document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
				document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
				document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
				"BHW in-charge: "+document.getElementById("hs_userUsername"+ctr).value.toString()+"<br/>"+
				"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/";
				point = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
				hinfo+=occupantChild;
				occupantsChild = "";
				occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
				prevHouse=currHouse;
				createMarker(map,point,null,hinfo,false,false,false,false);
				hinfo="";
			}
			ctr++;
		}//*/
	}
}
	