<?php

use function PHPSTORM_META\map;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class approval extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_approval");
        $this->load->model("model_menu");

        // constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }
    // ----------------------------- # SURAT ------------------------------------
    public function index()
    {
        if ($this->session->userdata('login')) {
            // echo "<pre>";
            // print_r($this->session->all_userdata());
            // $akun = $this->model_approval->get_approval_akun()->result_array();
            // $surat_by_akun = $this->model_approval->get_approval_surat_login($akun['id_akun'])->result_array();
            // print_r($surat_by_akun);
            // echo "<br>";    

            // print_r($akun);
            // return;
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['data_surat'] = $this->model_approval->get_surat_by_id('27');
                $data['akses_akun'] = $this->model_approval->get_approval_akun()->result_array();
                
                $data['combobox_type_surat'] = $this->model_approval->combobox_type_surat();
                $data['combobox_klasifikasi'] = $this->model_approval->combobox_klasifikasi();
                $data['combobox_kategori'] = $this->model_approval->combobox_kategori();

                $data['combobox_bu'] = $this->model_approval->combobox_bu();
                $data['combobox_akun'] = $this->model_approval->combobox_akun();
                $data['combobox_alias'] = $this->model_approval->combobox_alias();


                $this->load->view('approval/index', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function detail($id_surat = null)
    {

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $data['data_surat'] = $this->model_approval->get_surat_by_id($id_surat);

            $data['id_user'] = $session['id_user'];
            $data['nm_user'] = $session['nm_user'];
            $data['session_level'] = $session['id_level'];
            $data['combobox_bu'] = $this->model_approval->combobox_bu();
            $data['combobox_akun'] = $this->model_approval->combobox_akun();
            $this->load->view('surat/surat_detail', $data);

        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function pdf($id_surat = null)
    {
        // $jenis_surat = $this->model_inbox_new->cek_jenis_surat($id_surat);

        // if($jenis_surat['id_type_surat'] == '8'){
        $this->pdf_nd($id_surat);
        // } else if($jenis_surat['id_type_surat'] == '4' || $jenis_surat['id_type_surat'] == '10'){
        // $this->pdf_edaran($id_surat); // edaran dan pengumuman
        // } else if($jenis_surat['id_type_surat'] == '9' ){
        // $this->pdf_nd($id_surat); // memo
        // } else {
        // $this->pdf_sku($id_surat);
        // }
    }
    function _mpdf($judul = '', $isi = '', $lMargin = 10, $rMargin = 10, $font = 10, $orientasi, $id_surat)
    {
        ob_start();
        ini_set("memory_limit", "-1");
        $session = $this->session->userdata('login');
        $this->load->library('M_pdf');
        $mpdf = new m_pdf('', 'A4');
        #$mpdf->showImageErrors = true;
        #$mpdf->curlAllowUnsafeSslRequests = true;
        $pdfFilePath = "output_pdf_name.pdf";
        $mpdf->pdf->SetHTMLHeader('<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <tr><td colspan="3" align="right"><img alt="" src="' . base_url() . 'assets/img/logos.png" style="float:right; height:32px; width:200px" /></td></tr></table>');
        //$id_bu = $session['id_bu'];
        // $id_bu = $this->db->query("select id_bu from tr_surat where id_surat = '$id_surat' ")->row("id_bu");
        // $footerbu = $this->db->query("select id_bu from tr_surat where id_surat = '$id_surat' ")->row("id_bu");
        // $telp_bu = $this->db->query("select telp from ref_bu where id_bu = '$footerbu' ")->row("telp");
        // $email_bu = $this->db->query("select email from ref_bu where id_bu = '$footerbu' ")->row("email");
        // $nm_bu = $this->db->query("select nm_bu from ref_bu where id_bu = '$footerbu' ")->row("nm_bu");
        // $alamat_bu = $this->db->query("select alamat from ref_bu where id_bu = '$footerbu' ")->row("alamat");
        // if ($footerbu == 60) {
        $mpdf->pdf->SetHTMLFooter('<table style="width:100%">
				<tbody>
					<tr>
						<td colspan="2"><span style="color:#6666ff"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Perum DAMRI Kantor Pusat, Matraman Raya No. 25 Jakarta Timur 13140</span></span></span></td>
					</tr>
					<tr>
						<td colspan="2"><span style="color:#6666ff"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Email : humas@damri.co.id</span></span></span></td>
					</tr>
					<tr>
						<td colspan="2"><span style="color:#6666ff"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Website : www.damri.co.id</span></span></span></td>
					</tr>
					<tr>
						<td><span style="color:#6666ff"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Telp : 021 - 8583131</span></span></span></td>
						<td style="text-align:right"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"><span style="color:#6666ff">Page {PAGENO} of {nb}</span></span></span></td>
					</tr>
				</tbody>
			</table>');
        // }
        // $mpdf->pdf->SetFooter('Printed e-Procurement on @ {DATE j-m-Y H:i:s} || Page {PAGENO} of {nb}');
        $mpdf->pdf->AddPage($orientasi, '', '', '', '', '25', '25', '20', '30', '5', '5');
        if (!empty($judul)) $mpdf->pdf->writeHTML($judul);
        $mpdf->pdf->WriteHTML($isi);
        $mpdf->pdf->Output();
    }
    public function pdf_nd($id_surat = null)
    {
        $data = $this->model_approval->get_surat_by_id($id_surat);
        // echo "<pre>";
        // print_r($data);
        // print_r($id_surat);

        $print = '';
        // return;
        $dataf = $this->model_approval->getpenerimaalias($id_surat, 2)->result();

        foreach ($dataf as $rowf) {
            $print .= $rowf->nm_alias . ' Perum DAMRI<br>';
        }
        $datas = $this->model_approval->getpenerimaeks(null, null, null, $id_surat, 1)->result();
        foreach ($datas as $rows) {
            $print .= $rows->nm_surat_external . ' Perum DAMRI<br>';
        }

        $cRet = '<br><table border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <tbody>
            <tr>
                <td colspan="3" style="text-align:center">
                <p><span style="font-family:Tahoma,Geneva,sans-serif"><strong><u><span style="font-size:20px;letter-spacing: 3px;">' . $data['nm_type_surat'] . '</span></u></strong></span></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Nomor :&nbsp; 99999 </span></span></td>
            </tr>
            <tr>
                <td style="width:100px">&nbsp;</td>
                <td style="width:2px">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="width:100px" valign="top"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">Kepada Yth&nbsp;</span></span></td>
                <td style="width:2px" valign="top"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">:&nbsp; </span></span></td>
                <td><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"> ' . $print . '</span></span></td>
            </tr>
            <tr>
                <td><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">Dari</span></span></td>
                <td><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">:&nbsp; </span></span></td>
                <td><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"> ' . $data['nm_akun'] . ' Perum DAMRI </span></span></td>
            </tr>
            <tr>
                <td><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">Perihal</span></span></td>
                <td><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">:&nbsp; </span></span></td>
                <td><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif">' . $data['perihal'] . '</span></span></td>
            </tr>
            <tr>
                <td colspan="3">
                <hr />
                <p>&nbsp;</p>
                </td>
            </tr>
        </tbody>
    </table>

    ';
        $cRet .= $data['isi_surat'];

        $cRet .= '<table align="right" border="0" cellpadding="1" cellspacing="1" style="width:300px">
                <tbody>
                    <tr>
                        <td style="text-align:center"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"><strong>Jakarta, 11/07/1999</strong></span></span></td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"><strong>' . $data['nm_akun'] . ' <br>PERUM DAMRI </strong></span></span></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                        <p>&nbsp;</p>';
        /* if($data['active'] == 4){
							$cRet .= '<img alt="" src="'.base_url().'surat/qr/'.@$data['id_surat'].'" style="height:100px; width:100px" />';
						} */
        // if ($data['active'] == 4) {
        //     $cRet .= '<img alt="" src="' . base_url() . 'inbox_new/qr/' . @$data['id_surat'] . '" style="height:100px; width:100px" />';
        $cRet .= '<p style="font-size:10px;">Ditandatangani secara elektronik</p>';
        // }
        $cRet .= '</td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><span style="font-size:14px"><span style="font-family:Tahoma,Geneva,sans-serif"><strong>' . strtoupper($data['nm_pegawai']) . '</strong></span></span></td>
                    </tr>
                </tbody>
            </table>';

        $print2 = '';

        $dataf2 = $this->model_approval->getpenerimaalias($id_surat, 1)->result(); //tembusan

        foreach ($dataf2 as $rowf2) {
            $print2 .= '- ' . $rowf2->nm_alias . ' Perum DAMRI<br>';
        }
        $datas2 = $this->model_approval->getpenerimaeks(null, null, null, $id_surat, 2)->result(); //tembusan
        foreach ($datas2 as $rows2) {
            $print2 .= '- ' . $rows2->nm_surat_external . '<br>';
        }

        $countup = $this->model_approval->get_count_attacment(null, $id_surat); // total berkas
        if ($countup['recordsTotal'] == 0) {
            $print3 = '';
        } else {
            $print3 = $countup['recordsTotal'] . ' Berkas';
        }

        $cRet .= '<br><table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td style="text-align:left"><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">
                        Lampiran : ' . $print3 . '</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">
                        Tembusan :</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><span style="font-size:14px" valign="top"><span style="font-family:Tahoma,Geneva,sans-serif">
                        ' . $print2 . '</span></span>
                        </td>
                    </tr>
            </table>';

        $this->_mpdf('', $cRet, 10, 10, 10, 'P', $id_surat);
    }
public function test(){
    $data1 = array(
        array(
           'title' => 'My title' ,
           'name' => 'My Name 2' ,
           'date' => 'My date 2'
        ),
        array(
           'title' => 'Another title' ,
           'name' => 'Another Name 2' ,
           'date' => 'Another date 2'
        )
     );
    $data = $this->model_approval->get_waiting_approval(37)->result_array();
    echo "<pre>";
    print_r($data);
    echo "<br>";
    print_r($data1);

    return;
}
    public function ax_data_surat()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_akun = $this->input->post('id_akun');
                $status = $this->input->post('status');
                if($id_akun == null){
                    $get_akses = $this->model_approval->get_approval_akun()->result_array();
                    $akun = $get_akses[0]['id_akun']; // get approval berdasarkan akses akun ter atas
                }else{
                    $akun = $id_akun;  // get approval berdasarkan akses akun selected
                }

                // $surat_by_akun = $this->model_approval->get_approval_surat_login($akun['id_akun'])->result_array(); // get berdasarkan akses akun login
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_approval->getAllSuratByAkunApproval($length, $start, $cari['value'], $akun, $status)->result_array();
                $count = $this->model_approval->get_count_surat($cari['value'], $akun);

                echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data ,  'start' => $start, 'draw' => $draw,  'length' => $length , 'id_akun' =>  $akun));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');wi    ndow.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_kirim_surat_approval()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $id_surat = $this->input->post('id_surat');
            $proses_approval = $this->model_approval->getApprovalOnProses($id_surat)->row_array();
            $id_approval = $proses_approval['id_approval'];

            $data_approval1 = array(
                'status' => '3', //ganti status paraf 2 dari 'Proses Approval' menjadi 3 'Disetujui'
            );
            $data_approval2 = array(
                'status' => '2', //ganti status paraf 1 dari 'Waiting' menjadi 2 'Proses Approval'
            );

            $update_approval1 = $this->model_approval->update_status_approval_pertama($id_approval, $data_approval1); // update status proses approval yang sekarang menjadi di setujui

            // check apakah ada paraf / tanda tangan yang masih proses, kalau tidak , update status surat menjadi 3 disetujui
            $waiting_approval = $this->model_approval->get_waiting_approval($id_surat)->row_array();
            if(!empty($waiting_approval)){
                $nextApproval = $waiting_approval['id_approval']; // get approval berdasarkan akses akun ter atas

                $update_approval = $this->model_approval->update_status_approval_kedua($nextApproval, $data_approval2); // update status Waiting yang selanjutnya menjadi Proses Approval
            }

            log_surat('Update', 'Melakukan Approval Surat',$id_surat, $session['id_user']); //helper insert activity log surat

            echo json_encode(array('status' => 'success', 'pesan' => 'Berhasul Approve surat'));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_set_data()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_surat = $this->input->post('id_surat');
                $id_type_surat = $this->input->post('id_type_surat');
                $id_klasifikasi = $this->input->post('id_klasifikasi');
                $id_kategori = $this->input->post('id_kategori');
                $perihal = $this->input->post('perihal');
                $isi_surat = $this->input->post('isi_surat');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_surat' => $id_surat,
                    'id_type_surat' => $id_type_surat,
                    'id_klasifikasi' => $id_klasifikasi,
                    'id_kategori' => $id_kategori,
                    'perihal' => $perihal,
                    'isi_surat' => $isi_surat,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );

                if (empty($id_surat))
                    $data['id_surat'] = $this->model_approval->insert_surat($data);
                else
                    $data['id_surat'] = $this->model_approval->update_surat($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_reject_surat()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);

            if (!empty($access['id_menu_details'])) {

                $id_surat = $this->input->post('id_surat');
                $data_approval = $this->model_approval->get_waiting_approval($id_surat)->result_array();

                $data = array('id_surat' => $id_surat);

                if (!empty($id_surat)){
                    $data['id_surat'] = $this->model_approval->reject_surat_approval($data);
                    $data['reset_approval'] = $this->model_approval->reject_surat_reset_approval($data);
                    $data['approval'] = $data_approval;
                }
                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_unset_data()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_surat = $this->input->post('id_surat');

                $data = array('id_surat' => $id_surat);

                if (!empty($id_surat))
                    $data['id_surat'] = $this->model_approval->delete_surat($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_get_data_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_surat = $this->input->post('id_surat');

                if (empty($id_surat))
                    $data = array();
                else
                    $data = $this->model_approval->get_surat_by_id($id_surat);

                echo json_encode($data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    // ---------------------- # END SURAT ------------------------------------

    // ---------------------- # ATTACHMENT -----------------------------------

    public function ax_data_attachment()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $id_surat =  $this->input->post('id_surat');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_approval->getAllattachment($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_approval->get_count_attachment($cari['value']);

            echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_surat_upload_attachment()
    {

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            // $menu_kd_menu_details = "S27";  //custom by database
            // $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            // if (!empty($access['id_menu_details'])) {

            $config['upload_path'] = "./uploads/surat/"; //path folder file upload
            $config['allowed_types'] = 'pdf|docx|doc|xlsx|xls|pptx|ppt|png|jpeg|jpg'; //type file yang boleh di upload
            $config['encrypt_name'] = TRUE; //enkripsi file name upload

            $this->load->library('upload', $config); //call library upload 
            if ($this->upload->do_upload("file")) { //upload file

                // print_r($this->upload->display_errors());

                $data = array('upload_data' => $this->upload->data()); //ambil file name yang diupload
                // print_r($data);
                // return;
                $id_surat = $this->input->post('id_surat_attach'); //get id surat selected
                $nm_attachment = $this->input->post('nm_attachment'); //get judul file
                $upload = $data['upload_data']['file_name']; //set file name ke variable image

                $session = $this->session->userdata('login');
                $data = array(
                    'id_surat' => $id_surat,
                    'nm_attachment' => $nm_attachment,
                    'attachment' => $upload,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_surat'] = $this->model_approval->insert_attachment($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            }

            // } else {
            //     echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            // }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_unset_data_attachment()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_surat_attachment = $this->input->post('id_surat_attachment');
            $attachment = $this->input->post('attachment');

            $data = array('id_surat_attachment' => $id_surat_attachment);

            if (!empty($id_surat_attachment)){
                $data['id_surat_attachment'] = $this->model_approval->delete_attachment($data);

                if($data['id_surat_attachment'] == TRUE ){
                    unlink(FCPATH."/uploads/surat/".$attachment);
                }
            }

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    // ---------------------- # END ATTACHMENT -------------------------------

    //----------------------- # APPROVAL -------------------------------------

    public function ax_data_approval()
    {

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $id_surat =  $this->input->post('id_surat');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_approval->getAllapproval($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_approval->get_count_approval($cari['value']);

            echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_set_data_approval()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_approval = $this->input->post('id_approval');
            $type_approval = $this->input->post('type_approval');
            $id_bu = $this->input->post('id_bu');
            $id_akun = $this->input->post('id_akun');
            $id_surat = $this->input->post('id_surat');
            $session = $this->session->userdata('login');
            $check_paraf = $this->model_approval->check_count_paraf($id_surat)->row_array(); //check paraf
            $check_approval = $this->model_approval->check_count_approval($id_surat)->row_array(); // check approval
            if ($type_approval == 2) {

                if ($check_approval['recordsApproval'] > 0) {
                    echo json_encode(array('status' => 'error', 'pesan' => 'Approval hanya untuk 1 orang !'));
                    return;
                }
            }

            // if ($check_paraf['recordsParaf'] == 0) {
            //     if ($type_approval == 2) {
            //         echo json_encode(array('status' => 'error', 'pesan' => 'Input Paraf Terlebih Dahulu !'));
            //         return;
            //     }
            // }


            $data = array(
                'id_approval' => $id_approval,
                'type_approval' => $type_approval,
                'id_akun' => $id_akun,
                'active' => '1',
                'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user'],
                'id_surat' => $id_surat

            );

            if (empty($id_approval)){
                $data['id_approval'] = $this->model_approval->insert_approval($data);

            }else{
                $data = array(
                    'id_approval' => $id_approval,
                    'type_approval' => $type_approval,
                    'id_akun' => $id_akun,
                    // 'active' => '1',
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user'],
                    'id_surat' => $id_surat
    
                );
                $data['id_approval'] = $this->model_approval->update_approval($data);

            }

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_get_data_approval_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_approval = $this->input->post('id_approval');

            if (empty($id_approval))
                $data = array();
            else
                $data = $this->model_approval->get_approval_by_id($id_approval);

            echo json_encode($data);
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_unset_data_approval()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_approval = $this->input->post('id_approval');

            $data = array('id_approval' => $id_approval);

            if (!empty($id_approval))
                $data['id_approval'] = $this->model_approval->delete_approval($data);

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }



    //---------------------- # END APPROVAL ------------------------------


    //---------------------- # PENERIMA INTERNAL -------------------------
    public function ax_data_surat_internal()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $id_surat = $this->input->post('id_surat');
            $data = $this->model_approval->getAllsurat_internal($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_approval->get_count_surat_internal($cari['value']);

            echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_set_data_internal()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $id_surat_alias = $this->input->post('id_surat_alias');
            $id_alias = $this->input->post('id_alias');
            $id_surat = $this->input->post('id_surat');
            $type_penerima = $this->input->post('type_penerima');
            $session = $this->session->userdata('login');
            $data = array(
                'id_surat_alias' => $id_surat_alias,
                'id_alias' => $id_alias,
                'id_perusahaan' => $session['id_perusahaan'],
                'id_surat' => $id_surat,
                'type_penerima' => $type_penerima,
                'active' => 1,
                'cuser' => $session['id_user']
            );

            if (empty($id_surat_alias))
                $data['id_surat_alias'] = $this->model_approval->insert_surat_internal($data);
            else
                $data['id_surat_alias'] = $this->model_approval->update_surat_internal($data);

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_unset_data_internal()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_surat_alias = $this->input->post('id_surat_alias');

            $data = array('id_surat_alias' => $id_surat_alias);

            if (!empty($id_surat_alias))
                $data['id_surat_alias'] = $this->model_approval->delete_surat_internal($data);

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_get_data_internal_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $id_surat_internal = $this->input->post('id_surat_internal');

            if (empty($id_surat_internal))
                $data = array();
            else
                $data = $this->model_approval->get_surat_internal_by_id($id_surat_internal);

            echo json_encode($data);
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    //---------------------- # END PENERIMA INTERNAL ---------------------


    //---------------------- # PENERIMA EXTERNAL -------------------------


    public function ax_data_surat_external()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $id_surat = $this->input->post('id_surat');
            $data = $this->model_approval->getAllsurat_external($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_approval->get_count_surat_external($cari['value']);

            echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_set_data_external()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_surat_external = $this->input->post('id_surat_external');
            $type_penerima = $this->input->post('type_penerima');
            $nm_surat_external = $this->input->post('nm_surat_external');
            $email_surat_external = $this->input->post('email_surat_external');
            $id_surat = $this->input->post('id_surat');
            $session = $this->session->userdata('login');
            $data = array(
                'id_surat_external' => $id_surat_external,
                'id_surat' => $id_surat,
                'type_penerima' => $type_penerima,
                'nm_surat_external' => $nm_surat_external,
                'email_surat_external' => $email_surat_external,
                'active' => 1,
                'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
            );

            if (empty($id_surat_external))
                $data['id_surat_external'] = $this->model_approval->insert_surat_external($data);
            else
                $data['id_surat_external'] = $this->model_approval->update_surat_external($data);

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_unset_data_external()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_surat_external = $this->input->post('id_surat_external');

            $data = array('id_surat_external' => $id_surat_external);

            if (!empty($id_surat_external))
                $data['id_surat_external'] = $this->model_approval->delete_surat_external($data);

            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_get_data_external_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');


            $id_surat_external = $this->input->post('id_surat_external');

            if (empty($id_surat_external))
                $data = array();
            else
                $data = $this->model_approval->get_surat_external_by_id($id_surat_external);

            echo json_encode($data);
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    //---------------------- # END PENERIMA EXTERNAL ---------------------

}
