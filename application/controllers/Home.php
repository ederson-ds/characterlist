<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $rarities = ["Very Rare", "Epic", "Legendary", "Common", "Rare", "Empyrean", "True Divinity", "Void Tier", "God"];
	private $genders = ["Male", "Female", "Genderless", "Androgenous", "Unknown", "Multiple", "Other"];
	public function index()
	{
		$this->load->model('SeriesModel');
		$data['seriesList'] = $this->SeriesModel->find(10, 0, "name");
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;

		foreach ($data['seriesList'] as $value) {
			$this->load->model('CharModel');
			$chars = $this->CharModel->findByIdSeries(10, 0, "name", $value->id);
			$value['chars'] = $chars;
		}

		$this->load->view('templates/header');
		$this->load->view('home', $data);
		$this->load->view('templates/footer');
	}
}
