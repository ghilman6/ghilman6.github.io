<!DOCTYPE html>
<html>
	<head>
		<?= $this->load->view('head'); ?>
		<style>
		 /* The switch - the box around the slider */
			.switch {
			  position: relative;
			  display: inline-block;
			  width: 60px;
			  height: 34px;
			}

			/* Hide default HTML checkbox */
			.switch input {display:none;}

			/* The slider */
			.slider {
			  position: absolute;
			  cursor: pointer;
			  top: 0;
			  left: 0;
			  right: 0;
			  bottom: 0;
			  background-color: #ccc;
			  -webkit-transition: .4s;
			  transition: .4s;
			}

			.slider:before {
			  position: absolute;
			  content: "";
			  height: 26px;
			  width: 26px;
			  left: 4px;
			  bottom: 4px;
			  background-color: white;
			  -webkit-transition: .4s;
			  transition: .4s;
			}

			input:checked + .slider {
			  background-color: #2196F3;
			}

			input:focus + .slider {
			  box-shadow: 0 0 1px #2196F3;
			}

			input:checked + .slider:before {
			  -webkit-transform: translateX(26px);
			  -ms-transform: translateX(26px);
			  transform: translateX(26px);
			}

			/* Rounded sliders */
			.slider.round {
			  border-radius: 34px;
			}

			.slider.round:before {
			  border-radius: 50%;
			} 
		</style>
	</head>
	<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">
		<div class="wrapper">
			<?= $this->load->view('nav'); ?>
			<?= $this->load->view('menu_groups'); ?>

			<div class="content-wrapper">

				<section class="content-header">
					<h1>Company</h1>
				</section>

				<section class="invoice">            
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">

								<div class="panel-heading">
									Form Update
								</div>

								<div class="panel-body">
                                    <?php                                                        
                                        foreach ($listperusahaanselect->result() as $rows) {
											echo validation_errors(); 
											echo form_open_multipart('perusahaan/Update'); 
									?>
									<div class="form-group">
                                        
                                        <input type="hidden" name="id_perusahaan" class="form-control" placeholder="ID perusahaan" value="<?= $rows->id_perusahaan?>" readonly>
                                    </div>
									<div class="form-group">
                                        <label>Perusahaan</label>
                                        <input type="text" name="nm_perusahaan" class="form-control" placeholder="Name perusahaan" value="<?= $rows->nm_perusahaan?>">
                                    </div>                                            
									<div class="form-group">
                                        <label>Address</label>
										<textarea name="textarea_address" class="form-control" placeholder="Address"><?= $rows->alamat?></textarea>
									</div>
									<div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" name="text_phone_number" class="form-control" placeholder="Phone Number" value="<?= $rows->telp?>">
									</div>
									
									<div class="form-group">
                                        <label>Logo</label><br />
										<img src="/uploads/<?= $rows->logo?>"  height="50">
                                        <input type="file" name="photo" class="">
										<span class="help">type: .png,  maxsize: 100KB, maxres: 500x500 px</span>
									</div>
									<div class="form-group">
										<label>Inventory Methode</label>
										<hr>
									</div>
									
									<div class="form-group col-lg-3">
										<label >FIFO (Fisrt In First Out)</label><br>
										<label class="switch">
										  <input type="checkbox" name="fifo" value="1" <?php if($rows->fifo == 1){echo"checked";}else{}?>>
										  <span class="slider round"></span>
										</label>
									</div>
									<div class="form-group col-lg-3">
										<label >FEFO (First Expired First Out)</label><br>
										<label class="switch">
										  <input type="checkbox" name="fefo" value="1" <?php if($rows->fefo == 1){echo"checked";}else{}?>>
										  <span class="slider round"></span>
										</label>
									</div>
									<div class="form-group col-lg-3">
										<label >Best Fit</label><br>
										<label class="switch">
										  <input type="checkbox" name="best" value="1" <?php if($rows->best == 1){echo"checked";}else{}?>>
										  <span class="slider round"></span>
										</label>
									</div>
									
									<div class="form-group col-lg-3">
                                        <label>Default Allocation</label>
                                        <select class="form-control select2" style="width: 100%;" name="alloc">
                                            <option value="F" <?php if('F' == $rows->alloc){echo 'selected';} ?>  >FIFO</option>
											<option value="E" <?php if('E' == $rows->alloc){echo "selected";} ?>  >FEFO</option>
											<option value="B" <?php if('B' == $rows->alloc){echo "selected";} ?>  >Best Fit</option>
                                        </select> 
                                    </div>
									
                                   
                                   
								</div>
								<div class="panel-footer">
									 <div class="form-group">
                                        <input type="submit" value="Save" class="btn btn-primary">
                                    </div>
								</div>
								 <?php 
											echo form_close(); 
										} 
									?>  
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>

    <?= $this->load->view('basic_js'); ?>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                "scrollX": true
        });
    });
	
	
    </script>
  </body>
</html>
