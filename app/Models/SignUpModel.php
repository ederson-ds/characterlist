<?php

namespace App\Models;

use R;

class SignUpModel extends RedbeanModel
{
    protected $table = "signup";
    public $firstName;
    public $email;
    public $password;
    public $accessLevel;

    public function insert()
    {
        session_start();
        $signup = R::dispense($this->table);
        $signup->firstName = $this->firstName;
        $signup->email = $this->email;
        $signup->password = $this->password;
        $signup->accessLevel = $this->accessLevel;
        $_SESSION['user_id'] = R::store($signup);
		$_SESSION['accessLevel'] = $this->accessLevel;
    }
}
