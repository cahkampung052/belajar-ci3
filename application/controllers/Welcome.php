<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
        $this->load->helper(['url', 'view']);

		// Cek jika belum memiliki session
		if($this->session->userdata('nama') === null) {
			redirect('login');
		}
	}

	public function index()
	{
		view('pages/home.html', [
			'baseUrl' => base_url(),
		]);
	}
}
