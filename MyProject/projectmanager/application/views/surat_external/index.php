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
				<h1>Penerima External</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Penerima External
								</button>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Penerima External</h4>
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
				url: "<?= base_url() ?>surat_external/ax_data_surat_external/",
				type: 'POST'
			},
			columns: [{
					data: "id_surat_external",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_surat_external"
				},
				{
					data: "nm_surat_external"
				},
				{
					data: "email_surat_external"
				},
				{
					data: "type_penerima",
					render: function(data, type, full, meta) {
						if (data == 1)
							return "Penerima";
						else return "Tembusan";
					}
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
			if ($('#nm_surat_external').val() == '') {
				alertify.alert("Warning", "Please fill Name.");
			} else {
				var url = '<?= base_url() ?>surat_external/ax_set_data';
				var data = {
					id_surat_external: $('#id_surat_external').val(),
					email_surat_external: $('#email_surat_external').val(),
					nm_surat_external: $('#nm_surat_external').val(),
					type_penerima: $('#type_penerima').val(),

					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("Penerima External data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_surat_external) {
			if (id_surat_external == 0) {
				$('#addModalLabel').html('Add Surat External');
				$('#id_surat_external').val('0');
				$('#type_penerima').val('1');
				$('#nm_surat_external').val('');
				$('#email_surat_external').val('');
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>surat_external/ax_get_data_by_id';
				var data = {
					id_surat_external: id_surat_external
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit Surat External');
					$('#id_surat_external').val(data['id_surat_external']);
					$('#type_penerima').val(data['type_penerima']);
					$('#nm_surat_external').val(data['nm_surat_external']);
					$('#email_surat_external').val(data['email_surat_external']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_surat_external) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>surat_external/ax_unset_data';
					var data = {
						id_surat_external: id_surat_external
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('surat external data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>