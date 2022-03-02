<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
        $this->load->helper(['url', 'view']);

		 // cek jika belum mempunyai session redirect ke login
		 if($this->session->userdata('nama')) {
			// do nothing
		} else {
			redirect('login');
		}
	}

	public function index()
	{
		view('pages/home.html', [
			'baseUrl' => base_url(),
			'nama' => $this->session->userdata('nama'),
		]);
	}
}
