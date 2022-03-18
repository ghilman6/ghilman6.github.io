<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_welcome");
    }

    public function index()
    {
        $data['alert'] = "";
        $this->load->view('login', $data);
        //jika seasson login belum sudah ada maka tampilkan home
        if ($this->session->userdata('login')) {
            //jika seasson ada direct ke home
			#$datax['jmlpaketmasuk'] = $this->model_welcome->jmlpaketmasuk();
			#$datax['jmlbelumdikirim'] = $this->model_welcome->jmlbelumdikirim();
			#$datax['jmlbulanini'] = $this->model_welcome->jmlbulanini();
			#$datax['jmltahunini'] = $this->model_welcome->jmltahunini();
			#$this->load->view('home', $datax);
            redirect('home', 'refresh');
        }
    }
	
	public function cekresi()
    {
		$resi = $this->input->post('resi');
		
		if(empty($resi)){
			$this->load->view('cekresi');
		}else{
			$data['detail']   = $this->model_welcome->detailresi($resi);
			$data['timeline'] = $this->model_welcome->timelineresi($resi);
			$data['noresi'] = $resi;
			$data['counter'] = $this->model_welcome->counter($resi);
			$this->load->view('cekresi',$data);
		}
    }

    public function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('survei');
        redirect('welcome', 'refresh');
    }

    public function relogin()
    {
        if (!empty($this->input->get('url'))) {
            $data['url'] = $this->input->get('url');
            $pecah = explode(' ', $data['url']);

            if (count($pecah)>0) {
                $data['url'] = $pecah[0].'/';
                for ($x=1;$x<count($pecah);$x++) {
                    $data['url'] .= $pecah[$x].'/';
                }
            } else {
                $data['url'] = $data['url'];
            }
            // print_r($data['url']);die;
            $data['alert'] = "Silahkan login kembali";
            $this->load->view('login', $data);
            //jika seasson login belum sudah ada maka tampilkan home
            if ($this->session->userdata('login')) {
                //jika seasson ada direct ke home
                redirect('home', 'refresh');
            }
        } else {
            $data['alert'] = "Silahkan login kembali";
            $this->load->view('login', $data);

            //jika seasson login belum sudah ada maka tampilkan home
            if ($this->session->userdata('login')) {
                //jika seasson ada direct ke home
                redirect('home', 'refresh');
            }
        }
    }

    public function faillogin()
    {
        $data['alert'] = "Username atau Password tidak valid. Silahkan login kembali";
        $this->load->view('login', $data);

        //jika seasson login belum sudah ada maka tampilkan home
        if ($this->session->userdata('login')) {
            //jika seasson ada direct ke home
            redirect('home', 'refresh');
        }
    }

   

   
}
