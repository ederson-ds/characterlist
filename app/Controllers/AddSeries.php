<?php

namespace App\Controllers;

use App\Models\PreSeriesModel;
use App\Models\SeriesModel;

class AddSeries extends BaseController
{
	public function index()
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		helper("validacao");
		$data['action'] = "Add";
		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
			$data['name'] = $name;
			$data['imageUrl'] = $imageUrl;
			$seriesModel = new SeriesModel();
			$series = $seriesModel->findByName($name);
			if ($series)
				$data['errorName'] = "Series already registered";
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
				$preSeriesModel = new \App\Models\PreSeriesModel();
				$preSeriesModel->name = $name;
				$preSeriesModel->imageUrl = $imageUrl;
				$preSeriesModel->insert();
				$data['successMsg'] = "Pre-Series created!";
			}
		}
		echo view('templates/header');
		echo view('addseries', $data);
		echo view('templates/footer');
	}

	public function edit($preSeries_id)
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		helper("validacao");
		$preSeriesModel = new PreSeriesModel();
		$preSeries = $preSeriesModel->findOne($preSeries_id);
		$data['name'] = $preSeries->name;
		$data['imageUrl'] = $preSeries->imageUrl;
		$data['action'] = "Edit";
		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
			$seriesModel = new SeriesModel();
			$series = $seriesModel->findByName($name);
			if ($series)
				$data['errorName'] = "Series already registered";
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
				$preSeriesModel = new PreSeriesModel();
				$preSeriesModel->name = $name;
				$preSeriesModel->imageUrl = $imageUrl;
				$preSeriesModel->edit($preSeries_id);
				return redirect()->to('dashboard');
			}
		}
		echo view('templates/header');
		echo view('addseries', $data);
		echo view('templates/footer');
	}

	public function editSeries($series_id)
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		helper("validacao");
		$seriesModel = new SeriesModel();
		$series = $seriesModel->findOne($series_id);
		$data['name'] = $series->name;
		$data['imageUrl'] = $series->imageUrl;
		$data['action'] = "Edit";
		if ($this->request->getMethod() === 'post') {
			$name = $this->request->getPost("name");
			$imageUrl = $this->request->getPost("imageUrl");
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
				$preSeriesModel = new PreSeriesModel();
				$preSeries = $preSeriesModel->findOneByPreviousSeries($series_id);
				if ($preSeries) {
					$preSeriesModel->name = $name;
					$preSeriesModel->imageUrl = $imageUrl;
					$preSeriesModel->edit($preSeries->id);
					return redirect()->to('dashboard');
				}
				$preSeriesModel->name = $name;
				$preSeriesModel->imageUrl = $imageUrl;
				$preSeriesModel->previousSeries = $series_id;
				$preSeriesModel->insert();
				return redirect()->to('dashboard');
			}
		}
		echo view('templates/header');
		echo view('addseries', $data);
		echo view('templates/footer');
	}

	public function delete($preSeries_id)
	{
		$preSeriesModel = new PreSeriesModel();
		$preSeriesModel->excluir($preSeries_id);
		return redirect()->to('dashboard');
	}
}
