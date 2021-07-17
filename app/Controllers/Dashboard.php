<?php

namespace App\Controllers;

use App\Models\PreCharModel;
use App\Models\PreSeriesModel;

class Dashboard extends BaseController
{
	public function index()
	{
		session_start();
		$preSeriesModel = new PreSeriesModel();
		$data['preSeriesList'] = $preSeriesModel->get($_SESSION['user_id']);

		$preChar = new PreCharModel();
		$data['preCharList'] = $preChar->get($_SESSION['user_id']);

		echo view('templates/header');
		echo view('dashboard', $data);
		echo view('templates/footer');
	}
}
