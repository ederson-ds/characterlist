<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AddSeries extends CI_Controller
{
	public function index()
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$this->load->helper('validacao');
		$data['action'] = "Add";
		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
			$data['name'] = $name;
			$data['imageUrl'] = $imageUrl;
			$this->load->model("SeriesModel");
			$series = $this->SeriesModel->findByName($name);
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
				$this->load->model("PreSeriesModel");
				$this->PreSeriesModel->name = $name;
				$this->PreSeriesModel->imageUrl = $imageUrl;
				$this->PreSeriesModel->insert();
				$data['successMsg'] = "Pre-Series created!";
			}
		}
		$this->load->view('templates/header');
		$this->load->view('addseries', $data);
		$this->load->view('templates/footer');
	}

	public function edit($preSeries_id)
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$this->load->helper('validacao');
		$this->load->model("PreSeriesModel");
		$preSeries = $this->PreSeriesModel->findOne($preSeries_id);
		$data['name'] = $preSeries->name;
		$data['imageUrl'] = $preSeries->imageUrl;
		$data['action'] = "Edit";
		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
			$this->load->model("SeriesModel");
			$series = $this->SeriesModel->findByName($name);
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
				$this->load->model("PreSeriesModel");
				$this->PreSeriesModel->name = $name;
				$this->PreSeriesModel->imageUrl = $imageUrl;
				$this->PreSeriesModel->edit($preSeries_id);
				return redirect('/dashboard', 'refresh');
			}
		}
		$this->load->view('templates/header');
		$this->load->view('addseries', $data);
		$this->load->view('templates/footer');
	}

	public function editSeries($series_id)
	{
		$data['errorName'] = "";
		$data['errorImageUrl'] = "";
		$data['successMsg'] = "";
		$this->load->helper('validacao');
		$this->load->model("SeriesModel");
		$series = $this->SeriesModel->findOne($series_id);
		$data['name'] = $series->name;
		$data['imageUrl'] = $series->imageUrl;
		$data['action'] = "Edit";
		if ($this->input->post()) {
			$name = $this->input->post("name");
			$imageUrl = $this->input->post("imageUrl");
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
				$this->load->model("PreSeriesModel");
				$preSeries = $this->PreSeriesModel->findOneByPreviousSeries($series_id);
				if ($preSeries) {
					$this->PreSeriesModel->name = $name;
					$this->PreSeriesModel->imageUrl = $imageUrl;
					$this->PreSeriesModel->edit($preSeries->id);
					return redirect('/dashboard', 'refresh');
				}
				$this->PreSeriesModel->name = $name;
				$this->PreSeriesModel->imageUrl = $imageUrl;
				$this->PreSeriesModel->previousSeries = $series_id;
				$this->PreSeriesModel->insert();
				return redirect('/dashboard', 'refresh');
			}
		}
		$this->load->view('templates/header');
		$this->load->view('addseries', $data);
		$this->load->view('templates/footer');
	}

	public function delete($preSeries_id)
	{
		$this->load->model("PreSeriesModel");
		$this->PreSeriesModel->excluir($preSeries_id);
		return redirect('/dashboard', 'refresh');
	}
}
