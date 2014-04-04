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
            	<li><?= anchor(site_url('website/dashboard'),'Dashboard')?></li>
               	<?php }?>
               	<?php if($this->session->userdata('TPtype') == "BHW"){?>
               	<li><?= anchor(site_url('website/dashboard'),'Dashboard')?></li>
               	<?php }?>
               		<?php if($this->session->userdata('TPtype') == "MIDWIFE"){?>
               	<li><?= anchor(site_url('website/dashboard'),'Dashboard')?></li>
               	<?php }?>
               	
               	<!-- functions -->
               	<?php if($this->session->userdata('TPtype') == "CHO") {?>
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Functions <b class="caret"></b></a>
	              <ul class="dropdown-menu">
              		<li><?= anchor(site_url('website/upload'),'Upload PIDSR Forms')?></li>
                	<!-- <li><?= anchor(base_url('index.php/case_report/viewCaseReport'),'View Cases')?></li>
                	<li><?= anchor(base_url('index.php/larval_survey/viewLarvalReport'),'View Surveys')?></li>  -->
                	<li class="divider"></li>
                	<li class="dropdown-header">User Controls</li>
                	<li><?= anchor(site_url('website/user/add'),'Create User')?></li>
                	<li><?= anchor(site_url('website/user/get_users'),'View Users')?></li>
                	<li><?= anchor(site_url('website/tweet_test'),'Tweet Status')?></li>
                	<!-- in question  -->
						<!-- <li><?php //anchor(base_url('index.php/CHO/'),'View Tasks')?></li>  -->
					<!-- /end of in question -->
                	<!-- 
                	<li class="divider"></li>
                	<li class="dropdown-header">Mapping Commands</li>
                	<li><?php //anchor(base_url('index.php/addmap'),'Add Polygon')?></li>
            		<li><?php //anchor(base_url('index.php/deletemap'),'Delete Polygon')?></li>
            		 -->
	              </ul>
	            </li> <!-- /end of functions -->
               	<?php } else if($this->session->userdata('TPtype') == "BHW") { ?>
               	<li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Map Views <b class="caret"></b></a>
	              <ul class="dropdown-menu">
                	<li class="dropdown-header"> Tools </li>
              		<li><?= anchor(site_url('website/households/visits'),'Household visits')?></li>
              		<li><?= anchor(site_url('website/larval_survey'),'Update Larval Nodes')?></li>
              		<li><?= anchor(site_url('website/households/visits'),'Update POIs')?></li>
                	<li class="divider"></li>
                	<li class="dropdown-header"> Map Reports </li>
                	<li><?= anchor(site_url('website/cases/view_map'),'Case Map')?></li>
                	<!-- <li><?= anchor(site_url(''),'Larval Map')?></li> -->
                	<!-- in question  -->
						<!-- <li><?php //anchor(base_url('index.php/CHO/'),'View Tasks')?></li>  -->
					<!-- /end of in question -->
                	<!-- 
                	<li class="divider"></li>
                	<li class="dropdown-header">Mapping Commands</li>
                	<li><?php //anchor(base_url('index.php/addmap'),'Add Polygon')?></li>
            		<li><?php //anchor(base_url('index.php/deletemap'),'Delete Polygon')?></li>
            		 -->
	              </ul>
	            </li> <!-- /end of functions -->
	            <?php } ?>
               
               	<!-- reports 
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Reports <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	                <li><?= anchor(site_url('website/threshold/epidemic_threshold'),'Epidemic Threshold')?></li>
 					<li><?= anchor(base_url('index.php/case_report/testChart'),'Surveillance Report ')?></li>
 					<?php if($this->session->userdata('TPtype') == "CHO"){?>
 					<li><?= anchor(base_url('index.php/CHO/view_dengue_profile'),'Dengue Profile')?></li>
 					<?php } ?>
	              </ul>
	            </li> -->   
	                   
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