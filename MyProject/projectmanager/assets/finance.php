<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Finance extends CI_Controller {
	 function __construct(){
        parent::__construct();
        $this->load->model("model_finance");
        $this->load->model("model_menu");
        $this->load->helper('terbilang');
        }

	public function index()
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
        $data['nm_user_last'] = $session['nm_user_last'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];
		
		$this->load->view('finance/index', $data);
		}else{
		redirect('welcome/relogin','refresh');	
		}
		
	}

	public function angsuran()
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
        $data['nm_user_last'] = $session['nm_user_last'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];

        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
   	
		$data['listangsuran'] = $this->model_finance->getallangsuran($tahun, $bulan);
		
		$this->load->view('finance/list_angsuran', $data);
		}else{
		redirect('welcome/relogin','refresh');	
		}
		
	}

	public function kwitansi($id_angsuran)
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
        $data['nm_user_last'] = $session['nm_user_last'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];

		$data['angsuran'] = $this->model_finance->getangsuran($id_angsuran);
		
		$this->load->view('finance/kwitansi', $data);
		}else{
		redirect('welcome/relogin','refresh');	
		}
		
	}

	public function lunas()
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
        $data['nm_user_last'] = $session['nm_user_last'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];
		
		$this->load->view('finance/lunas', $data);
		}else{
		redirect('welcome/relogin','refresh');	
		}
		
	}

	public function list_lunas()
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
        $data['nm_user_last'] = $session['nm_user_last'];
        $data['id_user'] = $session['id_user'];
        $data['session_level'] = $session['id_level'];

        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
   	
		$data['listangsuran'] = $this->model_finance->getallangsuranlunas($tahun, $bulan);
		
		$this->load->view('finance/list_lunas', $data);
		}else{
		redirect('welcome/relogin','refresh');	
		}
		
	}

	Public function pelunasan($id_angsuran) 
	{
		if($this->session->userdata('login'))
        {
		$session = $this->session->userdata('login');
		$data = array(
		
   		'status' => 2,
   		'user_pelunasan' => $session['id_user'],
			
		);	
		$this->model_finance->updatepelunasan($id_angsuran, $data);
		echo "<script>alert('Pelunasan Berhasil');window.location.href='javascript:history.back(-1);'</script>";
		}else{
		redirect('welcome/relogin','refresh');	
		}
	}

	public function laporan_spk($id_pinjaman)
    {
    	$data['pinjaman'] = $this->model_operasional->getpinjamandetail($id_pinjaman);
    	
	    // Load the library
	    //$this->load->library('html2pdf');
	    
	    //Set folder to save PDF to
	    $this->html2pdf->folder('./assets/pdfs/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename("spk-$id_pinjaman.pdf");
	    
	    //Set the paper defaults
	    $this->html2pdf->paper('Legal', 'portrait');
	    
	   
	    
	    // Load html view
	   // $this->html2pdf->html($this->load->view('operasional/report_spk', $data, true));
	    
	    //if($this->html2pdf->create('download')) {
	    	//PDF was successfully saved or downloaded
	    //	echo 'PDF saved';
	    //}
	     $this->load->view('operasional/report_spk', $data);
    }

}