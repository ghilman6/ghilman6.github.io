<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class task extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_activity");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['combobox_status'] = $this->model_activity->combobox_status();
                $data['combobox_program_detail'] = $this->model_activity->combobox_program_detail();
                $data['combobox_nm_program'] = $this->model_activity->combobox_nm_program();

                $this->load->view('task/index', $data);
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

    public function ax_data_status()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S11";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $filter = $this->input->post('filter');
                // if($id_akun == null){
                //     $get_akses = $this->model_surat->get_approval_akun()->result_array();
                //     $akun = $get_akses[0]['id_akun']; // get approval berdasarkan akses akun ter atas
                // }else{
                //     $akun = $id_akun;  // get approval berdasarkan akses akun selected
                // }

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_activity->getAllStatus($length, $start, $cari['value'],$filter)->result_array();
                $count = $this->model_activity->get_count_status($cari['value'],$filter);

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
    public function ax_get_program_detail(){
        $id_program = $this->input->post('id_program');
        $program_detail = $this->model_activity->get_detail_by_program($id_program)->result_array();
        $data = $this->model_activity->get_program_by_id($id_program);
        // print_r($program_detail);
        // return;
        $html= '';
        if(empty($program_detail)){
            $html .= '<option value="0">-- Pilih Activity --</option>';


        }else{
            foreach($program_detail as $a){
                $html .= '<option value="'.$a['nm_program_detail'].'"  >'.$a['nm_program_detail'].'</option>';
            }
        }

        echo json_encode(array('status' => 'success',  'html' => $html,'data'=> $data));

    }
    public function details($id_activity)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['id_activity'] = $id_activity;
                $data['session_level'] = $session['id_level'];
                // $data['combobox_status'] = $this->model_activity->combobox_status();

                $this->load->view('activity/details', $data);
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

    public function detailsatt($id_activity)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['id_activity'] = $id_activity;
                $data['session_level'] = $session['id_level'];
                $data['combobox_attachment'] = $this->model_activity->combobox_attachment();

                $this->load->view('task/detail_att', $data);
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

    public function pic($id_activity)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['id_activity'] = $id_activity;
                $data['session_level'] = $session['id_level'];
                // $data['combobox_user'] = $this->model_activity->combobox_user();

                $this->load->view('activity/pic', $data);
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

    public function pic_details($id_activity_detail)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['id_activity_detail'] = $id_activity_detail;
                $data['session_level'] = $session['id_level'];
                // $data['combobox_user'] = $this->model_activity->combobox_user();

                $this->load->view('activity/pic_details', $data);
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

    public function activity($id_activity_detail)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['id_activity_detail'] = $id_activity_detail;
                $data['session_level'] = $session['id_level'];

                $this->load->view('activity/activity', $data);
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


    public function ax_data_activity()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "TSK01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $tanggal = $this->input->post('tanggal');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_activity->getAllactivity($length, $start, $cari['value'],$tanggal)->result_array();
            $count = $this->model_activity->get_count_activity($cari['value'],$tanggal);

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

    public function ax_data_att()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "TSK01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $tanggal = $this->input->post('tanggal');
            $id_activity = $this->input->post('id_activity');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_activity->getAllactivityatt($length, $start,$cari['value'],$id_activity)->result_array();
            $count = $this->model_activity->get_count_activityatt($cari['value'], $id_activity);

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

    public function ax_data_activity_detail()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_activity->getAllactivity_detail($length, $start, $cari['value'], $id_activity)->result_array();
            $count = $this->model_activity->get_count_activity_detail($cari['value'], $id_activity);

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
	
    public function ax_data_pic()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_activity->getAllpic($length, $start, $cari['value'], $id_activity)->result_array();
            $count = $this->model_activity->get_count_pic($cari['value'], $id_activity);

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

    public function ax_data_pic_detail()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity_detail = $this->input->post('id_activity_detail');
            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_activity->getAllpic_detail($length, $start, $cari['value'], $id_activity_detail)->result_array();
            $count = $this->model_activity->get_count_pic_detail($cari['value'], $id_activity_detail);

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

    // public function ax_data_activity()
    // {
    //     if ($this->session->userdata('login')) {
    //         $session = $this->session->userdata('login');
    //         $menu_kd_menu_details = "PM01";  //custom by database
    //         $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
    //         if (!empty($access['id_menu_details'])) {

    //         $id_activity_detail = $this->input->post('id_activity_detail');
    //         $start = $this->input->post('start');
    //         $draw = $this->input->post('draw');
    //         $length = $this->input->post('length');
    //         $cari = $this->input->post('search', true);
    //         $data = $this->model_activity->getAllactivity($length, $start, $cari['value'], $id_activity_detail)->result_array();
    //         $count = $this->model_activity->get_count_activity($cari['value'], $id_activity_detail);

    //         echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
    //         } else {
    //             echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
    //         }
    //     } else {
    //         if ($this->uri->segment(1) != null) {
    //             $url = $this->uri->segment(1);
    //             $url = $url.' '.$this->uri->segment(2);
    //             $url = $url.' '.$this->uri->segment(3);
    //             redirect('welcome/relogin/?url='.$url.'', 'refresh');
    //         } else {
    //             redirect('welcome/relogin', 'refresh');
    //         }
    //     }
    // }

	public function ax_set_data()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
            $nm_activity = $this->input->post('nm_activity');
            $due = $this->input->post('due');
            $id_status = $this->input->post('id_status');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_activity' => $id_activity,
                'nm_activity' => $nm_activity,
                'due' => $due,
                'id_status' => $id_status,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
    		);
    		
    		if(empty($id_activity))
    			$data['id_activity'] = $this->model_activity->insert_activity($data);
    		else
    			$data['id_activity'] = $this->model_activity->update_activity($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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
	
    public function ax_set_details()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
            // ubah
            $id_activity = $this->input->post('id_activity');
            $id_activity_detail = $this->input->post('id_activity_detail');
            $nm_activity_detail = $this->input->post('nm_activity_detail');
            $due = $this->input->post('due');
            $id_status = $this->input->post('id_status');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_activity' => $id_activity,
                'id_activity_detail' => $id_activity_detail,
                'nm_activity_detail' => $nm_activity_detail,
                'due' => $due,
                'id_status' => $id_status,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
    		);
    		
    		if(empty($id_activity_detail))
    			$data['id_activity_detail'] = $this->model_activity->insert_activity_detail($data);
    		else
    			$data['id_activity_detail'] = $this->model_activity->update_activity_detail($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_set_pic()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
            // ubah
            $id_activity = $this->input->post('id_activity');
            $id_pic = $this->input->post('id_pic');
            $id_user = $this->input->post('id_user');
            $id_bu = $this->input->post('id_bu');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_activity' => $id_activity,
                'id_pic' => $id_pic,
                'id_user' => $id_user,
                'id_bu' => $id_bu,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
    		);
    		
    		if(empty($id_pic))
    			$data['id_pic'] = $this->model_activity->insert_pic($data);
    		else
    			$data['id_pic'] = $this->model_activity->update_pic($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_set_pic_detail()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
            // ubah
            $id_activity_detail = $this->input->post('id_activity_detail');
            $id_pic = $this->input->post('id_pic');
            $id_user = $this->input->post('id_user');
            $id_bu = $this->input->post('id_bu');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_activity_detail' => $id_activity_detail,
                'id_pic' => $id_pic,
                'id_user' => $id_user,
                'id_bu' => $id_bu,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
    		);
    		
    		if(empty($id_pic))
    			$data['id_pic'] = $this->model_activity->insert_pic_detail($data);
    		else
    			$data['id_pic'] = $this->model_activity->update_pic_detail($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_set_activity()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
            // ubah
            $id_activity = $this->input->post('id_activity');
            $id_program = $this->input->post('id_program');
            $program_detail = $this->input->post('nm_program_detail');
            $keterangan= $this->input->post('keterangan');
            $id_status = $this->input->post('id_status');
            $cdate = $this->input->post('cdate');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_activity' => $id_activity,
                'id_program' => $id_program,
                'nm_program_detail' => $program_detail,
                'id_status' => $id_status,
                'keterangan' => $keterangan,
                'cdate' => $cdate,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan'],
                'cuser' => $session['id_user']
    		);
    		
    		if(empty($id_activity))
    			$data['id_activity'] = $this->model_activity->insert_activity($data);
    		else
    			$data['id_activity'] = $this->model_activity->update_activity($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_set_activityatt()
	{

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            // $menu_kd_menu_details = "PM01";  //custom by database
            // $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            // if (!empty($access['id_menu_details'])) {

            $config['upload_path'] = "./uploads/attachment/"; //path folder file upload
            $config['allowed_types'] = 'pdf|docx|doc|xlsx|xls|pptx|ppt|png|jpeg|jpg'; //type file yang boleh di upload
            $config['encrypt_name'] = TRUE; //enkripsi file name upload

            $this->load->library('upload', $config); //call library upload 
            if ($this->upload->do_upload("nm_file")) { //upload file

                // print_r($this->upload->display_errors());

                $data = array('upload_data' => $this->upload->data()); //ambil file name yang diupload
                // print_r($data);
                // return;
                $id_activity = $this->input->post('id_activity');
                $id_attachment = $this->input->post('id_attachment'); //get id surat selected
                $nm_file = $this->input->post('nm_file'); //get judul file
                $upload = $data['upload_data']['file_name']; //set file name ke variable image

                $session = $this->session->userdata('login');
                $data = array(
                    'id_activity' => $id_activity,
                    'id_attachment' => $id_attachment,
                    'nm_file' => $upload,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_attachment'] = $this->model_activity->insert_attachment($data);

                echo json_encode(array('status' => 'success', 'data' => $data, 'message' => 'Berhasil Upload'));
                return;
            }else{
                echo json_encode(array('status' => 'error', 'data' => null, 'message' => $this->upload->display_errors()));
                return;
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

	public function ax_unset_data()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
    		
    		$data = array('id_activity' => $id_activity);
    		
    		if(!empty($id_activity))
    			$data['id_activity'] = $this->model_activity->delete_activity($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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
	
    public function ax_unset_detail()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity_detail = $this->input->post('id_activity_detail');
    		
    		$data = array('id_activity_detail' => $id_activity_detail);
    		
    		if(!empty($id_activity_detail))
    			$data['id_activity_detail'] = $this->model_activity->delete_activity_detail($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_unset_pic()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_pic = $this->input->post('id_pic');
    		
    		$data = array('id_pic' => $id_pic);
    		
    		if(!empty($id_pic))
    			$data['id_pic'] = $this->model_activity->delete_pic($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_unset_pic_detail()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_pic = $this->input->post('id_pic');
    		
    		$data = array('id_pic' => $id_pic);
    		
    		if(!empty($id_pic))
    			$data['id_pic'] = $this->model_activity->delete_pic_detail($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_unset_activity()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "TSK01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
    		
    		$data = array('id_activity' => $id_activity);
    		
    		if(!empty($id_activity))
    			$data['id_activity'] = $this->model_activity->delete_activity($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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

    public function ax_unset_activityatt()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "TSK01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_activity = $this->input->post('id_activity');
    		
    		$data = array('id_activity' => $id_activity);
    		
    		if(!empty($id_activity))
    			$data['id_activity'] = $this->model_activity->delete_activityatt($data);
    		
    		echo json_encode(array('status' => 'success', 'data' => $data));

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
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_activity = $this->input->post('id_activity');
    		
    		if(empty($id_activity))
    			$data = array();
    		else
    			$data = $this->model_activity->get_activity_by_id($id_activity);
    		
    		echo json_encode($data);

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

    public function ax_get_data_detail_by_id()
	{
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_activity_detail = $this->input->post('id_activity_detail');
    		
    		if(empty($id_activity_detail))
    			$data = array();
    		else
    			$data = $this->model_activity->get_activity_detail_by_id($id_activity_detail);
    		
    		echo json_encode($data);

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

    public function ax_get_filter_task()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            // $startDateTipeSurat = '2022-01-01';
            // $endDateTipeSurat = '2022-01-19';
            $filterTglTask = $this->input->post('filterTglTask');
            $dataTask= $this->model_activity->data_tanggal_task($filterTglTask);
            // print_r($dataGrafik);
            // return;
            echo json_encode(array('status' => 'success', 'data' => json_decode($dataTask)));
        } else {
            echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
        }
    }

    public function ax_get_data_pic_by_id()
	{
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_pic = $this->input->post('id_pic');
    		
    		if(empty($id_pic))
    			$data = array();
    		else
    			$data = $this->model_activity->get_pic_by_id($id_pic);
    		
    		echo json_encode($data);

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

    public function ax_get_data_pic_detail_by_id()
	{
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_pic = $this->input->post('id_pic');
    		
    		if(empty($id_pic))
    			$data = array();
    		else
    			$data = $this->model_activity->get_pic_detail_by_id($id_pic);
    		
    		echo json_encode($data);

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

    public function ax_get_data_activity_by_id()
	{
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_activity = $this->input->post('id_activity');
    		
    		if(empty($id_activity))
    			$data = array();
    		else
    			$data = $this->model_activity->get_activity_by_id($id_activity);
    		
    		echo json_encode($data);

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

    public function ax_get_data_activityatt_by_id()
	{
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "PM01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_activity = $this->input->post('id_activity');
    		
    		if(empty($id_activity))
    			$data = array();
    		else
    			$data = $this->model_activity->get_activityatt_by_id($id_activity);
    		
    		echo json_encode($data);

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
