function mapDengueOverlay(map)
{
	var dg_length = document.getElementById("dg_length").value.toString();
	var dinfo="";
	var point;
	
	if (dg_length != 0)
	{//alert(dg_length);
		
		var ctr =0;//*
		while(ctr < dg_length)
		{
			//*
			dinfo = ""+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"<br/>"
				+document.getElementById("dg_householdName"+ctr).value.toString()+" Household<br/>"
				+document.getElementById("dg_houseNo"+ctr).value.toString()+", "
				+document.getElementById("dg_street"+ctr).value.toString()+" "
				+document.getElementById("dg_barangay"+ctr).value.toString()+"<br/>"
				+"Birth: "+document.getElementById("dg_dob"+ctr).value.toString()+"<br/>"
				+"Gender: "+document.getElementById("dg_sex"+ctr).value.toString()+"<br/>"
				+"Guardian: "+document.getElementById("dg_guardian"+ctr).value.toString()+"<br/>"
				+"Contact No: "+document.getElementById("dg_contact"+ctr).value.toString()+"<br/><br/>"
				+"Case Information <br/>"
				+"Case No: "+document.getElementById("dg_caseNo"+ctr).value.toString()+"<br/>"
				+"Status: "+document.getElementById("dg_status"+ctr).value.toString()+"<br/>"
				+"Days Fever: "+document.getElementById("dg_daysFever"+ctr).value.toString()+"<br/>"
				+"Suspect Source: "+document.getElementById("dg_suspectedSource"+ctr).value.toString()+"<br/>"
				+"Muscle Pain: "+document.getElementById("dg_hasMusclePain"+ctr).value.toString()+"<br/>"
				+"Joint Pain: "+document.getElementById("dg_hasJointPain"+ctr).value.toString()+"<br/>"
				+"Headache: "+document.getElementById("dg_hasHeadache"+ctr).value.toString()+"<br/>"
				+"Bleeding: "+document.getElementById("dg_hasBleeding"+ctr).value.toString()+"<br/>"
				+"Rashes: "+document.getElementById("dg_hasRashes"+ctr).value.toString()+"<br/>"
				+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
				+"Last Visit: "+document.getElementById("dg_lastVisited"+ctr).value.toString()+"<br/>";
			//alert(ctr);
			point = new google.maps.LatLng(document.getElementById("dg_lat"+ctr).value.toString(),document.getElementById("dg_lng"+ctr).value.toString());
			createMarker(map,point,null,dinfo,null,false,false,false);//*/
			ctr++;
		}
		//var lengthinvariant=dinfo.length;
		/*
		alert(dinfo[0]);
		for (var i=0; i<lengthinvariant; i++)
		{
			point = new google.maps.LatLng(dlat[i],dlng[i]);
			//createMarker(map,point,null,dinfo[i],false,false,false,false);
		}//*/
	}
}
	