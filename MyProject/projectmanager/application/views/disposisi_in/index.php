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
		/* .container{max-width:1170px; margin:auto;} */
		img{ max-width:100%;}
		.inbox_people {
		background: #f8f8f8 none repeat scroll 0 0;
		float: left;
		overflow: hidden;
		width: 40%; border-right:1px solid #c4c4c4;
		}
		.inbox_msg {
		/* border: 1px solid #c4c4c4; */
		/* clear: both;
		overflow: hidden; */
		}
		.top_spac{ margin: 20px 0 0;}


		.recent_heading {float: left; width:40%;}
		.srch_bar {
		display: inline-block;
		text-align: right;
		width: 60%;
		}
		.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

		.recent_heading h4 {
		color: #05728f;
		font-size: 21px;
		margin: auto;
		}
		.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
		.srch_bar .input-group-addon button {
		background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
		border: medium none;
		padding: 0;
		color: #707070;
		font-size: 18px;
		}
		.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

		.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
		.chat_ib h5 span{ font-size:13px; float:right;}
		.chat_ib p{ font-size:14px; color:#989898; margin:auto}
		.chat_img {
		float: left;
		width: 11%;
		}
		.chat_ib {
		float: left;
		padding: 0 0 0 15px;
		width: 88%;
		}

		.chat_people{ overflow:hidden; clear:both;}
		.chat_list {
		border-bottom: 1px solid #c4c4c4;
		margin: 0;
		padding: 18px 16px 10px;
		}
		.inbox_chat { height: 550px; overflow-y: scroll;}

		.active_chat{ background:#ebebeb;}

		.incoming_msg_img {
		display: inline-block;
		width: 6%;
		}
		.received_msg {
		display: inline-block;
		padding: 0 0 0 10px;
		vertical-align: top;
		width: 92%;
		}
		.received_withd_msg p {
		background: #ebebeb none repeat scroll 0 0;
		border-radius: 3px;
		color: #646464;
		font-size: 14px;
		margin: 0;
		padding: 5px 10px 5px 12px;
		width: 100%;
		}
		.time_date {
		color: #747474;
		display: block;
		font-size: 12px;
		margin: 8px 0 0;
		}
		.received_withd_msg { width: 57%;}
		.mesgs {
		float: left;
		padding: 30px 15px 0 25px;
		width: 100%;
		border: 1px solid #c4c4c4;

		}

		.sent_msg p {
		background: #05728f none repeat scroll 0 0;
		border-radius: 3px;
		font-size: 14px;
		margin: 0; color:#fff;
		padding: 5px 10px 5px 12px;
		width:100%;
		}
		.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
		.sent_msg {
		float: right;
		width: 46%;
		}
		.input_msg_write input {
		background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
		border: medium none;
		color: #4c4c4c;
		font-size: 15px;
		min-height: 48px;
		width: 100%;
		}

		.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
		.msg_send_btn {
		background: #05728f none repeat scroll 0 0;
		border: medium none;
		border-radius: 50%;
		color: #fff;
		cursor: pointer;
		font-size: 17px;
		height: 33px;
		position: absolute;
		right: 0;
		top: 11px;
		width: 33px;
		}
		.messaging { padding: 0 0 50px 0;}
		.msg_history {
		height: 416px;
		overflow-y: auto;
		}
	</style>
</head>

<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">
	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>DISPOSISI IN</h1>
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
							<li class="active"><a data-toggle="tab" href="#chat_disposisi">Disposisi</a></li>
							<li><a data-toggle="tab" href="#preview_pdf">Preview PDF</a></li>
							<li><a data-toggle="tab" href="#menu1">Isi Surat</a></li>

						</ul>

						<div class="tab-content">
						<div id="chat_disposisi" class="tab-pane fade in active">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h4 class="panel-title">

										</h4>
									</div>
									<div id="collapse33" class="panel-collapse collapse in">
										<div class="panel-body">
											<div class="form-group d-none" id="container_chat">
												<p> <b>Percakapan / Note :</b></p>
												<div class="mesgs" >
														<div class="msg_history" id="msg_history">
															<!-- chat percakapan tampil disini -->
														</div>
													<div class="type_msg">
														<div class="input_msg_write">
															<input type="text" class="write_msg" id="isi_chat" name="isi_chat" placeholder="Ketik pesan / note disini ..." />
															<button class="msg_send_btn" type="button" id="btnKirimChat"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
														</div>
													</div>


												</div>
												<div class="row disposisi" id="divdisposisi">
														<div class="form-group col-md-12" >
														<hr>
															<p><b>List Penerima Disposisi :</b></p>
															<select class="form-control select2-multiple" style="width:100%" id="selected_list_disposisi" name="selected_list_disposisi[]" multiple="multiple" disabled>
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
											</div>
											<h3 class="text-center" id="pilih_disposisi_dulu">Pilih Disposisi Terlebih Dahulu Untuk Di Menampilkan !</h3>
												<img class="img-responsive center-block gif" src="<?= base_url() ?>assets/img/loading2.gif" id="gif_disposisi" style="width:60%; height:60%; display: none;">
										</div>

									</div>
								</div>
							</div>
							<div id="preview_pdf" class="tab-pane fade ">
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
	var id_akun_selected = $('#id_akun_access').val();
	var id_disposisi_selected ;

	$(document).ready(function() {
		$('.select2-multiple').select2();

		$(".tabs_collapse").click(function() {
			$(".tabs_collapse").removeClass("active");
			$(this).addClass("active"); // Add Active class to each tabs collapse

		});

		$(document).on('click', '.pilih_surat', function() {
			$('#pilih_surat_dulu').css('display', 'none');
			$('#pilih_disposisi_dulu').css('display', 'none');

			let id_surat = $(this).data('id_surat');
			let id_disposisi = $(this).data('id_disposisi');
			id_surat_selected = id_surat;
			id_disposisi_selected = id_disposisi;
			$('#id_surat_selected').val(id_surat);
			load_pdf(id_surat); //load preview pdf
			get_data_surat(id_surat);
			chatdisposisi(id_disposisi); // get percakapan / note disposisi
			selectDisposisi(id_disposisi); // get penerima disposisi

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
			url: "<?= base_url() ?>disposisi_in/ax_data_surat/",
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
					let str = `<span class="pilih_surat pointer" data-id_disposisi="${full['id_disposisi']}" data-id_surat="${full['id_surat']}">`;
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
		let id_akun = this.value;
		id_akun_selected = id_akun;
		buTable.ajax.reload(); // reload table berdasarkan id_akun
		$('#container_chat').hide();
		$('#pilih_disposisi_dulu').show();

	});

	$('#btnKirimChat').on('click', function () {
		let isi_chat = $('#isi_chat').val();

			if(isi_chat == ''){
				alertify.alert("Warning", "Note Tidak Boleh Kosong.");
				return false;
			}else if(id_disposisi_selected == null){
				alertify.alert("Warning", "Penerima Disposisi Tidak Boleh Kosong");
				return false;
			}else{
					alertify.confirm(
								`
								Note ini akan dikirim , apakah anda yakin ? <br><br>
								<b style="color:red;">Note* : Pastikan Sudah Benar</b>.
								`,
						function (ok) {
							if (ok) {
								const url = '<?=base_url()?>disposisi_in/ax_upload_note_disposisi/';
								let data = {
									nm_note: isi_chat,
									id_disposisi: id_disposisi_selected,
								};
										
								$.ajax({
									url: url,
									method: 'POST',
									data: data
								}).done(function(data, textStatus, jqXHR) {
									var data = JSON.parse(data);
									if(data['status'] == "success")
									{
										alertify.success("Note Berhasil Dikirim.");
										// tbllistchatdisposisi.ajax.reload();
										chatdisposisi(id_disposisi_selected);
										$('#isi_chat').val('');
									}
								});
							}
						},
					"Default Value"
					).set({ title: "Konfirmasi" });
			};

	});



	const selectDisposisi = (id_disposisi) => {
		if(id_disposisi_selected != null ){

			$('#selected_list_disposisi').val(['']).trigger('change');
			$.ajax({
				url: "<?=base_url()?>disposisi_in/get_selected_dispo/"+id_disposisi,
				dataType: 'json',
				success: function(datas){
					var agd = $.map(datas.data, function (obj) {
						var id_alias = obj.id_alias;
						var idals = id_alias.split(",");
						$('#selected_list_disposisi').val(idals).trigger('change');
					});
				}
			});
		}
	}
	const chatdisposisi = (id_disposisi) => {

			let url = "<?=base_url()?>disposisi_in/get_chatdispo/";
			let data = {
				id_disposisi: id_disposisi,
			};
			// console.log(id_disposisi);
			$('#gif_disposisi').show();
			$("#container_chat").hide();
			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(res, textStatus, jqXHR) {
				var data = JSON.parse(res);
				if(data['status'] == "success")
				{
					console.log(data['data']);
					$('#msg_history').html(data['data']);
					$('#gif_disposisi').hide();
					$('#container_chat').show();
				}
			});


			// $('#tbllistchatdisposisi').DataTable().clear().draw();
			// var tbllistchatdisposisi = $('#tbllistchatdisposisi').DataTable({
			// 	destroy: true,	
			// 	"ordering" : false,
			// 	"scrollX": true,
			// 	"processing": true,
			// 	"serverSide": true,
			// 	"lengthChange": false,
			// 	"info":     false,
			// 	"paging":   false,
			// 	'searching': false,
			// 	"ajax": 
			// 	{
			// 		"url": "<?=base_url()?>disposisi_in/get_chatdispo/"+id_surat,
			// 		"type": 'POST',    
			// 	},
			// 	columns: 
			// 	[
			// 		{
			// 			data: "nm_note", render: function(data, type, full, meta){
			// 				let str = '';
			// 				str += `
			// 					<div class="direct-chat-msg right">
			// 						<div class="direct-chat-info clearfix">
			// 							<span class="direct-chat-name pull-left">${full['nm_user']}</span>
			// 							<span class="direct-chat-timestamp pull-right">${full['cdate']}</span>
			// 						</div>
			// 						<div class="direct-chat-text bg-aqua">
			// 							<p><span style="font-family:Tahoma">${data}</span></p>
			// 						</div>
			// 					</div>
			// 				`
			// 				return str;
			// 			}
			// 		},
			// 	]
			// });
	}


</script>
<script type="text/javascript">
		
const base_url = `<?= base_url() ?>`;
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

</html>