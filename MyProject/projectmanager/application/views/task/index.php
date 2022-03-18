<!DOCTYPE html>
<html>
	<head>
		<?= $this->load->view('head'); ?>
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/assets/plugins/ckeditor/ckeditor.js">

	</head>
	<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">
		<script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
		<div class="wrapper">
			<?= $this->load->view('nav'); ?>
			<?= $this->load->view('menu_groups'); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Task #</h1>
				</section>
				<section class="invoice">
				<div class="nav-tabs-custom">
									<div class="tab-content ">
										<div class="form-horizontal">

											<div class="row">
												
												<div class="col-lg-10 col-md-8 col-sm-6">
													<label>Tanggal </label>

													<div class="input-group">
														<input type="text" id="filterTglTask" name="filterTglTask" class="form-control" placeholder="Masukkan Tanggal">
														
													</div>
												</div>


											</div>

										</div>
									</div>
								</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Task
									</button>
									<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Task</h4>
												</div>
												<div class="modal-body">
													<input type="hidden" id="id_activity" name="id_activity" value='' />
													<input type="hidden" id="id_program_detail" name="id_program_detail" value='<?= $id_program_detail?>' />

													<div class="form-group ">
														<label>Program</label>
														<select class="form-control select2 " style="width: 100%;" id="id_program" name="id_program">
																<option value="0">--Program--</option>
																<?php
																foreach ($combobox_nm_program->result() as $rowmenu) {
																?>
																<option value="<?= $rowmenu->id_program?>"  ><?= $rowmenu->nm_program?></option>
																<?php
																}
																?>
														</select>
													</div>

													<div class="form-group ">
														<label>Nama Program detail</label>
														<select class="form-control " style="width: 100%;" id="program_detail" name="program_detail">
																<option value="0">--Activity--</option>

														</select>
													</div>

													<div class="form-group">
														<label>Due Date</label>
														<input type="text" id="due" name="due" class="form-control" readonly="readonly" placeholder="Due">
													</div>

													<div class="form-group">
														<label>Keterangan</label>
														<textarea id="keterangan" name="keterangan" class="form-control" rows="10" cols="80"></textarea>
													</div>

													

													<div class="form-group ">
														<label>Status</label>
														<select class="form-control select2 " style="width: 100%;" id="id_status" name="id_status">
																<option value="0">--Status--</option>
																<?php
																foreach ($combobox_status->result() as $rowmenu) {
																?>
																<option value="<?= $rowmenu->id_status?>"  ><?= $rowmenu->nm_status?></option>
																<?php
																}
																?>
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
													<th>program</th>
													<th>Program Detail</th>
													<th>keterangan</th>
													<th>Last Update</th>
                                                    <th>User</th>
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
		<script>
			CKEDITOR.replace('keterangan');
		</Script>
		<?= $this->load->view('basic_js'); ?>
		<script type='text/javascript'>

		// getTglTask();	

			$('#id_program').on('change', function(){
				const url = `<?=base_url()?>task/ax_get_program_detail`;
				const id_program = this.value;

				const data = {
					id_program: id_program,
					
				};
				$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(res, textStatus, jqXHR) {
						const data = JSON.parse(res);
						$('#program_detail').html(data.html);
						$("#due").datepicker('setDate',data.data['due']);

					});
			})

			

			 $("#filterTglTask").on("change", function(){ 
				buTable.ajax.reload();
			 });

			
			var buTable = $('#buTable').DataTable({
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: 
				{
					url: "<?= base_url()?>task/ax_data_activity/",
					type: 'POST',
					data: function ( d ) {
			         return $.extend({}, d, { 
			         	
						"tanggal": $("#filterTglTask").val()

			         });
			     	}
					
				},
				columns: 
				[
					{
						data: "id_activity", render: function(data, type, full, meta){
							var str = '';
							str += '<div class="btn-group">';
							str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a href="<?= base_url()?>task/detailsatt/'+data+'"><i class="fa fa-list"></i> Lihat Attachment</a></li>';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_activity" },
					{ data: "nm_program" },
					{ data: "nm_program_detail" },
					{ data: "keterangan" },
					{ data: "cdate" },
                    { data: "nm_user" },
					{ data: "nm_status" },
					
				]
			});
			
			$('#btnSave').on('click', function () {
				var keterangan = CKEDITOR.instances.keterangan.getData()
				if($('#nm_user').val() == '')
				{
					alertify.alert("Warning", "Please fill user");
				}
				else
				{
					var url = '<?=base_url()?>task/ax_set_activity';
					var data = {
						id_activity: $('#id_activity').val(),
						id_program: $('#id_program').val(),
						nm_program_detail: $('#program_detail').val(),
						id_status: $('#id_status').val(),
						keterangan: keterangan,
						cdate: $('#cdate').val(),
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
							alertify.success("program data saved.");
							$('#addModal').modal('hide');
							buTable.ajax.reload();
						}
					});
				}
			});
			
			function ViewData(id_activity)
			{
				if(id_activity == 0)
				{
					$('#addModalLabel').html('Add Task');
					$('#id_activity').val('0');
					$('#program').val('');
					$('#nm_program_detail').val('');
					$('#keterangan').val('');
					$('#cdate').val('');
					$('#active').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>task/ax_get_data_activity_by_id';
					var data = {
						id_activity: id_activity
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						
						var data = JSON.parse(data);
						console.log(data.id_activity)
						$('#addModalLabel').html('Edit activity');
						$('#id_activity').val(data.id_activity);
						$('#program').val(data.id_program);
						$('#nm_program_detai').val(data.nm_program_detail);
						$('#keterangan').val(data.keterangan);
						$('#cdate').val(data.cdate);
						$('#active').val(data.active);
						$('#addModal').modal('show');
					});
				}
			}

			
			
			function DeleteData(id_activity)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>task/ax_unset_activity';
						var data = {
							id_activity: id_activity
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							buTable.ajax.reload();
							alertify.error('activity data deleted.');
						});
					},
					function(){ }
				);
			}

			 function getFilterTgl(now = null) {

				const filterTglTask = $('#filterTglTask').val();

				if (filterTglSurat == '') {
						alertify.error("Pilih Tanggal Awal Dulu !");
						return;
				}


				const url = `${base_url}task/ax_get_filter_task`;
				let data = {
					filterTglTask: filterTglTask
				};
			}
			

			$( "#due").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "yy-mm-dd"
			});
			$( "#due" ).inputmask("yyyy-mm-dd",{"placeholder": "yyyy-mm-dd"});
			$("#filter").on("change", function(){ 
				buTable.ajax.reload();
			 });

			 $( "#filterTglTask").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "yy-mm-dd"
			});
			$( "#filterTglTask" ).inputmask("yyyy-mm-dd",{"placeholder": "yyyy-mm-dd"});
			$("#filter").on("change", function(){ 
				buTable.ajax.reload();
			 });

			
				
		</script>
	</body>
</html>
