<!-- HEADER -->
<?php $this->load->view('/site/templates/header');?>

</head>
<body>
<!-- CONTENT -->
	<!-- Custom styles for this template -->
    <link href="<?php echo base_url('style/css/jumbotron.css'); ?>" rel="stylesheet">
    
    <div class="alert alert-danger"> <?php var_dump($values); ?> </div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>