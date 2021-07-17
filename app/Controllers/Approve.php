<?php

namespace App\Controllers;

use App\Models\CharModel;
use App\Models\LoginModel;
use App\Models\PreCharModel;
use App\Models\PreSeriesModel;
use App\Models\SeriesModel;

class Approve extends BaseController
{
	public function index()
	{
		echo "teste";
	}

	public function PreSeries($preSeries_id)
	{
		session_start();
		$loginModel = new LoginModel();
		$user = $loginModel->findOneByID($_SESSION['user_id']);
		if ($user->accessLevel == 1) {
			$preSeriesModel = new PreSeriesModel();
			$preSeries = $preSeriesModel->findOne($preSeries_id);
			if ($preSeries->previous_series_id) {
				$seriesModel = new SeriesModel();
				$series = $seriesModel->findOne($preSeries->previous_series_id);
				$seriesModel->name = $preSeries->name;
				$seriesModel->imageUrl = $preSeries->imageUrl;
				$seriesModel->edit($series->id);
			} else {
				$series = new SeriesModel();
				$series->name = $preSeries->name;
				$series->imageUrl = $preSeries->imageUrl;
				$series->insert();
			}

			$preSeriesModel->excluir($preSeries_id);
		}
		return redirect()->to('/dashboard');
	}

	public function PreChar($preChar_id)
	{
		session_start();
		$loginModel = new LoginModel();
		$user = $loginModel->findOneByID($_SESSION['user_id']);
		if ($user->accessLevel == 1) {
			$preCharModel = new PreCharModel();
			$preChar = $preCharModel->findOne($preChar_id);
			if ($preChar->pre_series_id) {
				$preSeriesModel = new PreSeriesModel();
				$preSeries = $preSeriesModel->findOne($preChar->pre_series_id);
				$series = new SeriesModel();
				$series->name = $preSeries->name;
				$series->imageUrl = $preSeries->imageUrl;
				$series->insert();
				$preSeriesModel->excluir($preChar->pre_series_id);

				$charModel = new CharModel();
				$charModel->name = $preChar->name;
				$charModel->imageUrl = $preChar->imageUrl;
				$charModel->rarity = $preChar->rarity;
				$charModel->gender = $preChar->gender;
				$charModel->series = $preChar->pre_series_id;
				$charModel->insert();
				$preCharModel->excluir($preChar_id);
			} else {
				if ($preChar->previous_char_id) {
					$charModel = new CharModel();
					$char = $charModel->findOne($preChar->previous_char_id);
					$charModel->name = $preChar->name;
					$charModel->imageUrl = $preChar->imageUrl;
					$charModel->rarity = $preChar->rarity;
					$charModel->gender = $preChar->gender;
					$charModel->series = $preChar->series;
					$charModel->edit($char->id);
				} else {
					$charModel = new CharModel();
					$charModel->name = $preChar->name;
					$charModel->imageUrl = $preChar->imageUrl;
					$charModel->rarity = $preChar->rarity;
					$charModel->gender = $preChar->gender;
					$charModel->series = $preChar->series;
					$charModel->insert();
				}
				$preCharModel->excluir($preChar_id);
			}
		}
		return redirect()->to('/dashboard');
	}
}
