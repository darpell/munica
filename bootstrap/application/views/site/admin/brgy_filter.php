<!-- HEADER -->
<?php $data['title'] = 'Filter'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES-->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<!-- Defining Variables -->
<script>
var distribution = new Array();
distribution[0] = <?= $distribution['male'] ?>;
distribution[1] = <?= $distribution['female'] ?>;

// Age Dsitribution
var male = new Array();

male[0] = <?= $male_age_dist['child'] ?>;
male[1] = <?= $male_age_dist['adolescent'] ?>;
male[2] = <?= $male_age_dist['mid'] ?>;
male[3] = <?= $male_age_dist['old'] ?>;
male[4] = <?= $male_age_dist['ancient'] ?>;

var female = new Array();

female[0] = <?= $female_age_dist['child'] ?>;
female[1] = <?= $female_age_dist['adolescent'] ?>;
female[2] = <?= $female_age_dist['mid'] ?>;
female[3] = <?= $female_age_dist['old'] ?>;
female[4] = <?= $female_age_dist['ancient'] ?>;
//end of Age Distribution

var symp_mp = <?= $symptoms['has_muscle_pain'] ?>;
var symp_jp = <?= $symptoms['has_joint_pain'] ?>;
var symp_h = <?= $symptoms['has_headache'] ?>;
var symp_b = <?= $symptoms['has_bleeding'] ?>;
var symp_r = <?= $symptoms['has_rashes'] ?>;
</script>
<!-- end of Defining Variables -->
<script src="<?php echo base_url('scripts/cases/distribution.js');?>"></script>
<script src="<?php echo base_url('scripts/cases/symptoms.js');?>"></script>
<!-- end of ADDITIONAL FILES -->

</head>
<body>
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
	<div class="col-md-5">		
			<!-- Links -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Usual Sources </h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li> <a> Office <span class="badge pull-right"> <?= count($offices) ?> </span></a> </li>
						<li> <a> School <span class="badge pull-right"> <?= count($schools) ?></span></a> </li>
					</ul>
				</div>
			</div>
			<!-- end of Links -->
			
			<!-- Symptoms Pie Chart -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Symptoms: </h3>
				</div>
				<div class="panel-body">
					<div id="symptoms"></div>
					<ul class="nav nav-pills nav-stacked">
						<li> <a> <span class="badge"> <?= $symptoms['has_muscle_pain'] ?> </span> Muscle Pain </a> </li>
						<li> <a> <span class="badge"> <?= $symptoms['has_joint_pain'] ?> </span> Joint Pain </a> </li>
						<li> <a> <span class="badge"> <?= $symptoms['has_headache'] ?> </span> Headache </a> </li>
						<li> <a> <span class="badge"> <?= $symptoms['has_bleeding'] ?> </span> Bleeding </a> </li>
						<li> <a> <span class="badge"> <?= $symptoms['has_rashes'] ?> </span> Rashes </a> </li>
					</ul>
				</div>
			</div>
			<!-- end of Symptoms Pie Chart -->
	</div>
	<div class="col-md-7">
		<!-- Graph -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Graph of All Active Cases</h3>
			</div>
			<div class="panel-body">
				<div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto"> Graph of Distribution </div>
			</div>
		</div>
		<!-- end of Graph -->
		<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Filter Barangays in Dasmarinas CHO-I </h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<?php foreach ($brgys as $brgy) { $barangay = $brgy['barangay'];?>
						<li> 
							<a href="<?= site_url('website/households/filter_CAs/' . $barangay) ?>"> <?= $barangay ?> 
							with <span class="badge"> <?php echo count($ca_count[$barangay]) ?> </span> Catchment Areas  
							and <span class="badge"> <?php echo count($case_count[$barangay])?> </span> Active Cases </a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
	</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>