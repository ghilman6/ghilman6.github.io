<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//insert log riwayat surat
// if (! function_exists('log_surat')) {
    function log_surat($nm_log = null, $desc = null, $id_surat = null, $c_user = null)
    {    
        $CI =& get_instance();
 
        $fields = array(
            'nm_log' => $nm_log,
            'deskripsi_log' => $desc,
            'id_surat' => $id_surat,
            'cuser' => $c_user,
        );
            
        //load model log
        $CI->load->model('model_surat');
     
        //save to database
        $CI->model_surat->log_surat($fields);
    
    }
// }