<!-- HEADER -->
<?php $data['title'] = "System Users"; $this->load->view('/site/templates/header',$data);?>


</head>
<body>
<!-- CONTENT -->
<div class="container">
<!-- Search -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> <span class="glyphicon glyphicon-search"></span> Search Map Nodes </h3>
			</div>
			<div class="panel-body">
				<?php 
					$attributes = array(
											'id' 	=> 'TPsearch',
											'role'	=> 'form'
										);
					echo form_open('website/poi/search',$attributes); 
				?>
				<!-- Search Bar -->
	        	<div class="form-group">
		        	<input type="text" class="form-control" name="TPsearch-txt" id="TPsearch-txt" placeholder="Search" required autofocus/>
	        	</div>
	        	<!-- end of Search Bar -->
	        	<div class="form-group"><center><input type="submit" value="Search" class="btn btn-default" /></center></div>
	        	</form>
			</div>
		</div>
		<!-- end of Search -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> Viewing All POIs </h3>
	</div>
	<div class="panel-body">
	<!-- Table of POIs -->
		<table class="table">
			<thead>
				<tr>
					<th> Node Name </th> <th> Type </th> <th> Barangay </th> <th> Notes </th> <th> Created On </th> <th> End Date </th>
				</tr>
			<thead>
			<tbody>
				<?php foreach ($pois as $poi) {?>
				<tr>
					<td> <a href="<?= site_url('website/poi/update/' . $poi['node_no']) ?>"> <?= $poi['node_name']?> </a> </td> 
					<td> <?php if ($poi['node_type'] == 0) echo 'Source Area'; else if ($poi['node_type'] == 1) echo 'Risk Area'; ?> </td> 
					<td> <?= $poi['node_barangay'] ?> </td>
					<td> <?= $poi['node_notes'] ?> </td> 
					<td> <?= date('D, M d Y',strtotime($poi['node_addedOn'])) ?> </td> 
					<td> <?= $poi['node_endDate'] ?> </td> 
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- /end of Table of POIs -->
		<div style="text-align:right">
			<?php echo $links; ?>
		</div>
	</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>