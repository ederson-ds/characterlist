<?php

namespace App\Controllers;

class Logout extends BaseController
{
	public function index()
	{
		session_start();

		// remove all session variables
		session_unset();

		// destroy the session
		session_destroy();

		return redirect()->to('home');
	}
}
