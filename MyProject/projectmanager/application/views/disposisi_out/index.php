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
	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>INBOX</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<input type="hidden" id="id_surat_selected" name="id_surat_selected" value='' />	
								<select class="form-control select2" style="width: 100%;" id="id_akun_access" name="id_akun_access">
									<!-- <option value="0">-- Akses Akun --</option> -->
									<?php
										foreach ($combobox_akses_akun->result() as $ak) {
									?>
											<option value="<?= $ak->id_akun ?>"><?= $ak->nm_akun ?></option>
									<?php
										}
									?>
								</select>
								
							</div>
							<div class="panel-body">
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>List Surat</th>
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
									<!----------------- SECTION ISI SURAT ------------------>
									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse5">
											<h4 class="panel-title">
												<span>
													Isi Surat</span>
											</h4>
										</div>
										<div id="collapse5" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="panel panel-default">
													
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" id="">
																<thead>
																	<tr>
																		<th>Keterangan</th>
																		

																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td id="perihal"></td>
																	</tr>
																	<tr>
																		<td id="nm_klasifikasi"></td>
																	</tr>
																	<tr>
																		<td id="nm_type_surat"></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>

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
													
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table class="table table-striped table-bordered table-hover" id="buTableAttach">
																<thead>
																	<tr>
																		<th>Options</th>
																		<th>Attachement</th>
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
														
													</div>
													<div class="panel-body">
														<div class="dataTable_wrapper">
															<table style="overflow: auto; width: 100%;" class="table table-striped table-bordered table-hover" id="buTableApproval">
																<thead style="overflow: hidden; position: relative; border: 0px; width: 100%;">
																	<tr>
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
									<!---------------- SECTION DISPOSISI ------------------->

									<div class="panel panel-primary">
										<div class="panel-heading accordion-toggle pointer" data-toggle="collapse" data-parent="#accordion2" href="#collapse8">
											<h4 class="panel-title">
												<span>
													Disposisi</span>
											</h4>
										</div>
										<div id="collapse8" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="row disposisi" id="divdisposisi">
														<div class="form-group col-md-12" >
															<select class="form-control select2-multiple" style="width:100%" id="listdisposisi" name="listdisposisi[]" multiple="multiple" >
																<?php foreach ($combobox_penerima_internal->result() as $rowd) { 
																	/*
																		if($rowd->posisi == 'a'){ ?>

																			<optgroup label="<?= $rowd->nama?>">
																		<?php }else{  */
																		?>
																				<option value="<?= $rowd->id_alias?>"  ><?= $rowd->nm_alias?></option>

																		<?php /* } ?>
																			</optgroup>
																		<?php  */
																		} ?>
															</select>
														</div>
												</div>
												<hr>
												<textarea id="disposisi_note" name="disposisi_note" class="form-control" rows="10" cols="80"></textarea>
												<div class="box-footer">
													<div class="pull-right">
													<button type="button" class="btn btn-primary" id="btnSaveNote" ><i class="fa fa-envelope-o"></i> Kirim Disposisi & Note</button>
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
<script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
<?= $this->load->view('basic_js'); ?>

<script>
	var id_surat_selected; // global

	CKEDITOR.replace('disposisi_note');

	$(document).ready(function() {
		$('.select2-multiple').select2();

		$(".tabs_collapse").click(function() {
			$(".tabs_collapse").removeClass("active");
			$(this).addClass("active"); // Add Active class to each tabs collapse

		});

		$(document).on('click', '.pilih_surat', function() {
			$('#pilih_surat_dulu').css('display', 'none');

			let id_surat = $(this).data('id_surat');
			id_surat_selected = id_surat;
			$('#id_surat_selected').val(id_surat);
			load_pdf(id_surat); //load preview pdf
			get_data_surat(id_surat);

		});


	});
	$("#accordion, #accordion2").on("shown.bs.collapse", function() {
		// re adjust responsive data tables didalam accordion
		$.each($.fn.dataTable.tables(true), function() {
			$(this).DataTable().columns.adjust().draw();
		});
	});
	

	const get_data_surat = (id_surat) => { // get data surat by id
		const url = '<?= base_url() ?>inbox/ax_get_data_by_id';
		const data = {
			'id_surat': id_surat,
		};
		return $.ajax({
			url: url,
			method: 'POST',
			data: data
		}).done(function(data, textStatus, jqXHR) {
			// pass data
			var data = JSON.parse(data);
			$('#nm_klasifikasi').html(data['nm_klasifikasi']);
			$('#nm_type_surat').html(data['nm_type_surat']);
			$('#perihal').html(data['perihal']);
			buTableAttach.ajax.reload();
			buTableApproval.ajax.reload(); 
		});
	}	
</Script>

<script type='text/javascript'>
	var buTable = $('#buTable').DataTable({
		"ordering": false,
		"scrollX": true,
		"processing": true,
		"serverSide": true,
		ajax: {
			url: "<?= base_url() ?>inbox/ax_data_surat/",
			type: 'POST',
			data: function(d) {
					return $.extend({}, d, {

						"id_akun": $("#id_akun_access").val()

					});
				}
		},
		columns: [
		

			{
				data: "id_surat",
				render: function(data, type, full, meta) {
					let str = `<span class="pilih_surat pointer" data-id_surat="${full['id_surat']}">`;
					str += '[ '+data + ' ] - ' + full['nm_type_surat'] + ' - ' + full['nm_klasifikasi'] + ' - ' + full['nm_kategori'] + ' - ' + full['perihal'] + ' - <b>' + full['tgl_surat']+'</b>';
					str += '</span>'
					return str;
				}
			},
		]

	});

	var buTableApproval = $('#buTableApproval').DataTable({
		"ordering": false,
		"scrollX": true,
		"processing": true,
		"serverSide": true,
		ajax: {
			url: "<?= base_url() ?>inbox/ax_data_approval/",
			type: 'POST',
			data: function(d) {
					return $.extend({}, d, {

						"id_surat": $("#id_surat_selected").val()

					});
				}
		},
		columns: [
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
		]

	});

	var buTableAttach = $('#buTableAttach').DataTable({
		"ordering": false,
		"scrollX": true,
		"processing": true,
		"serverSide": true,
		ajax: {
			url: "<?= base_url() ?>inbox/ax_data_attachment/",
			type: 'POST',
			data: function(d) {
					return $.extend({}, d, {

						"id_surat": $("#id_surat_selected").val()

					});
				}
		},
		columns: [
			{
                data: "id_surat_attachment", render: function(data, type, full, meta){
                    var str = '';
                    str += '<div class="btn-group">';
                    str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
                    str += '<ul class="dropdown-menu">';
                    str += `<li><a onclick="ViewAttachment('${full.attachment}')"><i class="fa fa-pencil"></i> Lihat File</a></li>`;
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

	$('#id_akun_access').on('change', function() {
		buTable.ajax.reload(); // reload table berdasarkan id_akun
	});

	$('#btnSaveNote').on('click', function () {
		let isi_note = CKEDITOR.instances.disposisi_note.getData()
		let disposisi_selected = $('#listdisposisi').val();

			if(id_surat_selected == null){
				alertify.alert("Pilih surat mana yang akan di disposisi");
				return false;
			}else if(isi_note == ''){
				alertify.alert("Warning", "Note Tidak Boleh Kosong.");
				return false;
			}else if(disposisi_selected == null){
				alertify.alert("Warning", "Penerima Disposisi Tidak Boleh Kosong");
				return false;
			}else{
					alertify.confirm(
								`
								Surat ini akan dikirim untuk di disposisi, apakah anda yakin ? <br><br>
								<b style="color:red;">Note* : Pastikan Sudah Benar</b>.
								`,
						function (ok) {
							if (ok) {
								const url = '<?=base_url()?>inbox/ax_upload_data_disposisi/';
								let data = {
									id_alias: disposisi_selected,
									editornote: isi_note,
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
										alertify.success("Note data saved.");
										// tbllistchatdisposisi.ajax.reload();
										window.location.reload();
									}
								});
							}
						},
					"Default Value"
					).set({ title: "Konfirmasi" });
			};

	});

</script>
<?= $this->load->view('pdf_js'); ?>
</html>