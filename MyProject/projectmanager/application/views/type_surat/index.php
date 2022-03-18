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
					<h1>Tipe Surat</h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Tipe Surat
									</button>
									<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Add Type Surat</h4>
												</div>
												<div class="modal-body">
													<input type="hidden" id="id_type_surat" name="id_type_surat" value='' />

													<div class="form-group">
														<label>Kode </label>
														<input type="text" id="kd_type_surat" name="kd_type_surat" class="form-control" placeholder="Kode Type Surat">
													</div>

													<div class="form-group">
														<label>Name</label>
														<input type="text" id="nm_type_surat" name="nm_type_surat" class="form-control" placeholder="Name">
													</div>
													
													<div class="form-group">
														<label>Jenis Tanda Tangan</label>
														<select class="form-control" id="jenis_ttd" name="jenis_ttd">
															<option value="1"  >Digital</option>
															<option value="0"  >Basah</option>
														</select>
													</div>

													<div class="form-group">
														<label>Active</label>
														<select class="form-control" id="active" name="active">
															<option value="1"  >Active</option>
															<option value="0"  >Not Active</option>
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
													<th>Kode</th>
													<th>Tipe Surat</th>
													<th>Jenis Tanda Tangan</th>
													<th>Active</th>
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
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: 
				{
					url: "<?= base_url()?>type_surat/ax_data_type_surat/",
					type: 'POST'
				},
				columns: 
				[
					{
						data: "id_type_surat", render: function(data, type, full, meta){
							var str = '';
							str += '<div class="btn-group">';
							str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a href="<?= base_url()?>pengiriman/details/'+data+'"><i class="fa fa-list"></i> Details</a></li>';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_type_surat" },
					{ data: "kd_type_surat" },
					{ data: "nm_type_surat" },
					{ data: "jenis_ttd", render: function(data, type, full, meta){
							if(data == 1)
								return "Digital";
							else return "Basah";
						} },
					
					{ data: "active", render: function(data, type, full, meta){
							if(data == 1)
								return "Active";
							else return "Not Active";
						}
					}
				]
			});
			
			$('#btnSave').on('click', function () {
				if($('#nm_type_surat').val() == '')
				{
					alertify.alert("Warning", "Please fill Name.");
				}
				else
				{
					var url = '<?=base_url()?>type_surat/ax_set_data';
					var data = {
						id_type_surat: $('#id_type_surat').val(),
						kd_type_surat: $('#kd_type_surat').val(),
						nm_type_surat: $('#nm_type_surat').val(),
						jenis_ttd: $('#jenis_ttd').val(),
						active: $('#active').val()
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						if(data['status'] == "success")
						{
							alertify.success("Type Surat data saved.");
							$('#addModal').modal('hide');
							buTable.ajax.reload();
						}
					});
				}
			});
			
			function ViewData(id_type_surat)
			{
				if(id_type_surat == 0)
				{
					$('#addModalLabel').html('Add Tipe Surat');
					$('#id_type_surat').val('0');
					$('#kd_type_surat').val('');
					$('#nm_type_surat').val('');
					$('#jenis_ttd').val('1');
					$('#active').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>type_surat/ax_get_data_by_id';
					var data = {
						id_type_surat: id_type_surat
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit Tipe Surat');
						$('#id_type_surat').val(data['id_type_surat']);
						$('#kd_type_surat').val(data['kd_type_surat']);
						$('#nm_type_surat').val(data['nm_type_surat']);
						$('#jenis_ttd').val(data['jenis_ttd']);
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
			
			function DeleteData(id_type_surat)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>type_surat/ax_unset_data';
						var data = {
							id_type_surat: id_type_surat
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							buTable.ajax.reload();
							alertify.error('Type Surat data deleted.');
						});
					},
					function(){ }
				);
			}
		</script>
	</body>
</html>
