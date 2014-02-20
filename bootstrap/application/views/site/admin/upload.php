<!-- HEADER -->
<?php $data['title'] = "Upload PIDSR Forms"; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> Upload PIDSR Form </h3>
	</div>
	<div class="panel-body">
		<div class="col-md-8">
		
		<!-- Initial Upload -->
		<!-- /end of Initial Upload -->
		
		</div>
		<div class="col-md-4">
		<!-- Upload Form -->
			<div class="form-group">
			<?php
				echo form_open_multipart('website/upload/do_upload');
			?>
				<label for="userfile"> File Input </label>
				<input type="file" name="userfile" id="userfile" size="20" />
				<p class="help-block"> Upload the Dengue.mdb file</p>
				<label style="color:red"> <?php echo $error;?> </label> <br/>
				<button type="submit" value="Upload" class="btn btn-primary"> Upload <span class="glyphicon glyphicon-upload"> </span></button>
				</form>
			</div>
		<!-- /end of Upload Form -->
		</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>