<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_validation extends CI_Controller
{
    public function index()
    {
        // load library form validasi , agar login kita lebih aman
        $this->load->library('form_validation');

        $this->load->helper('url'); // digunakan untuk fungsi redirect di bawah

        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|callback_check_database');
        // disini terdapat callback : callback_check_database. digunakan untuk memanggil function check_database() dibawah.
        //jika validasi gagal maka akan langsung akan dkembalikan ke login
        if ($this->form_validation->run() == false) {
            redirect('welcome/faillogin', 'refresh');
        } else {
            if ($this->input->post('url') != '') {
                redirect(base_url($this->input->post('url')), 'refresh');
            } else {
                redirect('welcome', 'refresh');
            }
        }
    }

    public function check_database()
    {
        $this->load->library('session');
        //validasi kedua dengan cara mengecek database
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        //query ke database dan memanggil model m_login
        $this->load->model('model_login');
        $result = $this->model_login->login($username, $password);

        //jika hasilnya ada pada maka masukan ke season field nama dan username dengan nama season : login
        if ($result) {
            foreach ($result as $row) {
                $sess_array = array(
                    'nm_user'=> $row->nm_user,
                    // 'keterangan'=> $row->keterangan,
                    'id_user'=> $row->id_user,
                    'username' => $row->username,
                    'password' => $row->password,
                    'id_level' => $row->id_level,
                    'id_bu' => $row->id_bu,
                    'id_perusahaan' => $row->id_perusahaan,
                    'nm_perusahaan' => $row->nm_perusahaan,
                    'active' => $row->active,
                     
                );

                $this->session->set_userdata('login', $sess_array);
            }
            return true;
        } else {
            return false;
        }
    }

   
}
