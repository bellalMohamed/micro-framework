<?php

namespace App\Controllers;

class UserController {
	public function index($response)
	{
		return $response->setBody('users');
	}
}