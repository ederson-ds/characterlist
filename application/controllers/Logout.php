<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
	public function index()
	{
		session_start();

		// remove all session variables
		session_unset();

		// destroy the session
		session_destroy();

		return redirect('/home', 'refresh');
	}
}
