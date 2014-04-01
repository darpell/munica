<!-- HEADER -->
<?php $data['title'] = 'Map'; $this->load->view('/site/templates/header',$data);?>


<!-- CONTENT -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/OverlappingMarkerSpiderfier.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/generalmappingtools.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/barangayoverlay.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/larvaloverlay.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/dengueoverlay.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/householdoverlay.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('scripts/mapping/poioverlay.js') ?>"></script>
<script type="text/javascript">
	google.load('visualization', '1.1', {packages: ['controls','corechart']});
</script>
<style>
#pad15
{
padding:15px;
}
</style>
<script type="text/javascript">
function drawVisualization() {
	
}
</script>
<script>
function loadXMLDoc(q)
{
	

var xmlhttp;
if (q=="")
  {
  //document.getElementById("txtHint").innerHTML="";
  //return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   	//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    //alert(xmlhttp.responseText);
    }
  };
  var url = 'http://localhost/workspace/monica/index.php/case_report/get_denguecases/' + q;
  xmlhttp.open("post",url,false);
xmlhttp.send(null);

}

function splitter(str)//Data splitter
{
	str = str.split("%%");
	var data = new Array();
	for (var i = 0; i < str.length; i++)
	{
		data[i] = str[i].split("&&");
	}
	return data;
}

function splitter2(str)
{
	str = str.split("%%");
	var data = new Array();
	for (var i = 0; i < str.length; i++)
	{
		data[i] = str[i].split("&&");
	}
	return data;
}

function countInstances(arr) {
    var a = [], b = [], prev;

    arr.sort();
    for ( var i = 0; i < arr.length; i++ ) {
        if ( arr[i] !== prev ) {
            a.push(arr[i]);
            b.push(1);
        } else {
            b[b.length-1]++;
        }
        prev = arr[i];
    }

    return [a, b];
}
var infoWindow = new google.maps.InfoWindow();
infoWindow.setOptions({maxWidth:600});

var centroidMarker;

function setInfo(fMarker,fInfo,fMap) {
	google.maps.event.addListener(fMarker, 'click', function() {
		infoWindow.setOptions({content:fInfo});
		infoWindow.open(fMap, this);
	});
}

function createMarker(map,point,image,info,bounce,isOld,isPoI,hasCircle)
{
}

function setPolyInfo(poly,str,pmap)
{
	var p;
	google.maps.event.addListener(poly,'click', function(event) {
	    infoWindow.setContent(str);
	    if (event) {
	       p = event.latLng;
	    }
	    infoWindow.setPosition(p);
	    infoWindow.open(pmap);
	    // map.openInfoWindowHtml(point,html); 
	  });
}

function load() {
	var map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(14.301716, 120.942506),
		zoom: 14,
		mapTypeId: 'roadmap'
	});
	var oms = new OverlappingMarkerSpiderfier(map);
	if(document.getElementById('getLarva').value.toString()=="1")//CURRENT LARVAL SURVEY
    {
		var ls_length = document.getElementById("ls_length").value.toString();
		var linfo="";
		var point;
		
		if (ls_length != 0)
		{			
			var ctr =0;//*
			while(ctr < ls_length)
			{
				//*
				linfo = "Larval Survey #"+document.getElementById("ls_no"+ctr).value.toString()+"<br/>"
				//+document.getElementById("ls_household"+ctr).value.toString()+" Household<br/>"//
				+"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("ls_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("ls_household"+ctr).value.toString()+" Household</a><br/>"
				+"Container: "+document.getElementById("ls_container"+ctr).value.toString()+"<br/>"
				+"Created by: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("ls_createdBy"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("ls_bhwName"+ctr).value.toString()+"</a><br/>"
				+"Created on: "+document.getElementById("ls_createdOn"+ctr).value.toString();//*/
				//alert(ctr);
				point = new google.maps.LatLng(document.getElementById("ls_lat"+ctr).value.toString(),document.getElementById("ls_lng"+ctr).value.toString());
				centroidMarker = new google.maps.Marker({
					  position: point,
					  map: map,
				      icon: document.getElementById("ls_icon").value.toString(),
					});
				
				var invariant1=document.getElementById("ls_no"+ctr).value.toString();
				if(document.getElementById("dgLarvalBounce_length").value.toString() != 0)
					for(var i=0;i < document.getElementById("dgLarvalBounce_length").value.toString();i++)
					{
						if(document.getElementById("dgLarvalBounce"+i).value.toString() == invariant1)
							centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
					}
				setInfo(centroidMarker,linfo,map);
				oms.addMarker(centroidMarker);
				//createMarker(map,point,document.getElementById("ls_icon").value.toString(),linfo,null,false,false,false);//*/
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
        //mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("Larva").value,false);
    }
	if(document.getElementById('getBb').value.toString()=="1")//BARANGAY OVERLAY
	{
		//alert("Alert BB!");
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
			var tabStr="";
			//*
			while(ctr<bb_length)
			{//alert(parseFloat(document.getElementById("bb_polyLat"+ctr).value.toString()));
				var cntent;
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
								clickable:true
							});
					bermudaTriangle.setMap(map);
					tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString()+"</h4></center>";
					tabStr +="<br/>";
					if(document.getElementById('getLarva').value.toString()=="1")
					{
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
							tabStr +="Larval Positives Detected: "+document.getElementById('SA1_l').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
							tabStr +="Larval Positives Detected: "+document.getElementById('SA3_l').value.toString();

						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
							tabStr +="Larval Positives Detected: "+document.getElementById('L2_l').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
							tabStr +="Larval Positives Detected: "+document.getElementById('S1_l').value.toString();
					}
					tabStr +="<br/>";
					if(document.getElementById('getDengue').value.toString()=="1")
					{
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
							tabStr +="Dengue Cases Detected: "+document.getElementById('SA1_d').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
							tabStr +="Dengue Cases Detected: "+document.getElementById('SA3_d').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
							tabStr +="Dengue Cases Detected: "+document.getElementById('L2_d').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
							tabStr +="Dengue Cases Detected: "+document.getElementById('S1_d').value.toString();
					}
					tabStr +="<br/>";
					if(document.getElementById('getPoi').value.toString()=="1")
					{
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
							tabStr +="Points of Interest Detected: "+document.getElementById('SA1_p').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
							tabStr +="Points of Interest Detected: "+document.getElementById('SA3_p').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
							tabStr +="Points of Interest Detected: "+document.getElementById('L2_p').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
							tabStr +="Points of Interest Detected: "+document.getElementById('S1_p').value.toString();
					}
					tabStr +="<br/>";
					if(document.getElementById('getHouseholds').value.toString()=="1")
					{
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
							tabStr +="Houeholds Detected: "+document.getElementById('SA1_h').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
							tabStr +="Houeholds Detected: "+document.getElementById('SA3_h').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
							tabStr +="Houeholds Detected: "+document.getElementById('L2_h').value.toString();
							
						if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
							tabStr +="Houeholds Detected: "+document.getElementById('S1_h').value.toString();
					}
					/*
					tabStr += "<h5></>Table 1. Displaying Age Distribution for period <br/><i>"+document.getElementById("cdate1").value.toString()+" to "+document.getElementById("cdate2").value.toString()+"</i>";
					tabStr += "<br/><table border='1' cellpadding='5' cellspacing='0' id='results' >";
					tabStr += "<tr><td align='center'><b>Age Range</b></td><td align='center'><b>Patient Amount</b></td></tr>";
					for(var i=0; i < document.getElementById("table1_length").value.toString(); i++ )
					{
						//alert(""+document.getElementById("table1_brgy"+i).value.toString() + document.getElementById("bb_polyName"+ctr).value.toString());
						if(document.getElementById("table1_brgy"+i).value.toString() == document.getElementById("bb_polyName"+(ctr-1)).value.toString())
						{
							tabStr +="<td align='center'>"+document.getElementById("table1_range"+(i)).value.toString()+"</td>"
								+"<td align='center'>"+document.getElementById("table1_count"+(i)).value.toString()+"</td></tr>";
						}
					}
					tabStr +="</table></center>";//*/
					setPolyInfo(bermudaTriangle,tabStr,map);
					//tabStr="";
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
						clickable:true
					});
			bermudaTriangle.setMap(map);
			
			tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString()+"</h4></center>";
			tabStr +="<br/>";
			if(document.getElementById('getLarva').value.toString()=="1")
			{
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
					tabStr +="Larval Positives Detected: "+document.getElementById('SA1_l').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
					tabStr +="Larval Positives Detected: "+document.getElementById('SA3_l').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
					tabStr +="Larval Positives Detected: "+document.getElementById('L2_l').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
					tabStr +="Larval Positives Detected: "+document.getElementById('S1_l').value.toString();
			}
			tabStr +="<br/>";
			if(document.getElementById('getDengue').value.toString()=="1")
			{
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
					tabStr +="Dengue Cases Detected: "+document.getElementById('SA1_d').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
					tabStr +="Dengue Cases Detected: "+document.getElementById('SA3_d').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
					tabStr +="Dengue Cases Detected: "+document.getElementById('L2_d').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
					tabStr +="Dengue Cases Detected: "+document.getElementById('S1_d').value.toString();
			}
			tabStr +="<br/>";
			if(document.getElementById('getPoi').value.toString()=="1")
			{
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
					tabStr +="Points of Interest Detected: "+document.getElementById('SA1_p').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
					tabStr +="Points of Interest Detected: "+document.getElementById('SA3_p').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
					tabStr +="Points of Interest Detected: "+document.getElementById('L2_p').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
					tabStr +="Points of Interest Detected: "+document.getElementById('S1_p').value.toString();
			}
			tabStr +="<br/>";
			if(document.getElementById('getHouseholds').value.toString()=="1")
			{
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
					tabStr +="Houeholds Detected: "+document.getElementById('SA1_h').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
					tabStr +="Houeholds Detected: "+document.getElementById('SA3_h').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
					tabStr +="Houeholds Detected: "+document.getElementById('L2_h').value.toString();
					
				if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
					tabStr +="Houeholds Detected: "+document.getElementById('S1_h').value.toString();
			}
			/*
			tabStr += "<h5></>Table 1. Displaying Age Distribution for period <br/><i>"+document.getElementById("cdate1").value.toString()+" to "+document.getElementById("cdate2").value.toString()+"</i>";
			tabStr += "<br/><table border='1' cellpadding='5' cellspacing='0' id='results' >";
			tabStr += "<tr><td align='center'><b>Age Range</b></td><td align='center'><b>Patient Amount</b></td></tr>";
			for(var i=0; i < document.getElementById("table1_length").value.toString(); i++ )
			{
				//alert(""+document.getElementById("table1_brgy"+i).value.toString() + document.getElementById("bb_polyName"+ctr).value.toString());
				if(document.getElementById("table1_brgy"+i).value.toString() == document.getElementById("bb_polyName"+(ctr-1)).value.toString())
				{
					tabStr +="<td align='center'>"+document.getElementById("table1_range"+(i)).value.toString()+"</td>"
						+"<td align='center'>"+document.getElementById("table1_count"+(i)).value.toString()+"</td></tr>";
				}
			}
			tabStr +="</table></center>";//*/
			setPolyInfo(bermudaTriangle,tabStr,map);
			
			polygonChild = [];
		}
	}
	if(document.getElementById('getDengue').value.toString()=="1")//CURRENT DENGUE CASES
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
				//dinfo = "<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("dg_caseNo"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</a><br/>";
				if(document.getElementById("dg_status"+ctr) != null)
				{
					dinfo = "<b><a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("dg_caseNo"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</a></b><br/>";
				}
				else
				{
					dinfo = "<b>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</b><br/>";
				}
				dinfo +="<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("dg_householdID"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_householdName"+ctr).value.toString()+" Household</a><br/>";
				dinfo +=document.getElementById("dg_houseNo"+ctr).value.toString()+", "
					+document.getElementById("dg_street"+ctr).value.toString()+" "
					+document.getElementById("dg_barangay"+ctr).value.toString()+"<br/>"
					+"Birth: "+document.getElementById("dg_dob"+ctr).value.toString()+"<br/>"
					+"Gender: "+document.getElementById("dg_sex"+ctr).value.toString()+"<br/>"
					+"Guardian: "+document.getElementById("dg_guardian"+ctr).value.toString()+"<br/>"
					+"Contact No: "+document.getElementById("dg_contact"+ctr).value.toString()+"<br/><br/>"
					+"Case Information <br/>"
					+"Case No: "+document.getElementById("dg_caseNo"+ctr).value.toString()+"<br/>";//alert("!");
				if(document.getElementById("dg_status"+ctr) != null)
				{
					dinfo +="Status: "+document.getElementById("dg_status"+ctr).value.toString()+"<br/>";
				}
				else
				{
					dinfo +="Outcome: "+document.getElementById("dg_outcome"+ctr).value.toString()+"<br/>";//alert("!");
				}
				dinfo +="Days Fever: "+document.getElementById("dg_daysFever"+ctr).value.toString()+"<br/>"
					+"Suspect Source: "+document.getElementById("dg_suspectedSource"+ctr).value.toString()+"<br/>"
					+"Muscle Pain: "+document.getElementById("dg_hasMusclePain"+ctr).value.toString()+"<br/>"
					+"Joint Pain: "+document.getElementById("dg_hasJointPain"+ctr).value.toString()+"<br/>"
					+"Headache: "+document.getElementById("dg_hasHeadache"+ctr).value.toString()+"<br/>"
					+"Bleeding: "+document.getElementById("dg_hasBleeding"+ctr).value.toString()+"<br/>"
					+"Rashes: "+document.getElementById("dg_hasRashes"+ctr).value.toString()+"<br/>"
					+"BHW in Charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("dg_bhwName"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_bhwpropername"+ctr).value.toString()+"</a><br/>"//+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
					+"Last Visit: "+document.getElementById("dg_lastVisited"+ctr).value.toString()+"<br/><br/>";
				//alert(ctr);
				point = new google.maps.LatLng(document.getElementById("dg_lat"+ctr).value.toString(),document.getElementById("dg_lng"+ctr).value.toString());
				var setCircle=false;
				if(document.getElementById("dgPoIDistance_length").value.toString() != 0)
				{
					if(document.getElementById("dgPoIDistance"+ctr).value.toString() == 0)
					{
						dinfo += "No Points of Interests detected nearby.<br/>";
					}
					else
					{
						dinfo += document.getElementById("dgPoIDistance"+ctr).value.toString();
						setCircle=true;
					}
				}//*
				if(document.getElementById("dgLarvalDistance_length").value.toString() != 0)
				{
					if(document.getElementById("dgLarvalDistance"+ctr).value.toString() == 0)
					{
						dinfo += "No Larval Positives detected nearby.<br/>";
					}
					else
					{
						dinfo += document.getElementById("dgLarvalDistance"+ctr).value.toString();
						setCircle=true;
					}
				}
				if(setCircle)
				{
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
				}//*/
				//*
				if(document.getElementById("dg_status"+ctr) == null)
				{//alert("!");
					if(document.getElementById("dg_outcome"+ctr).value.toString() == "A")
						img=document.getElementById("dg_iconA").value.toString();
					else
						img=document.getElementById("dg_iconD").value.toString();
				}
				else if(document.getElementById("dg_status"+ctr).value.toString() == "threatening")
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
				//createMarker(map,point,img,dinfo,null,false,false,false);//*/
				centroidMarker = new google.maps.Marker({  
			        position: point,   
			        map: map,  
			        icon: img
			    	});  
				ctr++;
				setInfo(centroidMarker,dinfo,map);
				oms.addMarker(centroidMarker);
			}
		}
    }
	if(document.getElementById('getPoi').value.toString()=="1")//CURRENT POINTS OF INTEREST
    {
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
				//createMarker(map,point,img,poiinfo,null,false,false,false);//*/
				centroidMarker = new google.maps.Marker({
					  position: point,
					  map: map,
				      icon: img
					});
				var invariant1=document.getElementById("poi_id"+ctr).value.toString();
				if(document.getElementById("dgPoIBounce_length").value.toString() != 0)
					for(var i=0;i < document.getElementById("dgPoIBounce_length").value.toString();i++)
					{
						if(document.getElementById("dgPoIBounce"+i).value.toString() == invariant1)
							centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
					}
				setInfo(centroidMarker,poiinfo,map);
				oms.addMarker(centroidMarker);
				ctr++;
				poiinfo="";
			}
		}
    }
	if(document.getElementById('getHouseholds').value.toString()=="1")//CURRENT HOUSEHOLDS
    {
    	var hs_length = document.getElementById("hs_length").value.toString();//alert(hs_length);
    	var point;
    	var hinfo = "";
		var occupantsChild = "";
		var ctr = 0;
		var currHouse = document.getElementById("hs_householdId0").value.toString();
		var img = document.getElementById("hs_icon").value.toString();
		
		if (hs_length != 0)
		{//alert("HS");
			var prevHouse = currHouse;
			hinfo=""+
			"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
				document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
				document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
				document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
				"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwpropername"+ctr).value.toString()+"</a><br/>"+
				"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/>";
			
			// = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
			occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
		}//*/
		while(ctr < hs_length)
		{
			currHouse=document.getElementById("hs_householdId"+ctr).value.toString();;
			if (currHouse==prevHouse || ctr==0)
			{
				occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
				point = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
				if(ctr == hs_length-1)
				{
					hinfo=""+
					"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
					document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
					document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
					document.getElementById("hs_street"+ctr).value.toString()+" Street<br/><br/>"+
					"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwLName"+ctr).value.toString()+", "+document.getElementById("hs_bhwFName"+ctr).value.toString()+" "+document.getElementById("hs_bhwMName"+ctr).value.toString()+"</a><br/>"+
					"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/";
					hinfo+=occupantsChild;
				}
			}
			else
			{//*
				hinfo=""+
				"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
				document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
				document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
				document.getElementById("hs_street"+ctr).value.toString()+" Street<br/><br/>"+
				"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwpropername"+ctr).value.toString()+"</a><br/>"+
				"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/";//*/
				
				hinfo+=occupantsChild;
				prevHouse=currHouse;
				centroidMarker = new google.maps.Marker({
					  position: point,
					  map: map,
				      icon: img
					});
				setInfo(centroidMarker,hinfo,map);

				occupantsChild =document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
				oms.addMarker(centroidMarker);
				hinfo="";
			}
			ctr++;
		}//*/
		centroidMarker = new google.maps.Marker({
			  position: point,
			  map: map,
		      icon: img
			});
		setInfo(centroidMarker,hinfo,map);
		oms.addMarker(centroidMarker);
		hinfo="";//*/
    }
}
  function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	  $("#old").change(function() {
		  if($("#old").val()==1)
		  {
			  var map = new google.maps.Map(document.getElementById("map"), {
					center: new google.maps.LatLng(14.301716, 120.942506),
					zoom: 14,
					mapTypeId: 'roadmap'
				});
			  	var oms = new OverlappingMarkerSpiderfier(map);
				if(document.getElementById('getLarva').value.toString()=="1")
			    {
					var ls_length = document.getElementById("ls_length").value.toString();
					var linfo="";
					var point;
					
					if (ls_length != 0)
					{//alert(dg_length);
						
						var ctr =0;//*
						while(ctr < ls_length)
						{
							//*
							linfo = "Larval Survey #"+document.getElementById("ls_no"+ctr).value.toString()+"<br/>"
							//+document.getElementById("ls_household"+ctr).value.toString()+" Household<br/>"//
							+"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("ls_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("ls_household"+ctr).value.toString()+" Household</a><br/>"
							+"Container: "+document.getElementById("ls_container"+ctr).value.toString()+"<br/>"
							+"Created by: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("ls_createdBy"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("ls_bhwName"+ctr).value.toString()+"</a><br/>"
							+"Created on: "+document.getElementById("ls_createdOn"+ctr).value.toString();//*/
							//alert(ctr);
							point = new google.maps.LatLng(document.getElementById("ls_lat"+ctr).value.toString(),document.getElementById("ls_lng"+ctr).value.toString());
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: document.getElementById("ls_icon").value.toString(),
								});
							
							var invariant1=document.getElementById("ls_no"+ctr).value.toString();
							if(document.getElementById("dgLarvalBounce_length").value.toString() != 0)
								for(var i=0;i < document.getElementById("dgLarvalBounce_length").value.toString();i++)
								{
									if(document.getElementById("dgLarvalBounce"+i).value.toString() == invariant1)
										centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
								}
							setInfo(centroidMarker,linfo,map);
							oms.addMarker(centroidMarker);
							//createMarker(map,point,document.getElementById("ls_icon").value.toString(),linfo,null,false,false,false);//*/
							ctr++;
						}
					}
				    
					ls_length = document.getElementById("Pls_length").value.toString();
					linfo="";
					point;
					
					if (ls_length != 0)
					{//alert(dg_length);
						
						var ctr =0;//*
						while(ctr < ls_length)
						{
							//*
							linfo = "Larval Survey #"+document.getElementById("Pls_no"+ctr).value.toString()+"<br/>"
							//+document.getElementById("ls_household"+ctr).value.toString()+" Household<br/>"//
							+"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("Pls_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pls_household"+ctr).value.toString()+" Household</a><br/>"
							+"Container: "+document.getElementById("Pls_container"+ctr).value.toString()+"<br/>"
							+"Created by: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("Pls_createdBy"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pls_bhwName"+ctr).value.toString()+"</a><br/>"
							+"Created on: "+document.getElementById("Pls_createdOn"+ctr).value.toString();//*/
							//alert(ctr);
							point = new google.maps.LatLng(document.getElementById("Pls_lat"+ctr).value.toString(),document.getElementById("Pls_lng"+ctr).value.toString());
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: document.getElementById("Pls_icon").value.toString(),
								});
							
							var invariant1=document.getElementById("Pls_no"+ctr).value.toString();
							if(document.getElementById("PdgLarvalBounce_length").value.toString() != 0)
								for(var i=0;i < document.getElementById("PdgLarvalBounce_length").value.toString();i++)
								{
									if(document.getElementById("PdgLarvalBounce"+i).value.toString() == invariant1)
										centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
								}
							setInfo(centroidMarker,linfo,map);
							oms.addMarker(centroidMarker);
							ctr++;
						}
					}
			    }
				if(document.getElementById('getBb').value.toString()=="1")
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
						var tabStr="";
						//*
						while(ctr<bb_length)
						{//alert(parseFloat(document.getElementById("bb_polyLat"+ctr).value.toString()));
							var cntent;
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
											clickable:true
										});
								bermudaTriangle.setMap(map);
								tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString()+"</h4></center>";
								tabStr +="<br/>";
								if(document.getElementById('getLarva').value.toString()=="1")
								{
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
										tabStr +="Larval Positives Detected: "+document.getElementById('SA1_l').value.toString()+" <i>("+document.getElementById('PSA1_l').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
										tabStr +="Larval Positives Detected: "+document.getElementById('SA3_l').value.toString()+" <i>("+document.getElementById('PSA3_l').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
										tabStr +="Larval Positives Detected: "+document.getElementById('L2_l').value.toString()+" <i>("+document.getElementById('PL2_l').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
										tabStr +="Larval Positives Detected: "+document.getElementById('S1_l').value.toString()+" <i>("+document.getElementById('PS1_l').value.toString()+")</i>";
								}
								tabStr +="<br/>";
								if(document.getElementById('getDengue').value.toString()=="1")
								{
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
										tabStr +="Dengue Cases Detected: "+document.getElementById('SA1_d').value.toString()+" <i>("+document.getElementById('PSA1_d').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
										tabStr +="Dengue Cases Detected: "+document.getElementById('SA3_d').value.toString()+" <i>("+document.getElementById('PSA3_d').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
										tabStr +="Dengue Cases Detected: "+document.getElementById('L2_d').value.toString()+" <i>("+document.getElementById('PL2_d').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
										tabStr +="Dengue Cases Detected: "+document.getElementById('S1_d').value.toString()+" <i>("+document.getElementById('PS1_d').value.toString()+")</i>";
								}
								tabStr +="<br/>";
								if(document.getElementById('getPoi').value.toString()=="1")
								{
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
										tabStr +="Points of Interest Detected: "+document.getElementById('SA1_p').value.toString()+" <i>("+document.getElementById('PS1_p').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
										tabStr +="Points of Interest Detected: "+document.getElementById('SA3_p').value.toString()+" <i>("+document.getElementById('PSA3_p').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
										tabStr +="Points of Interest Detected: "+document.getElementById('L2_p').value.toString()+" <i>("+document.getElementById('PL2_p').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
										tabStr +="Points of Interest Detected: "+document.getElementById('S1_p').value.toString()+" <i>("+document.getElementById('PS1_p').value.toString()+")</i>";
								}
								tabStr +="<br/>";
								if(document.getElementById('getHouseholds').value.toString()=="1")
								{
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
										tabStr +="Houeholds Detected: "+document.getElementById('SA1_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
										tabStr +="Houeholds Detected: "+document.getElementById('SA3_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
										tabStr +="Houeholds Detected: "+document.getElementById('L2_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
										
									if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
										tabStr +="Houeholds Detected: "+document.getElementById('S1_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
								}
								/*
								tabStr += "<h5></>Table 1. Displaying Age Distribution for period <br/><i>"+document.getElementById("cdate1").value.toString()+" to "+document.getElementById("cdate2").value.toString()+"</i>";
								tabStr += "<br/><table border='1' cellpadding='5' cellspacing='0' id='results' >";
								tabStr += "<tr><td align='center'><b>Age Range</b></td><td align='center'><b>Patient Amount</b></td></tr>";
								for(var i=0; i < document.getElementById("table1_length").value.toString(); i++ )
								{
									//alert(""+document.getElementById("table1_brgy"+i).value.toString() + document.getElementById("bb_polyName"+ctr).value.toString());
									if(document.getElementById("table1_brgy"+i).value.toString() == document.getElementById("bb_polyName"+(ctr-1)).value.toString())
									{
										tabStr +="<td align='center'>"+document.getElementById("table1_range"+(i)).value.toString()+"</td>"
											+"<td align='center'>"+document.getElementById("table1_count"+(i)).value.toString()+"</td></tr>";
									}
								}
								tabStr +="</table></center>";//*/
								setPolyInfo(bermudaTriangle,tabStr,map);
								//tabStr="";
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
									clickable:true
								});
						bermudaTriangle.setMap(map);
						
						tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString()+"</h4></center>";
						tabStr +="<br/>";
						if(document.getElementById('getLarva').value.toString()=="1")
						{
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
								tabStr +="Larval Positives Detected: "+document.getElementById('SA1_l').value.toString()+" <i>("+document.getElementById('PSA1_l').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
								tabStr +="Larval Positives Detected: "+document.getElementById('SA3_l').value.toString()+" <i>("+document.getElementById('PSA3_l').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
								tabStr +="Larval Positives Detected: "+document.getElementById('L2_l').value.toString()+" <i>("+document.getElementById('PL2_l').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
								tabStr +="Larval Positives Detected: "+document.getElementById('S1_l').value.toString()+" <i>("+document.getElementById('PS1_l').value.toString()+")</i>";
						}
						tabStr +="<br/>";
						if(document.getElementById('getDengue').value.toString()=="1")
						{
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
								tabStr +="Dengue Cases Detected: "+document.getElementById('SA1_d').value.toString()+" <i>("+document.getElementById('PSA1_d').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
								tabStr +="Dengue Cases Detected: "+document.getElementById('SA3_d').value.toString()+" <i>("+document.getElementById('PSA3_d').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
								tabStr +="Dengue Cases Detected: "+document.getElementById('L2_d').value.toString()+" <i>("+document.getElementById('PL2_d').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
								tabStr +="Dengue Cases Detected: "+document.getElementById('S1_d').value.toString()+" <i>("+document.getElementById('PS1_d').value.toString()+")</i>";
						}
						tabStr +="<br/>";
						if(document.getElementById('getPoi').value.toString()=="1")
						{
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
								tabStr +="Points of Interest Detected: "+document.getElementById('SA1_p').value.toString()+" <i>("+document.getElementById('PS1_p').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
								tabStr +="Points of Interest Detected: "+document.getElementById('SA3_p').value.toString()+" <i>("+document.getElementById('PSA3_p').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
								tabStr +="Points of Interest Detected: "+document.getElementById('L2_p').value.toString()+" <i>("+document.getElementById('PL2_p').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
								tabStr +="Points of Interest Detected: "+document.getElementById('S1_p').value.toString()+" <i>("+document.getElementById('PS1_p').value.toString()+")</i>";
						}
						tabStr +="<br/>";
						if(document.getElementById('getHouseholds').value.toString()=="1")
						{
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN I")
								tabStr +="Houeholds Detected: "+document.getElementById('SA1_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAN AGUSTIN III")
								tabStr +="Houeholds Detected: "+document.getElementById('SA3_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "LANGKAAN II")
								tabStr +="Houeholds Detected: "+document.getElementById('L2_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
								
							if(document.getElementById("bb_polyName"+(ctr-1)).value.toString() == "SAMPALOC I")
								tabStr +="Houeholds Detected: "+document.getElementById('S1_h').value.toString()+" <i>("+document.getElementById('PSA1_h').value.toString()+")</i>";
						}
						/*
						tabStr += "<h5></>Table 1. Displaying Age Distribution for period <br/><i>"+document.getElementById("cdate1").value.toString()+" to "+document.getElementById("cdate2").value.toString()+"</i>";
						tabStr += "<br/><table border='1' cellpadding='5' cellspacing='0' id='results' >";
						tabStr += "<tr><td align='center'><b>Age Range</b></td><td align='center'><b>Patient Amount</b></td></tr>";
						for(var i=0; i < document.getElementById("table1_length").value.toString(); i++ )
						{
							//alert(""+document.getElementById("table1_brgy"+i).value.toString() + document.getElementById("bb_polyName"+ctr).value.toString());
							if(document.getElementById("table1_brgy"+i).value.toString() == document.getElementById("bb_polyName"+(ctr-1)).value.toString())
							{
								tabStr +="<td align='center'>"+document.getElementById("table1_range"+(i)).value.toString()+"</td>"
									+"<td align='center'>"+document.getElementById("table1_count"+(i)).value.toString()+"</td></tr>";
							}
						}
						tabStr +="</table></center>";//*/
						setPolyInfo(bermudaTriangle,tabStr,map);
						
						polygonChild = [];
					}
			    }	
				if(document.getElementById('getPoi').value.toString()=="1")
			    {
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
							//createMarker(map,point,img,poiinfo,null,false,false,false);//*/
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: img
								});
							var invariant1=document.getElementById("poi_id"+ctr).value.toString();
							if(document.getElementById("dgPoIBounce_length").value.toString() != 0)
								for(var i=0;i < document.getElementById("dgPoIBounce_length").value.toString();i++)
								{
									if(document.getElementById("dgPoIBounce"+i).value.toString() == invariant1)
										centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
								}
							setInfo(centroidMarker,poiinfo,map);
							oms.addMarker(centroidMarker);
							ctr++;
							poiinfo="";
						}
					}

					poi_length = document.getElementById("Ppoi_length").value.toString();
					poiinfo="";
					point;
					img;
					
					if (poi_length != 0)
					{
						img=document.getElementById("Ppoi_iconS").value.toString();
						var ctr =0;//*
						while(ctr < poi_length)
						{//*
							poiinfo = "<b>"+document.getElementById("Ppoi_name"+ctr).value.toString()+"</b><br/>";
							if(parseInt(document.getElementById("Ppoi_type"+ctr).value.toString()) === 1)
								{
									img=document.getElementById("Ppoi_iconR").value.toString();//poiinfo +="SOURCE AREA<br/><br/>"poi_iconS;
								}
								//poiinfo +="RISK AREA<br/><br/>";//*/
							poiinfo +=document.getElementById("Ppoi_barangay"+ctr).value.toString()+"<br/>";
							poiinfo +=document.getElementById("Ppoi_notes"+ctr).value.toString()+"<br/>";
							
							//alert(ctr);
							point = new google.maps.LatLng(document.getElementById("Ppoi_lat"+ctr).value.toString(),document.getElementById("Ppoi_lng"+ctr).value.toString());
							//createMarker(map,point,img,poiinfo,null,false,false,false);//*/
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: img
								});
							var invariant1=document.getElementById("Ppoi_id"+ctr).value.toString();
							if(document.getElementById("PdgPoIBounce_length").value.toString() != 0)
								for(var i=0;i < document.getElementById("PdgPoIBounce_length").value.toString();i++)
								{
									if(document.getElementById("PdgPoIBounce"+i).value.toString() == invariant1)
										centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
								}
							setInfo(centroidMarker,poiinfo,map);
							oms.addMarker(centroidMarker);
							ctr++;
							poiinfo="";
						}
					}
			    }	
				if(document.getElementById('getHouseholds').value.toString()=="1")
			    {
					var hs_length = document.getElementById("hs_length").value.toString();//alert(hs_length);
			    	var point;
			    	var hinfo = "";
					var occupantsChild = "";
					var ctr = 0;
					var currHouse = document.getElementById("hs_householdId0").value.toString();
					var img = document.getElementById("hs_icon").value.toString();
					
					if (hs_length != 0)
					{//alert("HS");
						var prevHouse = currHouse;
						hinfo=""+
							"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
							document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
							document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
							document.getElementById("hs_street"+ctr).value.toString()+"<br/><br/>"+
							"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwpropername"+ctr).value.toString()+"</a><br/>"+
							"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/>";
						
						// = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
						occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
					}//*/
					while(ctr < hs_length)
					{
						currHouse=document.getElementById("hs_householdId"+ctr).value.toString();;
						if (currHouse==prevHouse || ctr==0)
						{
							occupantsChild+=document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
							point = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
							if(ctr == hs_length-1)
							{
								hinfo=""+
								"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
								document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
								document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
								document.getElementById("hs_street"+ctr).value.toString()+" Street<br/><br/>"+
								"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwpropername"+ctr).value.toString()+"</a><br/>"+
								"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/";
								hinfo+=occupantsChild;
							}
						}
						else
						{//*
							hinfo=""+
							"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("hs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_householdName"+ctr).value.toString()+" Household</a><br/>"+
							document.getElementById("hs_barangay"+ctr).value.toString()+"<br/>"+
							document.getElementById("hs_houseNo"+ctr).value.toString()+", "+
							document.getElementById("hs_street"+ctr).value.toString()+" Street<br/><br/>"+
							"BHW in-charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/user/update/"+document.getElementById("hs_bhwId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("hs_bhwpropername"+ctr).value.toString()+"</a><br/>"+
							"Last Visit: "+document.getElementById("hs_lastVisited"+ctr).value.toString()+"<br/";//*/
							
							hinfo+=occupantsChild;
							prevHouse=currHouse;
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: img
								});
							setInfo(centroidMarker,hinfo,map);

							occupantsChild =document.getElementById("hs_lname"+ctr).value.toString()+", "+document.getElementById("hs_fname"+ctr).value.toString()+" <i>"+document.getElementById("hs_dob"+ctr).value.toString()+" "+document.getElementById("hs_sex"+ctr).value.toString()+"</i><br/>";
							oms.addMarker(centroidMarker);
							hinfo="";
						}
						ctr++;
					}//*/
					centroidMarker = new google.maps.Marker({
						  position: point,
						  map: map,
					      icon: img
						});
					setInfo(centroidMarker,hinfo,map);
					oms.addMarker(centroidMarker);
					hinfo="";//*/

					hs_length = document.getElementById("phs_length").value.toString();//alert(hs_length);
			    	point=null;
			    	hinfo = "";
					occupantsChild = "";
					ctr = 0;
					currHouse = document.getElementById("Phs_householdId0").value.toString();
					img = document.getElementById("Phs_icon").value.toString();
					
					if (hs_length != 0)
					{//alert("HS");
						var prevHouse = currHouse;
						hinfo=""+
						"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("Phs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Phs_householdName"+ctr).value.toString()+" Household</a><br/>"+
							document.getElementById("Phs_barangay"+ctr).value.toString()+"<br/>"+
							document.getElementById("Phs_houseNo"+ctr).value.toString()+", "+
							document.getElementById("Phs_street"+ctr).value.toString()+"<br/><br/>"+
							"BHW in-charge: "+document.getElementById("Phs_userUsername"+ctr).value.toString()+"<br/>"+
							"Last Visit: "+document.getElementById("Phs_lastVisited"+ctr).value.toString()+"<br/>";
						
						// = new google.maps.LatLng(document.getElementById("hs_lat"+ctr).value.toString(),document.getElementById("hs_lng"+ctr).value.toString());
						occupantsChild+=document.getElementById("Phs_lname"+ctr).value.toString()+", "+document.getElementById("Phs_fname"+ctr).value.toString()+" <i>"+document.getElementById("Phs_dob"+ctr).value.toString()+" "+document.getElementById("Phs_sex"+ctr).value.toString()+"</i><br/>";
					}//*/
					while(ctr < hs_length)
					{
						currHouse=document.getElementById("Phs_householdId"+ctr).value.toString();;
						if (currHouse==prevHouse || ctr==0)
						{
							occupantsChild+=document.getElementById("Phs_lname"+ctr).value.toString()+", "+document.getElementById("Phs_fname"+ctr).value.toString()+" <i>"+document.getElementById("Phs_dob"+ctr).value.toString()+" "+document.getElementById("Phs_sex"+ctr).value.toString()+"</i><br/>";
							point = new google.maps.LatLng(document.getElementById("Phs_lat"+ctr).value.toString(),document.getElementById("Phs_lng"+ctr).value.toString());
							if(ctr == hs_length-1)
							{
								hinfo=""+
								"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("Phs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Phs_householdName"+ctr).value.toString()+" Household</a><br/>"+
								document.getElementById("Phs_barangay"+ctr).value.toString()+"<br/>"+
								document.getElementById("Phs_houseNo"+ctr).value.toString()+", "+
								document.getElementById("Phs_street"+ctr).value.toString()+" Street<br/><br/>"+
								"BHW in-charge: "+document.getElementById("Phs_bhwpropername"+ctr).value.toString()+"<br/>"+
								"Last Visit: "+document.getElementById("Phs_lastVisited"+ctr).value.toString()+"<br/";
								hinfo+=occupantsChild;
							}
						}
						else
						{//*
							//alert(document.getElementById("Phs_householdName"+ctr).value.toString());//*
							hinfo=""+
							"<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("Phs_householdId"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Phs_householdName"+ctr).value.toString()+" Household</a><br/>"+
							document.getElementById("Phs_barangay"+ctr).value.toString()+"<br/>"+
							document.getElementById("Phs_houseNo"+ctr).value.toString()+", "+
							document.getElementById("Phs_street"+ctr).value.toString()+" Street<br/><br/>"+
							"BHW in-charge: "+document.getElementById("Phs_bhwpropername"+ctr).value.toString()+"<br/>"+
							"Last Visit: "+document.getElementById("Phs_lastVisited"+ctr).value.toString()+"<br/";//*/
							
							hinfo+=occupantsChild;
							prevHouse=currHouse;
							centroidMarker = new google.maps.Marker({
								  position: point,
								  map: map,
							      icon: img
								});
							setInfo(centroidMarker,hinfo,map);

							occupantsChild =document.getElementById("Phs_lname"+ctr).value.toString()+", "+document.getElementById("Phs_fname"+ctr).value.toString()+" <i>"+document.getElementById("Phs_dob"+ctr).value.toString()+" "+document.getElementById("Phs_sex"+ctr).value.toString()+"</i><br/>";
							oms.addMarker(centroidMarker);
							hinfo="";
						}
						ctr++;
					}//*/
					centroidMarker = new google.maps.Marker({
						  position: point,
						  map: map,
					      icon: img
						});
					setInfo(centroidMarker,hinfo,map);
					oms.addMarker(centroidMarker);
					hinfo="";//*/
			    }	
				if(document.getElementById('getDengue').value.toString()=="1")//PREVIOUS DENGUE CASES
			    {
				    //alert("Alert DG!");
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
							//dinfo = "<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("dg_caseNo"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</a><br/>"
							if(document.getElementById("dg_status"+ctr) != null)
							{
								dinfo = "<b><a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("dg_caseNo"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</a></b><br/>";
							}
							else
							{
								dinfo = "<b>"+document.getElementById("dg_lName"+ctr).value.toString()+", "+document.getElementById("dg_fName"+ctr).value.toString()+"</b><br/>";
							}
							dinfo+="<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("dg_householdID"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_householdName"+ctr).value.toString()+" Household</a><br/>"//+document.getElementById("dg_householdName"+ctr).value.toString()+" Household<br/>"
								+document.getElementById("dg_houseNo"+ctr).value.toString()+", "
								+document.getElementById("dg_street"+ctr).value.toString()+" "
								+document.getElementById("dg_barangay"+ctr).value.toString()+"<br/>"
								+"Birth: "+document.getElementById("dg_dob"+ctr).value.toString()+"<br/>"
								+"Gender: "+document.getElementById("dg_sex"+ctr).value.toString()+"<br/>"
								+"Guardian: "+document.getElementById("dg_guardian"+ctr).value.toString()+"<br/>"
								+"Contact No: "+document.getElementById("dg_contact"+ctr).value.toString()+"<br/><br/>"
								+"Case Information <br/>"
								+"Case No: "+document.getElementById("dg_caseNo"+ctr).value.toString()+"<br/>";//alert("!");
							if(document.getElementById("dg_status"+ctr) != null)
							{
								dinfo +="Status: "+document.getElementById("dg_status"+ctr).value.toString()+"<br/>";
							}
							else
							{
								dinfo +="Outcome: "+document.getElementById("dg_outcome"+ctr).value.toString()+"<br/>";//alert("!");
							}
							dinfo +="Days Fever: "+document.getElementById("dg_daysFever"+ctr).value.toString()+"<br/>"
								+"Suspect Source: "+document.getElementById("dg_suspectedSource"+ctr).value.toString()+"<br/>"
								+"Muscle Pain: "+document.getElementById("dg_hasMusclePain"+ctr).value.toString()+"<br/>"
								+"Joint Pain: "+document.getElementById("dg_hasJointPain"+ctr).value.toString()+"<br/>"
								+"Headache: "+document.getElementById("dg_hasHeadache"+ctr).value.toString()+"<br/>"
								+"Bleeding: "+document.getElementById("dg_hasBleeding"+ctr).value.toString()+"<br/>"
								+"Rashes: "+document.getElementById("dg_hasRashes"+ctr).value.toString()+"<br/>"
								+"BHW in Charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("dg_bhwName"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_bhwpropername"+ctr).value.toString()+"</a><br/>"//+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
								+"Last Visit: "+document.getElementById("dg_lastVisited"+ctr).value.toString()+"<br/><br/>";
							//alert(ctr);
							point = new google.maps.LatLng(document.getElementById("dg_lat"+ctr).value.toString(),document.getElementById("dg_lng"+ctr).value.toString());
							var setCircle=false;
							if(document.getElementById("dgPoIDistance_length").value.toString() != 0)
							{
								if(document.getElementById("dgPoIDistance"+ctr).value.toString() == 0)
								{
									dinfo += "No Points of Interests detected nearby.<br/>";
								}
								else
								{
									dinfo += document.getElementById("dgPoIDistance"+ctr).value.toString();
									setCircle=true;
								}
							}//*
							if(document.getElementById("dgLarvalDistance_length").value.toString() != 0)
							{
								if(document.getElementById("dgLarvalDistance"+ctr).value.toString() == 0)
								{
									dinfo += "No Larval Positives detected nearby.<br/>";
								}
								else
								{
									dinfo += document.getElementById("dgLarvalDistance"+ctr).value.toString();
									setCircle=true;
								}
							}
							if(setCircle)
							{
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
							}//*/
							//*
							if(document.getElementById("dg_status"+ctr) == null)
							{//alert("!");
								if(document.getElementById("dg_outcome"+ctr).value.toString() == "A")
									img=document.getElementById("dg_iconA").value.toString();
								else
									img=document.getElementById("dg_iconD").value.toString();
							}
							else if(document.getElementById("dg_status"+ctr).value.toString() == "threatening")
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
							//createMarker(map,point,img,dinfo,null,false,false,false);//*/
							centroidMarker = new google.maps.Marker({  
						        position: point,   
						        map: map,  
						        icon: img
						    	});  
							ctr++;
							setInfo(centroidMarker,dinfo,map);
							oms.addMarker(centroidMarker);
						}
					}
					
				    //alert("Alert DG!");
					dg_length = document.getElementById("Pdg_length").value.toString();
					dinfo="";
					point;
					img;
					
					if (dg_length != 0)
					{//alert(dg_length);
						var ctr =0;//*
						while(ctr < dg_length)
						{
							//*
							img=document.getElementById("Pdg_icon1").value.toString();
							//dinfo = "<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("Pdg_personID"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pdg_lName"+ctr).value.toString()+", "+document.getElementById("Pdg_fName"+ctr).value.toString()+"</a><br/>"
							if(document.getElementById("Pdg_status"+ctr) != null)
							{
								dinfo = "<b><a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/cases/view_person/"+document.getElementById("Pdg_caseNo"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pdg_lName"+ctr).value.toString()+", "+document.getElementById("Pdg_fName"+ctr).value.toString()+"</a></b><br/>";
							}
							else
							{
								dinfo = "<b>"+document.getElementById("Pdg_lName"+ctr).value.toString()+", "+document.getElementById("Pdg_fName"+ctr).value.toString()+"</b><br/>";
							}
							dinfo+="<a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_persons/"+document.getElementById("Pdg_householdID"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pdg_householdName"+ctr).value.toString()+" Household</a><br/>"//+document.getElementById("dg_householdName"+ctr).value.toString()+" Household<br/>"
								+document.getElementById("Pdg_houseNo"+ctr).value.toString()+", "
								+document.getElementById("Pdg_street"+ctr).value.toString()+" "
								+document.getElementById("Pdg_barangay"+ctr).value.toString()+"<br/>"
								+"Birth: "+document.getElementById("Pdg_dob"+ctr).value.toString()+"<br/>"
								+"Gender: "+document.getElementById("Pdg_sex"+ctr).value.toString()+"<br/>"
								+"Guardian: "+document.getElementById("Pdg_guardian"+ctr).value.toString()+"<br/>"
								+"Contact No: "+document.getElementById("Pdg_contact"+ctr).value.toString()+"<br/><br/>"
								+"Case Information <br/>"
								+"Case No: "+document.getElementById("Pdg_caseNo"+ctr).value.toString()+"<br/>";//alert("!");
							if(document.getElementById("Pdg_status"+ctr) != null)
							{
								dinfo +="Status: "+document.getElementById("Pdg_status"+ctr).value.toString()+"<br/>";
							}
							else
							{
								dinfo +="Outcome: "+document.getElementById("Pdg_outcome"+ctr).value.toString()+"<br/>";//alert("!");
							}
							dinfo +="Days Fever: "+document.getElementById("Pdg_daysFever"+ctr).value.toString()+"<br/>"
								+"Suspect Source: "+document.getElementById("Pdg_suspectedSource"+ctr).value.toString()+"<br/>"
								+"Muscle Pain: "+document.getElementById("Pdg_hasMusclePain"+ctr).value.toString()+"<br/>"
								+"Joint Pain: "+document.getElementById("Pdg_hasJointPain"+ctr).value.toString()+"<br/>"
								+"Headache: "+document.getElementById("Pdg_hasHeadache"+ctr).value.toString()+"<br/>"
								+"Bleeding: "+document.getElementById("Pdg_hasBleeding"+ctr).value.toString()+"<br/>"
								+"Rashes: "+document.getElementById("Pdg_hasRashes"+ctr).value.toString()+"<br/>"
								+"BHW in Charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("Pdg_bhwName"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("Pdg_bhwpropername"+ctr).value.toString()+"</a><br/>"//+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
								+"Last Visit: "+document.getElementById("Pdg_lastVisited"+ctr).value.toString()+"<br/><br/>";
							//alert(ctr);
							point = new google.maps.LatLng(document.getElementById("Pdg_lat"+ctr).value.toString(),document.getElementById("Pdg_lng"+ctr).value.toString());
							var setCircle=false;
							if(document.getElementById("PdgPoIDistance_length").value.toString() != 0)
							{
								if(document.getElementById("PdgPoIDistance"+ctr).value.toString() == 0)
								{
									dinfo += "No Points of Interests detected nearby.<br/>";
								}
								else
								{
									dinfo += document.getElementById("PdgPoIDistance"+ctr).value.toString();
									setCircle=true;
								}
							}//*
							if(document.getElementById("PdgLarvalDistance_length").value.toString() != 0)
							{
								if(document.getElementById("PdgLarvalDistance"+ctr).value.toString() == 0)
								{
									dinfo += "No Larval Positives detected nearby.<br/>";
								}
								else
								{
									dinfo += document.getElementById("PdgLarvalDistance"+ctr).value.toString();
									setCircle=true;
								}
							}
							if(setCircle)
							{
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
							}//*/
							//*
							if(document.getElementById("Pdg_status"+ctr) == null)
							{//alert("!");
								if(document.getElementById("Pdg_outcome"+ctr).value.toString() == "A")
									img=document.getElementById("Pdg_iconA").value.toString();
								else
									img=document.getElementById("Pdg_iconD").value.toString();
							}
							else if(document.getElementById("Pdg_status"+ctr).value.toString() == "threatening")
							{
								img=document.getElementById("Pdg_icon2").value.toString();
							}
							else if(document.getElementById("Pdg_status"+ctr).value.toString() == "serious")
							{
								img=document.getElementById("Pdg_icon3").value.toString();
							}
							else if(document.getElementById("Pdg_status"+ctr).value.toString() == "hospitalized")
							{
								img=document.getElementById("Pdg_icon4").value.toString();
							}//*/
							//createMarker(map,point,img,dinfo,null,false,false,false);//*/
							centroidMarker = new google.maps.Marker({  
						        position: point,   
						        map: map,  
						        icon: img
						    	});  
							ctr++;
							setInfo(centroidMarker,dinfo,map);
							oms.addMarker(centroidMarker);
						}
					}
			    } 
		  }
		  else
		  {
			  load();
		  }
	  });
	});
</script>
</head>
<input type = 'hidden' id ='baseURL' name='baseURL' value='<?php echo base_url()?>'>
<input type = 'hidden' id ='getLarva' name='getLarva' value='<?php echo $getLarva?>'>
<input type = 'hidden' id ='getDengue' name='getDengue' value='<?php echo $getDengue?>'>
<input type = 'hidden' id ='getPoi' name='getPoi' value='<?php echo $getPoI?>'>
<input type = 'hidden' id ='getHouseholds' name='getHouseholds' value='<?php echo $getHouseholds?>'>
<input type = 'hidden' id ='getBb' name='getBb' value='<?php echo $getBB?>'>

<input type = 'hidden' id ='dataBInfo' name='dataBInfo' value='<?php echo $binfo?>'>
<input type = 'hidden' id ='dataBAge' name='dataBAge' value='<?php echo $table1?>'>
<input type = 'hidden' id ='dataBAge2' name='dataBAge2' value='<?php echo $bage?>'>
<input type = 'hidden' id ='dataBCount' name='dataBCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<!-- <input type = 'hidden' id ='Larva' name='Larva' value=''> -->
<input type = 'hidden' id ='Dengue' name='Dengue' value=''>
<input type = 'hidden' id ='Household' name='Household' value=''>

<input type = 'hidden' id ='SA1_l' name='SA1_l' value='<?php echo $SA1_l?>'>
<input type = 'hidden' id ='SA3_l' name='SA3_l' value='<?php echo $SA3_l?>'>
<input type = 'hidden' id ='L2_l' name='L2_l' value='<?php echo $L2_l?>'>
<input type = 'hidden' id ='S1_l' name='S1_l' value='<?php echo $S1_l?>'>

<input type = 'hidden' id ='SA1_d' name='SA1_d' value='<?php echo $SA1_d?>'>
<input type = 'hidden' id ='SA3_d' name='SA3_d' value='<?php echo $SA3_d?>'>
<input type = 'hidden' id ='L2_d' name='L2_d' value='<?php echo $L2_d?>'>
<input type = 'hidden' id ='S1_d' name='S1_d' value='<?php echo $S1_d?>'>

<input type = 'hidden' id ='SA1_p' name='SA1_p' value='<?php echo $SA1_p?>'>
<input type = 'hidden' id ='SA3_p' name='SA3_p' value='<?php echo $SA3_p?>'>
<input type = 'hidden' id ='L2_p' name='L2_p' value='<?php echo $L2_p?>'>
<input type = 'hidden' id ='S1_p' name='S1_p' value='<?php echo $S1_p?>'>

<input type = 'hidden' id ='SA1_h' name='SA1_h' value='<?php echo $SA1_h?>'>
<input type = 'hidden' id ='SA3_h' name='SA3_h' value='<?php echo $SA3_h?>'>
<input type = 'hidden' id ='L2_h' name='L2_h' value='<?php echo $L2_h?>'>
<input type = 'hidden' id ='S1_h' name='S1_h' value='<?php echo $S1_h?>'>

<input type = 'hidden' id ='PSA1_l' name='PSA1_l' value='<?php echo $PSA1_l?>'>
<input type = 'hidden' id ='PSA3_l' name='PSA3_l' value='<?php echo $PSA3_l?>'>
<input type = 'hidden' id ='PL2_l' name='PL2_l' value='<?php echo $PL2_l?>'>
<input type = 'hidden' id ='PS1_l' name='PS1_l' value='<?php echo $PS1_l?>'>

<input type = 'hidden' id ='PSA1_d' name='PSA1_d' value='<?php echo $PSA1_d?>'>
<input type = 'hidden' id ='PSA3_d' name='PSA3_d' value='<?php echo $PSA3_d?>'>
<input type = 'hidden' id ='PL2_d' name='PL2_d' value='<?php echo $PL2_d?>'>
<input type = 'hidden' id ='PS1_d' name='PS1_d' value='<?php echo $PS1_d?>'>

<input type = 'hidden' id ='PSA1_p' name='PSA1_p' value='<?php echo $PSA1_p?>'>
<input type = 'hidden' id ='PSA3_p' name='PSA3_p' value='<?php echo $PSA3_p?>'>
<input type = 'hidden' id ='PL2_p' name='PL2_p' value='<?php echo $PL2_p?>'>
<input type = 'hidden' id ='PS1_p' name='PS1_p' value='<?php echo $PS1_p?>'>

<input type = 'hidden' id ='PSA1_h' name='PSA1_h' value='<?php echo $PSA1_h?>'>
<input type = 'hidden' id ='PSA3_h' name='PSA3_h' value='<?php echo $PSA3_h?>'>
<input type = 'hidden' id ='PL2_h' name='PL2_h' value='<?php echo $PL2_h?>'>
<input type = 'hidden' id ='PS1_h' name='PS1_h' value='<?php echo $PS1_h?>'>

<?php if ($table1 != null){?>
<input type="hidden" id="table1_length" value="<?php echo count($table1); ?>" />
	<?php for ($ctr = 0; $ctr < count($table1); $ctr++) {if($ctr != 0){?>
		<input type="hidden" id="table1_brgy<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['cr_barangay']; ?>"	/>
		<input type="hidden" id="table1_count<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['patientcount']; ?>"	/>
		<input type="hidden" id="table1_range<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['agerange']; ?>"	/>
	<?php }
		else {?>
		<input type="hidden" id="table1_brgy<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['cr_barangay']; ?>"	/>
		<input type="hidden" id="table1_count<?= $ctr ?>" 	value="Patient Count"	/>
		<input type="hidden" id="table1_range<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['agerange']; ?>"	/><?php }}?> 
	<?php } else { ?> <input type="hidden" id="table1_length" value="0" /> <?php } ?>

	<!-- Period 1 Data -->
	
<?php if ($denguePoIDistance != null){?>
<input type="hidden" id="dgPoIDistance_length" value="<?php echo count($denguePoIDistance); ?>" />
	<?php for ($ctr = 0; $ctr < count($denguePoIDistance); $ctr++) {?>
		<input type="hidden" id="dgPoIDistance<?= $ctr ?>" 	value="<?php echo $denguePoIDistance[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="dgPoIDistance_length" value="0" /> <?php } ?>
	
<?php if ($denguePoIBounce != null){?>
<input type="hidden" id="dgPoIBounce_length" value="<?php echo count($denguePoIBounce); ?>" />
	<?php for ($ctr = 0; $ctr < count($denguePoIBounce); $ctr++) {?>
		<input type="hidden" id="dgPoIBounce<?= $ctr ?>" 	value="<?php echo $denguePoIBounce[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="dgPoIBounce_length" value="0" /> <?php } ?>

<?php if ($dengueLarvalDistance != null){?>
<input type="hidden" id="dgLarvalDistance_length" value="<?php echo count($dengueLarvalDistance); ?>" />
	<?php for ($ctr = 0; $ctr < count($dengueLarvalDistance); $ctr++) {?>
		<input type="hidden" id="dgLarvalDistance<?= $ctr ?>" 	value="<?php echo $dengueLarvalDistance[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="dgLarvalDistance_length" value="0" /> <?php } ?>
	
<?php if ($dengueLarvalBounce != null){?>
<input type="hidden" id="dgLarvalBounce_length" value="<?php echo count($dengueLarvalBounce); ?>" />
	<?php for ($ctr = 0; $ctr < count($dengueLarvalBounce); $ctr++) {?>
		<input type="hidden" id="dgLarvalBounce<?= $ctr ?>" 	value="<?php echo $dengueLarvalBounce[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="dgLarvalBounce_length" value="0" /> <?php } ?>

	<!-- Period 2 Data -->
	
<?php if ($PdenguePoIDistance != null){?>
<input type="hidden" id="PdgPoIDistance_length" value="<?php echo count($PdenguePoIDistance); ?>" />
	<?php for ($ctr = 0; $ctr < count($PdenguePoIDistance); $ctr++) {?>
		<input type="hidden" id="PdgPoIDistance<?= $ctr ?>" 	value="<?php echo $PdenguePoIDistance[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="PdgPoIDistance_length" value="0" /> <?php } ?>
	
<?php if ($PdenguePoIBounce != null){?>
<input type="hidden" id="PdgPoIBounce_length" value="<?php echo count($PdenguePoIBounce); ?>" />
	<?php for ($ctr = 0; $ctr < count($PdenguePoIBounce); $ctr++) {?>
		<input type="hidden" id="PdgPoIBounce<?= $ctr ?>" 	value="<?php echo $PdenguePoIBounce[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="PdgPoIBounce_length" value="0" /> <?php } ?>

<?php if ($PdengueLarvalDistance != null){?>
<input type="hidden" id="PdgLarvalDistance_length" value="<?php echo count($PdengueLarvalDistance); ?>" />
	<?php for ($ctr = 0; $ctr < count($PdengueLarvalDistance); $ctr++) {?>
		<input type="hidden" id="PdgLarvalDistance<?= $ctr ?>" 	value="<?php echo $PdengueLarvalDistance[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="PdgLarvalDistance_length" value="0" /> <?php } ?>
	
<?php if ($PdengueLarvalBounce != null){?>
<input type="hidden" id="PdgLarvalBounce_length" value="<?php echo count($PdengueLarvalBounce); ?>" />
	<?php for ($ctr = 0; $ctr < count($PdengueLarvalBounce); $ctr++) {?>
		<input type="hidden" id="PdgLarvalBounce<?= $ctr ?>" 	value="<?php echo $PdengueLarvalBounce[$ctr]; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="PdgLarvalBounce_length" value="0" /> <?php } ?>
	
	<!-- Period 1 Data -->
	
<?php if ($larval != null){?>
<input type="hidden" id="ls_length" value="<?php echo count($larval); ?>" />
	<?php for ($ctr = 0; $ctr < count($larval); $ctr++) {?>
		<input type="hidden" id="ls_no<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['id']; ?>"	/>
		<input type="hidden" id="ls_household<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['household']; ?>"	/>
		<input type="hidden" id="ls_householdId<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['householdId']; ?>"	/>
		<input type="hidden" id="ls_container<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['container']; ?>"	/>
		<input type="hidden" id="ls_lat<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="ls_lng<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['lng']; ?>"	/>
		<input type="hidden" id="ls_createdBy<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['createdBy']; ?>"	/>
		<input type="hidden" id="ls_createdOn<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['createdOn']; ?>"	/>
		<input type="hidden" id="ls_updatedBy<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['updatedBy']; ?>"	/>
		<input type="hidden" id="ls_updatedOn<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['updatedOn']; ?>"	/>
		<input type="hidden" id="ls_barangay<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['barangay']; ?>"	/>
		<input type="hidden" id="ls_bhwID<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="ls_bhwName<?= $ctr ?>" 	value="<?php echo $larval[$ctr]['bhwName']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="ls_length" value="0" /> <?php } ?>
	<input type="hidden" id="ls_icon" value="<?php echo base_url('/images/eggs.png')?>" />
	
<?php if ($bb != null){?>
<input type="hidden" id="bb_length" value="<?php echo count($bb); ?>" />
	<?php for ($ctr = 0; $ctr < count($bb); $ctr++) {?>
		<input type="hidden" id="bb_polyName<?= $ctr ?>" 	value="<?php echo $bb[$ctr]['pName']; ?>"	/>
		<input type="hidden" id="bb_polyID<?= $ctr ?>" 		value="<?php echo $bb[$ctr]['pID']; ?>"	/>
		<input type="hidden" id="bb_polyLat<?= $ctr ?>"		value="<?php echo $bb[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="bb_polyLng<?= $ctr ?>" 	value="<?php echo $bb[$ctr]['lng']; ?>"			/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="bb_length" value="0" /> <?php } ?>
	
<?php if ($poi != null){?>
<input type="hidden" id="poi_length" value="<?php echo count($poi); ?>" />
	<?php for ($ctr = 0; $ctr < count($poi); $ctr++) {?>
		<input type="hidden" id="poi_id<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['id']; ?>"	/>
		<input type="hidden" id="poi_name<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['name']; ?>"	/>
		<input type="hidden" id="poi_lat<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="poi_lng<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['lng']; ?>"	/>
		<input type="hidden" id="poi_notes<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['notes']; ?>"	/>
		<input type="hidden" id="poi_type<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['type']; ?>"	/>
		<input type="hidden" id="poi_addedOn<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['addedOn']; ?>"	/>
		<input type="hidden" id="poi_endDate<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['endDate']; ?>"	/>
		<input type="hidden" id="poi_barangay<?= $ctr ?>" 	value="<?php echo $poi[$ctr]['barangay']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="poi_length" value="0" /> <?php } ?>
	<input type="hidden" id="poi_iconR" value="<?php echo base_url('/images/risk.png')?>" />
	<input type="hidden" id="poi_iconS" value="<?php echo base_url('/images/source.png')?>" />
	
	<!-- Period 2 Data -->
	
	<?php if ($Plarval != null){?>
	<input type="hidden" id="Pls_length" value="<?php echo count($Plarval); ?>" />
		<?php for ($ctr = 0; $ctr < count($Plarval); $ctr++) {?>
			<input type="hidden" id="Pls_no<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['id']; ?>"	/>
			<input type="hidden" id="Pls_household<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['household']; ?>"	/>
			<input type="hidden" id="Pls_householdId<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['householdId']; ?>"	/>
			<input type="hidden" id="Pls_container<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['container']; ?>"	/>
			<input type="hidden" id="Pls_lat<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['lat']; ?>"	/>
			<input type="hidden" id="Pls_lng<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['lng']; ?>"	/>
			<input type="hidden" id="Pls_createdBy<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['createdBy']; ?>"	/>
			<input type="hidden" id="Pls_createdOn<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['createdOn']; ?>"	/>
			<input type="hidden" id="Pls_updatedBy<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['updatedBy']; ?>"	/>
			<input type="hidden" id="Pls_updatedOn<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['updatedOn']; ?>"	/>
			<input type="hidden" id="Pls_bhwName<?= $ctr ?>" 	value="<?php echo $Plarval[$ctr]['bhwName']; ?>"	/>
		<?php }?> 
		<?php } else { ?> <input type="hidden" id="Pls_length" value="0" /> <?php } ?>
		<input type="hidden" id="Pls_icon" value="<?php echo base_url('/images/Peggs.png')?>" />
		
	<?php if ($Ppoi != null){?>
	<input type="hidden" id="Ppoi_length" value="<?php echo count($Ppoi); ?>" />
		<?php for ($ctr = 0; $ctr < count($Ppoi); $ctr++) {?>
			<input type="hidden" id="Ppoi_id<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['id']; ?>"	/>
			<input type="hidden" id="Ppoi_name<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['name']; ?>"	/>
			<input type="hidden" id="Ppoi_lat<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['lat']; ?>"	/>
			<input type="hidden" id="Ppoi_lng<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['lng']; ?>"	/>
			<input type="hidden" id="Ppoi_notes<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['notes']; ?>"	/>
			<input type="hidden" id="Ppoi_type<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['type']; ?>"	/>
			<input type="hidden" id="Ppoi_addedOn<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['addedOn']; ?>"	/>
			<input type="hidden" id="Ppoi_endDate<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['endDate']; ?>"	/>
			<input type="hidden" id="Ppoi_barangay<?= $ctr ?>" 	value="<?php echo $Ppoi[$ctr]['barangay']; ?>"	/>
		<?php }?> 
		<?php } else { ?> <input type="hidden" id="Ppoi_length" value="0" /> <?php } ?>
		<input type="hidden" id="Ppoi_iconR" value="<?php echo base_url('/images/Prisk.png')?>" />
		<input type="hidden" id="Ppoi_iconS" value="<?php echo base_url('/images/Psource.png')?>" />
		
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='dist' name='dist' value='<?php echo $dist?>'>

<input type = 'hidden' id ='PLarva' name='PLarva' value='<?php echo $Plarval?>'>
<input type = 'hidden' id ='Pdist' name='Pdist' value='<?php echo $Pdist?>'>

<input type = 'hidden' id ='interest' name='interest' value='<?php echo $interest?>'>

<!-- <input type = 'hidden' id ='Pdata' name='Pdata' value='<?php// echo $Pnodes?>'> -->
<input type = 'hidden' id ='PdataBInfo' name='PdataBInfo' value='<?php echo $Pbinfo?>'>
<input type = 'hidden' id ='PdataBAge' name='PdataBAge' value='<?php echo $table2?>'>
<input type = 'hidden' id ='PdataBAge2' name='PdataBAge2' value='<?php echo $Pbage?>'>
<input type = 'hidden' id ='PdataBCount' name='PdataBCount' value='<?php echo $Pbcount?>'>
<input type = 'hidden' id ='Ptype' name='Ptype' value='<?php echo $node_type?>'>
	
	<!-- Period 1 Data -->

<?php if ($household != null){$hs_invariant=count($household);?>
<input type="hidden" id="hs_length" value="<?php echo $hs_invariant; ?>" />
	<?php for ($ctr = 0; $ctr < $hs_invariant; $ctr++) {?>
		<input type="hidden" id="hs_householdId<?= $ctr ?>" 	value="<?php echo $household[$ctr]['id']; ?>"	/>
		<input type="hidden" id="hs_householdName<?= $ctr ?>" 	value="<?php echo $household[$ctr]['houseName']; ?>"	/>
		<input type="hidden" id="hs_houseNo<?= $ctr ?>"			value="<?php echo $household[$ctr]['houseNo']; ?>"	/>
		<input type="hidden" id="hs_street<?= $ctr ?>" 			value="<?php echo $household[$ctr]['street']; ?>"			/>
		<input type="hidden" id="hs_lastVisited<?= $ctr ?>"	 	value="<?php echo $household[$ctr]['lastVisited']; ?>"			/>
		<input type="hidden" id="hs_lat<?= $ctr ?>" 			value="<?php echo $household[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="hs_lng<?= $ctr ?>" 			value="<?php echo $household[$ctr]['lng']; ?>"		/>
		<input type="hidden" id="hs_personId<?= $ctr ?>" 		value="<?php echo $household[$ctr]['personID']; ?>"		/>
		<input type="hidden" id="hs_bhwId<?= $ctr ?>" 			value="<?php echo $household[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="hs_userUsername<?= $ctr ?>"	value="<?php echo $household[$ctr]['bhwUsername']; ?>"	/>
		<input type="hidden" id="hs_barangay<?= $ctr ?>" 		value="<?php echo $household[$ctr]['householdBarangay']; ?>"	/>
		<input type="hidden" id="hs_fname<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personFName']; ?>"	/>
		<input type="hidden" id="hs_lname<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personLName']; ?>"	/>
		<input type="hidden" id="hs_dob<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personDoB']; ?>"	/>
		<input type="hidden" id="hs_sex<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personSex']; ?>"	/>
		<input type="hidden" id="hs_bhwpropername<?= $ctr ?>" 			value="<?php echo $household[$ctr]['bhwpropername']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="hs_length" value="0" /> <?php } ?>
	<input type="hidden" id="hs_icon" value="<?php echo base_url('/images/group-2.png')?>" />
	
	<!-- Period 2 Data -->

<?php if ($household != null){$Phs_invariant=count($Phousehold);?>
<input type="hidden" id="phs_length" value="<?php echo $Phs_invariant; ?>" />
	<?php for ($ctr = 0; $ctr < $Phs_invariant; $ctr++) {?>
		<input type="hidden" id="Phs_householdId<?= $ctr ?>" 	value="<?php echo $Phousehold[$ctr]['id']; ?>"	/>
		<input type="hidden" id="Phs_householdName<?= $ctr ?>" 	value="<?php echo $Phousehold[$ctr]['houseName']; ?>"	/>
		<input type="hidden" id="Phs_houseNo<?= $ctr ?>"			value="<?php echo $Phousehold[$ctr]['houseNo']; ?>"	/>
		<input type="hidden" id="Phs_street<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['street']; ?>"			/>
		<input type="hidden" id="Phs_lastVisited<?= $ctr ?>"	 	value="<?php echo $Phousehold[$ctr]['lastVisited']; ?>"			/>
		<input type="hidden" id="Phs_lat<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="Phs_lng<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['lng']; ?>"		/>
		<input type="hidden" id="Phs_personId<?= $ctr ?>" 		value="<?php echo $Phousehold[$ctr]['personID']; ?>"		/>
		<input type="hidden" id="Phs_bhwId<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="Phs_userUsername<?= $ctr ?>"	value="<?php echo $Phousehold[$ctr]['bhwUsername']; ?>"	/>
		<input type="hidden" id="Phs_barangay<?= $ctr ?>" 		value="<?php echo $Phousehold[$ctr]['householdBarangay']; ?>"	/>
		<input type="hidden" id="Phs_fname<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['personFName']; ?>"	/>
		<input type="hidden" id="Phs_lname<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['personLName']; ?>"	/>
		<input type="hidden" id="Phs_dob<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['personDoB']; ?>"	/>
		<input type="hidden" id="Phs_sex<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['personSex']; ?>"	/>
		<input type="hidden" id="Phs_bhwpropername<?= $ctr ?>" 			value="<?php echo $Phousehold[$ctr]['bhwpropername']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="hs_length" value="0" /> <?php } ?>
	<input type="hidden" id="Phs_icon" value="<?php echo base_url('/images/Pgroup-2.png')?>" />
	
	<!-- Period 1 Data -->
	
<?php if ($dengue != null){?>
<input type="hidden" id="dg_length" value="<?php echo count($dengue); ?>" />
	<?php for ($ctr = 0; $ctr < count($dengue); $ctr++) {?>	
		<input type="hidden" id="dg_caseNo<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['id']; ?>"	/>
		<input type="hidden" id="dg_personID<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['personID']; ?>"	/>
		<input type="hidden" id="dg_hasMusclePain<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['hasMusclePain']; ?>"	/>
		<input type="hidden" id="dg_hasJointPain<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['hasJointPain']; ?>"	/>
		<input type="hidden" id="dg_hasHeadache<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['hasHeadache']; ?>"	/>
		<input type="hidden" id="dg_hasBleeding<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['hasBleeding']; ?>"	/>
		<input type="hidden" id="dg_hasRashes<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['hasRashes']; ?>"	/>
		<input type="hidden" id="dg_daysFever<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['daysFever']; ?>"	/>
		<input type="hidden" id="dg_createdOn<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['createdOn']; ?>"	/>
		<input type="hidden" id="dg_lastUpdatedOn<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['lastUpdatedOn']; ?>"	/>
		<input type="hidden" id="dg_suspectedSource<?= $ctr ?>" 	value="<?php echo $dengue[$ctr]['suspectedSource']; ?>"	/>
		<input type="hidden" id="dg_remarks<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['remarks']; ?>"	/>
		<?php if (isset($dengue[$ctr]['status'])){?>
		<input type="hidden" id="dg_status<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['status']; ?>"	/>
		<?php }else{?>
		<input type="hidden" id="dg_outcome<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['outcome']; ?>"	/>
		<?php }?>
		<input type="hidden" id="dg_householdID<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['householdID']; ?>"	/>
		<input type="hidden" id="dg_personID<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['personID']; ?>"	/>
		<input type="hidden" id="dg_bhwID<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="dg_householdName<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['householdName']; ?>"	/>
		<input type="hidden" id="dg_houseNo<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['houseNo']; ?>"	/>
		<input type="hidden" id="dg_street<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['street']; ?>"	/>
		<input type="hidden" id="dg_lastVisited<?= $ctr ?>" 		value="<?php echo $dengue[$ctr]['lastVisited']; ?>"	/>
		<input type="hidden" id="dg_lat<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="dg_lng<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['lng']; ?>"	/>
		<input type="hidden" id="dg_bhwName<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['bhwName']; ?>"	/>
		<input type="hidden" id="dg_barangay<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['barangay']; ?>"	/>
		<input type="hidden" id="dg_fName<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['fName']; ?>"	/>
		<input type="hidden" id="dg_lName<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['lName']; ?>"	/>
		<input type="hidden" id="dg_dob<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['dob']; ?>"	/>
		<input type="hidden" id="dg_sex<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['sex']; ?>"	/>
		<input type="hidden" id="dg_guardian<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['guardian']; ?>"	/>
		<input type="hidden" id="dg_contact<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['contact']; ?>"	/>
		<input type="hidden" id="dg_bhwpropername<?= $ctr ?>" 			value="<?php echo $dengue[$ctr]['propername']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="dg_length" value="0" /> <?php } ?>
	<input type="hidden" id="dg_icon1" value="<?php echo base_url('/images/notice.png')?>" />
	<input type="hidden" id="dg_icon2" value="<?php echo base_url('/images/notice2.png')?>" />
	<input type="hidden" id="dg_icon3" value="<?php echo base_url('/images/notice3.png')?>" />
	<input type="hidden" id="dg_icon4" value="<?php echo base_url('/images/hospital.png')?>" />
	<input type="hidden" id="dg_iconA" value="<?php echo base_url('/images/A.png')?>" />
	<input type="hidden" id="dg_iconD" value="<?php echo base_url('/images/D.png')?>" />
	
	<!-- Period 2 Data -->
	
<?php if ($Pdengue != null){?>
<input type="hidden" id="Pdg_length" value="<?php echo count($Pdengue); ?>" />
	<?php for ($ctr = 0; $ctr < count($Pdengue); $ctr++) {?>	
		<input type="hidden" id="Pdg_caseNo<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['id']; ?>"	/>
		<input type="hidden" id="Pdg_personID<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['personID']; ?>"	/>
		<input type="hidden" id="Pdg_hasMusclePain<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['hasMusclePain']; ?>"	/>
		<input type="hidden" id="Pdg_hasJointPain<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['hasJointPain']; ?>"	/>
		<input type="hidden" id="Pdg_hasHeadache<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['hasHeadache']; ?>"	/>
		<input type="hidden" id="Pdg_hasBleeding<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['hasBleeding']; ?>"	/>
		<input type="hidden" id="Pdg_hasRashes<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['hasRashes']; ?>"	/>
		<input type="hidden" id="Pdg_daysFever<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['daysFever']; ?>"	/>
		<input type="hidden" id="Pdg_createdOn<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['createdOn']; ?>"	/>
		<input type="hidden" id="Pdg_lastUpdatedOn<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['lastUpdatedOn']; ?>"	/>
		<input type="hidden" id="Pdg_suspectedSource<?= $ctr ?>" 	value="<?php echo $Pdengue[$ctr]['suspectedSource']; ?>"	/>
		<input type="hidden" id="Pdg_remarks<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['remarks']; ?>"	/>
		<?php if (isset($Pdengue[$ctr]['status'])){?>
		<input type="hidden" id="Pdg_status<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['status']; ?>"	/>
		<?php }else{?>
		<input type="hidden" id="Pdg_outcome<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['outcome']; ?>"	/>
		<?php }?>
		<input type="hidden" id="Pdg_householdID<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['householdID']; ?>"	/>
		<input type="hidden" id="Pdg_personID<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['personID']; ?>"	/>
		<input type="hidden" id="Pdg_bhwID<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="Pdg_householdName<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['householdName']; ?>"	/>
		<input type="hidden" id="Pdg_houseNo<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['houseNo']; ?>"	/>
		<input type="hidden" id="Pdg_street<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['street']; ?>"	/>
		<input type="hidden" id="Pdg_lastVisited<?= $ctr ?>" 		value="<?php echo $Pdengue[$ctr]['lastVisited']; ?>"	/>
		<input type="hidden" id="Pdg_lat<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['lat']; ?>"	/>
		<input type="hidden" id="Pdg_lng<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['lng']; ?>"	/>
		<input type="hidden" id="Pdg_bhwName<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['bhwName']; ?>"	/>
		<input type="hidden" id="Pdg_barangay<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['barangay']; ?>"	/>
		<input type="hidden" id="Pdg_fName<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['fName']; ?>"	/>
		<input type="hidden" id="Pdg_lName<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['lName']; ?>"	/>
		<input type="hidden" id="Pdg_dob<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['dob']; ?>"	/>
		<input type="hidden" id="Pdg_sex<?= $ctr ?>" 				value="<?php echo $Pdengue[$ctr]['sex']; ?>"	/>
		<input type="hidden" id="Pdg_guardian<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['guardian']; ?>"	/>
		<input type="hidden" id="Pdg_contact<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['contact']; ?>"	/>
		<input type="hidden" id="Pdg_bhwpropername<?= $ctr ?>" 			value="<?php echo $Pdengue[$ctr]['propername']; ?>"	/>
	<?php }?> 
	<?php } else { ?> <input type="hidden" id="Pdg_length" value="0" /> <?php } ?>
	<input type="hidden" id="Pdg_icon1" value="<?php echo base_url('/images/Pnotice.png')?>" />
	<input type="hidden" id="Pdg_icon2" value="<?php echo base_url('/images/Pnotice2.png')?>" />
	<input type="hidden" id="Pdg_icon3" value="<?php echo base_url('/images/Pnotice3.png')?>" />
	<input type="hidden" id="Pdg_icon4" value="<?php echo base_url('/images/Phospital.png')?>" />
	<input type="hidden" id="Pdg_iconA" value="<?php echo base_url('/images/PA.png')?>" />
	<input type="hidden" id="Pdg_iconD" value="<?php echo base_url('/images/PD.png')?>" />
	
	<input type="hidden" id="cdate1" value="<?php echo $cdate1?>" />
	<input type="hidden" id="cdate2" value="<?php echo $cdate2?>" />

</form>
<body onload="load()">
<?php 
	$optionsMonths=array(
		"01"=>"January",
		"02"=>"February",
		"03"=>"March",
		"04"=>"April",
		"05"=>"May",
		"06"=>"June",
		"07"=>"July",
		"08"=>"August",
		"09"=>"September",
		"10"=>"October",
		"11"=>"November",
		"12"=>"December"
	);
	$optionsYear=array(
		
		"2006"=>"2006",
		"2007"=>"2007",
		"2008"=>"2008",
		"2009"=>"2009",
		"2010"=>"2010",
		"2011"=>"2011",
		"2012"=>"2012",
		"2013"=>"2013",
		"2014"=>"2014",
		"2015"=>"2015",
		"2016"=>"2016"
	);?>
<center><table border="0" width=90%>
<tr>
	<td style="width:75%; height:900px" rowspan="1">
	    <div id="map" style="width: 100%%; height: 100%"></div>
	</td>
	<td id='pad15' style="width:25%; height:900px">
		<form action="" method='post'>
		<label style="color:red"><?php echo form_error('NDtype-ddl'); ?></label>
		
		
		<center><table border="1" style="width:90%">
		<tr><td>
		<h4><center>Map Control<br /><i>(Today is <?php echo date('F d, Y');?>)</i></center></h4></td></tr>
		<tr><td id='pad15' style="width:50%"><h4><center>Node Type</center></h4>
		<?php 
		$cboxDengue = array(
				'name'        => 'cboxDengue',
				'id'          => 'cboxDengue',
				'value'       => 'denguecase',
				'checked'     => $getDengue,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxDengue);
		echo "Dengue Nodes<br/>";
		
		$cboxActiveDengueOnly = array(
				'name'        => 'cboxActiveDengueOnly',
				'id'          => 'cboxActiveDengueOnly',
				'value'       => 'activedenguecaseonly',
				'checked'     => $getActiveDengueOnly,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxActiveDengueOnly);
		echo "Active Case Nodes Only<br/>";
		
		$cboxLarva = array(
				'name'        => 'cboxLarva',
				'id'          => 'cboxLarva',
				'value'       => 'larvalpositive',
				'checked'     => $getLarva,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxLarva);
		echo "Larva Nodes<br/>";
		
		$cboxPoI = array(
				'name'        => 'cboxPoI',
				'id'          => 'cboxPoI',
				'value'       => 'pointsofinterest',
				'checked'     => $getPoI,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxPoI);
		echo "Points of Interest<br/>";
		//*
		$cboxHouseholds = array(
				'name'        => 'cboxHouseholds',
				'id'          => 'cboxHouseholds',
				'value'       => 'Households',
				'checked'     => $getHouseholds,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxHouseholds);
		echo "Households<br/>";//*/
		
		$cboxBarangayBoundaries = array(
				'name'        => 'cboxBB',
				'id'          => 'cboxBB',
				'value'       => 'barangayboundaries',
				'checked'     => $getBB,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxBarangayBoundaries);
		echo "Barangay Boundaries<br/>";
		?></td><tr><td id='pad15'><h4><center>Date</center></h4>
		
		
		
	    <b>Main Search Date </b><?php echo "<br/><i>(".$cdate1." to ".$cdate2.")</i>"?>
		<br /><!-- 
	    From: <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
	    To: <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
		<br /> -->
		<?php 
		
		echo "Start Date:<br/>";
		echo form_dropdown('YearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo "End Date:&#160;<br/>";
		echo form_dropdown('YearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthEnd-ddl', $optionsMonths,date('m'));
		?>
		<br/><br/><b> Date Comparison </b><br/>
		
		<?php
		echo "<i>(".$pdate1." to ".$pdate2.")</i><br/>"; 	
		?>
		<select name='old' id='old'>
		  <option value="0" selected>Hide</option>
		  <option value="1">Display</option>
		</select>Period 2 Nodes <br />
		<br/> 
		<select name='deflt' id='deflt'>
		  <option value="1" selected>Default</option>
		  <option value="0">Custom</option>
		</select><br/>
		<i>Default, same period of the previous year(s)</i><br/>
		<i>Custom, from drop down lists below</i><br/><br/>
		
		<?php
		echo "Start Date:<br/>";
		echo form_dropdown('PYearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo "End Date:&#160;<br/>";
		echo form_dropdown('PYearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthEnd-ddl', $optionsMonths,date('m'));
		?></td></tr>
		</table>
		<div><br/><input type="submit" value="Sort Data" width="40%"/></center></div>
		</form> 
	</td>
</tr>

</table></center>
<!-- <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-text="<?php echo $bcount?>">Tweet</a> -->
<script>/*
	!function(d,s,id)
	{
		var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id))
		{
			js=d.createElement(s);
			js.id=id;
			js.src="https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	}
	(document,"script","twitter-wjs");//*/
</script>
		
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>
