<!DOCTYPE html>
<html>

<head>
	<?= $this->load->view('head'); ?>
	
	<style>
		.pointer:hover {
			cursor: pointer;
			background-color: #47a5ed;

		}

		.d-none {
			display: none;
		}
	</style>
</head>

<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">
	<script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Surat</h1>
				<input type="hidden" id="id_surat_selected" name="id_surat_selected" value="">
			</section>
	
			<section class="invoice">
				<div class="row">
					<div class="col-lg-5">
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add surat
								</button>
								
								<div class="modal fade" id="addModal" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog  modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add surat</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<!-- <input type="hidden" id="id_surat" name="id_surat" value='' /> -->

														<div class="form-group">
															<label>Pilih Tipe</label>
															<select class="form-control select2" style="width: 100%;" id="id_type_surat" name="id_type_surat">
																<option value="0">--Pilih Tipe--</option>
																<?php
																foreach ($combobox_type_surat->result() as $rowmenu) {
																?>
																	<option value="<?= $rowmenu->id_type_surat ?>"><?= $rowmenu->nm_type_surat ?></option>
																<?php
																}
																?>
															</select>
														</div>

														<div class="form-group">
															<label>Pilih Klasifikasi</label>
															<select class="form-control select2" style="width: 100%;" id="id_klasifikasi" name="id_klasifikasi">
																<option value="0">--Pilih klasifikasi--</option>
																<?php
																foreach ($combobox_klasifikasi->result() as $rowmenu) {
																?>
																	<option value="<?= $rowmenu->id_klasifikasi ?>"><?= $rowmenu->nm_klasifikasi ?></option>
																<?php
																}
																?>
															</select>
														</div>

														<div class="form-group">
															<label>Pilih Kategori</label>
															<select class="form-control select2" style="width: 100%;" id="id_kategori" name="id_kategori">
																<option value="0">--Pilih Kategori--</option>
																<?php
																foreach ($combobox_kategori->result() as $rowmenu) {
																?>
																	<option value="<?= $rowmenu->id_kategori ?>"><?= $rowmenu->nm_kategori ?></option>
																<?php
																}
																?>
															</select>
														</div>

														<div class="form-group">
															<label>Perihal</label>
															<input type="text" id="perihalAdd" name="perihalAdd" class="form-control" placeholder="Perihal">
														</div>

														<div class="form-group">
															<label>Isi Surat</label>
															<textarea id="t_isi_surat" name="t_isi_surat" class="form-control" rows="10" cols="80"></textarea>
														</div>

														<div class="form-group">
															<label>Active</label>
															<select class="form-control" id="active" name="active">
																<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
															</select>
														</div>
													</div>

												</div>

											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary" id='SuratbtnSave'>Save</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
							<label>Filter Surat</label>
							<div class="row">
								<div class="col-lg-12">
								<select class="form-control select2" style="width: 100%;" id="filter_surat" name="filter_surat">
										<option value="">-- Filter Surat --</option>
												<option value="1">Draft</option>
												<option value="2">Proses Approval<option>
									</select>
								</div>
								<div class="col-lg-7">

								</div>
							</div>	
							<br>
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>Surat</th>

											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#preview_pdf">Preview PDF</a></li>
							<li><a data-toggle="tab" href="#menu1">Isi Surat</a></li>
							<button type="button" id="BtnKirimApproval" class="pull-right btn btn-success pull-right d-none ">
								<i class='fa fa-paper-plane'></i> KIRIM KE APPROVAL
							</button>
							<button type="button" id="BtnHapusSurat" style="margin-right: 10px;" class="pull-right btn btn-danger pull-right d-none">
								<i class='fa fa-trash'></i> HAPUS
							</button>
						</ul>

						<div class="tab-content">
							<div id="preview_pdf" class="tab-pane fade in active">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h4 class="panel-title">

										</h4>
									</div>
									<div id="collapse1" class="panel-collapse collapse in">
										<div class="panel-body">
											<div class="form-group">
												<h3 class="text-center" id="pilih_surat_dulu">Pilih Surat Terlebih Dahulu Untuk Di Tampilkan !</h3>

												<div id="showpdf" class="showpdf"></div>
												<img class="img-responsive center-block gif" src="<?= base_url() ?>assets/img/loading2.gif" id="gif" style="width:60%; height:60%; display: none;">
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="menu1" class="tab-pane fade d-none">

								<div class="panel-group" id="accordion2">
									<!---------------- SECTION ISI SURAT ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse11">
											<h4 class="panel-title">
												<span>
													Isi Surat
												</span>

											</h4>
										</div>
										<div id="collapse11" class="panel-collapse collapse in">

											<div class="panel-body">
												<div class="form-group">
												<button type="button" id="SuratBtnEdit" class=" pull-right btn btn-warning pull-right">
													<i class='fa fa-save'></i> SIMPAN PERUBAHAN
												</button>
												<br>
												</div>

												<div class="form-group">
													<label>Pilih Tipe</label>
													<select class="form-control select2" style="width: 100%;" id="id_type_surat_selected" name="id_type_surat_selected">
														<option value="0">--Pilih Tipe--</option>
														<?php
														foreach ($combobox_type_surat->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_type_surat ?>"><?= $rowmenu->nm_type_surat ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label>Pilih Klasifikasi</label>
													<select class="form-control select2" style="width: 100%;" id="id_klasifikasi_selected" name="id_klasifikasi_selected">
														<option value="0">--Pilih klasifikasi--</option>
														<?php
														foreach ($combobox_klasifikasi->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_klasifikasi ?>"><?= $rowmenu->nm_klasifikasi ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label>Pilih Kategori</label>
													<select class="form-control select2" style="width: 100%;" id="id_kategori_selected" name="id_kategori_selected">
														<option value="0">--Pilih Kategori--</option>
														<?php
														foreach ($combobox_kategori->result() as $rowmenu) {
														?>
															<option value="<?= $rowmenu->id_kategori ?>"><?= $rowmenu->nm_kategori ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label>Perihal</label>
													<input type="text" id="perihal_selected" name="perihal_selected" class="form-control" placeholder="Perihal">
												</div>
												<div class="form-group">
													<!-- <label>Isi Surat</label> -->
													<textarea id="isi_surat_selected" name="isi_surat_selected" class="form-control" rows="10" cols="80"></textarea>
												</div>
												<div class="row">

												</div>


											</div>
										</div>
									</div>
									<!----------------- SECTION ATTACHEMENT ------------------>
									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse6">
											<h4 class="panel-title">
												<span>
													Attachement</span>
											</h4>
										</div>
										<div id="collapse6" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
													<button class="btn btn-primary" onclick='addAttachment(0)'>
															<i class='fa fa-cloud-upload'></i> Attachment
														</button>
														<div class="modal fade" id="addModalAttach" tabindex="" role="dialog" aria-labelledby="addModalLabelattach" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabeleks">Form Add Attachment</h4>
																	</div>
																	<form id="upload_attach" enctype="multipart/form-data">
																		<input type="hidden" id="id_surat_attach" name="id_surat_attach" readonly>

																		<div class="modal-body">
																			<div class="form-group">
																				<label>Nama Attachment</label>
																				<input type="text" id="nm_attachment" name="nm_attachment" class="form-control" placeholder="Nama Attachment">
																			</div>

																			<div class="form-group">
																				<input type="file" name="file" id="file_attachment" class="form-control">
																			</div>



																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit" class="btn btn-primary" id='btn_attach'>Save</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover">
																<table class="table table-striped table-bordered table-hover" id="buTableAttach">
																	<thead>
																		<tr>
																			<th>Options</th>
																			<th>Nama</th>
																			<th>File</th>
																		</tr>
																	</thead>
																</table>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION APPROVAL ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse7">
											<h4 class="panel-title">
												<span>
													Approval</span>
											</h4>
										</div>
										<div id="collapse7" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" id="BtnAddApproval" onclick='ViewDataApproval(0)'>
															<i class='fa fa-plus'></i> Add approval
														</button>
														<div class="modal fade" id="addModalApproval" role="dialog" aria-labelledby="addModalLabelAp" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabel">Form Add approval</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_approval" name="id_approval" value='0' />





																		<div class="form-group">
																			<label>Akun</label>
																			<select class="form-control select2" style="width: 100%;" id="id_akunAp" name="id_akunAp">
																				<option value="">--Akun--</option>
																				<?php
																				foreach ($combobox_akun->result() as $rowmenu) {
																				?>
																					<option value="<?= $rowmenu->id_akun ?>"><?= $rowmenu->nm_akun ?> - <?= $rowmenu->nm_pegawai ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>

																		<!-- <div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="activeAp" name="activeAp">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div> -->
																		<div class="form-group">
																			<label>Tipe Approval</label>
																			<select class="form-control" id="type_approval" name="type_approval">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Paraf</option>
																				<option value="2" <?php echo set_select('myselect', '2'); ?>>Approval</option>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveApproval'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table style="overflow: auto; width: 100%;" class="table table-striped table-bordered table-hover" id="buTableApproval">
																<thead style="overflow: hidden; position: relative; border: 0px; width: 100%;">
																	<tr>
																		<th>Options</th>
																		<th>Status</th>
																		<th>Alias</th>
																		<th>Approval</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION INTERNAL ------------------->
									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse8">
											<h4 class="panel-title">
												<span>
													Penerima Internal</span>
											</h4>
										</div>
										<div id="collapse8" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewDataInter(0)'>
															<i class='fa fa-plus'></i> Add Penerima Internal
														</button>
														<div class="modal fade" id="addModalInter" role="dialog" aria-labelledby="addModalLabelInter" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabelInter">Form Add Penerima internal</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_surat_alias" name="id_surat_alias" value='' />

																		<div class="form-group">
																			<label>Alias</label>
																			<select class="form-control select2" style="width: 100%;" id="id_alias" name="id_alias">
																				<option value="">-- Pilih --</option>
																				<?php
																				foreach ($combobox_alias->result() as $row_ca) {
																				?>
																					<option value="<?= $row_ca->id_alias ?>"><?= $row_ca->nm_alias ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>
																		<div class="form-group">
																			<label>Type Penerima</label>
																			<select class="form-control" id="type_penerimaInter" name="type_penerimaInter">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Tembusan</option>
																				<option value="2" <?php echo set_select('myselect', '2'); ?>>Penerima</option>
																			</select>
																		</div>




																		<!-- <div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="activeInter" name="activeInter">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div> -->
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveInter'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" id="buTableInter">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>Alias</th>
																		<th>Type Penerima</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---------------- SECTION EXTERNAL ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse9">
											<h4 class="panel-title">
												<span>
													Penerima External</span>
											</h4>
										</div>
										<div id="collapse9" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													<div class="panel-heading">
														<button class="btn btn-primary" onclick='ViewDataEx(0)'>
															<i class='fa fa-plus'></i> Add Penerima External
														</button>
														<div class="modal fade" id="addModalEx" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="Form-add-bu" id="addModalLabelEx">Form Add Penerima External</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" id="id_surat_external" name="id_surat_external" value='' />

																		<div class="form-group">
																			<label>Type Penerima</label>
																			<select class="form-control" id="type_penerima" name="type_penerima">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Penerima</option>
																				<option value="2" <?php echo set_select('myselect', '2'); ?>>Tembusan</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label>Penerima</label>
																			<input type="text" id="nm_surat_external" name="nm_surat_external" class="form-control" placeholder="Penerima">
																		</div>

																		<div class="form-group">
																			<label>Email Penerima</label>
																			<input type="text" id="email_surat_external" name="email_surat_external" class="form-control" placeholder="Email">
																		</div>


																		<!-- <div class="form-group">
																			<label>Active</label>
																			<select class="form-control" id="active" name="active">
																				<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
																				<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
																			</select>
																		</div> -->
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary" id='btnSaveEx'>Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" style="overflow: auto; width: 100%;" id="buTableEx">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>#</th>
																		<th>Penerima</th>
																		<th>Email</th>
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
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

		</div>
		</section>
	</div>
	</div>
</body>
<?= $this->load->view('basic_js'); ?>

<script>
	const base_url = `<?= base_url() ?>`;
	CKEDITOR.replace('t_isi_surat');
	CKEDITOR.replace('isi_surat_selected');

	let counteratt = 1;
	let id_surat_selected;

	$(document).ready(function() {
		$(".tabs_collapse").click(function() {
			$(".tabs_collapse").removeClass("active");
			$(this).addClass("active"); // Add Active class to each tabs collapse

		});

		$(document).on('click', '.pilih_surat', function() { //select data table surat berdasarkan surat yang di klik
			$('#pilih_surat_dulu').css('display', 'none'); // tampilkan tulisan pilih surat dulu pada preview pdf

			let id_surat = $(this).data('id_surat');
			load_pdf(id_surat); //load preview pdf by id 
			get_data_surat(id_surat); // get data surat selected by id 
			id_surat_selected = id_surat;
			$('#id_surat_selected').val(id_surat); //input hidden id_surat_selected
			$('#id_surat_attach').val(id_surat); //input hidden id_surat_attach

			// function ada di /assets/custom_js/
			getApprovalSelected();
			getAttachSelected();
			getInternalSelected();
			getExternalSelected();

		});


	});
	$("#accordion, #accordion2").on("shown.bs.collapse", function() {
		// re adjust responsive data tables didalam accordion
		$.each($.fn.dataTable.tables(true), function() {
			$(this).DataTable().columns.adjust().draw();
		});
	});
	//------- tampilkan data surat berdasarkan surat yg dipilih ---------
	const select_tipe_surat = (data) => {
		const data_surat = JSON.parse(data);
		const tipe_surat = data_surat.id_type_surat;
		$("#id_type_surat_selected").select2().val(tipe_surat).trigger("change");


	}
	const select_klasifikasi = (data) => {
		const data_surat = JSON.parse(data);
		const klasifikasi = data_surat.id_klasifikasi;
		$("#id_klasifikasi_selected").select2().val(klasifikasi).trigger("change");
	}
	const select_kategori = (data) => {
		const data_surat = JSON.parse(data);
		const kategori = data_surat.id_kategori;
		$("#id_kategori_selected").select2().val(kategori).trigger("change");
	}
	const select_perihal = (data) => {
		const data_surat = JSON.parse(data);
		const perihal = data_surat.perihal;
		$('#perihal_selected').val(perihal);
		CKEDITOR.instances.isi_surat_selected.setData(data_surat.isi_surat);

	}
	// --------------------- end selected surat --------------------------

	const get_data_surat = (id_surat) => { // get data surat by id
		const url = '<?= base_url() ?>surat/ax_get_data_by_id';
		const data = {
			'id_surat': id_surat,
		};
		return $.ajax({
			url: url,
			method: 'POST',
			data: data
		}).done(function(res, textStatus, jqXHR) {
			// pass res 
			const data = JSON.parse(res);

			if(data.active == 1){ // Validasi Apakah Surat Itu Dalam Proses Approval / Draft
				$("#BtnKirimApproval").show();
				$("#BtnKirimApproval").prop('disabled',false);
				$("#BtnHapusSurat").show();
				$("#BtnAddApproval").show();
			}else{
				$("#BtnKirimApproval").show();
				$("#BtnHapusSurat").hide();
				$("#BtnKirimApproval").attr('disabled','disabled');
				$("#BtnAddApproval").hide();
			}

			select_tipe_surat(res);
			select_klasifikasi(res);
			select_kategori(res);
			select_perihal(res);
		});
	}
</Script>


<!-- list surat di data table -->
<script type='text/javascript'>
	var buTable ;
	const getSuratList = (filter = null) => {
		var data = {
			filter: filter,
		};
		buTable = $('#buTable').DataTable({
		"bDestroy": true,
		"ordering": false,
		"scrollX": true,
		"processing": true,
		"serverSide": true,
		ajax: {
			url: "<?= base_url() ?>surat/ax_data_surat/",
			type: 'POST',
			data: data
		},
		columns: [

			{
				data: "id_surat",
				render: function(data, type, full, meta) {
					let str = `
						<span class="pilih_surat pointer" data-id_surat="${full['id_surat']}">
						[ ${data} ]`
						
						if(full['active'] == 1 ){ // span color status surat
							str += `<span class="label label-warning">Draft</span>`;
						}else if(full['active'] == 2 ){
							str += `<span class="label label-info">Proses Approval</span>`;

						}else{
							str += `<span class="label label-info">Di Setujui</span>`;
						}

						str +=` - ${full['nm_type_surat']} - ${full['nm_klasifikasi']} - ${full['nm_kategori']} - ${full['perihal']} - <b>${full['cdate']}</b> - ${full['nm_user']}
						</span>
						`;
					return str;
				}
			},

		]

	});
	};
	getSuratList();
	// isi surat berdasarkan akses akun approval di select
	$('#filter_surat').on('change', function() {
		// alert( this.value );
		getSuratList(this.value); // reload table berdasarkan id_akun
		$("#BtnKirimApproval").hide();
		$("#BtnHapusSurat").hide();
		$('#pilih_surat_dulu').show();
		$('#showpdf').hide();
	});

	$('#SuratbtnSave').on('click', function() {
		var t_isi_surat = CKEDITOR.instances.t_isi_surat.getData()
		if ($('#id_type_surat').val() == '0') {
			alertify.alert("Warning", "Please fill Tipe Surat.");
		} else if ($('#id_klasifikasi').val() == '0') {
			alertify.alert("Warning", "Please fill Klasifikasi.");
		} else if ($('#id_kategori').val() == '0') {
			alertify.alert("Warning", "Please fill Kategori.");
		} else if ($('#perihalAdd').val() == '') {
			alertify.alert("Warning", "Please fill Perihal.");
		} else if (t_isi_surat == '') {
			alertify.alert("Warning", "Please fill Isi Surat.");
		} else {
			var url = '<?= base_url() ?>surat/ax_set_data';
			var data = {
				id_surat: '',
				id_type_surat: $('#id_type_surat').val(),
				id_klasifikasi: $('#id_klasifikasi').val(),
				id_kategori: $('#id_kategori').val(),
				perihal: $('#perihalAdd').val(),
				isi_surat: t_isi_surat,
				active: $('#active').val()
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				if (data['status'] == "success") {
					alertify.success("surat data saved.");
					$('#addModal').modal('hide');
					buTable.ajax.reload();
				}
			});
		}
	});

	$('#SuratBtnEdit').on('click', function() {
		var edit_isi_surat = CKEDITOR.instances.isi_surat_selected.getData()
		if (id_surat_selected == '' || id_surat_selected == 0 || id_surat_selected == null) {
			alertify.error("Pilih Surat Terlebih Dahulu !.");
		} else if ($('#id_klasifikasi_selected').val() == '0') {
			alertify.alert("Warning", "Please fill Klasifikasi.");
		} else if ($('#id_kategori_selected').val() == '0') {
			alertify.alert("Warning", "Please fill Kategori.");
		} else if ($('#perihal_selected').val() == '') {
			alertify.alert("Warning", "Please fill Perihal.");
		} else if (edit_isi_surat == '') {
			alertify.alert("Warning", "Please fill Isi Surat.");
		} else if ($('#id_type_surat_selected').val() == '0') {
			alertify.alert("Warning", "Please fill Tipe Surat.");
		} else {
			var url = '<?= base_url() ?>surat/ax_set_data';
			var data = {
				id_surat: id_surat_selected,
				id_type_surat: $('#id_type_surat_selected').val(),
				id_klasifikasi: $('#id_klasifikasi_selected').val(),
				id_kategori: $('#id_kategori_selected').val(),
				perihal: $('#perihal_selected').val(),
				isi_surat: edit_isi_surat,
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(res, textStatus, jqXHR) {
				var data = JSON.parse(res);
				if (data['status'] == "success") {
					load_pdf(data['data'].id_surat); // load pdf after edit
					alertify.success("surat data saved.");
					buTable.ajax.reload();
					$('.nav-tabs a[href="#preview_pdf"]').tab('show'); // pindah tab preview pdf after edit

				}
			});
		}
	});
	
	$("#BtnKirimApproval").on("click", function () {
	if (id_surat_selected == null) {
		alertify.error(`Pilih Surat Terlebih Dahulu !`);
		return;
	}
	console.log(id_surat_selected);
	alertify
		.confirm(
		`
					Surat ini akan dikirim untuk di approve, apakah anda yakin ? <br><br>
					<b style="color:red;">Note* : Pastikan Isi Surat, Approval, Penerima Sudah Terisi</b>.
					`,
		function (ok) {
			if (ok) {
			var url = `${base_url}surat/ax_kirim_surat_approval`;
			var data = {
				id_surat: id_surat_selected,
			};

			$.ajax({
				url: url,
				method: "POST",
				data: data,
			}).done(function (res, textStatus, jqXHR) {
				var data = JSON.parse(res);
				console.log(data);
				if (data["status"] == "success") {
					alertify.success("Surat Berhasil Dikirim Ke Approval");
					buTable.ajax.reload();
					$('.nav-tabs a[href="#preview_pdf"]').tab("show"); // pindah tab preview pdf after edit
					$('#showpdf').hide();
					$('#pilih_surat_dulu').show();
					$("#BtnKirimApproval").hide();
					$("#BtnHapusSurat").hide();
				} else {
					alertify.error(data["pesan"]);
				}
			});
			}
		},
		"Default Value"
		)
		.set({ title: "Konfirmasi" });
	});
	$("#BtnHapusSurat").on("click", function () {
	if (id_surat_selected == null) {
		alertify.error(`Pilih Surat Terlebih Dahulu !`);
		return;
	}
	console.log(id_surat_selected);
	alertify
		.confirm(
		`
					Apakah anda yakin untuk menghapus surat ini ? <br><br>
					<b style="color:red;">Note* : Data surat tidak bisa dikembalikan lagi !</b>.
					`,
		function (ok) {
			if (ok) {
			var url = `${base_url}surat/ax_unset_data`;
			var data = {
				id_surat: id_surat_selected,
			};

			$.ajax({
				url: url,
				method: "POST",
				data: data,
			}).done(function (data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				if (data["status"] == "success") {
				alertify.success('Data Surat Berhasil Di hapus.');
				buTable.ajax.reload();
				$('.nav-tabs a[href="#preview_pdf"]').tab("show"); // pindah tab preview pdf after edit
				$('#showpdf').hide();
				$('#pilih_surat_dulu').show();
					$("#BtnKirimApproval").hide();
					$("#BtnHapusSurat").hide();
				}
			});
			}
		},
		"Default Value"
		)
		.set({ title: "Konfirmasi" });
	});
	function ViewData(id_surat) {
		if (id_surat == 0) {
			$('#addModalLabel').html('Add surat');
			$('#id_surat').val('0');
			$('#id_type_surat').val('');
			$('#id_klasifikasi').val('');
			$('#id_kategori').val('');
			$('#perihalAdd').val('');
			$('#t_isi_surat').val('');
			$('#active').val('1');
			$('#addModal').modal('show');
		} else {
			var url = '<?= base_url() ?>surat/ax_get_data_by_id';
			var data = {
				id_surat: id_surat
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				$('#addModalLabel').html('Edit surat');
				$('#id_surat').val(data['id_surat']);
				$('#id_type_surat').val(data['id_type_surat']);
				$('#id_klasifikasi').val(data['id_klasifikasi']);
				$('#id_kategori').val(data['id_kategori']);
				$('#perihalAdd').val(data['perihal']);
				$('#t_isi_surat').val(data['isi_surat']);
				$('#active').val(data['active']);
				$('#addModal').modal('show');
			});
		}
	}

	function DeleteData(id_surat) {
		alertify.confirm(
			'Confirmation',
			'Are you sure you want to delete this data?',
			function() {
				var url = '<?= base_url() ?>surat/ax_unset_data';
				var data = {
					id_surat: id_surat
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					buTable.ajax.reload();
					alertify.error('surat data deleted.');
				});
			},
			function() {}
		);
	}
// ============================= js penerima surat internal ================================
var buTableInter;
const getInternalSelected = () => {
    var data = {
		id_surat: id_surat_selected,
	};

    buTableInter = $('#buTableInter').DataTable({
		"bDestroy": true,
        "ordering" : false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        ajax: 
        {
            url: `${base_url}surat/ax_data_surat_internal/`,
            type: 'POST',
            data: data
        },
        columns: 
        [
            {
                data: "id_surat_alias", render: function(data, type, full, meta){
                    var str = '';
                    str += '<div class="btn-group">';
                    str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
                    str += '<ul class="dropdown-menu">';
                    str += '<li><a onClick="DeleteDataInter(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
                    str += '</ul>';
                    str += '</div>';
                    return str;
                }
            },
                
            { data: "nm_alias" },
            { data: "type_penerima", render: function(data, type, full, meta){
                    if(data == 1){
                        return `<span class="label label-info">Tembusan</span>`;
					}else{ 
						return `<span class="label label-primary">Penerima</span>`;
					}
                }
            },
        ]
    });
}

    
    $('#btnSaveInter').on('click', function () {
        // console.log($('#id_alias').val());
        // return;
        if(id_surat_selected == '' || id_surat_selected == 0){
            alertify.alert("Warning", "Pilih Surat Terlebih Dahulu");
        }
        if($('#type_penerimaInter').val() == '')
        {
            alertify.alert("Warning", "Please fill Tipe Penerima.");
        }
        else if($('#id_alias').val() == '')
        {
            alertify.alert("Warning", "Please fill Alias.");
        }
        else
        {
            var url = `${base_url}surat/ax_set_data_internal`;
            var data = {
                id_surat_alias: $('#id_surat_alias').val(),
                id_alias: $('#id_alias').val(),
                type_penerima: $('#type_penerimaInter').val(),
                id_surat: id_surat_selected

            };
 
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                if(data['status'] == "success")
                {
                    alertify.success("surat internal data saved.");
                    $('#addModalInter').modal('hide');
                    buTableInter.ajax.reload();
                }
            });
        }
    });
    
    function ViewDataInter(id_surat_alias)
    {
        if(id_surat_alias == 0)
        {
            $('#addModalLabelInter').html('Add surat internal');
            $('#id_surat_alias').val('0');
            $('#type_penerimaInter').val('1');
            $('#id_alias').val('0');					
            $('#activeInter').val('1');
            $('#addModalInter').modal('show');
        }
        
    }
    
    function DeleteDataInter(id_surat_alias)
    {
        alertify.confirm(
            'Confirmation', 
            'Are you sure you want to delete this data?', 
            function(){
                var url = `${base_url}surat/ax_unset_data_internal`;
                var data = {
                    id_surat_alias: id_surat_alias
                };
                        
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    buTableInter.ajax.reload();
                    alertify.error('surat internal data deleted.');
                });
            },
            function(){ }
        );
    }
// =========================== end js internal ==============================

// =========================== js approval ==================================

	var buTableApproval;
	const getApprovalSelected = () => {
	var data = {
		id_surat: id_surat_selected,
	};
	buTableApproval = $("#buTableApproval").DataTable({
		bDestroy: true,
		ordering: false,
		scrollX: true,
		processing: true,
		serverSide: true,
		ajax: {
		url: `${base_url}surat/ax_data_approval`,
		type: "POST",
		data: data,
		},
		columns: [
		{
			data: "id_approval",
			render: function (data, type, full, meta) {
			var str = "";
			str += '<div class="btn-group">';
			str +=
				'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
			str += '<ul class="dropdown-menu">';

			str +=
				'<li><a onClick="DeleteDataApproval(' +
				data +
				')"><i class="fa fa-trash"></i> Delete</a></li>';
			str += "</ul>";
			str += "</div>";
			return str;
			},
		},

		{
			data: "status",
			render: function (data, type, full, meta) {
			if (data == 1)
				return '<span class="label label-warning">Waiting</span>';
			else if (data == 2)
				return '<span class="label label-primary">Proses Approval</span>';
			else return '<span class="label label-success">Approved</span>';
			},
		},
		{
			class: "intro",
			data: "nm_akun",
			render: function (data, type, full, meta) {
			var str = "";

			str += data + " - " + full["nm_pegawai"];
			return str;
			},
		},
		{
			data: "type_approval",
			render: function (data, type, full, meta) {
			if (data == 1) return "Paraf";
			else return "Approval";
			},
		},
		],
	});
	};

	$("#btnSaveApproval").on("click", function () {
	if (id_surat_selected == "" || id_surat_selected == 0) {
		alertify.alert("Warning", "Pilih Surat Terlebih Dahulu");
	} else if ($("#type_approval").val() == "") {
		alertify.alert("Warning", "Please fill Tipe Approval.");
	} else if ($("#id_akunAp").val() == "") {
		alertify.alert("Warning", "Please fill Alias.");
	} else {
		var url = `${base_url}surat/ax_set_data_approval`;
		var data = {
		id_approval: $("#id_approval").val(),
		type_approval: $("#type_approval").val(),
		id_akun: $("#id_akunAp").val(),
		id_surat: id_surat_selected,
		};

		$.ajax({
		url: url,
		method: "POST",
		data: data,
		}).done(function (data, textStatus, jqXHR) {
		var data = JSON.parse(data);
		if (data["status"] == "success") {
			alertify.success("approval data saved.");
			$("#addModalApproval").modal("hide");
			buTableApproval.ajax.reload();
		} else {
			alertify.error(data["pesan"]);
		}
		});
	}
	});

	function ViewDataApproval(id_approval) {
	if (id_approval == 0) {
		$("#addModalLabelAp").html("Add approval");
		$("#id_approval").val("0");
		$("#type_approval").val("1");
		$("#id_buAp").val("0");
		$("#id_akunAp").select2().val("").trigger("change");
		// $('#id_akunAp').val('0');
		$("#select2-id_akun-containerAp").html("--Akun--");
		// $('#activeAp').val('1');
		$("#addModalApproval").modal("show");
	} else {
		var url = `${base_url}surat/ax_get_data_approval_by_id`;
		var data = {
		id_approval: id_approval,
		};

		$.ajax({
		url: url,
		method: "POST",
		data: data,
		}).done(function (data, textStatus, jqXHR) {
		var data = JSON.parse(data);
		$("#addModalLabelAp").html("Edit approval");
		$("#id_approval").val(data["id_approval"]);
		$("#type_approval").val(data["type_approval"]);
		$("#id_buAp").val(data["id_bu"]);
		$("#id_userAp").val(data["id_user"]);
		$("#id_akunAp").select2().val(data["id_akun"]).trigger("change");
		$("#id_buAp").val(data["id_akun"]);
		$("#activeAp").val(data["active"]);
		$("#addModalApproval").modal("show");
		});
	}
	}

	function DeleteDataApproval(id_approval) {
	alertify.confirm(
		"Confirmation",
		"Are you sure you want to delete this data?",
		function () {
		var url = `${base_url}surat/ax_unset_data_approval`;
		var data = {
			id_approval: id_approval,
		};

		$.ajax({
			url: url,
			method: "POST",
			data: data,
		}).done(function (data, textStatus, jqXHR) {
			var data = JSON.parse(data);
			buTableApproval.ajax.reload();
			alertify.error("approval data deleted.");
		});
		},
		function () {}
	);
	}
// ============================ end js approval ==============================


// ============================ js surat external =============================
var buTableEx;
const getExternalSelected = () => {
    var data = {
		id_surat: id_surat_selected,
	};
    buTableEx = $('#buTableEx').DataTable({
        "bDestroy": true,
        "ordering" : false,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        ajax: 
        {
            url: `${base_url}surat/ax_data_surat_external/`,
            type: 'POST',
            data: data

        },
        columns: 
        [
            {
                data: "id_surat_external", render: function(data, type, full, meta){
                    var str = '';
                    str += '<div class="btn-group">';
                    str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
                    str += '<ul class="dropdown-menu">';
                    str += '<li><a onclick="ViewDataEx(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
                    str += '<li><a onClick="DeleteDataEx(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
                    str += '</ul>';
                    str += '</div>';
                    return str;
                }
            },
            
            { data: "id_surat_external" },
            { data: "nm_surat_external" },
            { data: "email_surat_external" },
            { data: "type_penerima", render: function(data, type, full, meta){
                    if(data == 1)
                        return '<span class="label label-primary">Penerima</span>';
                    else return '<span class="label label-info">Tembusan</span>';
                }
            },
            
            { data: "active", render: function(data, type, full, meta){
                    if(data == 1)
                        return "Active";
                    else return "Not Active";
                }
            }
        ]
    });
}


    $('#btnSaveEx').on('click', function () {
        if(id_surat_selected == '' || id_surat_selected == 0){
            alertify.alert("Warning", "Pilih Surat Terlebih Dahulu");

        }
        if($('#nm_surat_external').val() == '')
        {
            alertify.alert("Warning", "Please fill Name.");
        }
        else
        {
            var url = `${base_url}surat/ax_set_data_external`;
            var data = {
                id_surat_external: $('#id_surat_external').val(),
                email_surat_external: $('#email_surat_external').val(),
                nm_surat_external: $('#nm_surat_external').val(),
                type_penerima: $('#type_penerima').val(),
                id_surat: id_surat_selected,
            };
                    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                if(data['status'] == "success")
                {
                    alertify.success("Penerima External data saved.");
                    $('#addModalEx').modal('hide');
                    buTableEx.ajax.reload();
                }
            });
        }
    });
    
    function ViewDataEx(id_surat_external)
    {
        if(id_surat_external == 0)
        {
            $('#addModalLabelEx').html('Add Surat External');
            $('#id_surat_external').val('0');
            $('#type_penerima').val('1');
            $('#nm_surat_external').val('');
            $('#email_surat_external').val('');
            $('#activeEx').val('1');
            $('#addModalEx').modal('show');
        }
        else
        {
            var url = `${base_url}surat/ax_get_data_external_by_id`;
            var data = {
                id_surat_external: id_surat_external
            };
                    
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                var data = JSON.parse(data);
                $('#addModalLabelEx').html('Edit Surat External');
                $('#id_surat_external').val(data['id_surat_external']);
                $('#type_penerima').val(data['type_penerima']);
                $('#nm_surat_external').val(data['nm_surat_external']);
                $('#email_surat_external').val(data['email_surat_external']);
                $('#activeEx').val(data['active']);
                $('#addModalEx').modal('show');
            });
        }
    }
    
    function DeleteDataEx(id_surat_external)
    {
        alertify.confirm(
            'Confirmation', 
            'Are you sure you want to delete this data?', 
            function(){
                var url = `${base_url}surat/ax_unset_data_external`;
                var data = {
                    id_surat_external: id_surat_external
                };
                        
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    buTableEx.ajax.reload();
                    alertify.error('surat external data deleted.');
                });
            },
            function(){ }
        );
    }
// ========================== end js surat external ============================


// ========================== js attachement ===================================
var buTableAttach;

function addAttachment() {

    $('#addModalLabelattach').html('Add Attachment');
    $('#nm_attachment').val('');
    $('#file_attachment').val('');
    $('#addModalAttach').modal('show');
}

$('#upload_attach').submit(function(e) {
    e.preventDefault();

    if ($('#id_surat_attach').val() == '') {
        alertify.alert("Warning", "Silahkan Pilih Surat Dulu !");
    }else if($('#nm_attachment').val() == '') {
        alertify.alert("Warning", "Silahkan Isi Judul !");

    }else if($('#file_attachment').val() == '') {
        alertify.alert("Warning", "Silahkan Pilih Dokumen Untuk Melakukan Proses Reupload!");

    } else {
        $.ajax({
            url: `${base_url}surat/ax_surat_upload_attachment/`,
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
        }).done(function(data, textStatus, jqXHR) {

            buTableAttach.ajax.reload();
            $('#addModalAttach').modal('hide');
            alertify.success('Upload Surat Berhasil');
        });
    }
});
const getAttachSelected = () => {
	var data = {
		id_surat: id_surat_selected,
	};
    buTableAttach = $('#buTableAttach').DataTable({
		"bDestroy": true,
        "ordering" : false,
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "colReorder": true,
        "responsive": true,
        "scrollY": "260px",
        "scrollCollapse": true,
        "scrollX": true,
        ajax: 
        {
            url: `${base_url}surat/ax_data_attachment/`,
            type: 'POST',
            data: data

        },
        columns: 
        [
            {
                data: "id_surat_attachment", render: function(data, type, full, meta){
                    var str = '';
                    str += '<div class="btn-group">';
                    str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
                    str += '<ul class="dropdown-menu">';
                    str += `<li><a onclick="ViewAttachment('${full.attachment}')"><i class="fa fa-pencil"></i> Lihat File</a></li>`;
                    str += `<li><a onClick="DeleteDataAttachment('${data}','${full.attachment}')"><i class="fa fa-trash"></i> Delete</a></li>`;
                    str += '</ul>';
                    str += '</div>';
                    return str;
                }
            },
            
            { class:"intro",
            data: "nm_attachment" },
            { class:"intro",
            data: "attachment" },
        ]
    });
}

    
    function ViewAttachment(attachment)
    {
        console.log(attachment);
        window.open(`${base_url}uploads/surat/${attachment}`, '_blank').focus();
    }
    
    
    function DeleteDataAttachment(id_surat_attachment = null, nama_file = null)
    {
        alertify.confirm(
            'Confirmation', 
            'Are you sure you want to delete this data?', 
            function(){
                var url = `${base_url}surat/ax_unset_data_attachment`;
                var data = {
                    id_surat_attachment: id_surat_attachment,
                    attachment: nama_file,
                };
                        
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    buTableAttach.ajax.reload();
                    alertify.success('attachment data deleted.');
                });
            },
            function(){ }
        );
    }
    
// ============================== end js attachment ===============================

// ============================== js preview PDF  =================================
	const show_pdf = (url) => {
	console.log("proses menampilkan pdf ....");
	$("#showpdf").html(
		`<iframe style="width: 100%; height: 650px;" id="pdf-preview" src="${url}"></iframe>`
	);

	return new Promise((resolve, reject) => {

		$("#pdf-preview").on("load", function (e) {
		resolve("PDF Fully Loaded");
		$("#showpdf").show();
		});
	});
	};
	async function load_pdf(id_surat) {
	try {
		const url = `${base_url}surat/pdf/${id_surat}`;
		$("#showpdf").hide();
		$("#gif").show();
		const pdf = await show_pdf(url);
		$("#gif").fadeOut();
		console.log(pdf);
	} catch (rejectedReason) {
		console.log(rejectedReason);
	}
	}
// ================================ end preview js========================================
</script>
<!-- end list surat di datatable -->

</html>