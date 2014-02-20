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
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> Epidemic threshold </h3>
	</div>
	<div class="panel-body">
		<style>
			td { padding: 5px; padding-left:15px; padding-right:15px; }
		</style>
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
	</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>