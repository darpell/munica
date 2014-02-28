<!-- HEADER -->
<?php $data['title'] = "System Users"; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES-->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<!-- Defining Variables -->
<script>
var distribution = new Array();
distribution[0] = <?= $distribution['male'] ?>;
distribution[1] = <?= $distribution['female'] ?>;
var male = new Array(3, 2, 1, 3, 4);
var female = new Array(2, 3, 5, 7, 6);
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
<div class="container">
<div class="col-md-5">		
		<!-- Links -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Usual Sources </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li> <a> Office <span class="badge pull-right"> 0 </span></a> </li>
					<li> <a> School <span class="badge pull-right">0</span></a> </li>
				</ul>
			</div>
		</div>
		<!-- end of Links -->
		
		<!-- Links -->
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
		<!-- end of Links -->
</div>
<div class="col-md-7">
<!-- Graph -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Graph of Suspected Cases</h3>
			</div>
			<div class="panel-body">
				<div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto"> Graph of Distribution </div>
			</div>
		</div>
	<!-- end of Graph -->

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> Viewing All <?= $type ?> Cases </h3>
	</div>
	<div class="panel-body">
	<!-- Table of Users -->
		<table class="table">
			<thead>
				<tr>
					<th> Person Name </th> <th> Gender </th> <th> Fever Duration </th> <th> Suspected Source </th> <th> Contact Number </th>
				</tr>
			<thead>
			<tbody>
				<?php foreach ($cases as $case) {?>
				<tr>
					<td> <a href="<?= site_url('website/cases/view_person/' . $case['imcase_no']) ?>"><?= $case['person_first_name'] . ' ' . $case['person_last_name'] ?> </a> </td> 
					<td> <?= $case['person_sex'] ?> </td>
					<td> <?= $case['days_fever'] ?> </td> 
					<td> <?= $case['suspected_source'] ?> </td>
					<td> <?= $case['person_contactno'] ?> </td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- /end of Table of Users -->
		<div style="text-align:right">
			<?php echo $links; ?>
		</div>
	</div>
</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>