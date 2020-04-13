<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mo_Auth extends CI_Model {

	public function cek_user($id,$table){
		$this->db->where('username',$id);
		$this->db->or_where('email',$id);
		return $this->db->get($table)->row_array();
	}

	public function create_id(){
		$this->db->select('Right(user.id_user,4) as kode ',false);
        $this->db->order_by('id_user', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('user');
        if($query->num_rows()<>0){
            $data = $query->row();
            $kode = intval($data->kode)+1;
        }else{
            $kode = 1;

        }
       	$kodemax = str_pad($kode,4,"0",STR_PAD_LEFT);
        $kodejadi  = "RGUB-".$kodemax;
        return $kodejadi;
	}

	public function create_idt($user){
		$key = bin2hex($this->encryption->create_key(24));
		$agent = $this->agent->browser();

		$data = [
			'id_user' => $user,
			'for_agent' => $agent,
			'secret_key' => $key
		];
		$this->db->insert('user_point',$data);
		return $key;
	}

	public function register_user($data,$table){
		$user = [
			'id_user' => $data['id_user'],
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => $data['password']
		];
		$this->db->insert($table,$user);

		$this->create_detail($data['id_user'],$data['nama']);
	}

	private function create_detail($id,$nama){
		$detail = [
			'id_user' => $id,
			'nama_user' => $nama
		];
		$this->db->insert('user_data',$detail);
	}

	public function add_token($key,$email){
		$data = [
			'email' => $email,
			'token' => $key
		];
		$this->db->insert('user_verify',$data);
	}

	public function cek_mail($email,$table){
		$this->db->where('email',$email);
		return $this->db->get($table)->row_array();
	}

	public function confirm($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
		$this->deleted_token($where);
	}

	private function deleted_token($where){
		$this->db->where($where);
		$this->db->delete('user_verify');
	}

	public function destroy(){
		$id = $this->session->userdata('id');
		$this->db->where('id_user',$id);
		$this->db->delete('user_point');
	}

	public function cek_point(){
		$user = $this->session->userdata('id');
		$this->db->where('id_user',$user);
		return $this->db->get('user_point')->row_array();
	}

}

/* End of file Mo_Auth.php */
/* Location: ./application/models/Mo_Auth.php */