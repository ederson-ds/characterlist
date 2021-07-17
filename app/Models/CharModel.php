<?php

namespace App\Models;

use R;

class CharModel extends RedbeanModel
{
    protected $table = "char";
    public $name;
    public $imageUrl;
    public $rarity;
    public $gender;
    public $series;

    public function insert()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $char = R::dispense($this->table);
        $char->name = $this->name;
        $char->imageUrl = $this->imageUrl;
        $char->rarity = $this->rarity;
        $char->gender = $this->gender;
        $char->series = R::load("signup", $this->series);
        $char->user = R::load("signup", $_SESSION['user_id']);
        R::store($char);
    }

    public function edit($char_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $char = R::load($this->table, $char_id);
        $char->name = $this->name;
        $char->imageUrl = $this->imageUrl;
        $char->rarity = $this->rarity;
        $char->gender = $this->gender;
        $char->series = R::load("signup", $this->series);
        $char->user = R::load("signup", $_SESSION['user_id']);
        R::store($char);
    }

    public function findOne($id)
    {
        return R::findOne($this->table, ' id = ?', [$id]);
    }

    public function findByName($name)
    {
        return R::findOne($this->table, ' name = ?', [$name]);
    }

    public function findByIdSeries($registros, $offset, $orderBy, $series_id)
    {
        $where = " series_id = :series_id ";
        if ($orderBy)
            $orderBy = " ORDER BY " . $orderBy;
        return R::find(
            $this->table,
            $where . $orderBy . ' OFFSET :offset LIMIT :limit',
            array(
                ':limit' => $registros,
                ':offset' => $offset,
                ':series_id' => $series_id
            )
        );
    }
}
