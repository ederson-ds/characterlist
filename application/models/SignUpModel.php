<?php

require_once "rb.php";

class SignUpModel extends CI_Model
{
    protected $table = "signup";
    public $firstName;
    public $email;
    public $password;
    public $accessLevel;

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
        $signup = R::dispense($this->table);
        $signup->firstName = $this->firstName;
        $signup->email = $this->email;
        $signup->password = $this->password;
        $signup->accessLevel = $this->accessLevel;
        $_SESSION['user_id'] = R::store($signup);
        $_SESSION['accessLevel'] = $this->accessLevel;
    }
}
