<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SignUp extends CI_Controller
{
	public function index()
	{
		$data['errorFirstName'] = "";
		$data['errorEmail'] = "";
		$data['errorPassword'] = "";
		$this->load->helper("validacao");
		if ($this->input->post()) {
			$firstName = $this->input->post("firstName");
			$email = $this->input->post("email");
			$password = $this->input->post("password");
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
				$this->load->model("SignUpModel");
				$this->SignUpModel->firstName = $firstName;
				$this->SignUpModel->email = $email;
				$this->SignUpModel->password = $password;
				$this->SignUpModel->accessLevel = 0;
				$this->SignUpModel->insert();
				return redirect('/dashboard', 'refresh');
			}
		}
		$this->load->view('templates/header');
		$this->load->view('signup', $data);
		$this->load->view('templates/footer');
	}
}