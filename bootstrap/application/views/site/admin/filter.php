<!-- HEADER -->
<?php $data['title'] = 'Filter'; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
<!-- Filters -->
<div class="col-md-3">
	<!-- Barangays -->
	    <div class="form-group">
		   	<label for=""> Barangay: </label> <label class="text-danger"><?php echo form_error('TPbrgy-dd'); ?></label>
			<select class="form-control" name="TPbrgy-dd">
			<?php for ($ctr = 0; $ctr < count($brgys); $ctr++) { ?>
				<option value="<?= $brgys[$ctr]['barangay'] ?>"> <?= $brgys[$ctr]['barangay'] ?> </option>
			<?php } ?>
			</select>
		</div>
	<!-- end of Barangays -->
	
	<!-- Households -->
	    <div class="form-group">
		   	<label for=""> Household: </label> <label class="text-danger"><?php echo form_error('TPhh-dd'); ?></label>
			<select class="form-control" name="TPhh-dd">
			</select>
		</div>
	<!-- end of Households -->
</div>
<!-- /end of Filters -->

<div class="col-md-9">
	&nbsp;
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>