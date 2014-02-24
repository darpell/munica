function mapDengueOverlay(map) //Larvalpositive nodes display
{
	if (dg_length != 0)
	{alert("Dengue Overlay");
		var dg_length = document.getElementById("dg_length");
		var dinfo = new Array();
		var dlat = new Array();
		var dlng = new Array();
		
		var ctr =0;
		while(ctr<dg_length)
		{
			dinfo.push(""+
				+"<b>"+document.getElementById("dg_lName"+ctr)+", "+document.getElementById("dg_fName"+ctr)+"</b><br/>"
				+document.getElementById("dg_householdName"+ctr)+" Household<br/>"
				+document.getElementById("dg_houseNo"+ctr)+", "
				+document.getElementById("dg_street"+ctr)+" "
				+document.getElementById("dg_barangay"+ctr)+"<br/>"
				+"Birth: "+document.getElementById("dg_dob"+ctr)+"<br/>"
				+"Gender: "+document.getElementById("dg_sex"+ctr)+"<br/>"
				+"Guardian: "+document.getElementById("dg_guardian"+ctr)+"<br/>"
				+"Contact No: "+document.getElementById("dg_contact"+ctr)+"<br/><br/>"
				+"Case Information <br/>"
				+"Case No:"+document.getElementById("dg_caseNo"+ctr)+"<br/>"
				+"Status: "+document.getElementById("dg_status"+ctr)+"<br/>"
				+"Days Fever: "+document.getElementById("dg_daysFever"+ctr)+"<br/>"
				+"Suspect Source: "+document.getElementById("dg_suspectedSource"+ctr)+"<br/>"
				+"Days Fever: "+document.getElementById("dg_daysFever"+ctr)+"<br/>"
				+"Muscle Pain: "+document.getElementById("dg_hasMusclePain"+ctr)+"<br/>"
				+"Joint Pain: "+document.getElementById("dg_hasJointPain"+ctr)+"<br/>"
				+"Headache: "+document.getElementById("hasHeadache"+ctr)+"<br/>"
				+"Bleeding: "+document.getElementById("hasBleeding"+ctr)+"<br/>"
				+"Rashes: "+document.getElementById("hasRashes"+ctr)+"<br/>"
				+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr)+"<br/>"
				+"Last Visit: "+document.getElementById("dg_lastVisited"+ctr)+"<br/>");
			dlat.push(document.getElementById("dg_lat"+ctr));
			dlng.push(document.getElementById("dg_lng"+ctr));
		}
		var lengthinvariant=dinfo.length;
		var point;
		for (var i=0; i<lengthinvariant; i++)
		{
			point = new google.maps.LatLng(dlat[i],dlng[i]);
			createMarker(map,point,null,dinfo[i],false,false,false,false);
		}
	}
}
	