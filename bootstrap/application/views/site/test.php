<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Project Monica - <?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('style/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo base_url('style/css/jumbotron.css'); ?>" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  
	<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>">Project Monica</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <?php if($this->session->userdata('TPtype') == "CHO"){?>
            	<li><?= anchor(base_url('index.php/CHO/dashboard'),'Dashboard')?></li>
               	<?php }?>
               	<?php if($this->session->userdata('TPtype') == "BHW"){?>
               	<li><?= anchor(base_url('index.php/suggested/'),'Route Information')?></li>
               	<li><?= anchor(base_url('index.php/master_list/view_household_bhw'),'Catchment Area	')?></li>
               	<?php }?>
               		<?php if($this->session->userdata('TPtype') == "MIDWIFE"){?>
               	<li><?= anchor(base_url('index.php/master_list/view_household_midwife'),'Dashboard')?></li>
               	<?php }?>
               	
               	<!-- functions -->
               	<?php if($this->session->userdata('TPtype') == "CHO"){?>
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Functions <b class="caret"></b></a>
	              <ul class="dropdown-menu">
              		<li><?= anchor(base_url('index.php/upload'),'Upload PIDSR Forms')?></li>
                	<li><?= anchor(base_url('index.php/case_report/viewCaseReport'),'Update Cases')?></li>
                	<li><?= anchor(base_url('index.php/larval_survey/viewLarvalReport'),'Update Surveys')?></li>
                	<li class="divider"></li>
                	<li class="dropdown-header">User Controls</li>
                	<li><?= anchor(base_url('index.php/login/add_user'),'Create User')?></li>
                	<li><?= anchor(base_url('index.php/login/unapproved_users'),'View Users')?></li>
                	<!-- in question  -->
					<li><?= anchor(base_url('index.php/CHO/'),'View Tasks')?></li>
					<!-- /end of in question -->
                	<li class="divider"></li>
                	<li class="dropdown-header">Mapping Commands</li>
                	<li><?= anchor(base_url('index.php/addmap'),'Add Polygon')?></li>
            		<li><?= anchor(base_url('index.php/deletemap'),'Delete Polygon')?></li>
	              </ul>
	            </li> <!-- /end of functions -->
               	<?php } ?>
               	
               	<!-- reports -->
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Reports <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	                <li><?= anchor(site_url('website/threshold/epidemic_threshold'),'Epidemic Threshold')?></li>
 					<li><?= anchor(base_url('index.php/case_report/testChart'),'Surveillance Report ')?></li>
 					<?php if($this->session->userdata('TPtype') == "CHO"){?>
 					<li><?= anchor(base_url('index.php/CHO/view_dengue_profile'),'Dengue Profile')?></li>
 					<?php } ?>
	              </ul>
	            </li> <!-- /end of reports -->
            
            <!-- drowdown -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li> <!-- /end of dropdown -->
            
          </ul>
          
          <!-- if not signed in -->
          <?php if (current_url() == 'http://localhost/workspace/bootstrap/index.php/website/user/login') {?>
          <?php } else if ($this->session->userdata('TPusername') == FALSE) {?>
          <form class="navbar-form navbar-right" role="form" action="<?php echo site_url('website/user/login'); ?>" method="post">
            <div class="form-group">
              <input type="text" name="TPusername" placeholder="Username" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="TPpassword" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
          <?php } else { ?>
          	<form class="navbar-form navbar-right" role="form" action="<?php echo site_url('website/user/logout'); ?>" method="post">
          	<button type="submit" class="btn btn-default"> Logout <span class="glyphicon glyphicon-log-out"> </span> </button>
          	</form>
          <?php } ?>
        </div><!--/.nav-collapse -->
        
      </div>
    </div>

<!-- SCRIPTS -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Historic World Population by Region'
        },
        subtitle: {
            text: 'Source: Wikipedia.org'
        },
        xAxis: {
            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Population (millions)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Year 1800',
            data: [107, 31, 635, 203, 2]
        }, {
            name: 'Year 1900',
            data: [133, 156, 947, 408, 6]
        }, {
            name: 'Year 2008',
            data: [973, 914, 4054, 732, 34]
        }]
    });
});
</script>
<!-- /end of SCRIPTS -->

</head>

<body>
<!-- CONTENT -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> Epidemic threshold </h3>
	</div>
	<div class="panel-body">
		<style>
			td { padding: 5px; padding-left:15px; padding-right:15px; }
		</style>
		<table border="1">
			<tr>
				<td> Jan </td> <td> Feb </td> <td> Mar </td> <td> Apr </td> <td> May </td> 
				<td> Jun </td> <td> Jul </td> <td> Aug </td> <td> Sep </td> <td> Oct </td>
				<td> Nov </td> <td> Dec </td>
			</tr>
		</table>
	</div>
</div>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">test</div>



	<div class="container">
		<!-- Example row of columns -->
		<div class="row">
        	<div class="col-md-4">
          		<h4>24 hour customer service</h4>
				<ul>
					<li class="phone-num">
						512-943-1069 <br> 512-943-1068
					</li>
					<li class="email">
						<a href="#">info@WTPcom</a>
					</li>
					<li class="address">
						Dasmarinas City <br> Cavite
					</li>
				</ul>
        	</div>
        	
        	<div class="col-md-4">
        		<p> Twitter plugin </p>
        	</div>
        
        	<div class="col-md-4">
          		<h4>Get in touch with us</h4>
				<a href="http://www.facebook.com/DOHgovph" id="facebook">Facebook</a> <br/>
				<a href="http://twitter.com/#!/DOHgovph" id="twitter">Twitter</a> <br/>
        	</div>
      	</div>

      	<hr>

		<footer>
       		<p style="text-align:center;">Department of Health &copy; 2013</p>
		</footer>
	</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('scripts/js/bootstrap.min.js');?>"></script>
  </body>
</html>
