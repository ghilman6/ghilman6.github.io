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
            Company
          </h1>
        </section>

        <section class="invoice">
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<?php echo anchor('perusahaan/add', 'Create Company', array("class" => "btn btn-primary"));?>
                        </div>
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Options</th>
                                            <th>Comapany ID</th>
                                            <th>Company Name</th>
											<th>Address</th>
											<th>Number Phone</th>
                                            <th>Type</th>
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
		function konfirmasi(data){	
			var x = confirm('Are you sure?');
			if(x){
				location.href='<?= base_url()?>perusahaan/delete/'+data;
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
				url: "/perusahaan/ax_data_perusahaan/",
				type: 'POST'
			},
			columns: [
				{
					data: "id_perusahaan", render: function(data, type, full, meta)
					{
						//return "<a href='#' onClick='konfirmasi("+data+")' class='btn btn-danger'><i class='fa fa-trash'></i></a> <a href='perusahaan/formupdate/"+data+"' class='btn btn-warning'><i class='fa fa-pencil'></i></a>";
						return'<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="perusahaan/formupdate/'+data+'"><i class="fa fa-pencil"></i> Edit</a></li><li><a type="button" onClick="konfirmasi('+data+')"><i class="fa fa-trash"></i> Delete</a></li></ul></div>';
						}
				},
				{ data: "id_perusahaan" },
				{ data: "nm_perusahaan" },
				{ data: "alamat" },
				{ data: "telp" },
				{ data: "jenis", render: function(data, type, full, meta)
					{
						if(data==1)
							return "Pusat";
						else 
							return "Subcon";
					}
				},
				{ data: "active", render: function(data, type, full, meta)
					{
						if(data==1)
							return "active";
						else 
							return "deactive";
					}
				},
			],
        });
    });
    </script>
  </body>
</html>
