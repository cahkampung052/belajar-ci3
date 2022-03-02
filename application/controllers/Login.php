<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'view']);
        $this->load->model('user_model');
    }

	public function index()
	{
        // Jika sudah ada session langsung arahkan ke home
		if($this->session->userdata('nama') === null) {
            
            // Render view login
            view('pages/login.html', [
                'baseUrl' => base_url(),
                'error' => $this->session->flashdata('error') ?? null
            ]);
		}

        redirect('welcome');        
	}

    public function action() 
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $auth = $this->user_model->auth($email, $password);
    
        // Jika user tidak ditemukan redirect lagi ke halaman login
        if(!isset($auth->id)) {
            $this->session->set_flashdata('error', 'Kombinasi Email dan Password yang kamu masukkan salah');
            redirect('login');
        } 

        // Set Session
        $user = [
            'id' => $auth->id,
            'nama' => $auth->nama,
            'email' => $auth->email
        ];
        $this->session->set_userdata($user);

        // Render view home
        redirect('welcome');
    }
}
