<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body>
<div data-role="page">

	<div data-role="header">
		<h1> Person's Details </h1>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
	</div><!-- /header -->
	<div data-role="content">

		
		<ul data-role="listview" data-inset="true" data-theme="d">
				<li> Name: 
					<?php echo $person['person_first_name']; ?> <!-- First Name -->
					<?php echo $person['person_last_name']; ?> <!-- Last Name --> 
				</li>
				
				<li> Age: 
					<?php //http://stackoverflow.com/questions/11272691/php-data-difference-giving-fatal-error
						$bday = $person['person_dob']; 
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?> <!-- Age -->
				</li>
				
				<li> Gender: 
					<?php 
						if ($person['person_sex'] == 'M')
							echo 'Male';
						else if ($person['person_sex'] == 'F')
							echo 'Female';
					?> <!-- Sex -->
				</li>
				
				<li> Civil Status: 
					<?php echo $person['person_marital'];?> <!-- Civil Status -->
				</li>
				
				<li> Nationality: 
					<?php echo $person['person_nationality']; ?> <!-- Nationality-->
				</li>
					
				<li> Blood Type: 
					<?php 
						if ($person['person_blood_type'] == NULL || $person['person_blood_type'] == 'null')
							echo 'N.A.';
						else
							echo $person['person_blood_type'];
					?>
				</li> <!-- Blood Type -->
				
				<li>Guardian: 
					<?php echo $person['person_guardian'];?>
				</li>
				
				<li> Contact No: 
					<?php echo $person['person_contactno'];?> <!-- Civil Status -->
				</li>
		</ul>
		
		<form name="symptom_form" action="
			<?php echo site_url('mobile/cases/edit/' . $person['imcase_no']); ?>/edit_case"
			method="post" data-ajax="false">
		
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
				<div data-role="collapsible">
					<h2> Still Has Fever?</h2>
						<input type="hidden" name="household_id" id="household_id" value="<?php echo $person['household_id']; ?>"	/>
						<input type="hidden" name="person_id" id="person_id" value="<?php echo $person['person_id']; ?>"	/>
						
						<input type="hidden" name="imcase_no" id="imcase_no" value="<?php echo $person['imcase_no']; ?>"	/>
						<input type="hidden" name="created_on" id="created_on" value="<?php echo $person['created_on']; ?>"	/>
					<ul data-role="listview">
					
						<li  data-role="fieldcontain">
							 	<fieldset data-role="controlgroup">
									Other dengue related symptoms:
									<input type="checkbox" name="has_muscle_pain" id="checkbox-1a" value="Y" 
										<?php 
											if ($person['has_muscle_pain'] == 'Y') {
										?>
											checked="checked"
										<?php } else ; ?>									
										/>
									<label for="checkbox-1a"> Muscle Pain </label>
				
									<input type="checkbox" name="has_joint_pain" id="checkbox-2a" value="Y" 
										<?php 
											if ($person['has_joint_pain'] == 'Y') {
										?>
											checked="checked"
										<?php } else ; ?>
										/>
									<label for="checkbox-2a"> Joint Pain </label>
									
									<input type="checkbox" name="has_headache" id="checkbox-3a" value="Y" 
										<?php 
											if ($person['has_headache'] == 'Y') {
										?>
											checked="checked"
										<?php } else ; ?>
										/>
									<label for="checkbox-3a"> Headache </label>
				
									<input type="checkbox" name="has_rashes" id="checkbox-4a" value="Y" 
										<?php 
											if ($person['has_rashes'] == 'Y') {
										?>
											checked="checked"
										<?php } else ; ?>
										/>
									<label for="checkbox-4a"> Rashes </label>
									
									<input type="checkbox" name="has_bleeding" id="checkbox-5a" value="Y" 
										<?php 
											if ($person['has_bleeding'] == 'Y') {
										?>
											checked="checked"
										<?php } else ; ?>
										/>
									<label for="checkbox-5a"> Bleeding </label>
							    </fieldset>
							</li>
						
						
						<!-- TODO limit the minimum to 0 -->
						<li data-role="fieldcontain">
						    <label for="name"> Duration of Fever: </label>
							<label style="color:red"><?php echo form_error('duration'); ?></label>
						    <input type="number" name="duration" id="duration" value="<?php echo $person['days_fever'];// from db?>" min="1" max="20" />
						</li>
							
						<li data-role="fieldcontain">
						    <label for="name"> Suspected Source: (recent journey, etc.) </label>
						    <input type="text" name="source" id="source" value="<?php echo $person['suspected_source'];// from db ?>" />
						</li>
						
						<li data-role="fieldcontain">
						<label for="textarea"> Remarks: (medicine intake, etc.) </label>
							<textarea name="remarks" id="remarks">  </textarea>
						</li>
						
						<li>
							<input type="submit" value="Submit" />
						</li>
					
					</ul>
					
				</div>
		</div>
		</form>
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>