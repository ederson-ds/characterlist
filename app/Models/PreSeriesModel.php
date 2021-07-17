<?php

namespace App\Models;

use R;

class PreSeriesModel extends RedbeanModel
{
    protected $table = "preseries";
    public $name;
    public $imageUrl;
    public $previousSeries;

    public function insert()
    {
        session_start();
        $preSeries = R::dispense($this->table);
        $preSeries->name = $this->name;
        $preSeries->imageUrl = $this->imageUrl;
        $preSeries->previousSeries = R::load("series", $this->previousSeries);
        $preSeries->user = R::load("signup", $_SESSION['user_id']);
        R::store($preSeries);
    }

    public function edit($preSeries_id)
    {
        session_start();
        $preSeries = R::load($this->table, $preSeries_id);
        $preSeries->name = $this->name;
        $preSeries->imageUrl = $this->imageUrl;
        R::store($preSeries);
    }

    public function findOne($id)
    {
        return R::findOne($this->table, ' id = ?', [$id]);
    }

    public function findOneByPreviousSeries($previousSeries_id)
    {
        return R::findOne($this->table, ' previous_series_id = ?', [$previousSeries_id]);
    }

    public function get($user_id)
    {
        return R::find($this->table, " user_id = :user_id LIMIT :limit", array(
            ':user_id' => $user_id,
            ':limit' => 10,
        ));
    }
}
