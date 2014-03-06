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
infoWindow.setOptions({maxWidth:400});

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
				+"Created by: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("ls_createdBy"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("ls_createdBy"+ctr).value.toString()+"</a><br/>"
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
	if(document.getElementById('getBb').value.toString()=="1")
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
					tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString();
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
					tabStr +="</table></center>";
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
			
			tabStr = "<center><h4>Barangay "+document.getElementById("bb_polyName"+(ctr-1)).value.toString();
			tabStr += "<h5></>Table 1. Displaying Age Distribution for period <br/><i>"+document.getElementById("cdate1").value.toString()+" to "+document.getElementById("cdate2").value.toString()+"</i>";
			tabStr += "<br/><table border='1' cellpadding='5' cellspacing='0' id='results' >";
			tabStr += "<tr><td align='center'><b>Age Range</b></td><td align='center'><b>Patient Amount</b></td></tr>";
			for(var i=0; i < document.getElementById("table1_length").value.toString(); i++ )
			{
				if(document.getElementById("table1_brgy"+i).value.toString() == document.getElementById("bb_polyName"+(ctr-1)).value.toString())
				{
					tabStr +="<td align='center'>"+document.getElementById("table1_range"+(i)).value.toString()+"</td>"
						+"<td align='center'>"+document.getElementById("table1_count"+(i)).value.toString()+"</td></tr>";
				}
			}
			tabStr +="</table></center>";
			setPolyInfo(bermudaTriangle,tabStr,map);
			
			polygonChild = [];
		}
	}
	if(document.getElementById('getDengue').value.toString()=="1")
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
					+"BHW in Charge: <a href='"+document.getElementById("baseURL").value.toString()+"index.php/website/households/filter_HHs/"+document.getElementById("dg_bhwName"+ctr).value.toString()+"' target='_blank'>"+document.getElementById("dg_bhwName"+ctr).value.toString()+"</a><br/>"//+"BHW in-charge: "+document.getElementById("dg_bhwName"+ctr).value.toString()+"<br/>"
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
    }
	if(document.getElementById('getHouseholds').value.toString()=="1")
    {//alert("Household");
		mapHouseholdOverlay(map);
    }
    /*
	else
	{
    	//Data handler, SPLITTER
		var str = document.getElementById('data').value.toString();
		str = str.split("%&");
		
		mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge2').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
	}//*/
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
				
				
				if(document.getElementById('getLarva').value.toString()=="1")
			    {
					mapLarvalOverlay(map);
				    //mapLarvalOverlay(map,document.getElementById('Pdist').value,document.getElementById("PLarva").value,true);
			        //mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("Larva").value,false);
			    }
				if(document.getElementById('getBb').value.toString()=="1")
				{
					mapBarangayOverlay(map);
			    }	
				if(document.getElementById('getPoi').value.toString()=="1")
			    {
					mapPointsOfInterest(map);
			    }	
				if(document.getElementById('getHouseholds').value.toString()=="1")
			    {
					mapHouseholdOverlay(map);
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
<input type = 'hidden' id ='Dengue' name='Dengue' value='<?php echo $dengue?>'>
<input type = 'hidden' id ='Household' name='Household' value='<?php echo $household?>'>

<?php if ($table1 != null){?>
<input type="hidden" id="table1_length" value="<?php echo count($table1); ?>" />
	<?php for ($ctr = 0; $ctr < count($table1); $ctr++) {if($ctr != 0){?>
		<input type="hidden" id="table1_brgy<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['cr_barangay']; ?>"	/>
		<input type="hidden" id="table1_count<?= $ctr ?>" 	value="<?php echo $table1[$ctr]['patientcount']; ?>"	/>
		<input type="hidden" id="table1_range<?= $ctr ?>" 	value="<?php echo $table1[$ctr][0]; ?>"	/>
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
	<?php }?> 
	<input type="hidden" id="ls_icon" value="<?php echo base_url('/images/eggs-2.png')?>" />
	<?php } else { ?> <input type="hidden" id="ls_length" value="0" /> <?php } ?>
	
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
	<input type="hidden" id="poi_iconR" value="<?php echo base_url('/images/risk.png')?>" />
	<input type="hidden" id="poi_iconS" value="<?php echo base_url('/images/source.png')?>" />
	<?php } else { ?> <input type="hidden" id="poi_length" value="0" /> <?php } ?>
	
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
		<?php }?> 
		<input type="hidden" id="Pls_icon" value="<?php echo base_url('/images/eggs-2.png')?>" />
		<?php } else { ?> <input type="hidden" id="Pls_length" value="0" /> <?php } ?>
		
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
		<input type="hidden" id="Ppoi_iconR" value="<?php echo base_url('/images/risk.png')?>" />
		<input type="hidden" id="Ppoi_iconS" value="<?php echo base_url('/images/source.png')?>" />
		<?php } else { ?> <input type="hidden" id="Ppoi_length" value="0" /> <?php } ?>
		
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

<?php if ($household != null){?>
<input type="hidden" id="hs_length" value="<?php echo count($household); ?>" />
	<?php for ($ctr = 0; $ctr < count($household); $ctr++) {?>
		<input type="hidden" id="hs_householdId<?= $ctr ?>" 	value="<?php echo $household[$ctr]['householdID']; ?>"	/>
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
	<?php }?> 
	<input type="hidden" id="hs_icon" value="<?php echo base_url('/images/group.png')?>" />
	<?php } else { ?> <input type="hidden" id="hs_length" value="0" /> <?php } ?>
	
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
	<?php }?> 
	<input type="hidden" id="dg_icon1" value="<?php echo base_url('/images/notice.png')?>" />
	<input type="hidden" id="dg_icon2" value="<?php echo base_url('/images/notice2.png')?>" />
	<input type="hidden" id="dg_icon3" value="<?php echo base_url('/images/notice3.png')?>" />
	<input type="hidden" id="dg_icon4" value="<?php echo base_url('/images/hospital.png')?>" />
	<input type="hidden" id="dg_iconA" value="<?php echo base_url('/images/A.png')?>" />
	<input type="hidden" id="dg_iconD" value="<?php echo base_url('/images/D.png')?>" />
	<?php } else { ?> <input type="hidden" id="dg_length" value="0" /> <?php } ?>
	
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
	<?php }?> 
	<input type="hidden" id="Pdg_icon1" value="<?php echo base_url('/images/notice.png')?>" />
	<input type="hidden" id="Pdg_icon2" value="<?php echo base_url('/images/notice2.png')?>" />
	<input type="hidden" id="Pdg_icon3" value="<?php echo base_url('/images/notice3.png')?>" />
	<input type="hidden" id="Pdg_icon4" value="<?php echo base_url('/images/hospital.png')?>" />
	<input type="hidden" id="Pdg_iconA" value="<?php echo base_url('/images/A.png')?>" />
	<input type="hidden" id="Pdg_iconD" value="<?php echo base_url('/images/D.png')?>" />
	<?php } else { ?> <input type="hidden" id="Pdg_length" value="0" /> <?php } ?>
	
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
<table border="1" width=100%>
<tr>
	<td style="width:70%; height:600px" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td id='pad15' style="width:30%; height:200px">
		<form action="" method='post'>
		<label style="color:red"><?php echo form_error('NDtype-ddl'); ?></label>
		
		
		<table border="0" style="width:500px">
		<tr><td colspan="2">
		<h3><center>Map Control<br /><i>(Today is <?php echo date('F d, Y');?>)</i></center></h3></td></tr>
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
		$cboxHouseholds = array(
				'name'        => 'cboxHouseholds',
				'id'          => 'cboxHouseholds',
				'value'       => 'Households',
				'checked'     => $getHouseholds,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxHouseholds);
		echo "Households<br/>";
		$cboxBarangayBoundaries = array(
				'name'        => 'cboxBB',
				'id'          => 'cboxBB',
				'value'       => 'barangayboundaries',
				'checked'     => $getBB,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxBarangayBoundaries);
		echo "Barangay Boundaries<br/>";
		?></td><td id='pad15'><h4><center>Date</center></h4>
		
		
		
	    <b>Main Search Date </b><?php echo "<br/><i>(".$cdate1." to ".$cdate2.")</i>"?>
		<br /><!-- 
	    From: <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
	    To: <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
		<br /> -->
		<?php 
		
		echo "Start Date:";
		echo form_dropdown('YearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo "End Date:&#160;";
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
		echo "Start Date:";
		echo form_dropdown('PYearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo "End Date:&#160;";
		echo form_dropdown('PYearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthEnd-ddl', $optionsMonths,date('m'));
		?></td></tr>
		</table>
		<div><br/><center><input type="submit" value="Sort Data" width="40%"/></center></div>
		</form> 
	</td>
</tr>

</table>
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
