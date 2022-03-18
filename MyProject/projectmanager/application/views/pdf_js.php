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

	