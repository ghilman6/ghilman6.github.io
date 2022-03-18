	<script src="<?= base_url() ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/select2/select2.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/jquery.timepicker.js"></script>
	<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/bootstrap/src/bootstrap-input-spinner.js"></script>

	<script src="<?= base_url() ?>assets/plugins/fastclick/fastclick.min.js"></script>

	<script src="<?= base_url() ?>assets/dist/js/app.min.js"></script>

	<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

	<!--<script src="<?= base_url(); ?>assets/js/highcharts.js"></script>
    <script src="<?= base_url(); ?>assets/js/highcharts-3d.js"></script>
    <script src="<?= base_url(); ?>assets/js/exporting.js"></script>
    <script src="<?= base_url(); ?>assets/js/export-data.js"></script>
	-->
	<script src="<?= base_url() ?>assets/plugins/chartjs/Chart.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/chartjs/Chart.PieceLabel.min.js"></script>

	<script src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

	<script src="<?= base_url(); ?>assets/plugins/multiple-email/multiple-emails.js"></script>

	<script src="<?= base_url() ?>assets/dist/js/pages/dashboard.js"></script>
	<!-- Morris.js charts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/morris/morris.min.js"></script>
	<script>
	    $(".select2").select2();
	    $(".loader").hide();
	</script>

	<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="<?= base_url(); ?>assets/js/jquery.mask.min.js"></script>

	<script src="<?= base_url(); ?>assets/plugins/alertifyjs/alertify.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/jquery.number.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/touchspin/jquery.bootstrap-touchspin.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

	<script type="text/javascript">
	    function Left(str, n) {
	        var iLen = String(str).length - n;

	        return String(str).substring(iLen, 0);
	    }

	    function Right(str, n) {
	        if (n <= 0)
	            return "";
	        else if (n > String(str).length)
	            return str;
	        else {
	            var iLen = String(str).length;
	            return String(str).substring(iLen, iLen - n);
	        }
	    }
	</script>

	<script type="text/javascript">
	    function angka(x) {
	        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    }
		
	</script>


	<!--End of Tawk.to Script-->