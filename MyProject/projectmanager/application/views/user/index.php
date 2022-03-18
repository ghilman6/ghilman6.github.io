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
					<h1>User</h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary " onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Create User
									</button>
									<div class="modal fade" id="addModal" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" tabindex="">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-user" id="addModalLabel">Form Add</h4>
												</div>
												<div class="modal-body">
													<input type="hidden" id="id_user" name="id_user" value='' />
													<div class="form-group">
														<label>Nama</label>
														<input type="text" id="nm_user" name="nm_user" class="form-control" placeholder="Full Name">
													</div>
													<div class="form-group">
														<label>Username</label>
														<input type="text" id="username" name="username" class="form-control" placeholder="username">
													</div>
													<div class="form-group">
														<label>Password</label>
														<input type="password" id="password" name="password" class="form-control" placeholder="Password" value="12345">
													</div>
													<div class="form-group">
														<label>Level</label>
														<select class="form-control select2" id="id_level" name="id_level"  style="width:100%">
														<option value="0">--Level--</option>
														<?php
															foreach ($combobox_level->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_level?>"  ><?= $rowmenu->nm_level?></option>
														<?php
															}
														?>
														</select>
													</div>

													<div class="form-group">
														<label>BU</label>
														<select class="form-control select2" id="id_bu" name="id_bu" style="width:100%">
															<option value="0">--Bussiness Unit--</option>
														<?php
															foreach ($combobox_bu->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_bu?>"  ><?= $rowmenu->nm_bu?></option>
														<?php
															}
														?>
														</select>
													</div>
													
													
													<div class="form-group">
														<label>Active</label>
														<select class="form-control" id="active" name="active">
															<option value="1" <?php echo set_select('myselect', '1', TRUE); ?> >Active</option>
															<option value="0" <?php echo set_select('myselect', '0'); ?> >Not Active</option>
														</select>
													</div>
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="button" value="Save" class="btn btn-primary" id='btnSave'>Save</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="userTable">
											<thead>
												<tr>
													<th nowraps>Options</th>
													<th nowraps>#</th>
													<th nowraps>Name</th>
													<th nowraps>Username</th>
													<th nowraps>Level</th>
													<th nowraps>BU</th>
													<th nowraps>Active</th>
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
			var userTable = $('#userTable').DataTable({
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: {
					url: "<?= base_url() ?>user/ax_data_user/",
					type: 'POST'
				},
				columns: [
					{
						data: "id_user", render: function(data, type, full, meta)
						{
							var str = '';
							str += '<div class="btn-group">';
							str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a onclick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					{ data: "id_user" },
					{ data: "nm_user" },
					{ data: "username" },
					{ data: "nm_level" },
					{ data: "nm_bu" },
					{ data: "active", render: function(data, type, full, meta)
						{
							if(data == 1)
								return "Active";
							else 
								return "Not Active";
						}
					},
					
				],
			});
			
			$('#btnSave').on('click', function () {
				var id_user = $('#id_user').val();
				var id_bu = $('#id_bu').val();
				var nm_user = $('#nm_user').val();
				var username = $('#username').val();
				var password = $('#password').val();
				var id_level = $('#id_level').val();
				var active = $('#active').val();
				
				if(nm_user == '')
				{
					alertify.alert("Warning", "Please fill all information in form.");
				}
				else
				{
					var url = '<?=base_url()?>user/ax_set_data';
					var data = {
						id_user: id_user,
						id_bu: id_bu,
						nm_user: nm_user,
						username: username,
						password: password,
						id_level: id_level,
						active: active,
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						if(data['status'] == "success")
						{
							alertify.success("User data saved.");
							$('#addModal').modal('hide');
							userTable.ajax.reload();
						}
					});
				}
			});
			
			function ViewData(id_user)
			{
				if(id_user == 0)
				{
					$('#addModalLabel').html('Add User');
					$('#id_user').val('0');
					$('#nm_user').val('');
					$('#password').val('');
					$('#active').val('1');
					$('#id_bu').val('0');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>user/ax_get_data_by_id';
					var data = {
						id_user: id_user
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit User');
						$('#id_user').val(data['id_user']);
						$('#nm_user').val(data['nm_user']);
						$('#username').val(data['username']);
						$('#password').val('');
						$('#id_level').val(data['id_level']).trigger("change");
						$('#id_bu').val(data['id_bu']).trigger("change");
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
			
			function DeleteData(id_user)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>user/ax_unset_data';
						var data = {
							id_user: id_user
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							userTable.ajax.reload();
							alertify.error('User data deleted.');
						});
					},
					function(){ }
				);
			}
			
			
			
		</script>
	</body>
</html>
