<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		$data['msg'] = "";
		if ($this->input->post()) {
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			$this->load->model("LoginModel");
			$user = $this->LoginModel->findOne($email, $password);
			if ($user) {
				session_start();
				$_SESSION['firstName'] = $user->firstName;
				$_SESSION['user_id'] = $user->id;
				$_SESSION['accessLevel'] = $user->accessLevel;
				return redirect('/dashboard', 'refresh');
			} else {
				$data['msg'] = "Invalid email or password!";
			}
		}
		$this->load->view('templates/header');
		$this->load->view('login', $data);
		$this->load->view('templates/footer');
	}
}
