<!DOCTYPE html>
<html>

<head>
	<?= $this->load->view('head'); ?>
</head>

<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">
	<script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>

	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">

			<section class="content-header">
				<h1>Detail Surat</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-6">
						<table class="table table-striped table-hover" id="SuratTable">
							<thead>
								<tr>
									<th>Surat</th>
								</tr>
							</thead>
						</table>
						<hr>
					</div>
					<div class="col-lg-6">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#preview_pdf">Preview PDF</a></li>
							<li><a data-toggle="tab" href="#menu1">Isi Surat</a></li>
						</ul>

						<div class="tab-content">
							<div id="preview_pdf" class="tab-pane fade in active">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h4 class="panel-title">

										</h4>
									</div>
									<div id="collapse1" class="panel-collapse collapse in">
										<div class="panel-body">
											<div class="form-group">
												<img class="img-responsive center-block gif" src="<?= base_url() ?>assets/img/loading_pdf.gif" id="gif" style="width:100%; height:100%; display: none;">
												<div id="showpdf" class="showpdf"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="menu1" class="tab-pane fade">
								<div class="panel-group" id="accordion2">
									<!---------------- SECTION ISI SURAT ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse11">
													Isi Surat</a>
											</h4>
										</div>
										<div id="collapse11" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group">
													<!-- <label>Isi Surat</label> -->
													<textarea id="isi_surat" name="isi_surat" class="form-control" rows="10" cols="80"><?= $data_surat['isi_surat']  ?></textarea>
												</div>
											</div>
										</div>
									</div>
									<!----------------- SECTION ATTACHEMENT ------------------>
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse6">
													Attachement</a>
											</h4>
										</div>
										<div id="collapse6" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewData(0)'>
															<i class='fa fa-plus'></i> Add Attachement
														</button>
														<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabel">Form Add Attachement</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_kantor" name="id_kantor" value='' />

																		<div class="form-group">
																			<label>Name</label>
																			<input type="text" id="nm_kantor" name="nm_kantor" class="form-control" placeholder="Name">
																		</div>


																		<div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="active" name="active">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSave'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" id="buTableKantor">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>#</th>
																		<th>Attachement</th>
																		<th>Status</th>

																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION APPROVAL ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse7">
													Approval</a>
											</h4>
										</div>
										<div id="collapse7" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewDataApproval(0)'>
															<i class='fa fa-plus'></i> Add approval
														</button>
														<div class="modal fade" id="addModalApproval" tabindex="-1" role="dialog" aria-labelledby="addModalLabelAp" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabel">Form Add approval</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_approval" name="id_approval" value='0' />





																		<div class="form-group">
																			<label>Akun</label>
																			<select class="form-control select2" style="width: 100%;" id="id_akun" name="id_akun">
																				<option value="0">--Akun--</option>
																				<?php
																				foreach ($combobox_akun->result() as $rowmenu) {
																				?>
																					<option value="<?= $rowmenu->id_akun ?>"><?= $rowmenu->nm_akun ?> - <?= $rowmenu->nm_pegawai ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>

																		<div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="activeAp" name="activeAp">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div>
																		<div class="form-group">
																			<label>Tipe Approval</label>
																			<select class="form-control" id="type_approval" name="type_approval">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Paraf</option>
																				<option value="2" <?php echo set_select('myselect', '0'); ?>>Approval</option>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveApproval'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table style="overflow: auto; width: 100%;" class="table table-striped table-bordered table-hover" id="buTableApproval">
																<thead style="overflow: hidden; position: relative; border: 0px; width: 100%;">
																	<tr>
																		<th>Options</th>
																		<th>Status</th>
																		<th>Alias</th>
																		<th>Approval</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION INTERNAL ------------------->
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse8">
													Penerima Internal</a>
											</h4>
										</div>
										<div id="collapse8" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewDataInter(0)'>
															<i class='fa fa-plus'></i> Add Penerima Internal
														</button>
														<div class="modal fade" id="addModalInter" tabindex="-1" role="dialog" aria-labelledby="addModalLabelInter" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabelInter">Form Add Penerima internal</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_surat_internal" name="id_surat_internal" value='' />

																		<div class="form-group">
																			<label>Type Penerima</label>
																			<select class="form-control" id="type_penerimaInter" name="type_penerimaInter">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Tujuan</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Tembusan</option>
																			</select>
																		</div>



																		<div class="form-group">
																			<label>Alias</label>
																			<select class="form-control select2" style="width: 100%;" id="id_akunInter" name="id_akunInter">
																				<?php
																				foreach ($combobox_akun->result() as $rowmenu) {
																				?>
																					<option value="<?= $rowmenu->id_akun ?>"><?= $rowmenu->nm_akun ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>

																		<div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="activeInter" name="activeInter">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveInter'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" id="buTableInter">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>Alias</th>
																		<th>Type Penerima</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION EXTERNAL ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse9">
													Penerima External</a>
											</h4>
										</div>
										<div id="collapse9" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewDataEx(0)'>
															<i class='fa fa-plus'></i> Add Penerima External
														</button>
														<div class="modal fade" id="addModalEx" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabelEx">Form Add Penerima External</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_surat_external" name="id_surat_external" value='' />

																		<div class="form-group">
																			<label>Type Penerima</label>
																			<select class="form-control" id="type_penerima" name="type_penerima">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Penerima</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Tembusan</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label>Penerima</label>
																			<input type="text" id="nm_surat_external" name="nm_surat_external" class="form-control" placeholder="Penerima">
																		</div>

																		<div class="form-group">
																			<label>Email Penerima</label>
																			<input type="text" id="email_surat_external" name="email_surat_external" class="form-control" placeholder="Email">
																		</div>


																		<div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="active" name="active">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveEx'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" style="overflow: auto; width: 100%;" id="buTableEx">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>#</th>
																		<th>Penerima</th>
																		<th>Email</th>
																		<th>Type</th>
																		<th>Status</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
		</div>

	</div>
	</div>
	<!-- inital js page -->
	<?= $this->load->view('basic_js'); ?>

</body>
<script>
	CKEDITOR.replace('isi_surat');
	const base_url = `<?= base_url() ?>`;
	const id_surat = `<?= $data_surat['id_surat'] ?>`;

	$(document).ready(function() {
		load_pdf();
		$(".tabs_collapse").click(function() {
			$(".tabs_collapse").removeClass("active");
			$(this).addClass("active"); // Add Active class to each tabs collapse

		});
	});
	$("#accordion, #accordion2").on("shown.bs.collapse", function() {
		$.each($.fn.dataTable.tables(true), function() {
			$(this).DataTable().columns.adjust().draw();
		});
	});
</Script>
<!-- approval -->
<script type='text/javascript' src="<?= base_url('assets/custom_js/approval.js'); ?>"></script>
<!-- external -->
<script type='text/javascript' src="<?= base_url('assets/custom_js/external.js'); ?>"></script>
<!-- internal -->
<script type='text/javascript' src="<?= base_url('assets/custom_js/internal.js'); ?>"></script>
<!-- attachement { masih kantor karena belum di ubah ke attachement } -->
<script type='text/javascript' src="<?= base_url('assets/custom_js/attachement.js'); ?>"></script>
<!-- preview pdf -->
<script type='text/javascript' src="<?= base_url('assets/custom_js/preview_pdf.js'); ?>"></script>

<script type='text/javascript'>
	var SuratTable = $('#SuratTable').DataTable({
		"ordering": false,
		"scrollX": true,
		"processing": true,
		"serverSide": true,
		// "pageLength": 30"
		ajax: {
			url: "<?= base_url() ?>surat/ax_data_surat/",
			type: 'POST'
		},
		columns: [{
			data: "id_surat",
			render: function(data, type, full, meta) {
				var str = '';
				str += data + ' - ' + full['nm_type_surat'] + ' - ' + full['nm_klasifikasi'] + ' - ' + full['nm_kategori'] + ' - ' + full['perihal'];
				return str;
			}
		}, ]

	});

	$('#btnSave').on('click', function() {
		var isi_surat = CKEDITOR.instances.isi_surat.getData()
		if ($('#id_type_surat').val() == '0') {
			alertify.alert("Warning", "Please fill Tipe Surat.");
		} else if ($('#id_klasifikasi').val() == '0') {
			alertify.alert("Warning", "Please fill Klasifikasi.");
		} else if ($('#id_kategori').val() == '0') {
			alertify.alert("Warning", "Please fill Kategori.");
		} else if ($('#perihal').val() == '') {
			alertify.alert("Warning", "Please fill Perihal.");
		} else if (isi_surat == '') {
			alertify.alert("Warning", "Please fill Isi Surat.");
		} else {
			var url = '<?= base_url() ?>surat/ax_set_data';
			var data = {
				id_surat: $('#id_surat').val(),
				id_type_surat: $('#id_type_surat').val(),
				id_klasifikasi: $('#id_klasifikasi').val(),
				id_kategori: $('#id_kategori').val(),
				perihal: $('#perihal').val(),
				isi_surat: isi_surat,
				active: $('#active').val()
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				if (data['status'] == "success") {
					alertify.success("surat data saved.");
					$('#addModal').modal('hide');
					buTable.ajax.reload();
				}
			});
		}
	});

	function ViewData(id_surat) {
		if (id_surat == 0) {
			$('#addModalLabel').html('Add surat');
			$('#id_surat').val('0');
			$('#id_type_surat').val('');
			$('#id_klasifikasi').val('');
			$('#id_kategori').val('');
			$('#perihal').val('');
			$('#isi_surat').val('');
			$('#active').val('1');
			$('#addModal').modal('show');
		} else {
			var url = '<?= base_url() ?>surat/ax_get_data_by_id';
			var data = {
				id_surat: id_surat
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				$('#addModalLabel').html('Edit surat');
				$('#id_surat').val(data['id_surat']);
				$('#id_type_surat').val(data['id_type_surat']);
				$('#id_klasifikasi').val(data['id_klasifikasi']);
				$('#id_kategori').val(data['id_kategori']);
				$('#perihal').val(data['perihal']);
				$('#isi_surat').val(data['isi_surat']);
				$('#active').val(data['active']);
				$('#addModal').modal('show');
			});
		}
	}

	function DeleteData(id_surat) {
		alertify.confirm(
			'Confirmation',
			'Are you sure you want to delete this data?',
			function() {
				var url = '<?= base_url() ?>surat/ax_unset_data';
				var data = {
					id_surat: id_surat
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					buTable.ajax.reload();
					alertify.error('surat data deleted.');
				});
			},
			function() {}
		);
	}
</script>

</html>