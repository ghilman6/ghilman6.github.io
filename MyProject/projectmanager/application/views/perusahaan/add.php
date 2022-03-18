<!DOCTYPE html>
<html>
	<head>
		<?= $this->load->view('head'); ?>
	</head>
	<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">
		<div class="wrapper">
			<?= $this->load->view('nav'); ?>
			<?= $this->load->view('menu_groups'); ?>

			<div class="content-wrapper">

				<section class="content-header">
					<h1>Perusahaan</h1>
				</section>

				<section class="invoice">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Create Company
                        </div>
						<div class="panel-body">

							<?php echo form_open_multipart('perusahaan/insert',  array('class'=>'form-horizontal'));?>
								<div class="form-body">
									<div class="form-group">
										<label class="control-label col-md-2">Company Name</label>
										<div class="col-md-9">
											<input name="nm_perusahaan" placeholder="Company Name" class="form-control" type="text">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Address</label>
										<div class="col-md-9">
											<textarea name="textarea_address" placeholder="Address" class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Number Phone</label>
										<div class="col-md-9">
											<input name="text_phone_number" placeholder="Number Phone" class="form-control" type="text">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2" id="label-photo">Upload Logo</label>
										<div class="col-md-9">
											<input type="file" class="form-control" name="berkas">
											<small>size max.100 kb, file .png</small>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Type</label>
										<div class="col-md-9">
											<select name="jenis" class="form-control">
												<option value="1" <?php echo set_select('myselect', '1', TRUE); ?> >Pusat</option>
												<option value="2" <?php echo set_select('myselect', '2'); ?> >Subcon</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Active</label>
										<div class="col-md-9">
											<select name="active" class="form-control">
												<option value="1" <?php echo set_select('myselect', '1', TRUE); ?> >Active</option>
												<option value="0" <?php echo set_select('myselect', '0'); ?> >Deactive</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2"></label>
										<div class="col-md-9">
											<button type="submit" class="btn btn-primary">Save</button>
										
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
		<?= $this->load->view('basic_js'); ?>
	</body>
</html>
