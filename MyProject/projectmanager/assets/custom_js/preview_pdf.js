const show_pdf = (url) => {
  console.log("proses menampilkan pdf ....");
  // <iframe style="width: 100%; height: 650px;" id="pdf-preview" src="${url}"></iframe>
  $("#showpdf").html(
    `<iframe style="width: 100%; height: 650px;" id="pdf-preview" src="${url}"></iframe>`
  );

  return new Promise((resolve, reject) => {
    // setTimeout(function () {
    //   $("#showpdf").html(
    //     `<object id="pdf-preview" style="width: 100%; height: 650px;" data="${url}">`
    //   );
    //   $("#showpdf").show();
    //   resolve("PDF Fully Loaded");
    // }, 2000);

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
