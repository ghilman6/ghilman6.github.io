<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Perusahaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_perusahaan");
        $this->load->model("model_menu");
    }

    /* public function index()
    {
        if($this->session->userdata('login'))
        {
        $session = $this->session->userdata('login');
        $menu_kd_menu_details = "M01";
        $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
        if(!empty($access['id_menu_details'])){
        $data['nm_user'] = $session['nm_user'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];
        $this->load->view('perusahaan/index', $data);
        }else{
        echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
        }
        }else{
        redirect('welcome/relogin','refresh');
        }

    }

    Public function Insert(){
        if($this->session->userdata('login')){
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if(!empty($access['id_menu_details'])){
                $a = $this->input->post ('nm_perusahaan');
                if (empty($a)) {
                    echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                        $config['upload_path']          = './uploads/';
                        $config['allowed_types']        = 'png';
                        $config['max_size']             = 100;
                        $config['max_width']            = 1024;
                        $config['max_height']           = 768;
                        $config['file_name']			= date('dmYhis');

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('berkas')){
                            $error = array('error' => $this->upload->display_errors());
                            echo $error['error'];
                        }else{
                            $filename = $this->upload->data();
                            $data = array(
                                'id_perusahaan' => $this->input->post ('id_perusahaan'),
                                'nm_perusahaan' => $this->input->post ('nm_perusahaan'),
                                'jenis' => $this->input->post ('jenis'),
                                'cuser' => $session['id_user'],
                                'active' => $this->input->post ('active'),
                                'alamat' => $this->input->post ('textarea_address'),
                                'telp' => $this->input->post ('text_phone_number'),
                                'logo' => $filename['file_name']
                            );
                            $this->model_perusahaan->Insertperusahaan($data);
                            redirect('perusahaan');
                        }
                }
            }else{
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        }else{
            redirect('welcome/relogin','refresh');
        }
    }

    Public function Delete($id_perusahaan)
    {
        if($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if(!empty($access['id_menu_details'])) {
                $folder ='./uploads/';
                $img = $this->model_perusahaan->getAllperusahaanselect($id_perusahaan)->row_array();
                @unlink($folder.$img['logo']);
                $this->model_perusahaan->Deletetperusahaan($id_perusahaan);
                redirect('perusahaan');
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin','refresh');
        }
    } */

    public function FormUpdate()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $id_perusahaan = $session['id_perusahaan'];
            $menu_kd_menu_details = "M01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                ;
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];
                $data['listperusahaanselect'] = $this->model_perusahaan->getAllperusahaanselect($id_perusahaan);
                $this->load->view('perusahaan/update', $data);
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
            $menu_kd_menu_details = "M01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $a = $this->input->post('nm_perusahaan');
                if (empty($a)) {
                    echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                    $id_perusahaan = $session['id_perusahaan'];
                    if (empty($_FILES["photo"]['name'])) {
                        $data = array(

                            'nm_perusahaan' => $this->input->post('nm_perusahaan'),
                            'cuser' => $session['id_user'],
                            'alamat' => $this->input->post('textarea_address'),
                            'telp' => $this->input->post('text_phone_number'),
                            'fifo' => $this->input->post('fifo'),
                            'fefo' => $this->input->post('fefo'),
                            'best' => $this->input->post('best'),
                            'alloc' => $this->input->post('alloc')
                        );
                        $this->model_perusahaan->Updateperusahaan($id_perusahaan, $data);
						redirect('perusahaan/formupdate');
                    } else {
                        $config['upload_path']          = './uploads/';
                        $config['allowed_types']        = 'png';
                        $config['max_size']             = 100;
                        $config['max_width']            = 500;
                        $config['max_height']           = 500;
                        $config['file_name']            = do_hash(date('dmYhis'), 'md5');

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('photo')) {
                            $error = array('error' => $this->upload->display_errors());

                            echo "<script>alert('".$error['error']."');window.location.href='javascript:history.back(-1);'</script>";
                        } else {
                            $folder ='./uploads/';
                            $img = $this->model_perusahaan->getAllperusahaanselect($id_perusahaan)->row_array();
                            @unlink($folder.$img['logo']);

                            $filename = $this->upload->data();
                            $data = array(

                            'nm_perusahaan' => $this->input->post('nm_perusahaan'),
                            'cuser' => $session['id_user'],
                            'alamat' => $this->input->post('textarea_address'),
                            'telp' => $this->input->post('text_phone_number'),
							'fifo' => $this->input->post('fifo'),
                            'fefo' => $this->input->post('fefo'),
                            'best' => $this->input->post('best'),
                            'alloc' => $this->input->post('alloc'),
                            'logo' => $filename['file_name']
                        );
                            $this->model_perusahaan->Updateperusahaan($id_perusahaan, $data);
                            redirect('perusahaan/formupdate');
                        }
                    }
                }
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    /* public function ax_data_perusahaan()
    {
        $start = $this->input->post ('start');
        $draw = $this->input->post ('draw');
        $length = $this->input->post ('length');
        $cari = $this->input->post ('search');
        $data = $this->model_perusahaan->getAllperusahaan($length, $start, $cari['value'])->result_array();
        $count = $this->model_perusahaan->getAllperusahaan()->num_rows();

        array($cari);

        echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=>$cari['value'], 'data'=>$data));

    } */

    public function add()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M01";
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['nm_user'] = $session['nm_user'];
                $data['id_user'] = $session['id_user'];
                $data['session_level'] = $session['id_level'];
                $data['listperusahaan'] = $this->model_perusahaan->getAllperusahaan();
                $this->load->view('perusahaan/add', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }
}
