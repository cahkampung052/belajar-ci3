<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
        $this->load->helper(['url', 'view']);
		$this->load->model('user_model');

        // cek jika belum mempunyai session redirect ke login
        if($this->session->userdata('nama')) {
			// do nothing
		} else {
			redirect('login');
		}
	}

	public function index()
	{
		$data = $this->user_model->getAllUser();
		
		view('pages/user/daftar.html', [
			'baseUrl' => base_url(),
			'listUser' => $data,
			'sukses' => $this->session->flashdata('success') ?? null
		]);
	}

	public function create()
	{	
		$user = [
			'id' => '',
			'nama' => '',
			'email' => '',
			'password' => '' 
		];

		view('pages/user/form.html', [
			'baseUrl' => base_url(),
			'action' => base_url().'user/createAction',
			'tittle' => 'Tambah User Baru',
			'data' => $user,
			'error' => $this->session->flashdata('error') ?? null
		]);
	}

	public function createAction() {
		$data['nama'] = $this->input->post('nama') ?? '';
		$data['email'] = $this->input->post('email') ?? '';
		$data['password'] = sha1($this->input->post('password')) ?? '';

		// Validasi semua inputan harus diisi
		if(empty($data['nama']) || empty($data['nama']) || empty($data['nama'])){
			$this->session->set_flashdata('error', 'Data user gagal disimpan, pastikan semua textfield telah diisi');
			redirect('user/create');
		}

		$save = $this->user_model->create($data);

		if($save['status']) {
			$this->session->set_flashdata('success', 'Data user berhasil disimpan');
			redirect('user');
		}

		$this->session->set_flashdata('error', 'Data user gagal disimpan');
		redirect('user/create');
	}

	public function edit($id)
	{		
		$user = $this->user_model->getById($id);

		if(!isset($user->id)){
			return $this->load->view('errors/html/error_404', [
				'heading' => 'Ooops', 
				'message' => 'User yang kamu minta tidak terdaftar, Silahkan <a href="'.base_url('user').'"> klik di sini </a> untuk kembali'
			]);
		}

		// Hapus data password dari object yg diterima
		unset($user->password);
		print_r($user);

		view('pages/user/form.html', [
			'baseUrl' => base_url(),
			'action' => base_url().'user/editAction',
			'tittle' => 'Edit User : ' . $user->nama,
			'data' => (array) $user,
			'error' => $this->session->flashdata('error') ?? null
		]);
	}

	public function editAction() {
		$data['id'] = $this->input->post('id') ?? '';
		$data['nama'] = $this->input->post('nama') ?? '';
		$data['email'] = $this->input->post('email') ?? '';

		// Nama dan email tidak boleh kosong
		if(empty($data['nama']) || empty($data['nama']) || empty($data['id'])){
			$this->session->set_flashdata('error', 'Data user gagal disimpan, pastikan semua textfield telah diisi');
			redirect('user/edit/'. $data['id']);
		}

		// Jika ada perubahan password, enkripsi dan simpan ke database
		if(!empty($this->input->post('password'))) {
			$data['password'] = sha1($this->input->post('password'));
		}

		$save = $this->user_model->update($data);

		if($save['status']) {
			$this->session->set_flashdata('success', 'Data user berhasil disimpan');
			redirect('user');
		}

		$this->session->set_flashdata('error', 'Data user gagal disimpan');
		redirect('user/create');
	}

	public function deleteAction($id) {
		$user = $this->user_model->getById($id);

		if(!isset($user->id)){
			return $this->load->view('errors/html/error_404', [
				'heading' => 'Ooops', 
				'message' => 'User yang kamu minta tidak terdaftar, Silahkan <a href="'.base_url('user').'"> klik di sini </a> untuk kembali'
			]);
		}

		$delete = $this->user_model->delete($user->id);

		if($delete['status']) {
			$this->session->set_flashdata('success', 'Data user berhasil dihapus');
			redirect('user');
		}

		$this->session->set_flashdata('error', 'Data user gagal dihapus');
		redirect('user/create');
	}
}
