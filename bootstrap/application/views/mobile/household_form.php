<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"> 
</script> 
	<script src="http://j.maxmind.com/app/geoip.js"></script>-->


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
            	$('.lat').val(lat);
				$('.lng').val(lng);
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
</head> 
<body onload="initialize()">

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" id="ls_header" data-nobackbtn="true">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1>New Household</h1>
    </div><!-- /header -->
    <div data-role="content">
    
	<form id="hh_form" action="addhh" method="post" data-ajax="false">
			
					<!-- lat & lng -->
					<input type="hidden" name="lat" class="lat" />
					<input type="hidden" name="lng" class="lng" />
					<!-- /lat & lng -->
				
					<!-- household -->
					<label for="TPhousehold-txt"> Name of Household: </label>
					<label style="color:red"><?php echo form_error('hh_name'); ?></label>
					<input type="text" name="hh_name" id="hh_name" value="<?php echo set_value('hh_name'); ?>" data-mini="true" placeholder="Household Name"/>
					<!-- /household -->
					
					<!-- household_no -->
					<label for="TPhousehold-txt"> House Address No.: </label>
					<label style="color:red"><?php echo form_error('hh_no'); ?></label>
					<input type="text" name="hh_no" id="hh_no" value="<?php echo set_value('hh_no'); ?>" data-mini="true" placeholder="Household Address" />
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
						<input type="tel" name="hh_contact" id="hh_contact" value="<?php echo set_value('hh_contact'); ?>" data-mini="true" placeholder="09XX XXXXXXX"/>
						<!-- /contact -->
						
						<!-- landline -->
						<label for="hh_landline"> Landline No: </label>
						<label style="color:red"><?php echo form_error('hh_landline'); ?></label>
						<input type="tel" name="hh_landline" id="hh_landline" value="<?php echo set_value('hh_landline'); ?>" data-mini="true" placeholder="999 9999"/>
						<!-- /landline -->
						
						<!-- email -->
						<label for="hh_ym"> Email Address: </label>
						<label style="color:red"><?php echo form_error('hh_email'); ?></label>
						<input type="email" name="hh_email" id="hh_email" value="<?php echo set_value('hh_email'); ?>" data-mini="true" placeholder="your.name@your.domain"/>
						<!-- /email -->
						
						<!-- ym -->
						<label for="hh_ym"> Yahoo Messenger: </label>
						<label style="color:red"><?php echo form_error('hh_ym'); ?></label>
						<input type="tel" name="hh_ym" id="hh_ym" value="<?php echo set_value('hh_ym'); ?>" data-mini="true" placeholder="your.mail@yahoo.com"/>
						<!-- /ym -->
						
						<!-- fb -->
						<label for="hh_fb"> Facebook: </label>
						<label style="color:red"><?php echo form_error('hh_fb'); ?></label>
						<input type="tel" name="hh_fb" id="hh_fb" value="<?php echo set_value('hh_fb'); ?>" data-mini="true" placeholder="facebook.com/yourname"/>
						<!-- /fb -->
						
						<!-- twitter -->
						<label for="hh_tw"> Twitter: </label>
						<label style="color:red"><?php echo form_error('hh_tw'); ?></label>
						<input type="tel" name="hh_tw" id="hh_tw" value="<?php echo set_value('hh_tw'); ?>" data-mini="true" placeholder="yourid"/>
						<!-- /twitter -->
					</div>
				
					<br/>
				
					<div>
						<input type="submit" value="Submit" />
					</div>
			
				</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>