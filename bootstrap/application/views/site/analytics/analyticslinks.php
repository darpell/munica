<div class="col-md-3">		
		<!-- Filter -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filters </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li> <a href="<?= site_url('website/analytics/totalcasecount') ?>"> Total Case Count </a> </li>
					<li> <a href="<?= site_url('website/analytics/totallarvalcount') ?>"> Total Larval Count</a> </li>
					<li> <a href="<?= site_url('website/analytics/totalcaselarvalcount') ?>"> Total Case and Larval Count</a> </li>
					<li> <a href="<?= site_url('website/analytics/case_demographics') ?>"> Case Demographics</a> </li>
					<li> <a href="<?= site_url('website/analytics/population_demographics') ?>"> Population Demographics</a> </li>
				</ul>
			</div>
		</div>
		<!-- end of Filter -->
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Cases </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				  <li> <a href="<?= site_url('website/cases/view_suspected') ?>"> Suspected <span class="badge pull-right"><?php echo $this->db->get_where('immediate_cases',array('status' => 'suspected'))->num_rows(); ?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_threatening') ?>"> Threatening <span class="badge pull-right"><?php echo $this->db->get_where('immediate_cases',array('status' => 'threatening'))->num_rows(); ?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_serious') ?>"> Serious <span class="badge pull-right"><?php echo $this->db->get_where('immediate_cases',array('status' => 'serious'))->num_rows();?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_hospitalized') ?>"> Hospitalized <span class="badge pull-right"><?php echo $this->db->get_where('immediate_cases',array('status' => 'hospitalized'))->num_rows()?></span> </a> </li>
				</ul>
			</div>
		</div>
		<!-- end of Filters -->
</div>