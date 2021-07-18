<?php

require_once "rb.php";

class PreCharModel extends CI_Model
{
    protected $table = "prechar";
    public $name;
    public $imageUrl;
    public $rarity;
    public $gender;
    public $preSeries;
    public $series;
    public $previousChar;

    public function __construct()
    {
        if (!R::testConnection()) {
            R::setup(
                'pgsql:host=queenie.db.elephantsql.com;dbname=xozjhrue',
                'xozjhrue',
                'DGg0bVDqZCFps1hg5oRrs57DKxB5LYF5'
            );
        }
    }

    public function insert()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $preChar = R::dispense($this->table);
        $preChar->name = $this->name;
        $preChar->imageUrl = $this->imageUrl;
        $preChar->rarity = $this->rarity;
        $preChar->gender = $this->gender;
        if ($this->previousChar) {
            $preChar->previousChar = R::load("char", $this->previousChar);
        }
        $preChar->user = R::load("signup", $_SESSION['user_id']);
        if ($this->preSeries) {
            $preChar->preSeries = R::load("preseries", $this->preSeries);
        } else {
            $preChar->series =  R::load("series", $this->series);
        }
        R::store($preChar);
    }

    public function edit($preChar_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $preChar = R::load($this->table, $preChar_id);
        $preChar->name = $this->name;
        $preChar->imageUrl = $this->imageUrl;
        $preChar->rarity = $this->rarity;
        $preChar->gender = $this->gender;
        if ($this->preSeries) {
            $preChar->preSeries = R::load("preseries", $this->preSeries);
            $preChar->series = null;
        } else {
            $preChar->series =  R::load("series", $this->series);
            $preChar->preSeries = null;
        }
        R::store($preChar);
    }

    public function findOneByPreviousSeries($previousChar_id)
    {
        return R::findOne($this->table, ' previous_char_id = ?', [$previousChar_id]);
    }

    public function findOne($id)
    {
        return R::findOne($this->table, ' id = ?', [$id]);
    }

    public function get($user_id)
    {
        return R::find($this->table, " user_id = :user_id LIMIT :limit", array(
            ':user_id' => $user_id,
            ':limit' => 10,
        ));
    }

    public function excluir($id)
    {
        $item = $this->load($id);
        R::trash($item);
    }

    public function load($id)
    {
        return R::load($this->table, $id);
    }
}
