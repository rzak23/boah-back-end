<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){
		$this->form_validation->set_rules('uid','Uid','trim|required');
		$this->form_validation->set_rules('pass','Pass','trim|required|min_length[6]');

		if($this->form_validation->run() == FALSE){
			$this->load->view('login');
		}else{
			$this->proses_('masuk');
		}
	}

	public function register(){
		$this->form_validation->set_rules('nama','Nama','trim|required');
		$this->form_validation->set_rules('uname','Uname','trim|required|max_length[20]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('pass','Pass','trim|required|min_length[6]');

		if($this->form_validation->run() == FALSE){
			$this->load->view('register');
		}else{
			$this->proses_('daftar');
		}
	}

	private function proses_($param){
		if($param == "masuk"){
			$uid = htmlspecialchars($this->input->post('uid'));
			$pass = htmlspecialchars($this->input->post('pass'));

			$cek = $this->outh->cek_user($uid,'user');

			if($cek){
				if($cek['konfirmasi'] == "wait"){
					$msg = "Silahkan konfirmasi akun anda terlebih dahulu, cek kotak masuk email";
					$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

					redirect('login');
				}else{
					if($cek['status_user'] != "naktif"){
						if(password_verify($pass, $cek['password'])){
							$key = $this->outh->create_idt($cek['id_user']);
							$session = [
								'id' => $cek['id_user'],
								'username' => $cek['username'],
								'email' => $cek['email'],
								'path' => $cek['path'],
								'akses' => $cek['hak_akses'],
								'keyd' => $key
							];
							$this->session->set_userdata($session);

							redirect('dashboard');
						}else{
							$msg = "Password Salah";
							$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

							redirect('login');
						}
					}else{
						$msg = "User tidak terdaftar, silahkan lakukan registrasi terlebih dahulu";
						$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

						redirect('login');
					}
				}
			}else{
				$msg = "User tidak terdaftar, silahkan lakukan registrasi terlebih dahulu";
				$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

				redirect('login');
			}
		}elseif($param == "daftar"){
			$nama = htmlspecialchars($this->input->post('nama'));
			$uname = htmlspecialchars($this->input->post('uname'));
			$email = htmlspecialchars($this->input->post('email'));
			$pass = htmlspecialchars($this->input->post('pass'));

			$data = [
				'id_user' => $this->outh->create_id(),
				'nama' => $nama,
				'username' => $uname,
				'email' => $email,
				'password' => password_hash($pass, PASSWORD_DEFAULT),
				'konfirmasi' => "wait"
			];
			$this->outh->register_user($data,'user');

			$this->send_mail('register',$email);

			$msg = "Pendaftaran berhasil, silahkan konfirmasi akun terlebih dahulu, cek email";
			$this->session->set_flashdata('message','<div class="alert alert-success">'.$msg.'</div>');

			redirect('login');
		}
	}

	private function send_mail($param,$mail){
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.parekas.com';
		$config['smtp_user'] = 'no-reply@parekas.com';
		$config['smtp_pass'] = 'pis*ocdo^sPG';
		$config['smtp_port'] = 465;
		$config['smtp_crypto'] = 'ssl';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		if($param == "register"){
			$token = base64_encode(random_bytes(32));
			$this->outh->add_token($token,$mail);

			$msg = 'Terimakasih sudah mendaftarkan ke layanan kami, selanjutnya silahkan konfirmasi bahwa anda memang telah membuat akun ini dengan cara klik tombol konfirmasi dibawah. Jika anda tidak merasa melakukan pendaftaran silahkan abaikan pesan ini<br><br><a href="'.site_url('verify?email='.$mail.'&token='.urlencode($token)).'">Konfirmasi</a>';

			$this->email->from('no-reply@parekas.com','Notifikasi Boah');
			$this->email->subject('Verifikasi Akun');
			$this->email->to($mail);
			$this->email->message($msg);
			$this->email->send();
		}
	}

	public function konfirmasi(){
		$key = htmlspecialchars($this->input->get('token'));
		$email = htmlspecialchars($this->input->get('email'));

		$conf = $this->outh->cek_mail($email,'user_verify');
		if($conf){
			if($key == $conf['token']){
				$where = ['email' => $email];
				$data = ['konfirmasi' => "verify"];
				$this->outh->confirm($where,$data,'user');

				$msg = "Verifikasi berhasil, silahkan login";
				$this->session->set_flashdata('message','<div class="alert alert-success">'.$msg.'</div>');

				redirect('login');
			}else{
				$msg = "Tidak dapat memverikasi, karena identitas tidak dikenali";
				$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

				redirect('login');	
			}
		}else{
			$msg = "Email anda tidak terdaftar pada sistem";
			$this->session->set_flashdata('message','<div class="alert alert-danger">'.$msg.'</div>');

			redirect('login');
		}
	}

	public function logout(){
		$this->outh->destroy();

		$this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('path');
		$this->session->unset_userdata('akses');
		$this->session->unset_userdata('keyd');

		redirect('login');
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */