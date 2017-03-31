<?php

namespace App\Controllers;
use App\Models\User;
use \PDO;

class UserController {
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function index($response)
	{
		return $response->withJson([
			'error' => false,
		]);
	}

	public function users($response)
	{
		$users = $this->db->query('SELECT * FROM users')->fetchAll(PDO::FETCH_CLASS, User::class);
		return $response->withJson($users);
	}
}
