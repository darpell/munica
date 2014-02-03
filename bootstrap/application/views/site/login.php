<!-- HEADER -->
<?php $data['title'] = "Login"; $this->load->view('/site/templates/header',$data);?>


</head>
<body>
<!-- CONTENT -->
	<!-- Custom styles for this template -->
    <link href="<?php echo base_url('style/css/signin.css'); ?>" rel="stylesheet">

<div class="container">

      <form class="form-signin" role="form" action="<?php echo site_url('website/user/login'); ?>" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="TPusername" class="form-control" placeholder="Email address" required autofocus> 
        <input type="password" name="TPpassword" class="form-control" placeholder="Password" required> <br/>
        <?php if (form_error('TPusername') != NULL || form_error('TPpassword') != NULL){?>
        	<!-- Fix this as login credentials is wrong -->
        <label style="color:red"><?php echo form_error('TPusername'); ?></label> <br/>
        <label style="color:red"><?php echo form_error('TPpassword'); ?></label> <br/>
        <?php } else { ?>
        <label style="color:red"><?php echo 'Login failed'; ?></label> <br/>
        <?php } ?>
        <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>