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
					<h1>Business Unit</h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Business Unit
									</button>
									<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Add bu</h4>
												</div>
												<div class="modal-body">
													<form id='formAddItem'>
													<input type="hidden" id="id_bu" name="id_bu" value='' />

													<div class="form-group">
														<label>Divre</label>
														<select class="form-control " style="width: 100%;" id="id_divre" name="id_divre">
														<option value="0">--Jenis--</option>
														<?php
															foreach ($divre_combobox->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_divre?>"  ><?= $rowmenu->nm_divre?></option>
														<?php
															}
														?>
														</select>
													</div>
													

													<div class="form-group">
														<label>KD BU</label>
														<input type="text" id="kd_bu" name="kd_bu" class="form-control" placeholder="KD BU">
													</div>

													<div class="form-group">
														<label>Name</label>
														<input type="text" id="nm_bu" name="nm_bu" class="form-control" placeholder="Name">
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
													<th>Divre</th>
													<th>KD BU</th>
													<th>Business Unit</th>
													
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
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: 
				{
					url: "<?= base_url() ?>bu/ax_data_bu/",
					type: 'POST'
				},
				columns: 
				[
					{
						data: "id_bu", render: function(data, type, full, meta){
							var str = '';
							str += '<div class="btn-group">';
							str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a href="<?= base_url()?>bu/access/'+data+'"><i class="fa fa-users"></i> Access</a></li>';
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_bu" },
					{ data: "nm_divre" },
					{ data: "kd_bu" },
					{ data: "nm_bu" },
					
					{ data: "active", render: function(data, type, full, meta){
							if(data == 1)
								return "Active";
							else return "Not Active";
						}
					}
				]
			});
			
			$('#btnSave').on('click', function () {
				if($('#nm_bu').val() == '')
				{
					alertify.alert("Warning", "Please fill bu Name.");
				}
				else if($('#kd_bu').val() == '')
				{
					alertify.alert("Warning", "Please fill KD BU.");
				}

				else if($('#id_divre').val() == '0')
				{
					alertify.alert("Warning", "Please fill Divre.");
				}
				else
				{
					var url = '<?=base_url()?>bu/ax_set_data';
					var data = {
						id_bu: $('#id_bu').val(),
						id_divre: $('#id_divre').val(),
						nm_bu: $('#nm_bu').val(),
						kd_bu: $('#kd_bu').val(),
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
							alertify.success("bu data saved.");
							$('#addModal').modal('hide');
							buTable.ajax.reload();
						}
					});
				}
			});
			
			function ViewData(id_bu)
			{
				if(id_bu == 0)
				{
					$('#addModalLabel').html('Add bu');
					$('#id_bu').val('');
					$('#nm_bu').val('');
					$('#kd_bu').val('');
					$('#id_divre').val('0');
					$('#active').val('1');
					$('#systems').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>bu/ax_get_data_by_id';
					var data = {
						id_bu: id_bu
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit BU');
						$('#id_bu').val(data['id_bu']);
						$('#nm_bu').val(data['nm_bu']);
						$('#kd_bu').val(data['kd_bu']);
						$('#id_divre').val(data['id_divre']);
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
			
			function DeleteData(id_bu)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>bu/ax_unset_data';
						var data = {
							id_bu: id_bu
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							buTable.ajax.reload();
							alertify.error('bu data deleted.');
						});
					},
					function(){ }
				);
			}

			
		</script>
	</body>
</html>
