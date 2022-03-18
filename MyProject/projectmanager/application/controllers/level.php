<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_level");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $this->load->view('level/index', $data);
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

    

    public function formgroupakses($id_level)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];

                $data['level_id'] = $id_level;
                $this->load->view('level/groupakses', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function formdetailakses($id_level)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];

                $data['level_id'] = $id_level;
                $this->load->view('level/detailakses', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    

    public function ax_data_level()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $start = $this->input->post('start');
            $draw = $this->input->post('draw');
            $length = $this->input->post('length');
            $cari = $this->input->post('search', true);
            $data = $this->model_level->getAlllevel($length, $start, $cari['value'])->result_array();
            $count = $this->model_level->get_count_level($cari['value']);

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

    public function get_groupakses($id_level)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search');
                $data = $this->model_level->getGroupDetail($id_level, $length, $start, $cari['value'])->result_array();
                $count = $this->model_level->getGroupDetail($id_level, null, null, $cari['value'])->num_rows();

                array($cari);

                echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=>$cari['value'], 'data'=>$data));
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

    public function get_detailakses($id_level)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search');
                $data = $this->model_level->getMenuDetail($id_level, $length, $start, $cari['value'])->result_array();
                $count = $this->model_level->getMenuDetail($id_level, null, null, $cari['value'])->num_rows();
        
                array($cari);
        
                echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=>$cari['value'], 'data'=>$data));
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

    
	
	public function ax_set_data()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_level = $this->input->post('id_level');
            $nm_level = $this->input->post('nm_level');
    		$active = $this->input->post('active');
    		$session = $this->session->userdata('login');
    		$data = array(
                'id_level' => $id_level,
                'nm_level' => $nm_level,
    			'active' => $active,
    			'id_perusahaan' => $session['id_perusahaan']
    		);
    		
    		if(empty($id_level))
    			$data['id_level'] = $this->model_level->insert_level($data);
    		else
    			$data['id_level'] = $this->model_level->update_level($data);
    		
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
	
	public function ax_unset_data()
	{
		if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

            $id_level = $this->input->post('id_level');
    		
    		$data = array('id_level' => $id_level);
    		
    		if(!empty($id_level))
    			$data['id_level'] = $this->model_level->delete_level($data);
    		
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
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

    		$id_level = $this->input->post('id_level');
    		
    		if(empty($id_level))
    			$data = array();
    		else
    			$data = $this->model_level->get_level_by_id($id_level);
    		
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

    public function Updatecheck()
    {
        $id_menu_groups_access = $this->input->post('id_menu_groups_access');
        $data = array('active' => 1);
        $this->model_level->Updatemenu_group_access($id_menu_groups_access, $data);
    }

    public function Updatechecks()
    {
        $id_menu_groups_access = $this->input->post('id_menu_groups_access');
        $data = array('active' => 0);
        $this->model_level->Updatemenu_group_access($id_menu_groups_access, $data);
    }

    public function Updatecheck1()
    {
        $id_menu_groups_access = $this->input->post('id');
        foreach ($id_menu_groups_access as $id) {
            $data = array('active' => 0);
            $this->model_level->Updatemenu_group_access($id, $data);
        }
    }

    public function Updatechecks1()
    {
        $id_menu_groups_access = $this->input->post('id');
        foreach ($id_menu_groups_access as $id) {
            $data = array('active' => 1);
            $this->model_level->Updatemenu_group_access($id, $data);
        }
    }


    public function Updatecheckd()
    {
        $id_menu_details_access = $this->input->post('id_menu_details_access');
        $data = array('active' => 1);
        $this->model_level->Updatemenu_details_access($id_menu_details_access, $data);
    }

    public function Updatechecksd()
    {
        $id_menu_details_access = $this->input->post('id_menu_details_access');
        $data = array('active' => 0);
        $this->model_level->Updatemenu_details_access($id_menu_details_access, $data);
    }

    public function Updatecheck1d()
    {
        $id_menu_details_access = $this->input->post('id');
        foreach ($id_menu_details_access as $id) {
            $data = array('active' => 0);
            $this->model_level->Updatemenu_details_access($id, $data);
        }
    }

    public function Updatechecks1d()
    {
        $id_menu_details_access = $this->input->post('id');
        foreach ($id_menu_details_access as $id) {
            $data = array('active' => 1);
            $this->model_level->Updatemenu_details_access($id, $data);
        }
    }
}
