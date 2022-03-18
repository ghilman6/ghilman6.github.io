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

        </section>
		
		
		<section class="content">
		
			
			<!-- /.row -->
			  <div class="row">
				<div class="col-md-12">
				  <div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title">INFORMASI</h3>
						<div class="nav-tabs-custom">
							<div class="tab-content no-padding">
							</div>
						</div>
					  <!-- /.nav-tabs-custom -->
					</div>
					<div class="box-body with-border">
					<b>Update 2 September 2021</b><br>
					1. Perubahan Aplikasi terbaru E-Office v3.0
					
					</div>
				  </div>
				  <!-- /.box -->
				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			  
			  
		</section>
		
		
		</div>
    </div>
	
			<?= $this->load->view('basic_js'); ?>
			
	</body>
</html>
