
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
					<li><?= anchor(site_url('website/threshold/epidemic_threshold'),'Epidemic Threshold')?></li>
					<li> <a href="<?= site_url('website/analytics') ?>"> Recent Cases </a> </li>
					<li> <a href="<?= site_url('website/analytics/caselist') ?>"> Case list </a> </li>
					<li> <a href="<?php if($this->session->userdata('TPtype') == 'CHO') echo site_url('website/analytics/totaloutbreakcount'); else echo  site_url('website/analytics/outbreakcountyear');?>"> Outbreaks Occured</a> </li>
					<li> <a href="<?= site_url('website/analytics/totalcasecount') ?>"> Total Case Count </a> </li>
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
				
				 <li>Date From:<?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{ switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthstart', $options, $monthstart);
		 		$options = null;
		    	?> <?php  
		 		for($i = 2006; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearstart', $options, $yearstart);
		 		$options = null;
		    	?> </li>

			<br / >
				 <li>Date To:<?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthend', $options, $monthend);
		 		$options = null;
		    	?>  <?php  
		 		for($i = 2006; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearend', $options, $yearend);
		 		$options = null;
		    	?></li>
				  <br />
				  <input type= "hidden" name="url" value = "<?php echo current_url()?>" />
				  <?php if($this->session->userdata('TPtype') == 'CHO'){?>
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
		    	<?php }?>
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php }else if( $title =='outbreak'){
		echo form_open('website/analytics/outbreakcountyear');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				<?php if($this->session->userdata('TPtype') == 'CHO'){?>
				<li>Barangay:</li>
 				<?php  
 				//$options['all'] = 'All';
		 		foreach ($barangay as $row) {
				$options[$row]=$row;
				
				}
				
				echo form_dropdown('barangay', $options,$brgy);
		    	?>
		    	<br />
		    	<?php }?>
				 <li>Year</li>
				 <li>
 				<?php  
 				$options = null;
		 		for($i = $outbreak['yearstart']; $i <= $outbreak['yearend'];$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearselected', $options, date('Y'));
		 		
		    	?>
		    	</li>
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div><?php }else if( $title =='totaloutbreak'){
		echo form_open('website/analytics/outbreakcountyear');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				
				 <li>Barangay:</li>
 				<?php  
 				//$options['all'] = 'All';
		 		foreach ($barangay as $row) {
				$options[$row]=$row;
				
				}
				echo form_dropdown('barangay', $options);
		    	?>
		    	<br />
		  		<br />
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php }else if( $title =='totalcase'){
		echo form_open('website/analytics/totalcasecount');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				 <li>Date Start</li>
				 <li>
				 <?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthstart', $options, $cases['monthstart']);
		 		$options = null;
		    	?>
 				<?php  
		 		for($i = $cases['yearmin']; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearstart', $options, $cases['yearstart']);
		 		$options = null;
		    	?>
		    	</li>
		    	 <li>Date end</li>
				 <li>
				 <?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthend', $options, $cases['monthend']);
		 		$options = null;
		    	?>
		    	
 				<?php  
		 		for($i = $cases['yearmin']; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearend', $options, $cases['yearend']);
		 		?>
		 		</li>
		 		<?php if($this->session->userdata('TPtype') == 'CHO'){
		    	?>
		    	
		    	<li>Barangays Selected:</li>
 				<?php  
		 		foreach ($brgys as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
				}
		    	?>
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php }else if( $title =='totalcaselarval'){
		echo form_open('website/analytics/totalcaselarvalcount');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				  <li>Date Start</li>
				 <li>
				 <?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthstart', $options, $cases['monthstart']);
		 		$options = null;
		    	?>
 				<?php  
		 		for($i = $cases['yearmin']; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearstart', $options, $cases['yearstart']);
		 		$options = null;
		    	?>
		    	</li>
		    	 <li>Date end</li>
				 <li>
				 <?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('monthend', $options, $cases['monthend']);
		 		$options = null;
		    	?>
		    	
 				<?php  
		 		for($i = $cases['yearmin']; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('yearend', $options, $cases['yearend']);
		 		?>
		 		</li>
		 		<?php 
		 		if($this->session->userdata('TPtype') == 'CHO'){
		    	?>
		    	
		    	<li>Barangays Selected:</li>
 				<?php  
		 		foreach ($brgys as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
				}
		    	?>
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php } else if( $title =='casesummary'){
		echo form_open('website/analytics');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				<li>Week No:</li>
				 <li>
 				<?php  
		 		for($i = 5; $i <= date('W');$i++)
		 		{
		 			$options[$i]=$i. ': '. date('M d, Y', strtotime("-".(date('W')-$i). " week"));
		 		}
		 		echo form_dropdown('weekno', $options,$weekno);
				
		    	?>
		    	</li>
		    	<?php if($this->session->userdata('TPtype') == 'CHO'){
		    	?>
		    	<li>Barangays Selected:</li>
 				<?php  
		 		foreach ($barangay as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
		    	}
		    	?>
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php } else if( $title =='bhwcount'){
		echo form_open('website/analytics');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				<li>Week No:</li>
				 <li>
 				<?php  
		 		for($i = 5; $i <= date('W');$i++)
		 		{
		 			$options[$i]=$i. ': '. date('M d, Y', strtotime("-".(date('W')-$i). " week"));
		 		}
		 		echo form_dropdown('weekno', $options,$weekno);
				
		    	?>
		    	</li>
		    	<?php if($this->session->userdata('TPtype') == 'CHO'){
		    	?>
		    	<li>Barangays Selected:</li>
 				<?php  
		 		foreach ($barangay as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
		    	}
		    	?>
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php } else if( $title =='caselist'){
		echo form_open('website/analytics/caselist');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				 <li>Date:<?php  
		 		for($i = 1; $i <= 12;$i++)
		 		{ switch ($i)
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		 			$options[$i]=$month;
		 		}
		 		echo form_dropdown('month', $options, $month2);
		 		$options = null;
		    	?> <?php  
		 		for($i = 2006; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('year', $options, $year);
		 		$options = null;
		    	?> </li>
		    	<?php if($this->session->userdata('TPtype') == 'CHO'){
		    	?>
		    	<li>Barangays Selected:</li>
 				<?php  
		 		foreach ($barangay as $row) {
				echo '<li>';
		    	echo form_checkbox('barangay[]', $row, TRUE);
		    	echo " " . $row;
		    	echo '</li>';
				}
		    	}
		    	?>
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="Search"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
 				</ul>
			</div>
		</div>
		<?php }?>
		
		<!-- end of Filters -->
</div>