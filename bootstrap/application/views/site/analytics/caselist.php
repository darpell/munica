<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>



<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<?php  $data['title'] = 'caselist';  $this->load->view('/site/analytics/analyticslinks',$data);?>
<div class="col-md-9">

		
	<!-- population demographics -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case List </h3>
			</div>
			<div class="panel-body">
		
			 <legend><center></>Barangay Cases (<?php switch ($month2)
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
					 echo count($cases['immecase']). ') ' . $month.' '.$year;?> </center></legend>
				<table class="table table-hover">
				 <thead>
				<tr>
					<th>#</th> <th>Name</th> <th>Address</th><th>Barangay</th> <th>Age</th> <th>Gender</th><th>Contact No</th><th> Date Onset </th><th> Symptoms </th><th> Days of Fever </th><th> Outcome </th>
				</tr>
				</thead>
				<?php $ctr = 1; foreach ($cases['immecase'] as $row){?>
				<tr>
				<?php 
				$birthDate = $row['person_dob'];
				//explode the date to get month, day and year
				$birthDate = explode("-", $birthDate);
				//get age from date or birthdate
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
						? ((date("Y") - $birthDate[0]) - 1)
						: (date("Y") - $birthDate[0]));

				$symptoms='';
				if(isset($row['outcome'])){
				if($row['outcome'] == 'A')
				$outcome = 'Alive';
				if($row['outcome'] == 'D')
					$outcome = 'Deceased';
				if($row['outcome'] == 'U')
					$outcome = 'Unknown';
				}
				else 
					$outcome = 'Alive';
				 
				if($row['has_muscle_pain'] == 1)
				$symptoms .= '<li>Muscle Pain</li> ';
				
				if($row['has_joint_pain'] == 1)
					$symptoms .= '<li>Joint Pain</li> ';
				
				if($row['has_headache'] == 1)
					$symptoms .= '<li>Headache</li> ';
				
				if($row['has_bleeding'] == 1)
					$symptoms .= '<li>Bleeding</li> ';
				
				if($row['has_rashes'] == 1)
					$symptoms .= '<li>Rashes</li> ';

				echo '<td>'.$ctr.'</td>';
				echo '<td>'.$row['person_last_name'].', '.$row['person_first_name'].'</td>';
				echo '<td>'.$row['house_no'].' '.$row['street'].'</td>';
				echo '<td>'.$row['barangay'].'</td>';
				echo '<td>'.$age.'</td>';
				echo '<td>'.$row['person_sex'].'</td>';
				echo '<td>'.$row['person_contactno'].'</td>';
				echo '<td>'.$row['created_on'].'</td>';
				echo '<td>'.$symptoms.'</td>';
				echo '<td>'.$row['days_fever'].'</td>';
				echo '<td>'.$outcome.'</td>';
				?>
				</tr>
				<?php $ctr++;}?>
				</table>
				<legend><center></>Hospital Cases (<?php switch ($month2)
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
				echo count($cases['casereport']).') ' .$month.' '.$year;?>)</center></legend>
				
				
				<table class="table table-hover">
				 <thead>
				<tr>
					<th>#</th> <th>Name</th> <th>Address</th><th>Barangay</th> <th>Age</th> <th>Gender</th>	<th> Date Onset </th>	<th> Type </th><th> Outcome </th>
				</tr>
				</thead>
				<?php $ctr = 1; foreach ($cases['casereport'] as $row){?>
				<tr>
				<?php 

				if($row['cr_outcome'] == 'A')
					$outcome = 'Alive';
				if($row['cr_outcome'] == 'D')
					$outcome = 'Deceased';
				if($row['cr_outcome'] == 'U')
					$outcome = 'Unknown';
				
				echo '<td>'.$ctr.'</td>';
				echo '<td>'.$row['cr_last_name'].', '.$row['cr_first_name'].'</td>';
				echo '<td>'.$row['cr_street'].'</td>';
				echo '<td>'.$row['cr_barangay'].'</td>';
				echo '<td>'.$row['cr_age'].'</td>';
				echo '<td>'.$row['cr_sex'].'</td>';
				echo '<td>'.$row['cr_date_onset'].'</td>';
				echo '<td>'.$row['cr_type'].'</td>';
				echo '<td>'.$outcome.'</td>';
				?>
				</tr>
				<?php $ctr++;}?>
				</table>
							
			</div>
		</div>

	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>