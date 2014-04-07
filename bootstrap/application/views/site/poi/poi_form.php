<!-- HEADER -->
<?php $data['title'] = 'Update User'; $this->load->view('/site/templates/header', $data);?>

</head>
<body>
<!-- CONTENT -->    
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> View Node </h3>
	</div>
	<div class="panel-body">
	
	
	<?php 
	$attributes = array(
							'id' 	=> 'TPupdate',
							'role'	=> 'form'
						);
	echo form_open('website/poi/update/' . $poi['node_no'], $attributes); ?>
	<div class="row">
        <div class="col-lg-6">
        	<!-- Name -->
        	<div class="form-group">
	        	<label for="TPname-txt"> Name: </label> <label class="text-danger"><?php echo form_error('TPname-txt'); ?></label>
	        	<input type="text" class="form-control" name="TPname-txt" id="TPname-txt" value="<?php echo $poi['node_name']; ?>" placeholder="Name" required/>
        	</div>
        	<!-- end of Name -->
        	
        	<!-- Notes -->
        	<div class="form-group">
	        	<label for="TPnotes-txt"> Notes:  </label> <label class="text-danger"><?php echo form_error('TPnotes-txt'); ?></label>
	        	<input type="text" class="form-control" name="TPnotes-txt" id="TPnotes-txt" value="<?php echo $poi['node_notes']; ?>">
        	</div>
        	<!-- end of Notes -->
        	
        	<!-- End Date -->
        	<div class="form-group">
	        	<label for="TPend-date"> End Date: </label> <label class="text-danger"><?php echo form_error('TPend-date'); ?></label>
				<input type="date" class="form-control" name="TPend-date" id="TPend-date" value="<?php echo $poi['node_endDate']; ?>" required/>
        	</div>
        	<!-- end of End Date -->
			
			<div class="form-group"><center><input type="submit" value="Update" class="btn btn-lg btn-primary" /></center></div>
        </div>
    </div>
	</form>
	</div>
</div>
</div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>