<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		session_start();
		$this->load->model("PreSeriesModel");
		$data['preSeriesList'] = $this->PreSeriesModel->get($_SESSION['user_id']);

		$this->load->model("PreCharModel");
		$data['preCharList'] = $this->PreCharModel->get($_SESSION['user_id']);

		$this->load->view('templates/header');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}