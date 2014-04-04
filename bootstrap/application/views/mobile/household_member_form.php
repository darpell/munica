<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>
</head> 
<body>

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" data-nobackbtn="true">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1>Add Household Member</h1>
    </div><!-- /header -->
    <div data-role="content">
    
		<form id="add_member" action="" method="post" data-ajax="false">
			
			<input type="hidden" name="household_id" value="<?= $household_id; ?>" />
			
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
			<input type="date" name="hh_dob" id="hh_dob" value="<?php echo set_value('hh_dob'); ?>" data-mini="true"/>
			<!-- /dob -->
			
			<!-- gender -->
			<label for="hh_gender"> Gender: </label>
			<label style="color:red"><?php echo form_error('hh_gender'); ?></label>
			<fieldset data-role="controlgroup" data-mini="true">
			    	<input type="radio" name="hh_gender" id="hh_gender-1" value="M" />
			    	<label for="hh_gender-1"> Male </label>
			
					<input type="radio" name="hh_gender" id="hh_gender-2" value="F" />
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
			<input type="text" name="hh_nationality" id="hh_nationality" value="<?php echo set_value('hh_nationality'); ?>" data-mini="true" placeholder="Nationality" />
			<!-- /nationality -->
			
			<!-- blood_type -->
			<label for="hh_blood"> Blood Type: </label>
			<label style="color:red"><?php echo form_error('hh_blood'); ?></label>
			<input type="text" name="hh_blood" id="hh_blood" value="<?php echo set_value('hh_blood'); ?>" data-mini="true" placeholder="Blood Type" />
			<!-- /blood_type -->
			
			<!-- guardian -->
			<label for="hh_guardian"> Guardian (if any): </label>
			<label style="color:red"><?php echo form_error('hh_guardian'); ?></label>
			<input type="text" name="hh_guardian" id="hh_guardian" value="<?php echo set_value('hh_guardian'); ?>" data-mini="true" placeholder="Guardian" />
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
			
			<br/>
			
			<div>
				<input type="submit" value="Submit" />
			</div>
				
		</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>