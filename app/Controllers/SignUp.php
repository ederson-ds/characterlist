<?php

namespace App\Controllers;

class SignUp extends BaseController
{
	public function index()
	{
		$data['errorFirstName'] = "";
		$data['errorEmail'] = "";
		$data['errorPassword'] = "";
		helper("validacao");
		if ($this->request->getMethod() === 'post') {
			$firstName = $this->request->getPost("firstName");
			$email = $this->request->getPost("email");
			$password = $this->request->getPost("password");
			$data['firstName'] = $firstName;
			$data['email'] = $email;
			$data['password'] = $password;
			if (validarCampoObrigatorio($firstName)) {
				$data['errorFirstName'] = "Required field";
			} else if (strlen($firstName) < 4) {
				$data['errorFirstName'] = "It requires at least 4 characters";
			} else if (!validarSomenteLetrasENumeros($firstName)) {
				$data['errorFirstName'] = "Only letters and numbers allowed";
			}

			if (validarCampoObrigatorio($email)) {
				$data['errorEmail'] = "Required field";
			} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$data['errorEmail'] = "Invalid email";
			}

			if (validarCampoObrigatorio($password)) {
				$data['errorPassword'] = "Required field";
			} else if (strlen($password) < 6) {
				$data['errorPassword'] = "It requires at least 6 characters";
			}

			if(empty($data['errorFirstName']) && empty($data['errorEmail']) && empty($data['errorPassword'])) {
				session_start();
				$_SESSION['firstName'] = $firstName;
				$signUpModel = new \App\Models\SignUpModel();
				$signUpModel->firstName = $firstName;
				$signUpModel->email = $email;
				$signUpModel->password = $password;
				$signUpModel->accessLevel = 0;
				$signUpModel->insert();
				return redirect()->to('dashboard');
			}
		}

		echo view('templates/header');
		echo view('signup', $data);
		echo view('templates/footer');
	}
}
