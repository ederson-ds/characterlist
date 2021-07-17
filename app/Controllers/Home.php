<?php

namespace App\Controllers;

use App\Models\CharModel;
use App\Models\SeriesModel;

class Home extends BaseController
{
	private $rarities = ["Very Rare", "Epic", "Legendary", "Common", "Rare", "Empyrean", "True Divinity", "Void Tier", "God"];
	private $genders = ["Male", "Female", "Genderless", "Androgenous", "Unknown", "Multiple", "Other"];
	public function index()
	{
		$seriesModel = new SeriesModel();
		$data['seriesList'] = $seriesModel->find(10, 0, "name");
		$data['rarities'] = $this->rarities;
		$data['genders'] = $this->genders;

		foreach ($data['seriesList'] as $value) {
			$chars = new CharModel();
			$chars = $chars->findByIdSeries(10, 0, "name", $value->id);
			$value['chars'] = $chars;
		}

		echo view('templates/header');
		echo view('home', $data);
		echo view('templates/footer');
	}
}
