<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class inbox extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_inbox");
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
                $data['combobox_akses_akun'] = $this->model_inbox->combobox_akses_akun();
                $data['combobox_penerima_internal'] = $this->model_inbox->combobox_penerima_internal();

                $this->load->view('inbox/index', $data);
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
                $data = $this->model_inbox->getAllSurat($length, $start, $cari['value'], $id_akun)->result_array();
                $count = $this->model_inbox->get_count_surat($cari['value'], $id_akun);

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
    public function ax_data_disposisi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $id_surat = $this->input->post('id_surat');

				$start = $this->input->post('start');
				$draw = $this->input->post('draw');
				$length = $this->input->post('length');
				$cari = $this->input->post('search', true);
				$data = $this->model_inbox->getAlldisposisi($id_surat)->result_array();
				$count = $this->model_inbox->get_count_disposisi($id_surat);
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
                    $data = $this->model_inbox->get_surat_by_id($id_surat);

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
            $data = $this->model_inbox->getAllapproval($id_surat, $length, $start, $cari['value'])->result_array();
            $count = $this->model_inbox->get_count_approval($id_surat, $cari['value']);

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
        $data = $this->model_inbox->combobox_penerima_internal()->result_array();
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
                $data = $this->model_inbox->getAllattachment($id_surat, $length, $start, $cari['value'])->result_array();
                $count = $this->model_inbox->get_count_attachment($id_surat, $cari['value']);
    
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
	public function ax_upload_data_disposisi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "E02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {


                $id_surat = $this->input->post('id_surat');
                $nm_note = $this->input->post('editornote');
				$id_alias = $this->input->post('id_alias');

				#Penerima disposisi
				$data_dispo = array(
					'id_surat' => $id_surat,
					'active' => '1',
					'id_perusahaan' => $session['id_perusahaan'],
					'cuser' => $session['id_user'],
				);
                $data_dispo['id_surat'] = $this->model_inbox->insert_disposisi_head($data_dispo); // insert ke tr_disposisi

				$id_dispo = $this->model_inbox->selectiddispo($id_surat); // select id disposisi dari tr_disposisi

                $data_note = array(
                    'id_disposisi' => $id_dispo['id_disposisi'],
                    'nm_note' => $nm_note,
                    'active' => 1,
                    'cuser' => $session['id_user'],
                    'id_perusahaan' => $session['id_perusahaan'],
                );
                $data_note['id_surat'] = $this->model_inbox->insert_disposisi_note($data_note);  // insert disposisi note


				$jmlid_alias = count($id_alias);
				for ($i = 0; $i < $jmlid_alias; $i++) {
					$data_alias = array(
						'id_disposisi' => $id_dispo['id_disposisi'],
						'id_alias' => $id_alias[$i],
						'type_disposisi' => '0',
						'cuser' => $session['id_user'],
						'id_perusahaan' => $session['id_perusahaan'],
						'active' => 1,
					);
					$data_alias['id_surat'] = $this->model_inbox->insert_disposisi_int($data_alias); // insert penerima disposisi
				}
				
                


                echo json_encode(array('status' => 'success', 'data' => $data_alias));


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
