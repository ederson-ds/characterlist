<?php

namespace App\Models;

use R;

class SeriesModel extends RedbeanModel
{
    protected $table = "series";
    public $name;
    public $imageUrl;

    public function insert()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $series = R::dispense($this->table);
        $series->name = $this->name;
        $series->imageUrl = $this->imageUrl;
        $series->user = R::load("signup", $_SESSION['user_id']);
        R::store($series);
    }

    public function edit($series_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $series = R::load($this->table, $series_id);
        $series->name = $this->name;
        $series->imageUrl = $this->imageUrl;
        $series->user = R::load("signup", $_SESSION['user_id']);
        R::store($series);
    }

    public function findByName($name)
    {
        return R::findOne($this->table, ' name = ?', [$name]);
    }

    public function findOne($id)
    {
        return R::findOne($this->table, ' id = ?', [$id]);
    }
}
