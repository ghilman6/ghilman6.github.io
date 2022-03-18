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
					<h1>Activity #<?= $id_program_detail?></h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Activity
									</button>
									<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Add Activity</h4>
												</div>
												<div class="modal-body">
													<input type="hidden" id="id_activity" name="id_activity" value='' />
													<input type="hidden" id="id_program_detail" name="id_program_detail" value='<?= $id_program_detail?>' />

													<div class="form-group">
														<label>Activity</label>
														<input type="text" id="activity" name="activity" class="form-control" placeholder="Activity">
													</div>

													<div class="form-group">
														<label>Keterangan</label>
														<textarea id="keterangan" name="keterangan" class="form-control" rows="10" cols="80"></textarea>
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
													<th>Activity</th>
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
			var buTable = $('#buTable').DataTable({
				"ordering" : false,
				"scrollX": true,
				"processing": true,
				"serverSide": true,
				ajax: 
				{
					url: "<?= base_url()?>program/ax_data_activity/",
					type: 'POST',
					data: function ( d ) {
			         return $.extend({}, d, { 
			         	
			         	"id_program_detail": <?= $id_program_detail ?>,

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
							str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_activity" },
					{ data: "activity" },
					{ data: "keterangan" },
					{ data: "cdate" },
                    { data: "nm_user" },
					{ data: "active", render: function(data, type, full, meta){
							if(data == 1)
								return "Active";
							else return "Not Active";
						}
					}
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
					var url = '<?=base_url()?>program/ax_set_activity';
					var data = {
						id_program_detail: <?= $id_program_detail ?>,
						id_activity: $('#id_activity').val(),
						activity: $('#activity').val(),
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
					$('#addModalLabel').html('Add activity');
					$('#id_activity').val('0');
					$('#activity').val('');
					$('#keterangan').val('');
					$('#cdate').val('');
					$('#active').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>program/ax_get_data_activity_by_id';
					var data = {
						id_activity: id_activity
					};
							
					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit activity');
						$('#id_activity').val(data['id_activity']);
						$('#activity').val(data['activity']);
						$('#keterangan').val(data['keterangan']);
						$('#cdate').val(data['cdate']);
						$('#active').val(data['active']);
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
						var url = '<?=base_url()?>program/ax_unset_activity';
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
