<!DOCTYPE html>
<html>
	<head>
		<?= $this->load->view('head'); ?>
		<style>
		
		</style>
	</head>
	<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">
		<div class="wrapper">
			<?= $this->load->view('nav'); ?>
			<?= $this->load->view('menu_groups'); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Klasifikasi</h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<klasifikasitton class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Klasifikasi
									</klasifikasitton>
									<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<klasifikasitton type="klasifikasitton" class="close" data-dismiss="modal" aria-hidden="true">&times;</klasifikasitton>
													<h4 class="Form-add-klasifikasi" id="addModalLabel">Form Add Klasifikasi</h4>
												</div>
												<div class="modal-body">
													<form id='formAddItem'>
													<input type="hidden" id="id_klasifikasi" name="id_klasifikasi" value='' />

													<div class="form-group">
														<label>Jenis</label>
														<select class="form-control select2 " style="width: 100%;" id="id_jenis" name="id_jenis">
														<option value="0">--Jenis--</option>
														<?php
															foreach ($jenis_combobox->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_jenis?>"  ><?= $rowmenu->nm_jenis?></option>
														<?php
															}
														?>
														</select>
													</div>
													

													<div class="form-group">
														<label>KD Klasifikasi</label>
														<input type="text" id="kd_klasifikasi" name="kd_klasifikasi" class="form-control" placeholder="KD klasifikasi">
													</div>

													<div class="form-group">
														<label>Klasifikasi</label>
														<input type="text" id="nm_klasifikasi" name="nm_klasifikasi" class="form-control" placeholder="Name">
													</div>
													
													
													
													<div class="form-group">
														<label>Active</label>
														<select class="form-control" id="active" name="active">
															<option value="1" <?php echo set_select('myselect', '1', TRUE); ?> >Active</option>
															<option value="0" <?php echo set_select('myselect', '0'); ?> >Not Active</option>
														</select>
													</div>
													</form>
												</div>
												<div class="modal-footer">
													<klasifikasitton type="klasifikasitton" class="btn btn-default" data-dismiss="modal">Close</klasifikasitton>
													<klasifikasitton type="klasifikasitton" class="btn btn-primary" id='btnSave'>Save</klasifikasitton>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="klasifikasiTable">
											<thead>
												<tr>
													<th>Options</th>
													<th>#</th>
													<th>Jenis</th>
													<th>KD Klasifikasi</th>
													<th>Klasifikasi</th>
													
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
			var klasifikasiTable = $('#klasifikasiTable').DataTable({
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: 
				{
					url: "<?= base_url() ?>klasifikasi/ax_data_klasifikasi/",
					type: 'POST'
				},
				columns: 
				[
					{
						data: "id_klasifikasi", render: function(data, type, full, meta){
							var str = '';
							str += '<div class="btn-group">';
							str += '<klasifikasitton type="klasifikasitton" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></klasifikasitton>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_klasifikasi" },
					{ data: "nm_jenis" },
					{ data: "kd_klasifikasi" },
					{ data: "nm_klasifikasi" },
					
					{ data: "active", render: function(data, type, full, meta){
							if(data == 1)
								return "Active";
							else return "Not Active";
						}
					}
				]
			});
			
			$('#btnSave').on('click', function () {
				if($('#nm_klasifikasi').val() == '')
				{
					alertify.alert("Warning", "Please fill klasifikasi Name.");
				}
				else if($('#kd_klasifikasi').val() == '')
				{
					alertify.alert("Warning", "Please fill KD klasifikasi.");
				}

				else if($('#id_jenis').val() == '0')
				{
					alertify.alert("Warning", "Please fill jenis.");
				}
				else
				{
					var url = '<?=base_url()?>klasifikasi/ax_set_data';
					var data = {
						id_klasifikasi: $('#id_klasifikasi').val(),
						id_jenis: $('#id_jenis').val(),
						nm_klasifikasi: $('#nm_klasifikasi').val(),
						kd_klasifikasi: $('#kd_klasifikasi').val(),
						active: $('#active').val()
					};
					$.ajax({
						url: url,
						method: 'POST',
						data: data,
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						if(data['status'] == "success")
						{
							alertify.success("klasifikasi data saved.");
							$('#addModal').modal('hide');
							klasifikasiTable.ajax.reload();
						}
					});
				}
			});
			
			function ViewData(id_klasifikasi)
			{
				if(id_klasifikasi == 0)
				{
					$('#addModalLabel').html('Add Klasifikasi');
					$('#id_klasifikasi').val('');
					$('#nm_klasifikasi').val('');
					$('#kd_klasifikasi').val('');
					$('#id_jenis').val('0');
					$('#active').val('1');
					$('#systems').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>klasifikasi/ax_get_data_by_id';
					var data = {
						id_klasifikasi: id_klasifikasi
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit Klasifikasi');
						$('#id_klasifikasi').val(data['id_klasifikasi']);
						$('#nm_klasifikasi').val(data['nm_klasifikasi']);
						$('#kd_klasifikasi').val(data['kd_klasifikasi']);
						$('#id_jenis').val(data['id_jenis']);
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
			
			function DeleteData(id_klasifikasi)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>klasifikasi/ax_unset_data';
						var data = {
							id_klasifikasi: id_klasifikasi
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							klasifikasiTable.ajax.reload();
							alertify.error('klasifikasi data deleted.');
						});
					},
					function(){ }
				);
			}

			
		</script>
	</body>
</html>
