<?php

require_once 'rb.php';

class SeriesModel extends CI_Model
{
    protected $table = "series";
    public $name;
    public $imageUrl;

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

    public function find($registros, $offset, $orderBy)
    {
        if ($orderBy)
            $orderBy = " ORDER BY " . $orderBy;
        return R::find(
            $this->table,
            $orderBy . ' OFFSET :offset LIMIT :limit',
            array(
                ':limit' => $registros,
                ':offset' => $offset
            )
        );
    }

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
