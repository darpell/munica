<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
    <script type="text/javascript">
		$( document ).bind( "mobileinit", function() {
			// Make your jQuery Mobile framework configuration changes here!
			$.support.cors = true;
			$.mobile.allowCrossDomainPages = true;
		});
    </script>
    <script>
var geocoder = new google.maps.Geocoder();
function initialize(){
	
        if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    }
}
      function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              	//alert(results[0].formatted_address);
				//document.getElementById("test").innerHTML = results[0].formatted_address;
				//document.getElementById("TPstreet-txt").value = results[0].address_components[0].long_name;
				//document.getElementById("TPmunicipality-txt").value = results[0].address_components[2].long_name;
				//document.getElementById("TPbarangay-txt").value = results[0].address_components[1].long_name;
				//document.getElementById("lat").value = lat;
				//document.getElementById("lng").value = lng;
				
					  $('.lat').val(lat);
					  $('.lng').val(lng);
					  $('.TPstreet-txt').val(results[0].address_components[0].long_name);
					  $('.TPmunicipality-txt').val(results[0].address_components[2].long_name);
					  $('.TPbarangay-txt').val(results[0].address_components[1].long_name);
				
            } else {
              alert('No results found');
            }
          } else {
            alert('Geocoder failed due to: ' + status);
          }
        });
      }

       function showError(error)
	  {
	  switch(error.code) 
	    {
	    case error.PERMISSION_DENIED:
	      x.innerHTML="User denied the request for Geolocation.";
	      break;
	    case error.POSITION_UNAVAILABLE:
	      x.innerHTML="Location information is unavailable.";
	      break;
	    case error.TIMEOUT:
	      x.innerHTML="The request to get user location timed out.";
	      break;
	    case error.UNKNOWN_ERROR:
	      x.innerHTML="An unknown error occurred.";
	      break;
	    }
	  }
</script>

<!-- CONTENT -->
</head>
<body onload="initialize()">
<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="home_header" data-position="fixed" data-nobackbtn="true">
        <!-- <p style="font-size:medium;padding:5px;text-align:center;">Dengue Mapping</p> -->
        <a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
        <h1> Plot Points </h1>
    </div><!-- /header -->

    <div data-role="content">
    	<!-- Data Collapsible -->
    	<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
	    	<!-- PoI -->
	    	<div data-role="collapsible">
	    		<h2> Point of Interest </h2>
	    		<form action="new_poi" method="post" data-ajax="false">
				
				<!-- date -->
				<label for="TPdate-txt"> Date: </label>
				<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
				<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
				<!-- /date -->
			
				<!-- barangay -->
				<label for="TPbarangay-txt"> Barangay: </label>
				<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
				<input type="text" name="TPbarangay-txt_r" class="TPbarangay-txt" data-mini="true" readonly />
				<!-- /barangay -->
				
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
				
				<!-- street -->
				<label for="TPstreet-txt"> Street: </label>
				<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
				<input type="text" name="TPstreet-txt_r" class="TPstreet-txt" data-mini="true" readonly/>
				<!-- /street -->
			
				<!-- municipality -->
				<label for="TPmunicipality-txt"> Municipality: </label>
				<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
				<input type="text" name="TPmunicipality-txt_r" class="TPmunicipality-txt" data-mini="true" readonly/>
				<!-- /municipality -->
			
				<!-- name -->
				<label for="TPname-txt"> Name: </label>
				<label style="color:red"><?php echo form_error('TPname-txt_r'); ?></label>
				<input type="text" name="TPname-txt_r" id="TPhousehold-txt" value="<?php echo set_value('TPname-txt_r'); ?>" data-mini="true" placeholder="Name" />
				<!-- /name -->
			
				<!-- type -->
				<label> Type: </label>
				<fieldset data-role="controlgroup" data-mini="true">
						<label style="color:red"><?php echo form_error('TPtype-txt_r'); ?></label>
				    	<label> <input name="TPtype-rd" type="radio" value="0" checked="checked" /> Source Area </label>
						<label> <input name="TPtype-rd" type="radio" value="1"  /> Risk Area </label>
				</fieldset>
					<!-- /type -->
					
				<!-- remarks -->
				<label for="TPremarks-txt"> Remarks: </label>
					<label style="color:red"><?php echo form_error('TPremarks-txt_r'); ?></label>
					<textarea  name="TPremarks-txt_r" id="TPremarks-txt" placeholder="<?php echo set_value('TPremarks-txt_r'); ?>" data-mini="true"> </textarea>
				<!-- /remarks -->
			
				<div>
					<input type="submit" value="Submit" />
				</div>
			
			</form>
	    	</div>
	    	<!-- /end PoI -->
	    	
	    	<!-- Larval Occurrence -->
	    	<div data-role="collapsible">
	    		<h2> Larval Occurrence </h2>
	    		<form id="ls_form" action="addls" method="post" data-ajax="false">
			
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
			
				<!-- date -->
				<label for="TPdate-txt"> Date: </label>
				<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
				<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
				<!-- /date -->
			
				<!-- barangay -->
				<label for="TPbarangay-txt"> Barangay: </label>
				<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
				<input type="text" name="TPbarangay-txt_r" class="TPbarangay-txt" data-mini="true" readonly />
				<!-- /barangay -->
				
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
				
				<!-- street -->
				<label for="TPstreet-txt"> Street: </label>
				<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
				<input type="text" name="TPstreet-txt_r" class="TPstreet-txt" data-mini="true" readonly/>
				<!-- /street -->
			
				<!-- municipality -->
				<label for="TPmunicipality-txt"> Municipality: </label>
				<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
				<input type="text" name="TPmunicipality-txt_r" class="TPmunicipality-txt" data-mini="true" readonly/>
				<!-- /municipality -->
			
				<!-- household -->
				<label for="TPhousehold-txt"> Name of Household: </label>
				<label style="color:red"><?php echo form_error('TPhousehold-txt_r'); ?></label>
				<input type="text" name="TPhousehold-txt_r" id="TPhousehold-txt" value="<?php echo set_value('TPhousehold-txt_r'); ?>" data-mini="true" placeholder="Name of Household" />
				<!-- /household -->
				
				<!-- container -->
				<label for="TPcontainer-txt">Type of Container</label>
				<label style="color:red"><?php echo form_error('TPcontainer-txt'); ?></label>
				<input type="text" name="TPcontainer-txt_r" id="TPcontainer-txt" value="<?php echo set_value('TPcontainer-txt'); ?>" data-mini="true" placeholder="Type of Container" />
				<!-- /container -->
			
				<div>
					<input type="submit" value="Submit" />
				</div>
			
			</form>
	    	</div>
	    	<!-- /end Larval Occurrence -->
	    	
	    	<!-- Single Case Report/Investigation -->
	    	<div data-role="collapsible">
	    		<h2> New Household </h2>
	    		<form id="hh_form" action="addhh" method="post" data-ajax="false">
			
					<!-- lat & lng -->
					<input type="hidden" name="lat" class="lat" />
					<input type="hidden" name="lng" class="lng" />
					<!-- /lat & lng -->
				
					<!-- household -->
					<label for="TPhousehold-txt"> Name of Household: </label>
					<label style="color:red"><?php echo form_error('hh_name'); ?></label>
					<input type="text" name="hh_name" id="hh_name" value="<?php echo set_value('hh_name'); ?>" data-mini="true" placeholder="Name of Household"/>
					<!-- /household -->
					
					<!-- household_no -->
					<label for="TPhousehold-txt"> House Address: </label>
					<label style="color:red"><?php echo form_error('hh_no'); ?></label>
					<input type="text" name="hh_no" id="hh_no" value="<?php echo set_value('hh_no'); ?>" data-mini="true" placeholder="House Address"/>
					<!-- /household_no -->
					
					<!-- street -->
					<label for="TPstreet-txt"> Street: </label>
					<label style="color:red"><?php echo form_error('hh_street'); ?></label>
					<input type="text" name="hh_street" class="hh_street" data-mini="true" placeholder="Street"/>
					<!-- /street -->
					
					<h4> Please add at least one member of the household: </h4>
					
					<div> 
						<!-- first_name -->
						<label for="hh_fname"> First Name: </label>
						<label style="color:red"><?php echo form_error('hh_fname'); ?></label>
						<input type="text" name="hh_fname" id="hh_fname" value="<?php echo set_value('hh_fname'); ?>" data-mini="true" placeholder="First Name"/>
						<!-- /first_name -->
						
						<!-- last_name -->
						<label for="hh_lname"> Last Name: </label>
						<label style="color:red"><?php echo form_error('hh_lname'); ?></label>
						<input type="text" name="hh_lname" id="hh_lname" value="<?php echo set_value('hh_lname'); ?>" data-mini="true" placeholder="Last Name"/>
						<!-- /last_name -->
						
						<!-- dob -->
						<label for="hh_dob"> Date of Birth: </label>
						<label style="color:red"><?php echo form_error('hh_dob'); ?></label>
						<input type="date" name="hh_dob" id="hh_dob" value="<?php echo set_value('hh_dob'); ?>" data-mini="true" />
						<!-- /dob -->
						
						<!-- gender -->
						<label for="hh_gender"> Gender: </label>
						<label style="color:red"><?php echo form_error('hh_gender'); ?></label>
						<fieldset data-role="controlgroup" data-mini="true">
						    	<input type="radio" name="hh_gender" id="hh_gender-1" value="male" />
						    	<label for="hh_gender-1"> Male </label>
						
								<input type="radio" name="hh_gender" id="hh_gender-2" value="female" />
						    	<label for="hh_gender-2"> Female </label>
						</fieldset>
						<!-- /gender -->
						
						<!-- marital -->
						<label for="hh_marital"> Marital Status: </label>
						<label style="color:red"><?php echo form_error('hh_marital'); ?></label>
						<input type="text" name="hh_marital" id="hh_marital" value="<?php echo set_value('hh_marital'); ?>" data-mini="true" placeholder="Marital Status"/>
						<!-- /marital -->
						
						<!-- nationality -->
						<label for="hh_nationality"> Nationality: </label>
						<label style="color:red"><?php echo form_error('hh_nationality'); ?></label>
						<input type="text" name="hh_nationality" id="hh_nationality" value="<?php echo set_value('hh_nationality'); ?>" data-mini="true" placeholder="Nationality"/>
						<!-- /nationality -->
						
						<!-- blood_type -->
						<label for="hh_blood"> Blood Type: </label>
						<label style="color:red"><?php echo form_error('hh_blood'); ?></label>
						<input type="text" name="hh_blood" id="hh_blood" value="<?php echo set_value('hh_blood'); ?>" data-mini="true" placeholder="Blood Type"/>
						<!-- /blood_type -->
						
						<!-- guardian -->
						<label for="hh_guardian"> Guardian (if any): </label>
						<label style="color:red"><?php echo form_error('hh_guardian'); ?></label>
						<input type="text" name="hh_guardian" id="hh_guardian" value="<?php echo set_value('hh_guardian'); ?>" data-mini="true" placeholder="Guardian"/>
						<!-- /guardian -->
						
						<!-- contact -->
						<label for="hh_contact"> Contact No: </label>
						<label style="color:red"><?php echo form_error('hh_contact'); ?></label>
						<input type="tel" name="hh_contact" id="hh_contact" value="<?php echo set_value('hh_contact'); ?>" data-mini="true" placeholder="e.g. 09XX XXXXXXX"/>
						<!-- /contact -->
					</div>
				
					<br/>
				
					<div>
						<input type="submit" value="Submit" />
					</div>
			
				</form>
	    	</div>
	    	<!-- /end Single Case Report/Investigation -->
    	</div>
    	<!-- /end Data Collapsible -->
        
        <!-- 
        <ul data-role="listview" data-autodividers="true" data-inset="true">
        	<li> <a href="<?php //echo site_url('mobile/page/point_of_interest');?>" data-ajax="false" data-transition="slide"> Point of Interest </a> </li>
        	<li> <a href="<?php //echo site_url('mobile/page/larval_survey');?>" data-ajax="false" data-transition="slide"> Larval Occurrence </a> </li>
        	<li> <a href="<?php //echo site_url('mobile/immediate_case');?>" data-ajax="false" data-transition="slide"> Single Case Report </a> </li>
        </ul>
        <br/><br/>
        -->
    </div><!-- /content -->
	
</div><!-- /page -->
</body>
</html>