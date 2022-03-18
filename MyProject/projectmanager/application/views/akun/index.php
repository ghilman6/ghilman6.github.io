<!DOCTYPE html>
<html>

<head>
	<?= $this->load->view('head'); ?>
</head>

<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">
	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Akun</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Akun
								</button>
								<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Akun</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_akun" name="id_akun" value='0' />

												<div class="form-group">
													<label>Name</label>
													<input type="text" id="nm_akun" name="nm_akun" class="form-control" placeholder="Name">
												</div>

												<div class="form-group">
													<label>Cabang</label>
													<select class="form-control select2" style="width: 100%;" id="id_bu" name="id_bu">
														<option value="0">--Cabang--</option>
														<?php
														foreach ($combobox_bu->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_bu ?>"><?= $rowmenu->nm_bu ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label>Divisi</label>
													<select class="form-control select2" style="width: 100%;" id="id_divisi" name="id_divisi">
														<option value="0">--Divisi--</option>
														<?php
														foreach ($combobox_divisi->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_divisi ?>"><?= $rowmenu->nm_divisi ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label>Pegawai</label>
													<select class="form-control select2" style="width: 100%;" id="id_pegawai" name="id_pegawai">
														<option value="0">--Pegawai--</option>
														<?php
														foreach ($combobox_pegawai->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_pegawai ?>"><?= $rowmenu->nm_pegawai ?></option>
														<?php
														}
														?>
													</select>
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
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>Options</th>
												<th>#</th>
												<th>Akun</th>
												<th>Cabang</th>
												<th>Divisi</th>
												<th>Pegawai</th>
												<th>Status</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?= $this->load->view('basic_js'); ?>
	<script type='text/javascript'>
		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>akun/ax_data_akun/",
				type: 'POST'
			},
			columns: [{
					data: "id_akun",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						str += '<li><a href="<?= base_url() ?>akun/access/' + data + '"><i class="fa fa-users"></i> Access</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_akun"
				},
				{
					data: "nm_akun"
				},
				{
					data: "nm_bu"
				},
				{
					data: "nm_divisi"
				},
				{
					data: "nm_pegawai"
				},

				{
					data: "active",
					render: function(data, type, full, meta) {
						if (data == 1)
							return "Active";
						else return "Not Active";
					}
				}
			]
		});

		$('#btnSave').on('click', function() {
			if ($('#nm_akun').val() == '') {
				alertify.alert("Warning", "Please fill bu Name.");
			} else {
				var url = '<?= base_url() ?>akun/ax_set_data';
				var data = {
					id_akun: $('#id_akun').val(),
					nm_akun: $('#nm_akun').val(),
					id_bu: $('#id_bu').val(),
					id_divisi: $('#id_divisi').val(),
					id_pegawai: $('#id_pegawai').val(),
					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("akun data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_akun) {
			if (id_akun == 0) {
				$('#addModalLabel').html('Add Akun');
				$('#id_akun').val('0');
				$('#nm_akun').val('');
				$('#id_bu').val('0');
				$('#id_divisi').val('0');
				$('#select2-id_bu-container').html('--Cabang--');
				$('#select2-id_divisi-container').html('--Divisi--');
				$('#id_pegawai').val('0');
				$('#select2-id_pegawai-container').html('--Pegawai--');
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>akun/ax_get_data_by_id';
				var data = {
					id_akun: id_akun
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit akun');
					$('#id_akun').val(data['id_akun']);
					$('#nm_akun').val(data['nm_akun']);
					$('#select2-id_bu-container').html(data['nm_bu']);
					$('#select2-id_divisi-container').html(data['nm_divisi']);
					$('#id_bu').val(data['id_bu']);
					$('#id_divisi').val(data['id_divisi']);
					$('#select2-id_pegawai-container').html(data['nm_pegawai']);
					$('#id_pegawai').val(data['id_pegawai']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_akun) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>akun/ax_unset_data';
					var data = {
						id_akun: id_akun
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('akun data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>