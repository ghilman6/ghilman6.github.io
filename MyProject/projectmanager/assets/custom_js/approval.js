// js approval

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
            '<li><a onclick="ViewDataApproval(' +
            data +
            ')"><i class="fa fa-pencil"></i> Edit</a></li>';
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
//  end js approval
