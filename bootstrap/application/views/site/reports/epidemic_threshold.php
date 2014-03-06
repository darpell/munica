<!-- HEADER -->
<?php $data['title'] = "Epidemic Threshold"; $this->load->view('/site/templates/header',$data);?>

<!-- SCRIPTS -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<script src="<?php echo base_url('scripts/epidemic_threshold/epidemic_threshold_chart.js');?>"></script>
<!-- /end of SCRIPTS -->

</head>
<script>
  var median = <?php echo json_encode( $median); ?>;
  var quartile1 = <?php echo json_encode( $quartile1); ?>;
  var quartile3 = <?php echo json_encode( $quartile3); ?>;
  var currentcases = <?php echo json_encode( $currentcases); ?>;
  for (var i=0;i<currentcases.length;i++)
  {
	  currentcases[i] = parseInt(currentcases[i]);
	  median[i] = parseInt(median[i]);
	  quartile1[i] = parseInt(quartile1[i]);
	  quartile3[i] = parseInt(quartile3[i]);
  }

  
</script>
<body>
<!-- CONTENT -->
<div class="container">

<FORM>
<INPUT TYPE="button" onClick="window.print()" value="Print This Page">
</FORM><center>
<?php echo form_open('website/threshold/epidemic_threshold'); ?>
Year:

 				<?php  
 				
		 		for($i = 2013; $i <= date('Y');$i++)
		 		{
		 			$options[$i]=$i;
		 		}
		 		echo form_dropdown('year', $options, $year);
		 		$options = null;
		    	if($this->session->userdata('TPtype') == 'CHO'){ ?>
Barangay:
 				<?php  
 				$options['all'] = 'All';
		 		foreach ($barangay as $row) {
				$options[$row]=$row;
				}
				
				echo form_dropdown('barangay', $options,$brgy);
		    	}?>
		    	<input type="submit" class="submitButton" value="View"/>
		    	</center>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> Epidemic threshold </h3>
	</div>
	<div class="panel-body">
		<style>
			td { padding: 5px; padding-left:15px; padding-right:15px; }
		</style>
		<center><h3>Epidemic Threshold <?php echo date('Y');?><br /><small>City Health Office - I, City of Dasmarinas, Cavite</small></h3></center>
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">epidemic threshold chart</div>
		
		<!-- Data table for chart -->
		<table border="1" id="datatable" class="hidden">
			<thead>
				<tr>
					<th>&nbsp;</th> <th>2014</th> <th>2013</th> <th>2012</th> <th>2011</th> <th>2010</th> <th> 2009 </th>
				</tr>
			</thead>
			<tbody>			
			<?php
				for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++) 
				{
			?>
				<tr>
				<?php 
					$month = '';
					switch ($mth_ctr)
					{
						case '0': $month = 'JAN'; break;
						case '1': $month = 'FEB'; break;
						case '2': $month = 'MAR'; break;
						case '3': $month = 'APR'; break;
						case '4': $month = 'MAY'; break;
						case '5': $month = 'JUN'; break;
						case '6': $month = 'JUL'; break;
						case '7': $month = 'AUG'; break;
						case '8': $month = 'SEP'; break;
						case '9': $month = 'OCT'; break;
						case '10': $month = 'NOV'; break;
						case '11': $month = 'DEC'; break;
					}
				?>
					<th><?php echo $month; ?></th>
			<?php
					for ($ctr = 0; $ctr < $years; $ctr++) {
			?>
					<td><?php echo $results[$ctr . '_' . $mth_ctr]; ?></td>
			<?php }} ?>
				</tr>
			</tbody>
		</table>
		<!-- /end of Data table for chart -->
		<br />
		
		<table class="table" border="1">
			<thead>
				<tr>
					<th> &nbsp; </th>
					<?php
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++) 
						{
							$month_display = '';
							switch ($mth_ctr)
							{
								case '0': $month_display = 'JAN'; break;
								case '1': $month_display = 'FEB'; break;
								case '2': $month_display = 'MAR'; break;
								case '3': $month_display = 'APR'; break;
								case '4': $month_display = 'MAY'; break;
								case '5': $month_display = 'JUN'; break;
								case '6': $month_display = 'JUL'; break;
								case '7': $month_display = 'AUG'; break;
								case '8': $month_display = 'SEP'; break;
								case '9': $month_display = 'OCT'; break;
								case '10': $month_display = 'NOV'; break;
								case '11': $month_display = 'DEC'; break;
							}
					?>
					<th> <?= $month_display ?> </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
					<tr class="warning">
					<td>3rd Quartile</td>
				<?php 
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++)
						{
				?>
				
					<td> <?= $sorted[$mth_ctr][3] ?> </td>
				<?php } ?>
				</tr>
				
				<tr>
					<td><?php echo date('Y');?></td>
				<?php 
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++)
						{
						if ($results[0 . '_' . $mth_ctr]>=$sorted[$mth_ctr][3])
						echo '<td class= "danger">';
						else echo '<td>';

				?>
				
					 <?= $results[0 . '_' . $mth_ctr] ?> </td>
				<?php } ?>
				</tr>
			</tbody>
		</table>
		
		<br />
		<p><h4>1. Five ( 5 ) years monthly record of cases(<?php echo date('Y')-5;?>-<?php echo date('Y');?>)</h4></p>
		<table class="table" border="1">
			<thead>
				<tr>
					<th> &nbsp; </th>
					<?php
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++) 
						{
							$month_display = '';
							switch ($mth_ctr)
							{
								case '0': $month_display = 'JAN'; break;
								case '1': $month_display = 'FEB'; break;
								case '2': $month_display = 'MAR'; break;
								case '3': $month_display = 'APR'; break;
								case '4': $month_display = 'MAY'; break;
								case '5': $month_display = 'JUN'; break;
								case '6': $month_display = 'JUL'; break;
								case '7': $month_display = 'AUG'; break;
								case '8': $month_display = 'SEP'; break;
								case '9': $month_display = 'OCT'; break;
								case '10': $month_display = 'NOV'; break;
								case '11': $month_display = 'DEC'; break;
							}
					?>
					<th> <?= $month_display ?> </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
					for ($ctr = 0; $ctr < $years; $ctr++) 
					{
				?>
					<tr>
					<td> <?= date('Y') - $ctr ?> </td>
				<?php 
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++)
						{
				?>
				
					<td> <?= $results[$ctr . '_' . $mth_ctr] ?> </td>
				<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br />
		<p><h4>2. Number of cases acsending order by month</h4></p>
		<table class="table" border="1">
			<thead>
				<tr>
					<th> &nbsp; </th>
					<?php
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++) 
						{
							$month_display = '';
							switch ($mth_ctr)
							{
								case '0': $month_display = 'JAN'; break;
								case '1': $month_display = 'FEB'; break;
								case '2': $month_display = 'MAR'; break;
								case '3': $month_display = 'APR'; break;
								case '4': $month_display = 'MAY'; break;
								case '5': $month_display = 'JUN'; break;
								case '6': $month_display = 'JUL'; break;
								case '7': $month_display = 'AUG'; break;
								case '8': $month_display = 'SEP'; break;
								case '9': $month_display = 'OCT'; break;
								case '10': $month_display = 'NOV'; break;
								case '11': $month_display = 'DEC'; break;
							}
					?>
					<th> <?= $month_display ?> </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
					for ($ctr = 0; $ctr < $years; $ctr++) 
					{
				?>
					<tr>
				
					<td> <?php if ($ctr == 1) echo '1st Quartile'; else if ($ctr == 2) echo 'Median'; else if($ctr == 3) echo '3rd Quartile'; else if ($ctr == 5) echo date('Y');   ?> </td>
				<?php 
						for ($mth_ctr = 0; $mth_ctr < $months; $mth_ctr++)
						{ if ($ctr != 5){
				?>
				
								<td> <?= $sorted[$mth_ctr][$ctr]?> </td>
				<?php }else {  ?> <td> <?= $results[0 . '_' . $mth_ctr] ?> </td>
				
				<?php }} ?> </tr> <?php }?>
			</tbody>
		</table>
		
		
		<br />
	</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>