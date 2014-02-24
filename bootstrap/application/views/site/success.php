<!-- HEADER -->
<?php $data['title'] = 'Success'; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
    
    <div class="alert"> <?php echo $result; ?> </div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>