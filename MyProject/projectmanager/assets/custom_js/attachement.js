// <!-- js attachement -->
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
                    str += '<li><a onClick="DeleteDataAttachment(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
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
    
    
    function DeleteDataAttachment(id_surat_attachment)
    {
        alertify.confirm(
            'Confirmation', 
            'Are you sure you want to delete this data?', 
            function(){
                var url = `${base_url}surat/ax_unset_data_attachment`;
                var data = {
                    id_surat_attachment: id_surat_attachment
                };
                        
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    buTableAttach.ajax.reload();
                    alertify.error('attachment data deleted.');
                });
            },
            function(){ }
        );
    }
    
// <!-- end js attachment -->