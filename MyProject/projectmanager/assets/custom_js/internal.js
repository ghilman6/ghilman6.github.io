// <!-- js internal -->
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
                data: "id_surat_internal", render: function(data, type, full, meta){
                    var str = '';
                    str += '<div class="btn-group">';
                    str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
                    str += '<ul class="dropdown-menu">';
                    str += '<li><a onclick="ViewDataInter(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
                    str += '<li><a onClick="DeleteDataInter(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
                    str += '</ul>';
                    str += '</div>';
                    return str;
                }
            },
                
            { data: "nm_akun" },
            { data: "type_penerima", render: function(data, type, full, meta){
                    if(data == 1)
                        return '<span class="label label-info">Penerima</span>';
                    else return '<span class="label label-primary">Tembusan</span>';
                }
            },
        ]
    });
}

    
    $('#btnSaveInter').on('click', function () {
        // console.log($('#id_akunInter').val());
        // return;
        if(id_surat_selected == '' || id_surat_selected == 0){
            alertify.alert("Warning", "Pilih Surat Terlebih Dahulu");

        }
        if($('#type_penerimaInter').val() == '')
        {
            alertify.alert("Warning", "Please fill Tipe Penerima.");
        }
        else if($('#id_akunInter').val() == '')
        {
            alertify.alert("Warning", "Please fill Alias.");
        }
        else
        {
            var url = `${base_url}surat/ax_set_data_internal`;
            var data = {
                id_surat_internal: $('#id_surat_internal').val(),
                type_penerima: $('#type_penerimaInter').val(),
                id_akun: $('#id_akunInter').val(),
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
    
    function ViewDataInter(id_surat_internal)
    {
        if(id_surat_internal == 0)
        {
            $('#addModalLabelInter').html('Add surat internal');
            $('#id_surat_internal').val('0');
            $('#type_penerimaInter').val('1');
            $('#id_akunInter').val('0');					
            $('#activeInter').val('1');
            $('#addModalInter').modal('show');
        }
        else
        {
            var url = `${base_url}surat/ax_get_data_internal_by_id`;
            var data = {
                id_surat_internal: id_surat_internal
            };
                   console.log(id_surat_internal) 
            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).done(function(data, textStatus, jqXHR) {
                console.log(data);
                var data = JSON.parse(data);
                $('#addModalLabelInter').html('Edit surat internal');
                $('#id_surat_internal').val(data['id_surat_internal']);
                $('#type_surat_internal').val(data['type_surat_internal']);
                $('#type_penerimaInter').val(data['type_penerima']);
                $("#id_akunInter").select2().val(data['id_akun']).trigger("change");
                $('#activeInter').val(data['active']);
                $('#addModalInter').modal('show');
            });
        }
    }
    
    function DeleteDataInter(id_surat_internal)
    {
        alertify.confirm(
            'Confirmation', 
            'Are you sure you want to delete this data?', 
            function(){
                var url = `${base_url}surat/ax_unset_data_internal`;
                var data = {
                    id_surat_internal: id_surat_internal
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
// <!-- end js internal -->