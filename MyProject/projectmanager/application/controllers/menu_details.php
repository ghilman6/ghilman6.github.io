<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Menu_details extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_menu_details");
        $this->load->model("model_menu");
    }
    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S05";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];
                $data['combo_menu_groups'] = $this->model_menu_details->combobox_menu_groups();
                $data['listmenu_details'] = $this->model_menu_details->getAllmenu_details();
                $this->load->view('menu_details/index', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function Insert()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S05";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $a = $this->input->post('nm_menu_details');
                $b = $this->input->post('url');
                $c = $this->input->post('position');
                if (empty($a)or (empty($b)or (empty($c)))) {
                    echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                    $data = array(

        'nm_menu_details' => $this->input->post('nm_menu_details'),
        'kd_menu_details' => $this->input->post('kd_menu_details'),
        'url' => $this->input->post('url'),
        'active' => $this->input->post('active'),
        'position' => $this->input->post('position'),
        'id_menu_groups' => $this->input->post('id_menu_groups'),
        'cuser' => $session['id_perusahaan']

        );
                    // print_r($data);die;
                    $this->model_menu_details->Insertmenu_details($data);

                    redirect('menu_details');
                }
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function Delete($id_menu_details)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S05";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $this->model_menu_details->Deletetmenu_details($id_menu_details);
                redirect('menu_details');
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function FormUpdate($id_menu_details)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S05";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];
                $data['combo_menu_groups'] = $this->model_menu_details->combobox_menu_groups();
                $data['listmenu_detailsselect'] = $this->model_menu_details->getAllmenu_detailsselect($id_menu_details);
                $this->load->view('menu_details/update', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function Update()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S05";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $a = $this->input->post('nm_menu_details');
                $b = $this->input->post('url');
                $c = $this->input->post('position');
                if (empty($a)or (empty($b)or (empty($c)))) {
                    echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                    $id_menu_details = $this->input->post('id_menu_details');
                    $data = array(

        'nm_menu_details' => $this->input->post('nm_menu_details'),
        'kd_menu_details' => $this->input->post('kd_menu_details'),
        'url' => $this->input->post('url'),
        'active' => $this->input->post('active'),
        'position' => $this->input->post('position'),
        'id_menu_groups' => $this->input->post('id_menu_groups')
        );
                    $this->model_menu_details->Updatemenu_details($id_menu_details, $data);
                    redirect('menu_details');
                }
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function ax_data_menu_details()
    {
        $start = $this->input->post('start');
        $draw = $this->input->post('draw');
        $length = $this->input->post('length');
        $cari = $this->input->post('search');
        $data = $this->model_menu_details->getAllmenu_details($length, $start, $cari['value'])->result_array();
        $count = $this->model_menu_details->getAllmenu_details(null, null, $cari['value'])->num_rows();

        array($cari);

        echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=>$cari['value'], 'data'=>$data));
    }
}
