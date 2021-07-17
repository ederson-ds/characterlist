<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		$data['msg'] = "";
		if ($this->request->getMethod() === 'post') {
			$email = $this->request->getPost("email");
			$password = $this->request->getPost("password");
			$loginModel = new \App\Models\LoginModel();
			$user = $loginModel->findOne($email, $password);
			if($user) {
				session_start();
				$_SESSION['firstName'] = $user->firstName;
				$_SESSION['user_id'] = $user->id;
				$_SESSION['accessLevel'] = $user->accessLevel;
				return redirect()->to('dashboard');
			} else {
				$data['msg'] = "Invalid email or password!";
			}
		}

		echo view('templates/header');
		echo view('login', $data);
		echo view('templates/footer');
	}
}
