<!DOCTYPE html>
<html>
	<head>
		<?= $this->load->view('head'); ?>
		

	</head>
	<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">
		<script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
		<div class="wrapper">
			<?= $this->load->view('nav'); ?>
			<?= $this->load->view('menu_groups'); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Activity #<?= $id_activity?></h1>
				</section>
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<button class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Att
									</button>
									<div class="modal fade" id="addModal" tabindex="" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-bu" id="addModalLabel">Form Add Att</h4>
												</div>
												<div class="modal-body">
													
												<form id="upload_attach" enctype="multipart/form-data">

													<input type="hidden" id="id_activity" name="id_activity" value='<?= $id_activity?>' />
													

													<div class="form-group ">
														<label>Jenis Attachment</label>
														<select class="form-control select2 " style="width: 100%;" id="id_attachment" name="id_attachment">
																<option value="0">--Attachment--</option>
																<?php
																foreach ($combobox_attachment->result() as $att) {
																?>
																<option value="<?= $att->id_attachment?>"  ><?= $att->nm_attachment?></option>
																<?php
																}
																?>
														</select>
													</div>
													<div class="row mb-3">
                                						<label for="nm_file" class=" col-form-label"></label>
															<div class="col-sm-10">
																<input type="file" name="nm_file" class="" id="nm_file"><br>
																<?= form_error('nm_file', '<small class="text-danger pl-3" style="color:red;"></small>') ;?>
															</div>
													</div>

													
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-primary" id='btnSave'>Save</button>
												</div>
											</form>
	
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
													<th>Jenis Attachment</th>
													<th>File Attachment</th>
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
					url: "<?= base_url()?>task/ax_data_att/",
					type: 'POST',
					data: function ( d ) {
			         return $.extend({}, d, { 
			         	
			         	"id_activity": <?= $id_activity ?>,

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
							str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							str += '</ul>';
							str += '</div>';
							return str;
						}
					},
					
					{ data: "id_detail_activity" },
					{ data: "nm_attachment" },
					{data: "nm_file", render: function(data, type, full, meta){
							var str = '';
							
							
							// str += '<a href="<?=base_url()?>uploads/attachment/' + data + '">' + data + '</a>';
							str += '<a href="<?=base_url()?>uploads/attachment/' + data + '"><i class="fa fa-file-archive-o fa-2x"></i></a>';
							
							return str;
						}},
					
				]
			});
			
			// $('#btnSave').on('click', function () {
			// 	if($('#id_attachment').val() == '')
			// 	{
			// 		alertify.alert("Warning", "Please fill user");
			// 	}
			// 	else
			// 	{
			// 		var url = '<?=base_url()?>task/ax_set_activityatt';
			// 		var data = {
			// 			id_activity: <?= $id_activity ?>,
			// 			id_attachment: $('#id_attachment').val(),
			// 			nm_file: $('#nm_file').val(),

			// 		};
			// 				console.log(data)
			// 		$.ajax({
			// 			url: url,
			// 			method: 'POST',
			// 			data: data
			// 		}).done(function(data, textStatus, jqXHR) {
			// 			var data = JSON.parse(data);
			// 			if(data['status'] == "success")
			// 			{
			// 				alertify.success("program data saved.");
			// 				$('#addModal').modal('hide');
			// 				buTable.ajax.reload();
			// 			}
			// 		});
			// 	}
			// });
			
$('#upload_attach').submit(function(e) {
    e.preventDefault();
    if ($('#id_attachment').val() == 0) {
        alertify.alert("Warning", "Silahkan Pilih Tipe Dulu !");
    }else if($('#nm_file').val() == '') {
        alertify.alert("Warning", "Silahkan Pilih Dokumen Untuk Melakukan Proses Reupload!");

    } else {
		const form = new FormData(this);
		// console.log(form);
		// return;
        $.ajax({
            url: `<?=base_url()?>task/ax_set_activityatt/`,
            type: "post",
            data: form,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
        }).done(function(data, textStatus, jqXHR) {
			var data = JSON.parse(data);
			if(data['status'] == "success")
			{
				alertify.success(data['message']);
				$('#addModal').modal('hide');
				buTable.ajax.reload();
				return;
			}else{
				alertify.error(data['message']);
				return;
			}
        });
    }
});
			function ViewData(id_activity)
			{
				if(id_activity == 0)
				{
					$('#addModalLabel').html('Add Att');
					$('#activity').val('');
					// $('#nm_attachment').val('');
					// $('#nm_file').val('');
					$('#cdate').val('');
					$('#active').val('1');
					$('#addModal').modal('show');
				}
				else
				{
					var url = '<?=base_url()?>task/ax_get_data_activityatt_by_id';
					var data = {
						id_activity: <?= $id_activity?>
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
						// $('#nm_file').val(data['nm_file']);
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
						var url = '<?=base_url()?>task/ax_unset_activityatt';
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
