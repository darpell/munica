<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> Catchment Area List </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($subjects); $ctr++) {?>
					<input type="hidden" id="household_id_<?= $ctr ?>" 		value="<?php echo $subjects[$ctr]['household_id']; ?>"	/>
			<?php } ?>
			
			
				<!-- <li> <?php //echo $test; ?></li> -->
				<ul data-role="listview" data-inset="true" data-split-icon="check" data-split-theme="d" data-divider-theme="a" data-filter="true">
				<?php for ($ctr = 0; $ctr < count($subjects); $ctr++) {?>
					<?php 
						//$this->load->model('hh_model','model');
						$fever_count = count($cases);
							
						if ($fever_count != NULL || $fever_count != 0)
						{
					?>
							<li data-role="list-divider">
								<span> 
									<?= $fever_count ?>
								</span> active case/s in <?= $subjects[$ctr]['household_name']; ?>
							</li>
					<?php } ?>
					<li> <a href="<?php echo site_url('mobile/master_list/view_household/' . $subjects[$ctr]['household_id']);?>" data-ajax="false" data-transition="slide">
						<?php echo $subjects[$ctr]['household_name']; ?> <!-- Household No. e.g. "Blk 2" --> located at
						<?php echo $subjects[$ctr]['house_no']; ?>, <!-- Household No. e.g. "Blk 2" --> 
						<?php echo $subjects[$ctr]['street']; ?> <!-- Street -->
						<p class="ui-li-aside"> last visit: <strong>
						<?php echo date('D, M d Y',strtotime($last_visits[$ctr]['visit_date'])); ?> <!-- Last Visited On -->
						</strong></p>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>