<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="home"> Home </a>
			<h1> Case Details </h1>
		</div>
		<div data-role="content">
			<input type="hidden" id="imcase_no" value="<?php echo $case['imcase_no']; ?>"	/>

			<ul data-role="listview"data-inset="true" data-split-icon="check" data-theme="d" data-split-theme="d" data-divider-theme="a">
				<li data-theme="a">
					<?php 
					if ($case['status'] == 'suspected')
					{
					?>
						<label style="color:YELLOW;"> [Has Fever for <?php echo $case['days_fever']; ?> days] </label> <br/>	
					<?php 
						}
						else if ($case['status'] == 'threatening')
						{
					?>	
						<label style="color:ORANGE;"> [Has Fever for <?php echo $case['days_fever']; ?> days] </label> <br/>
					<?php 
						}
						else if ($case['status'] == 'serious')
						{
					?>
						<label style="color:RED;"> [Has Fever for <?php echo $case['days_fever']; ?> days] </label> <br/>
					<?php 
						}
						else
						{
					?>
						<label style="color:LIGHTGREEN;"> [Has Fever for <?php echo $case['days_fever']; ?> days] </label> <br/>
					<?php } ?>
					<p class="ui-li-aside"> Last Visited On <strong>
					<?php echo date('D, M d Y',strtotime($case['last_updated_on'])); ?> <!-- Last Visited On -->
					</strong></p>
				</li>
				
				<li data-theme="b"> 
					 
					
					<?php 
						$symptoms = array();
						if ($case['has_muscle_pain'] == 'Y')
							array_push($symptoms,"Muscle Pain");
						if ($case['has_joint_pain'] == 'Y')
							array_push($symptoms,"Joint Pain");
						if ($case['has_headache'] == 'Y')
							array_push($symptoms,"Headache");
						if ($case['has_bleeding'] == 'Y')
							array_push($symptoms,"Bleeding");
						if ($case['has_rashes'] == 'Y')
							array_push($symptoms,"Rashes");
							
						echo count($symptoms);
							if(count($symptoms) > 1)
								echo " Symptoms:";
							else
								echo " Symptom:";
					?>
						<br/>
					<?php
						echo implode(", ",$symptoms);
					?>
					
				</li>
				<li> Date Recorded: <?php echo date('D, M d Y',strtotime($case['created_on']));?> </li>
				<li> Name: <?php echo $case['person_first_name']; ?> <?php echo $case['person_last_name']; ?></li> <!-- Name -->
				<li> Contact No: <?php echo $case['person_contactno'];?> </li>
				<li> Civil Status: <?php echo $case['person_marital'];?> <!-- Civil Status --> </li>
				<li> Nationality: <?php echo $case['person_nationality']; ?> <!-- Nationality--> </li>
				<li> Gender: 
					<?php 
						if ($case['person_sex'] == 'M')
							echo 'Male';
						else if ($case['person_sex'] == 'F')
							echo 'Female';
					?> <!-- Sex -->
				</li>
				<li> Age: 
					<?php //http://stackoverflow.com/questions/11272691/php-data-difference-giving-fatal-error
						$bday = $case['person_dob']; 
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?> <!-- Age -->
				</li>
				<li>Guardian: 
					<?php echo $case['person_guardian'];?>
				</li>
				<li> Household Name: <?php echo $case['household_name'] . ' at ' . $case['house_no'] . ' ' . $case['street'];?> </li>
				<li> Remarks: <?php echo $case['remarks'];?> </li>
			</ul>
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>