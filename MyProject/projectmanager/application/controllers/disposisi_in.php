<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class disposisi_in extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_disposisi_in");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['combobox_akses_akun'] = $this->model_disposisi_in->combobox_akses_akun();
                $data['combobox_penerima_internal'] = $this->model_disposisi_in->combobox_penerima_internal();

                $this->load->view('disposisi_in/index', $data);
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

    public function ax_data_surat()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $id_akun = $this->input->post('id_akun');
                $filter = $this->input->post('filter');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_disposisi_in->getAllSurat($length, $start, $cari['value'], $id_akun)->result_array();
                $count = $this->model_disposisi_in->get_count_surat($cari['value'], $id_akun);

                echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
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
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_surat = $this->input->post('id_surat');

                if (empty($id_surat))
                    $data = array();
                else
                    $data = $this->model_disposisi_in->get_surat_by_id($id_surat);

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

    public function ax_data_approval()
    {

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_surat =  $this->input->post('id_surat');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_disposisi_in->getAllapproval($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_disposisi_in->get_count_approval($id_surat, $cari['value']);

            echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
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

    public function test(){
        $data = $this->model_disposisi_in->combobox_penerima_internal()->result_array();
        echo "<pre>";
        print_r($data);
        return;
    }

    public function ax_data_attachment()
    {
        
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $id_surat =  $this->input->post('id_surat');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_disposisi_in->getAllattachment($id_surat, $length, $start, $cari['value'])->result_array();
                $count = $this->model_disposisi_in->get_count_attachment($id_surat, $cari['value']);
    
                echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
                
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
	public function ax_upload_note_disposisi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_disposisi = $this->input->post('id_disposisi');
                $nm_note = $this->input->post('nm_note');

                $data_note = array(
                    'id_disposisi' => $id_disposisi,
                    'nm_note' => $nm_note,
                    'active' => 1,
                    'cuser' => $session['id_user'],
                    'id_perusahaan' => $session['id_perusahaan'],
                );
                $data_note['id_disposisi_note'] = $this->model_disposisi_in->insert_disposisi_note($data_note);  // insert disposisi note

                echo json_encode(array('status' => 'success', 'data' => $data_note['id_disposisi_note']));

        } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url.' '.$this->uri->segment(2);
                $url = $url.' '.$this->uri->segment(3);
                redirect('welcome/relogin/?url='.$url.'', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
    public function ax_data_disposisi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $id_surat = $this->input->post('id_surat');
                $id_akun = $this->input->post('id_akun');

				$start = $this->input->post('start');
				$draw = $this->input->post('draw');
				$length = $this->input->post('length');
				$cari = $this->input->post('search', true);
				$data = $this->model_disposisi_in->getAlldisposisi($id_surat,$id_akun)->result_array();
				$count = $this->model_disposisi_in->get_count_disposisi($id_surat,$id_akun);
				echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url.' '.$this->uri->segment(2);
                $url = $url.' '.$this->uri->segment(3);
                redirect('welcome/relogin/?url='.$url.'', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
	public function get_selected_dispo($id_disposisi = null){	
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
				$data = $this->model_disposisi_in->get_selected_dispo($id_disposisi)->result_array();
				echo json_encode(array('data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url.' '.$this->uri->segment(2);
                $url = $url.' '.$this->uri->segment(3);
                redirect('welcome/relogin/?url='.$url.'', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    
		
	}

	public function get_chatdispo(){	
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $id_disposisi = $this->input->post('id_disposisi');
				// $start = $this->input->post('start');
				// $draw = $this->input->post('draw');
				// $length = $this->input->post('length');
				// $cari = $this->input->post('search', true);
				$data = $this->model_disposisi_in->get_chatdispo($id_disposisi)->result_array();
                $note = '';
                foreach($data as $c){
                    if($c['cuser'] != $session['id_user']){ //incoming
                        $note .= '
                        <div class="incoming_msg">
                            <div class="incoming_msg_img"> 
                                <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                            </div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p>'.$c['nm_note'].'</p>
                                    <span class="time_date">'.$c['cdate'].'    |    '.$c['nm_user'].'</span>
                                </div>
                            </div>
                        </div>
                        ';
                    }else{ // outgoing
                        $note .= '
                        <div class="outgoing_msg">
                            <div class="sent_msg">
                                <p>'.$c['nm_note'].'</p>
                                <span class="time_date">'.$c['cdate'].'    |    Saya</span> 
                            </div>
                        </div>
                        ';
                    }

                }
                echo json_encode(array('status' => 'success', 'data' => $note));
				// $count = $this->model_disposisi_in->get_count_chatdispo($cari['value'], $id_disposisi);
				// echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url.' '.$this->uri->segment(2);
                $url = $url.' '.$this->uri->segment(3);
                redirect('welcome/relogin/?url='.$url.'', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    
		
	}
}
