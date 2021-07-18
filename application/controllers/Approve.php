<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approve extends CI_Controller
{
	public function index()
	{
		echo "teste";
	}

	public function PreSeries($preSeries_id)
	{
		session_start();
		$this->load->model("LoginModel");
		$user = $this->LoginModel->findOneByID($_SESSION['user_id']);
		if ($user->accessLevel == 1) {
			$this->load->model("PreSeriesModel");
			$preSeries = $this->PreSeriesModel->findOne($preSeries_id);
			if ($preSeries->previous_series_id) {
				$this->load->model("SeriesModel");
				$series = $this->SeriesModel->findOne($preSeries->previous_series_id);
				$this->SeriesModel->name = $preSeries->name;
				$this->SeriesModel->imageUrl = $preSeries->imageUrl;
				$this->SeriesModel->edit($series->id);
			} else {
				$this->load->model("SeriesModel");
				$this->SeriesModel->name = $preSeries->name;
				$this->SeriesModel->imageUrl = $preSeries->imageUrl;
				$this->SeriesModel->insert();
			}

			$this->PreSeriesModel->excluir($preSeries_id);
		}
		return redirect('/dashboard', 'refresh');
	}

	public function PreChar($preChar_id)
	{
		session_start();
		$this->load->model("LoginModel");
		$user = $this->LoginModel->findOneByID($_SESSION['user_id']);
		if ($user->accessLevel == 1) {
			$this->load->model("PreCharModel");
			$preChar = $this->PreCharModel->findOne($preChar_id);
			if ($preChar->pre_series_id) {
				$this->load->model("PreSeriesModel");
				$preSeries = $this->PreSeriesModel->findOne($preChar->pre_series_id);
				$this->load->model("SeriesModel");
				$this->SeriesModel->name = $preSeries->name;
				$this->SeriesModel->imageUrl = $preSeries->imageUrl;
				$this->SeriesModel->insert();
				$this->PreSeriesModel->excluir($preChar->pre_series_id);

				$this->load->model("CharModel");
				$this->CharModel->name = $preChar->name;
				$this->CharModel->imageUrl = $preChar->imageUrl;
				$this->CharModel->rarity = $preChar->rarity;
				$this->CharModel->gender = $preChar->gender;
				$this->CharModel->series = $preChar->pre_series_id;
				$this->CharModel->insert();
				$this->PreCharModel->excluir($preChar_id);
			} else {
				if ($preChar->previous_char_id) {
					$this->load->model("CharModel");
					$char = $this->CharModel->findOne($preChar->previous_char_id);
					$this->CharModel->name = $preChar->name;
					$this->CharModel->imageUrl = $preChar->imageUrl;
					$this->CharModel->rarity = $preChar->rarity;
					$this->CharModel->gender = $preChar->gender;
					$this->CharModel->series = $preChar->series;
					$this->CharModel->edit($char->id);
				} else {
					$this->load->model("CharModel");
					$this->CharModel->name = $preChar->name;
					$this->CharModel->imageUrl = $preChar->imageUrl;
					$this->CharModel->rarity = $preChar->rarity;
					$this->CharModel->gender = $preChar->gender;
					$this->CharModel->series = $preChar->series;
					$this->CharModel->insert();
				}
				$this->PreCharModel->excluir($preChar_id);
			}
		}
		return redirect('/dashboard', 'refresh');
	}
}
