<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> People Living in <?= $hh['house_no'] . ' at ' . $hh['street']; ?> </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
					<input type="hidden" id="household_id_<?= $ctr ?>" 		value="<?php echo $household_persons[$ctr]['household_id']; ?>"	/>
					<input type="hidden" id="person_id_<?= $ctr ?>" 		value="<?php echo $household_persons[$ctr]['person_id']; ?>"	/>
			<?php } ?>
			
			<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="check" data-split-theme="d">
				<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
					<li><!-- <a href="<?php echo site_url('mobile/household/'. $household_persons[$ctr]['household_id'] .'/new_mem');?>" data-ajax="false" data-transition="slide"> Add New Member </a>--></li>
				<?php $ctr+= count($household_persons);} ?>
				<?php 
				for ($ctr = 0; $ctr < count($household_persons); $ctr++) 
				{
					$this->load->model('hh_model','model');
					$active_case = $this->model->check_if_has_fever($household_persons[$ctr]['person_id']);
					if ($active_case != NULL)
					{
						if ($active_case['status'] == 'hospitalized') //is sick and hospitalized
						{
				?>
							<li data-theme="d">
								<a href="<?php echo site_url('mobile/master_list/view_person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
									<label style="color:GREEN;"> [Hospitalized] </label>
									<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
									<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name --> 
									<?php 
										$bday = $household_persons[$ctr]['person_dob'];
										$today = new DateTime();//date('Y-m-d');
										$diff = $today->diff(new DateTime($bday));
										echo $diff->y;
									?>, <!-- Age -->
									<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
								<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
								</a>
							</li>
							
					
				<?php
						}
						else //is sick but unhospitalized
						{
							//$this->masterlist->add_fever_day($household_persons[$ctr]['person_id']);
				?>
							<li data-theme="a">
								<a href="<?php echo site_url('mobile/master_list/view_person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
				<?php 
							if ($active_case['days_fever'] < 3)
							{
				?>
								<label style="color:YELLOW;"> [Has Fever for <?php echo $active_case['days_fever']; ?> days] </label>
				<?php 
							}
							else if($active_case['days_fever'] == 3 && $active_case['days_fever'] < 5)
							{
				?>		
								<label style="color:ORANGE;"> [Has Fever for <?php echo $active_case['days_fever']; ?> days] </label>
				<?php 
							}
							else if($active_case['days_fever'] >= 4)
							{
				?>
								<label style="color:RED;"> [Has Fever for <?php echo $active_case['days_fever']; ?> days] </label>
				<?php 
							}
				?>
								<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
								<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name -->
								<?php 
									$bday = $household_persons[$ctr]['person_dob'];
									$today = new DateTime();//date('Y-m-d');
									$diff = $today->diff(new DateTime($bday));
									echo $diff->y;
								?>, <!-- Age -->
								<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
								<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
								
								</a>
							</li>
				<?php
						}
					}
					else //not sick
					{
				?>
				
				<li> <a href="<?php echo site_url('mobile/master_list/view_person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
					<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name --> 
					<?php 
						$bday = $household_persons[$ctr]['person_dob'];
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?>, <!-- Age -->
					<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
					<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
					
					</a>
				</li>
				<?php
					} 
				} 
				?>
			</ul>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>