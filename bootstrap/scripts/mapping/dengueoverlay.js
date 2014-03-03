function mapDengueOverlay(map)
{
	var dg_length = document.getElementById("dg_length").value.toString();
	var dinfo="";
	var point;
	var img;
	
	if (dg_length != 0)
	{//alert(dg_length);
		
		var ctr =0;//*
		while(ctr < dg_length)
		{
			//*
			img=document.getElementById("dg_icon1").value.toString();
			dinfo = ""+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"<br/>"
			+"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("dg_householdID"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_householdName"+ctr).value.toString()+" Household</a><br/>"//+document.getElementById("dg_householdName"+ctr).value.toString()+" Household<br/>"
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
				+"BHW in Charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("dg_bhwName"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_bhwName"+ctr).value.toString()+"</a><br/>"//+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
				+"Last Visit: "+document.getElementById("dg_lastVisited"+ctr).value.toString()+"<br/><br/>";
			//alert(ctr);
			point = new google.maps.LatLng(document.getElementById("dg_lat"+ctr).value.toString(),document.getElementById("dg_lng"+ctr).value.toString());
			if(document.getElementById("dgPoIDistance_length").value.toString() != 0)
			{
				if(document.getElementById("dgPoIDistance"+ctr).value.toString() == 0)
				{
					dinfo += "No Points of Interests detected nearby.";
				}
				else
				{
					dinfo += document.getElementById("dgPoIDistance"+ctr).value.toString();
					var circle = new google.maps.Circle({
						center:point,
						radius:200,
						strokeColor:"#0000FF",
						strokeOpacity:0.7,
						strokeWeight:1,
						fillColor:"#66CCCC",
						fillOpacity:0.3,
						clickable:false
					});
					circle.setMap(map); 
				}
			}
			//*
			if(document.getElementById("dg_status"+ctr).value.toString() == "threatening")
			{
				img=document.getElementById("dg_icon2").value.toString();
			}
			else if(document.getElementById("dg_status"+ctr).value.toString() == "serious")
			{
				img=document.getElementById("dg_icon3").value.toString();
			}
			else if(document.getElementById("dg_status"+ctr).value.toString() == "hospitalized")
			{
				img=document.getElementById("dg_icon4").value.toString();
			}//*/
			createMarker(map,point,img,dinfo,null,false,false,false);//*/
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
	