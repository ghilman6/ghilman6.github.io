<!DOCTYPE html>
<html>

<head>
	<?= $this->load->view('head'); ?>
</head>


<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">

	<div class="wrapper">

		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>


		<div class="content-wrapper">
			<section class="content-header">

			</section>


			<section class="content">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Surat Masuk</span>
								<span class="info-box-number">

									
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box">
							<span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Surat Keluar</span>
								<span class="info-box-number">

									
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->

					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box">
							<span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Approval</span>
								<span class="info-box-number">

									
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->

					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box">
							<span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Disposisi</span>
								<span class="info-box-number">

									<?php
									$session = $this->session->userdata('login');
									$bu = $session['id_bu'];
									// $belumdiambil = $this->db->query("select count(id_logistics) belumdiambil from tr_bongkar_logistics where id_logistics not in (select id_logistics from tr_ambil_logistics) and id_bu = " . $this->db->escape($bu) . "")->row("belumdiambil");
									// echo $belumdiambil;
									?>
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->

					<!-- fix for small devices only -->
					<div class="clearfix visible-sm-block"></div>

					

					
					
					
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 class="box-title">GRAFIK SURAT BULANAN </h3>

								<div class="nav-tabs-custom">
									<div class="tab-content ">
										<div class="form-horizontal">

											<div class="row">
												<div class="col-lg-2 col-md-4 col-sm-6">
													<label>Tanggal Awal </label>
													<div class="input-group">

														<input type="text" id="startDateTipeSurat" name="startDateTipeSurat" class="form-control " placeholder="Tanggal Awal">
													</div>
												</div>
												<div class="col-lg-10 col-md-8 col-sm-6">
													<label>Tanggal Akhir </label>

													<div class="input-group">
														<input type="text" id="endDateTipeSurat" name="endDateTipeSurat" class="form-control" placeholder="Tanggal Akhir">
														<span class="input-group-btn" style="width:0;">
															<button class="btn btn-primary" id="btnCariTanggalTipeSurat" type="button" onClick="getTipeSurat('')">CARI</button>
														</span>
													</div>
												</div>


											</div>

										</div>
									</div>
								</div>
								<!-- Morris chart - Sales -->
								<!-- <div class="chart tab-pane active" id="revenue-chart-week" style="position: relative; height: 300px;"></div> -->
								<div id="container" style="width:100%; height:400px;"></div>

							</div>
						</div>
						<!-- /.nav-tabs-custom -->
					</div>
				</div>
				<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- /.row -->

	<!-- /.row -->

	</section>


	</div>
	</div>

	<?= $this->load->view('basic_js'); ?>

	<script type='text/javascript'>
		var base_url = `<?= base_url() ?>`;

		getTipeSurat(); // first load grafik tipe surat berdasarkan bulan NOW

		$("#startDateTipeSurat").datepicker({ // inisiasi datepicker start date tipe surat
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		$("#startDateTipeSurat").inputmask("yyyy-mm-dd", {
			"placeholder": "yyyy-mm-dd"
		});
		$("#endDateTipeSurat").datepicker({ // inisiasi datepicker end date tipe surat
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		$("#endDateTipeSurat").inputmask("yyyy-mm-dd", {
			"placeholder": "yyyy-mm-dd"
		});

		let grafikTipeSurat = new Highcharts.chart('container', { // inisiasi grafik chart tipe surat
			chart: {
				type: 'column'
			},
			title: {
				text: 'Grafik Tipe Surat'
			},
			accessibility: {
				announceNewData: {
					enabled: true
				}
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Total Surat Berdasarkan Tipe'
				},
				categories: ['NA']

			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y:.0f}'
					}
				}
			},

			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Surat<br/>'
			},
			drilldown: {
				series: null
			}

		});


		function getTipeSurat(now = null) {

			const startDateTipeSurat = $('#startDateTipeSurat').val();
			const endDateTipeSurat = $('#endDateTipeSurat').val();

			if (now != null) {
				if (startDateTipeSurat == '') {
					alertify.error("Pilih Tanggal Awal Dulu !");
					return;
				} else if (endDateTipeSurat == '') {
					alertify.error("Pilih Tanggal Akhir Dulu !");
					return;
				}
				while (grafikTipeSurat.series.length > 0)
					grafikTipeSurat.series[0].remove(true);
			}


			const url = `${base_url}home/ax_get_grafik_tipe_surat`;
			let data = {
				startDateTipeSurat: startDateTipeSurat,
				endDateTipeSurat: endDateTipeSurat
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				let res = JSON.parse(data);
				const formatted = res.data.map(surat => ({
					...surat,
					y: parseInt(surat.y)
				}))
				grafikTipeSurat.addSeries({
					name: 'Tipe Surat',
					colorByPoint: true,
					data: formatted
				});
			});

		}
	</script>
</body>

</html>