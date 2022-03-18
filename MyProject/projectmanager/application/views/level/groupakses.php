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
					<h1>Group Akses</h1>
				</section>
				
				<section class="invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									
									
									<button class="btn btn-primary" onclick='kembali()'>
										<i class='fa fa-arrow-left'></i> Kembali
									</button> 
									<?= $level_id; ?>
									
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="Form-add-level" id="myModalLabel">Form Add</h4>
												</div>
												<div class="modal-body">
													<?php echo validation_errors(); ?>
													<?php echo form_open('level/insert'); ?>
													<div class="form-group">
														<label>Level Name</label>
														<input type="text" name="nm_level" class="form-control" placeholder="Level Name">
													</div>
													<div class="form-group">
														<label>Status</label>
														<select class="form-control" name="active">
															<option value="1" <?php echo set_select('myselect', '1', TRUE); ?> >Active</option>
															<option value="0" <?php echo set_select('myselect', '0'); ?> >Deactive</option>
														</select> 
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<input type="submit" value="Save" class="btn btn-primary">                                       
													<?php echo form_close(); ?>
												</div>
											</div>
											
										</div>
										
									</div>
									
								</div>
								
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>No</th>                                         
													<th>Group Detail</th>
													<th><input type="checkbox" id="check-all"></th>
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
            var table;
			$(document).ready(function() {
				table = $('#dataTables-example').DataTable({
					"ordering" : false,
					"scrollX": true,
					"processing": true,
					"serverSide": true,
					ajax: {
						url: "<?= base_url() ?>level/get_groupakses/<?= $level_id; ?>",
						type: 'POST'
					},
					columns: [
						{ data: "id_menu_groups",width:'10px' },
						{ data: "nm_menu_groups" },
						{ data: "active", render: function(data, type, full, meta)
							{	
								var cek = '';
								if(data == 1){
									cek = 'checked';
								}
                                
                                return "<input type='checkbox' onclick='testing("+full.id_menu_groups_access+")' class='data-check' id='groupakses_"+full.id_menu_groups_access+"' data-emp-id='"+full.id_menu_groups_access+"' value='1' "+cek+" >";
							}
						},
					],
				});
			});
            
            function reload_table(){
                table.ajax.reload(null,false); 
            }

			function kembali(){
                window.location.href="<?=base_url();?>level";
            }
	
			function testing(id_menu_groups_access){

				if($("#groupakses_"+id_menu_groups_access).is(":checked")){

					var url = "<?=base_url();?>";
					var a = <?=$level_id ?>;

					jQuery.ajax({
						type: "POST",
						data: { id_level: a, id_menu_groups_access: id_menu_groups_access },
						url: "<?=base_url();?>level/updatecheck/"
					}).done(function(data) {
						console.log(data);
					});

				}else{
					jQuery.ajax({
						type: "POST",
						data: { id_level: a, id_menu_groups_access: id_menu_groups_access },
						url: "<?=base_url();?>level/updatechecks/"
					}).done(function(data) {
						console.log(data);
					});
				}
			}
            
            $('#check-all').on('click', function(e) {
				if($(this).is(':checked',true)) {
					$(".data-check").prop('checked', true);
                    var list_id = [];
                    $(".data-check:checked").each(function() {
                        list_id.push($(this).data('emp-id'));
                    });
                    $.ajax({
                        type: "POST",
                        data: {id:list_id},
                        url: "<?php echo site_url('level/updatechecks1/')?>",
                    });

				}else{  
					$(".data-check").prop('checked',false);
                    var list_id = [];
                    $(".data-check").each(function() {
                        list_id.push($(this).data('emp-id'));
                    });
                    $.ajax({
                        type: "POST",
                        data: {id:list_id},
                        url: "<?php echo site_url('level/updatecheck1/')?>",
                    });
  
				}		

			});     
		</script>
	</body>
</html>
