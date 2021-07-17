<?php

namespace App\Models;

use R;

class LoginModel extends RedbeanModel
{
    protected $table = "signup";
    public $email;
    public $password;

    public function findOne($email, $password)
    {
        return R::findOne($this->table, ' email = ? AND password = ? ', [$email, $password]);
    }

    public function findOneByID($user_id)
    {
        return R::findOne($this->table, ' id = ? ', [$user_id]);
    }
}
