<!-- HEADER -->
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
<script type="text/javascript">
	google.load('visualization', '1.1', {packages: ['controls','corechart']});
</script>
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
var infoWindow = new google.maps.InfoWindow();
infoWindow.setOptions({maxWidth:400});

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

function load() {
	var map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(14.301716, 120.942506),
		zoom: 14,
		mapTypeId: 'roadmap'
	});
	
	
	if(document.getElementById('getLarva').value.toString()=="1")
    {
        mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("Larva").value,false);
    }
	if(document.getElementById('getBb').value.toString()=="1")
	{
		//alert("Alert BB!");
		mapBarangayOverlay(map);
	}
	if(document.getElementById('getDengue').value.toString()=="1")
    {
	    //alert("Alert DG!");
		mapDengueOverlay(map);
    }
	if(document.getElementById('getPoi').value.toString()=="1")
    {
		mapPointsOfInterest(map);
    }
	if(document.getElementById('getHouseholds').value.toString()=="1")
    {
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
				    mapLarvalOverlay(map,document.getElementById('Pdist').value,document.getElementById("PLarva").value,true);
			        mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("Larva").value,false);
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
			    	/*Data handler, SPLITTER
					var str = document.getElementById('data').value.toString();
					str = str.split("%&");
					var Pstr = document.getElementById('Pdata').value.toString();
					Pstr = Pstr.split("%&");
					
					mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
					mapLarvalOverlay(map,document.getElementById('Pdist').value.toString(),Pstr[0],true);
					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
					//mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('PdataBAge2').value.toString(),Pstr[1],document.getElementById('PdataBInfo').value.toString(),true);
					mapHousholds(map,barangayCount,barangayAge,datax,barangayInfo) //Denguecase barangay polygon display//*/
		  }
		  else
		  {
			  //load();
		  }
	  });
	});
</script>
</head>
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
<input type = 'hidden' id ='Larva' name='Larva' value='<?php echo $larval?>'>
<input type = 'hidden' id ='Dengue' name='Dengue' value='<?php echo $dengue?>'>
<input type = 'hidden' id ='Household' name='Household' value='<?php echo $household?>'>

<?php if ($bb != 0){?>
<input type="hidden" id="bb_length" value="<?php echo count($bb); ?>" />
	<?php for ($ctr = 0; $ctr < count($bb); $ctr++) {?>
		<input type="hidden" id="bb_polyName<?= $ctr ?>" 	value="<?php echo $bb[$ctr]['pName']; ?>"	/>
		<input type="hidden" id="bb_polyID<?= $ctr ?>" 		value="<?php echo $bb[$ctr]['pID']; ?>"	/>
		<input type="hidden" id="bb_polyLat<?= $ctr ?>"		value="<?php echo $bb[$ctr]['pLat']; ?>"	/>
		<input type="hidden" id="bb_polyLng<?= $ctr ?>" 	value="<?php echo $bb[$ctr]['pLng']; ?>"			/>
	<?php }?> 
	<input type="hidden" id="bb_icon" value="<?php echo base_url('/images/arrow.png')?>" />
	<?php } else { ?> <input type="hidden" id="bb_length" value="0" /> <?php } ?>
	
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
<input type = 'hidden' id ='PDengue' name='PDengue' value='<?php echo $Pdengue?>'>

<?php if ($household != 0){?>
<input type="hidden" id="hs_length" value="<?php echo count($household); ?>" />
	<?php for ($ctr = 0; $ctr < count($household); $ctr++) {?>
		<input type="hidden" id="hs_householdId<?= $ctr ?>" 	value="<?php echo $household[$ctr]['householdID']; ?>"	/>
		<input type="hidden" id="hs_householdName<?= $ctr ?>" 	value="<?php echo $household[$ctr]['houseName']; ?>"	/>
		<input type="hidden" id="hs_houseNo<?= $ctr ?>"			value="<?php echo $household[$ctr]['houseNo']; ?>"	/>
		<input type="hidden" id="hs_street<?= $ctr ?>" 			value="<?php echo $household[$ctr]['street']; ?>"			/>
		<input type="hidden" id="hs_lastVisited<?= $ctr ?>"	 	value="<?php echo $household[$ctr]['lastVisited']; ?>"			/>
		<input type="hidden" id="hs_lat<?= $ctr ?>" 			value="<?php echo $household[$ctr]['householdLat']; ?>"	/>
		<input type="hidden" id="hs_lng<?= $ctr ?>" 			value="<?php echo $household[$ctr]['householdLng']; ?>"		/>
		<input type="hidden" id="hs_personId<?= $ctr ?>" 		value="<?php echo $household[$ctr]['personID']; ?>"		/>
		<input type="hidden" id="hs_bhwId<?= $ctr ?>" 			value="<?php echo $household[$ctr]['bhwID']; ?>"	/>
		<input type="hidden" id="hs_userUsername<?= $ctr ?>"	value="<?php echo $household[$ctr]['bhwUsername']; ?>"	/>
		<input type="hidden" id="hs_barangay<?= $ctr ?>" 		value="<?php echo $household[$ctr]['householdBarangay']; ?>"	/>
		<input type="hidden" id="hs_fname<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personFName']; ?>"	/>
		<input type="hidden" id="hs_lname<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personLName']; ?>"	/>
		<input type="hidden" id="hs_dob<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personDoB']; ?>"	/>
		<input type="hidden" id="hs_sex<?= $ctr ?>" 			value="<?php echo $household[$ctr]['personSex']; ?>"	/>
	<?php }?> 
	<input type="hidden" id="hs_icon" value="<?php echo base_url('/images/arrow.png')?>" />
	<?php } else { ?> <input type="hidden" id="hs_length" value="0" /> <?php } ?>
	
<?php if ($dengue != 0){?>
<input type="hidden" id="dg_length" value="<?php echo count($dengue); ?>" />
	<?php for ($ctr = 0; $ctr < count($dengue); $ctr++) {?>	
		<input type="hidden" id="dg_caseNo<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['caseNo']; ?>"	/>
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
		<input type="hidden" id="dg_status<?= $ctr ?>" 				value="<?php echo $dengue[$ctr]['status']; ?>"	/>
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
	<input type="hidden" id="dg_icon" value="<?php echo base_url('/images/arrow.png')?>" />
	<?php } else { ?> <input type="hidden" id="dg_length" value="0" /> <?php } ?>

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
		"1990"=>"1990",
		"1991"=>"1991",
		"1992"=>"1992",
		"1993"=>"1993",
		"1994"=>"1994",
		"1995"=>"1995",
		"1996"=>"1996",
		"1997"=>"1997",
		"1998"=>"1998",
		"1999"=>"1999",
		"2000"=>"2000",
		"2001"=>"2001",
		"2002"=>"2002",
		"2003"=>"2003",
		"2004"=>"2004",
		"2005"=>"2005",
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
		"2016"=>"2016",
		"2017"=>"2017",
		"2018"=>"2018",
		"2019"=>"2019",
		"2020"=>"2020"
	);?>
<table border="1" width=100%>
<tr>
	<td style="width:60%; height:600px" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td style="width:40%; height:200px">
		<form action="" method='post'>
		<label style="color:red"><?php echo form_error('NDtype-ddl'); ?></label>
		<div id="info" class="info">
		<i>(Today is <?php echo date('F d, Y');?>)</i>
		
		<h4>
		Select 'Barangay overlay' to view dengue cases per barangay.<br />
		Select 'Larval overlay' to view positive larval samplings.<br />
		Select 'both' to view overlays displaying both larval positives and dengue cases.<br />
		<?php 
		$options=array(
			"both"=>"Both",
			"denguecase"=>"Barangay overlay",
			"larvalpositive"=>"Larval overlay"
		);
		echo form_dropdown('NDtype-ddl', $options, $node_type);
		echo "<br/>";
		$cboxDengue = array(
				'name'        => 'cboxDengue',
				'id'          => 'cboxDengue',
				'value'       => 'denguecase',
				'checked'     => $getDengue,
				'style'       => 'margin:10px',
		);
		echo form_checkbox($cboxDengue);
		echo "Dengue Nodes<br/>";
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
		?></h4></div>
		
		
		
	    Main Search Date: <?php echo "<i>(Currently ".$cdate1." to ".$cdate2.")</i>"?>
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
		echo " End Date:&#160;&#160;";
		echo form_dropdown('YearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthEnd-ddl', $optionsMonths,date('m'));
		?>
		<br/><br/>
		<select name='old' id='old'>
		  <option value="0" selected>Hide</option>
		  <option value="1">Display</option>
		</select> <b> nodes containing old data.</b><br />
		
		<?php
		echo "Old Data Comparison: <i>(Currently ".$pdate1." to ".$pdate2.")</i><br/>"; 	
		?>
		Use 
		<select name='deflt' id='deflt'>
		  <option value="0">custom</option>
		  <option value="1" selected>default</option>
		</select> date for old data comparison. <i>Default is same length and period of the previous year(s)</i><br/>
		<?php
		echo "Start Date:";
		echo form_dropdown('PYearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo " End Date:&#160;&#160;";
		echo form_dropdown('PYearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthEnd-ddl', $optionsMonths,date('m'));
		?>
		<div><input type="submit" value="Sort" /></div>
		</form> 
	</td>
</tr>
<tr>
	<td style="width:40%; height:60%" rowspan='2'>
	<div style="height: 100%; overflow: auto;">
		<?php 
		$tmpl = array (
						'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" >',
					    'heading_row_start'   => '<tr>',
					    'heading_row_end'     => '</tr>',
					    'heading_cell_start'  => '<th id="result" scope="col">',
					    'heading_cell_end'    => '</th>',
					    'row_start'           => '<tr>',
					    'row_end'             => '</tr>',
					    'cell_start'          => '<td align="center">',
					    'cell_end'            => '</td>',
					    'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
					    'row_alt_end'         => '</tr>',
					    'cell_alt_start'      => '<td align="center">',
					    'cell_alt_end'        => '</td>',
					    'table_close'         => '</table>'
					   );
		$this->table->set_template($tmpl);
		echo "<br/><center><b>Age Distribution:</b><br/><h4></>Table 1. Displaying Age Distribution for period <br/><i>".$cdate1." to ".$cdate2."</i></h6>";
		echo $this->table->generate($table1);?>
		<?php echo "<br/><b>Age Distribution:</b><br/><h4></>Table 2. Displaying Age Distribution for period <br/><i>".$pdate1." to ".$pdate2."</i></h6><center>";
		echo $this->table->generate($table2);
		?>
	</div>
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
