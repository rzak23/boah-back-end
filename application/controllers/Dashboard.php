<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$point = $this->outh->cek_point();
		$key = $this->session->userdata('keyd');
		if($point != NULL){
			if($key != $point['secret_key']){
				$msg = "Silahkan login terlebih dahulu";
				$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');
				redirect('login');	
			}
		}else{
			$msg = "Silahkan login terlebih dahulu";
			$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');
			redirect('login');
		}
	}

	public function index(){
		echo 'berhasil\n';
		echo '<a href="'.site_url('logout').'">Logout</a>';
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */