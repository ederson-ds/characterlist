<?php

require 'rb.php';

use CI_Model;

class RedbeanModel extends CI_Model
{
    protected $table = '';
    protected $searchColumn = '';
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

    public function search($text, $registros, $offset, $orderBy)
    {
        if ($orderBy)
            $orderBy = " ORDER BY " . $orderBy;
        return R::find($this->table, ' ' . $this->searchColumn . ' LIKE ? ' . $orderBy . ' OFFSET ? LIMIT ?', ['%' . $text . '%', $offset, $registros]);
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

    public function excluir($id)
    {
        $item = $this->load($id);
        R::trash($item);
    }

    public function load($id)
    {
        return R::load($this->table, $id);
    }

    public function count()
    {
        return R::count($this->table);
    }

    public function countSearch($text)
    {
        return R::count($this->table, ' ' . $this->searchColumn . ' LIKE ?', ['%' . $text . '%']);
    }
}
