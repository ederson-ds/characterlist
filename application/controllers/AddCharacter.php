<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addcharacter extends CI_Controller
{
	private $rarities = ["Very Rare", "Epic", "Legendary", "Common", "Rare", "Empyrean", "True Divinity", "Void Tier", "God"];
	private $genders = ["Male", "Female", "Genderless", "Androgenous", "Unknown", "Multiple", "Other"];
	public function index()
	{
		session_start();
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$data['seriesId'] = "";
		$data['action'] = "Add";
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;
		$this->load->helper('validacao');

		if (!isset($_SESSION['user_id'])) {
			$this->load->view('templates/header');
			$this->load->view('addcharacter', $data);
			$this->load->view('templates/footer');
		}
		$this->load->model('PreSeriesModel');
		$preSeries = $this->PreSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$this->load->model('SeriesModel');
		$series = $this->SeriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
			$series = $this->input->post("series");
			$rarity = $this->input->post("rarity");
			$gender = $this->input->post("gender");
			$select = explode(",", $series);
			$data['name'] = $name;
			$data['imageUrl'] = $imageUrl;
			$this->load->model('CharModel');
			$char = $this->CharModel->findByName($name);
			if ($char)
				$data['errorName'] = "Character already registered";
			if (validarCampoObrigatorio($name)) {
				$data['errorName'] = "Required field";
			} else if (strlen($name) < 4) {
				$data['errorName'] = "It requires at least 4 characters";
			} else if (!validarSomenteLetrasENumerosEEspaco($name)) {
				$data['errorName'] = "Only letters and numbers allowed";
			}

			if (validarCampoObrigatorio($imageUrl)) {
				$data['errorImageUrl'] = "Required field";
			} else if (strlen($imageUrl) < 4) {
				$data['errorImageUrl'] = "It requires at least 4 characters";
			}

			if (empty($data['errorName']) && empty($data['errorImageUrl'])) {
				$this->load->model('PreCharModel');
				$this->PreCharModel->name = $name;
				$this->PreCharModel->imageUrl = $imageUrl;
				$this->PreCharModel->rarity = $rarity;
				$this->PreCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$this->PreCharModel->preSeries = $select[1];
				} else {
					$this->PreCharModel->series = $select[1];
				}
				$this->PreCharModel->insert();
				$data['successMsg'] = "Pre-Char created!";
			}
		}

		$this->load->view('templates/header');
		$this->load->view('addcharacter', $data);
		$this->load->view('templates/footer');
	}

	public function edit($preChar_id)
	{
		session_start();
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;
		$data['genders'] = $this->genders;
		$this->load->helper('validacao');

		$this->load->model('PreSeriesModel');
		$preSeries = $this->PreSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$this->load->model('SeriesModel');
		$series = $this->SeriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		$this->load->model('PreCharModel');
		$preChar = $this->PreCharModel->findOne($preChar_id);
		$data['name'] = $preChar->name;
		$data['imageUrl'] = $preChar->imageUrl;
		if ($preChar->preSeries) {
			$data['seriesId'] = "preSeries," . $preChar->preSeriesId;
		} else {
			$data['seriesId'] = "series," . $preChar->seriesId;
		}
		$data['action'] = "Edit";
		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
			$series = $this->input->post("series");
			$rarity = $this->input->post("rarity");
			$gender = $this->input->post("gender");
			$select = explode(",", $series);
			$this->load->model('CharModel');
			$char = $this->CharModel->findByName($name);
			if ($char)
				$data['errorName'] = "Character already registered";
			if (validarCampoObrigatorio($name)) {
				$data['errorName'] = "Required field";
			} else if (strlen($name) < 4) {
				$data['errorName'] = "It requires at least 4 characters";
			} else if (!validarSomenteLetrasENumerosEEspaco($name)) {
				$data['errorName'] = "Only letters and numbers allowed";
			}

			if (validarCampoObrigatorio($imageUrl)) {
				$data['errorImageUrl'] = "Required field";
			} else if (strlen($imageUrl) < 4) {
				$data['errorImageUrl'] = "It requires at least 4 characters";
			}

			if (empty($data['errorName']) && empty($data['errorImageUrl'])) {
				$this->PreCharModel->name = $name;
				$this->PreCharModel->imageUrl = $imageUrl;
				$this->PreCharModel->rarity = $rarity;
				$this->PreCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$this->PreCharModel->preSeries = $select[1];
					$this->PreCharModel->series = null;
				} else {
					$this->PreCharModel->series = $select[1];
					$this->PreCharModel->preSeries = null;
				}
				$this->PreCharModel->edit($preChar_id);
				return redirect('/dashboard', 'refresh');
			}
		}
		$this->load->view('templates/header');
		$this->load->view('addcharacter', $data);
		$this->load->view('templates/footer');
	}

	public function editChar($char_id)
	{
		session_start();
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;
		$this->load->helper('validacao');

		$this->load->model('PreSeriesModel');
		$preSeries = $this->PreSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$this->load->model('SeriesModel');
		$series = $this->SeriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		$this->load->model('CharModel');
		$char = $this->CharModel->findOne($char_id);
		$data['name'] = $char->name;
		$data['imageUrl'] = $char->imageUrl;
		if ($char->preSeries) {
			$data['seriesId'] = "preSeries," . $char->preSeriesId;
		} else {
			$data['seriesId'] = "series," . $char->seriesId;
		}
		$data['action'] = "Edit";
		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
			$series = $this->input->post("series");
			$rarity = $this->input->post("rarity");
			$gender = $this->input->post("gender");
			$select = explode(",", $series);
			if (validarCampoObrigatorio($name)) {
				$data['errorName'] = "Required field";
			} else if (strlen($name) < 4) {
				$data['errorName'] = "It requires at least 4 characters";
			} else if (!validarSomenteLetrasENumerosEEspaco($name)) {
				$data['errorName'] = "Only letters and numbers allowed";
			}

			if (validarCampoObrigatorio($imageUrl)) {
				$data['errorImageUrl'] = "Required field";
			} else if (strlen($imageUrl) < 4) {
				$data['errorImageUrl'] = "It requires at least 4 characters";
			}

			if (empty($data['errorName']) && empty($data['errorImageUrl'])) {
				$this->load->model('PreCharModel');
				$preChar = $this->PreCharModel->findOneByPreviousSeries($char_id);
				if ($preChar) {
					$this->PreCharModel->name = $name;
					$this->PreCharModel->imageUrl = $imageUrl;
					$this->PreCharModel->rarity = $rarity;
					$this->PreCharModel->gender = $gender;
					if ($select[0] == "preSeries") {
						$this->PreCharModel->preSeries = $select[1];
						$this->PreCharModel->series = null;
					} else {
						$this->PreCharModel->series = $select[1];
						$this->PreCharModel->preSeries = null;
					}
					$this->PreCharModel->edit($preChar->id);
					return redirect('/dashboard', 'refresh');
				}
				$this->PreCharModel->name = $name;
				$this->PreCharModel->imageUrl = $imageUrl;
				$this->PreCharModel->rarity = $rarity;
				$this->PreCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$this->PreCharModel->preSeries = $select[1];
					$this->PreCharModel->series = null;
				} else {
					$this->PreCharModel->series = $select[1];
					$this->PreCharModel->preSeries = null;
				}
				$this->PreCharModel->previousChar = $char_id;
				$this->PreCharModel->insert();
				return redirect('/dashboard', 'refresh');
			}
		}

		$this->load->view('templates/header');
		$this->load->view('addcharacter', $data);
		$this->load->view('templates/footer');
	}

	public function delete($preChar_id)
	{
		$this->load->model('PreCharModel');
		$this->PreCharModel->excluir($preChar_id);
		return redirect('/dashboard', 'refresh');
	}
}
