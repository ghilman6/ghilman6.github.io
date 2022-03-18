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
					<h1>Program detail #<?= $id_program?></h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add program detail
									</button>
									<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Add program detail</h4>
												</div>
												<div class="modal-body">
													<input type="hidden" id="id_program_detail" name="id_program_detail" value='' />
													<input type="hidden" id="id_program" name="id_program" value='<?= $id_program?>' />

													<div class="form-group">
														<label>Detail Program</label>
														<input type="text" id="nm_program_detail" name="nm_program_detail" class="form-control" placeholder="Nama Program Detail">
													</div>

													<div class="form-group">
														<label>Due Date</label>
														<input type="text" id="due" name="due" class="form-control" placeholder="Due">
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
													<th>Detail Program</th>
													<th>Due Date</th>
													<th>Status</th>
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
					url: "<?= base_url()?>program/ax_data_program_detail/",
					type: 'POST',
					data: function ( d ) {
			         return $.extend({}, d, { 
			         	
			         	"id_program": <?= $id_program ?>,

			         });
			     	}
				},
				columns: 
				[
					{
						data: "id_program_detail", render: function(data, type, full, meta){
							var str = '';
							str += '<div class="btn-group">';
							str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
							str += '<ul class="dropdown-menu">';
							str += '<li><a href="<?= base_url()?>program/pic_details/'+data+'"><i class="fa fa-user"></i> PIC</a></li>';
							str += '<li><a href="<?= base_url()?>program/activity/'+data+'"><i class="fa fa-list"></i>Activity</a></li>';
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_program_detail" },
					{ data: "nm_program_detail" },
					{ data: "due" },
					{ data: "nm_status" },
					{ data: "active", render: function(data, type, full, meta){
							if(data == 1)
								return "Active";
							else return "Not Active";
						}
					}
				]
			});
			
			$('#btnSave').on('click', function () {
				if($('#nm_program_detail').val() == '')
				{
					alertify.alert("Warning", "Please fill bu Name.");
				}
				else
				{
					var url = '<?=base_url()?>program/ax_set_details';
					var data = {
						id_program: <?= $id_program ?>,
						id_program_detail: $('#id_program_detail').val(),
						nm_program_detail: $('#nm_program_detail').val(),
						id_status: $('#id_status').val(),
						due: $('#due').val(),
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
			
			function ViewData(id_program_detail)
			{
				if(id_program_detail == 0)
				{
					$('#addModalLabel').html('Add program');
					$('#id_program_detail').val('0');
					$('#nm_program_detail').val('');
					$('#due').val('');
					$('#select2-id_status-container').html('---Status--');
					$('#id_status').val('0');
					$('#active').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>program/ax_get_data_detail_by_id';
					var data = {
						id_program_detail: id_program_detail
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit program');
						$('#id_program_detail').val(data['id_program_detail']);
						$('#nm_program_detail').val(data['nm_program_detail']);
						$('#due').val(data['due']);
						$('#select2-id_status-container').html(data['nm_status']);
						$('#id_status').val(data['id_status']);
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
			
			function DeleteData(id_program_detail)
			{
				alertify.confirm(
					'Confirmation', 
					'Are you sure you want to delete this data?', 
					function(){
						var url = '<?=base_url()?>program/ax_unset_detail';
						var data = {
							id_program_detail: id_program_detail
						};
								
						$.ajax({
							url: url,
							method: 'POST',
							data: data
						}).done(function(data, textStatus, jqXHR) {
							var data = JSON.parse(data);
							buTable.ajax.reload();
							alertify.error('program data deleted.');
						});
					},
					function(){ }
				);
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
		</script>
	</body>
</html>
