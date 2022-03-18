//  js surat external 
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
// end js surat external