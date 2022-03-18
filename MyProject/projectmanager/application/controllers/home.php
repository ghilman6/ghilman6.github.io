<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_menu");
        $this->load->model("model_home");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $data['nm_user'] = $session['nm_user'];
            // $data['keterangan'] = $session['keterangan'];
            $data['id_user'] = $session['id_user'];
            $data['session_level'] = $session['id_level'];


            $this->load->view('welcomeall', $data);
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function dashboard()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $data['nm_user'] = $session['nm_user'];
            // $data['keterangan'] = $session['keterangan'];
            $data['id_user'] = $session['id_user'];
            $data['session_level'] = $session['id_level'];
            // $data['datapaketchartweek'] = $this->model_home->datapaketchartweek();
            // $data['datarevenuechartmonth'] = $this->model_home->datarevenuechartmonth();
            $data['data_tipe_surat'] =  $this->model_home->data_grafik_tipe_surat();
            // echo '<pre>';
            // print_r($data['data_tipe_surat']);
            // return;

            $this->load->view('home', $data);
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function ax_get_grafik_tipe_surat()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            // $startDateTipeSurat = '2022-01-01';
            // $endDateTipeSurat = '2022-01-19';
            $startDateTipeSurat = $this->input->post('startDateTipeSurat');
            $endDateTipeSurat = $this->input->post('endDateTipeSurat');
            $dataGrafik = $this->model_home->data_grafik_tipe_surat($startDateTipeSurat, $endDateTipeSurat);
            // print_r($dataGrafik);
            // return;
            echo json_encode(array('status' => 'success', 'data' => json_decode($dataGrafik)));
        } else {
            echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
        }
    }


    public function Update()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $a = $this->input->post('password_lama');
            $b = $this->input->post('password_baru');
            if (empty($a) or empty($b)) {
                echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
            } else {
                $c = do_hash($this->input->post('password_lama'), 'md5');
                $d = $session['password'];
                if ($d != $c) {
                    echo "<script>alert('Password Lama Salah');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                    $id_user = $session['id_user'];
                    $data = array(

                        'password' => do_hash($this->input->post('password_baru'), 'md5'),

                    );
                    $this->model_home->UpdateUser($id_user, $data);
                    redirect('welcome/logout');
                }
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function get_data_dashboard()
    {

        $count = $this->model_home->countdata();
        $data = $this->model_home->getdata()->result_array();

        echo json_encode(array('ccheckin' => $count['ccheckin'], 'cwloading' => $count['cwloading'], 'cloading' => $count['cloading'], 'cdelivery' => $count['cdelivery'], 'data' => $data, 'recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => 1, 'search' => ''));
    }
}
