<?php

namespace App\Controllers;

use App\Models\CharModel;
use App\Models\PreCharModel;
use App\Models\PreSeriesModel;
use App\Models\SeriesModel;

class AddCharacter extends BaseController
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
		helper("validacao");

		if (!isset($_SESSION['user_id'])) {
			echo view('templates/header');
			echo view('addcharacter', $data);
			echo view('templates/footer');
		}

		$preSeriesModel = new PreSeriesModel();
		$preSeries = $preSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$seriesModel = new SeriesModel();
		$series = $seriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
			$series = $this->request->getPost("series");
			$rarity = $this->request->getPost("rarity");
			$gender = $this->request->getPost("gender");
			$select = explode(",", $series);
			$data['name'] = $name;
			$data['imageUrl'] = $imageUrl;
			$charModel = new CharModel();
			$char = $charModel->findByName($name);
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
				$preCharModel = new PreCharModel();
				$preCharModel->name = $name;
				$preCharModel->imageUrl = $imageUrl;
				$preCharModel->rarity = $rarity;
				$preCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$preCharModel->preSeries = $select[1];
				} else {
					$preCharModel->series = $select[1];
				}
				$preCharModel->insert();
				$data['successMsg'] = "Pre-Char created!";
			}
		}

		echo view('templates/header');
		echo view('addcharacter', $data);
		echo view('templates/footer');
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
		helper("validacao");

		$preSeriesModel = new PreSeriesModel();
		$preSeries = $preSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$seriesModel = new SeriesModel();
		$series = $seriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		$preCharModel = new PreCharModel();
		$preChar = $preCharModel->findOne($preChar_id);
		$data['name'] = $preChar->name;
		$data['imageUrl'] = $preChar->imageUrl;
		if ($preChar->preSeries) {
			$data['seriesId'] = "preSeries," . $preChar->preSeriesId;
		} else {
			$data['seriesId'] = "series," . $preChar->seriesId;
		}
		$data['action'] = "Edit";
		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
			$series = $this->request->getPost("series");
			$rarity = $this->request->getPost("rarity");
			$gender = $this->request->getPost("gender");
			$select = explode(",", $series);
			$charModel = new CharModel();
			$char = $charModel->findByName($name);
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
				$preCharModel->name = $name;
				$preCharModel->imageUrl = $imageUrl;
				$preCharModel->rarity = $rarity;
				$preCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$preCharModel->preSeries = $select[1];
					$preCharModel->series = null;
				} else {
					$preCharModel->series = $select[1];
					$preCharModel->preSeries = null;
				}
				$preCharModel->edit($preChar_id);
				return redirect()->to('dashboard');
			}
		}
		echo view('templates/header');
		echo view('addcharacter', $data);
		echo view('templates/footer');
	}

	public function editChar($char_id)
	{
		session_start();
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;
		helper("validacao");

		$preSeriesModel = new PreSeriesModel();
		$preSeries = $preSeriesModel->get($_SESSION['user_id']);
		$data['preSeriesList'] = $preSeries;

		$seriesModel = new SeriesModel();
		$series = $seriesModel->find(10, 0, "name");
		$data['seriesList'] = $series;

		$charModel = new CharModel();
		$char = $charModel->findOne($char_id);
		$data['name'] = $char->name;
		$data['imageUrl'] = $char->imageUrl;
		if ($char->preSeries) {
			$data['seriesId'] = "preSeries," . $char->preSeriesId;
		} else {
			$data['seriesId'] = "series," . $char->seriesId;
		}
		$data['action'] = "Edit";
		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
			$series = $this->request->getPost("series");
			$rarity = $this->request->getPost("rarity");
			$gender = $this->request->getPost("gender");
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
				$preCharModel = new PreCharModel();
				$preChar = $preCharModel->findOneByPreviousSeries($char_id);
				if ($preChar) {
					$preCharModel->name = $name;
					$preCharModel->imageUrl = $imageUrl;
					$preCharModel->rarity = $rarity;
					$preCharModel->gender = $gender;
					if ($select[0] == "preSeries") {
						$preCharModel->preSeries = $select[1];
						$preCharModel->series = null;
					} else {
						$preCharModel->series = $select[1];
						$preCharModel->preSeries = null;
					}
					$preCharModel->edit($preChar->id);
					return redirect()->to('dashboard');
				}
				$preCharModel->name = $name;
				$preCharModel->imageUrl = $imageUrl;
				$preCharModel->rarity = $rarity;
				$preCharModel->gender = $gender;
				if ($select[0] == "preSeries") {
					$preCharModel->preSeries = $select[1];
					$preCharModel->series = null;
				} else {
					$preCharModel->series = $select[1];
					$preCharModel->preSeries = null;
				}
				$preCharModel->previousChar = $char_id;
				$preCharModel->insert();
				return redirect()->to('dashboard');
			}
		}

		echo view('templates/header');
		echo view('addcharacter', $data);
		echo view('templates/footer');
	}

	public function delete($preChar_id)
	{
		$preCharModel = new PreCharModel();
		$preCharModel->excluir($preChar_id);
		return redirect()->to('dashboard');
	}
}
