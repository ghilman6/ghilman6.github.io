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
          <h1>
            Menu Details
          </h1>
        </section>

        <section class="invoice">
        
            
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button class="btn btn-primary " data-toggle="modal" data-target="#myModal">
                                Add Menu Details
                            </button>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="Form-add-menu_details" id="myModalLabel">Form Add Menu Details</h4>
                                        </div>
                                        <div class="modal-body">
                      <?php echo validation_errors(); ?>

                      <?php echo form_open(base_url().'menu_details/insert'); ?>
                      
                                            
                                            <div class="form-group">
                                            <label>KD Menu Detail</label>
                                            <input type="text" name="kd_menu_details" class="form-control" placeholder="KD Detail Menu">
                                            </div>

                                            <div class="form-group">
                                            <label>Menu Detail</label>
                                            <input type="text" name="nm_menu_details" class="form-control" placeholder="Detail Menu">
                                            </div>
                      
                                            <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" name="url" class="form-control" placeholder="URL">
                                            </div>
                      
                                            <div class="form-group">
                                            <label>Position</label>
                                            <input type="text" name="position" class="form-control" placeholder="Position">
                                            </div>

                                            <div class="form-group">
                                            <label>Menu Groups</label>
                                            <select class="form-control" name="id_menu_groups">
                                            <?php     
                                                        foreach ($combo_menu_groups->result() as $rowmenu) {
                                                        ?>
                                            <option value="<?= $rowmenu->id_menu_groups?>" <?php echo set_select('myselect', '$rowmenu->id_menu_groups'); ?> ><?= $rowmenu->nm_menu_groups?></option>
                                            
                                            <?php
                                            }
                                            ?>
                                            </select> 
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
                                            <th nowrap>Options</th>
                                            <th nowrap>ID Menu</th>
                                            <th nowrap>KD Menu</th>
                                            <th nowrap>Menu Detail</th>
                                            <th nowrap>URL</th>
                                            <th nowrap>Menu Groups</th>
                                            <th nowrap>Position</th>
                                            <th nowrap>Status</th>
                                            
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
	
	function konfirmasi(data){
			
			var x = confirm('Are you sure?');
			if(x){


				location.href='<?= base_url()?>menu_details/delete/'+data;

				}else{
					
			}
		}
	
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
			"ordering" : false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url()?>menu_details/ax_data_menu_details/",
				type: 'POST'
			},
			columns: [
				{
					data: "id_menu_details", render: function(data, type, full, meta)
					{
						//return "<a href='#' onClick='konfirmasi("+data+")' class='btn btn-danger' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a> <a href='menu_details/formupdate/"+data+"' class='btn btn-warning' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>";
						//return'<div class="btn-group"><button type="button" class="btn btn-default btn-sm">Action</button><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu"><li><a href="menu_details/formupdate/'+data+'"><i class="fa fa-pencil"></i> Edit</a></li><li><a type="button" onClick="konfirmasi('+data+')"><i class="fa fa-trash"></i> Delete</a></li></ul></div>';										
						return'<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="<?= base_url()?>menu_details/formupdate/'+data+'"><i class="fa fa-pencil"></i> Edit</a></li><li><a type="button" onClick="konfirmasi('+data+')"><i class="fa fa-trash"></i> Delete</a></li></ul></div>';										
					}
				},
				{ data: "id_menu_details" },
				{ data: "kd_menu_details" },
				{ data: "nm_menu_details" },
				{ data: "url" },
				{ data: "nm_groups" },
				{ data: "position" },
				{ data: "active", render: function(data, type, full, meta)
					{
						if(data==1)
							return "active";
						else return "deactive"
					}
				},
			],
        });
    });
    </script>
  </body>
</html>
