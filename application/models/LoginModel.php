<?php

require "rb.php";

class LoginModel extends CI_Model
{
    protected $table = "signup";
    public $email;
    public $password;

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

    public function findOne($email, $password)
    {
        return R::findOne($this->table, ' email = ? AND password = ? ', [$email, $password]);
    }

    public function findOneByID($user_id)
    {
        return R::findOne($this->table, ' id = ? ', [$user_id]);
    }
}