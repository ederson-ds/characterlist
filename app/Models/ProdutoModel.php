<?php

namespace App\Models;

use R;

class ProdutoModel extends RedbeanModel
{
    protected $table = "produto";
    protected $searchColumn = 'descricao';
    public $descricao;

    public function insert()
    {
        $produto = R::dispense($this->table);
        $produto->descricao = $this->descricao;
        R::store($produto);
    }

    public function edit($produto_id)
    {
        $produto = R::load($this->table, $produto_id);
        $produto->descricao = $this->descricao;
        R::store($produto);
    }
}
