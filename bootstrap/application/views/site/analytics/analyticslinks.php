 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <script>
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker2" ).datepicker();
});
</script>
<div class="col-md-3">		
		<!-- Filter -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Links </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li> <a href="<?= site_url('website/analytics') ?>"> Recent Cases </a> </li>
					<li> <a href="<?= site_url('website/analytics/larval_demographics') ?>"> Recent Larval Surveys</a> </li>
					<li> <a href="<?= site_url('website/analytics/totalcasecount') ?>"> Total Case Count </a> </li>
					<li> <a href="<?= site_url('website/analytics/totallarvalcount') ?>"> Total Larval Count</a> </li>
					<li> <a href="<?= site_url('website/analytics/totalcaselarvalcount') ?>"> Total Case and Larval Count</a> </li>
					<li> <a href="<?= site_url('website/analytics/case_demographics') ?>"> Case Demographics</a> </li>
					<li> <a href="<?= site_url('website/analytics/population_demographics') ?>"> Population Demographics</a> </li>
				</ul>
			</div>
		</div>
		<!-- end of Filter -->
		<?php if( $title =='home'){
		$this->load->helper('form');
		echo form_open('website/analytics/case_demographics');
		$barangay_form[] = 'LANGKAAN II';
		$barangay_form[] = 'SAN AGUSTIN I';
		$barangay_form[] = 'SAN AGUSTIN III';
		$barangay_form[] = 'SAMPALOC I';
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				
				<label style="color:red"><?php echo form_error('datepicker'); ?></label>
				 <li>Date From: <input type="text" name="datepicker" id="datepicker" readonly=true
				 value ="<?php echo $datefrom;?>"></li>

				 <label style="color:red"><?php echo form_error('datepicker2'); ?></label>
				 <li>Date To: <input type="text"  name="datepicker2" id="datepicker2" readonly=true
				 value ="<?php echo $dateto;?>"></li>
				  <br />
				  <input type= "hidden" name="url" value = "<?php echo current_url()?>" />
				  <!--  
				 <li>Barangay:</li>
 				<?php  
		 		foreach ($barangay_form as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
		    	?>
		    	<br />
		    	-->
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php }?>
		<!-- end of Filters -->
</div>